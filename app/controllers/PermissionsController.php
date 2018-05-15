<?php

/*
  +------------------------------------------------------------------------+
  | Vökuró                                                                 |
  +------------------------------------------------------------------------+
  | Copyright (c) 2016-present Phalcon Team (https://www.phalconphp.com)   |
  +------------------------------------------------------------------------+
  | This source file is subject to the New BSD License that is bundled     |
  | with this package in the file LICENSE.txt.                             |
  |                                                                        |
  | If you did not receive a copy of the license and are unable to         |
  | obtain it through the world-wide-web, please send an email             |
  | to license@phalconphp.com so we can send you a copy immediately.       |
  +------------------------------------------------------------------------+
*/

namespace Vokuro\Controllers;

use Vokuro\Models\Profiles;
use Vokuro\Models\Permissions;

/**
 * View and define permissions for the various profile levels.
 * Vokuro\Controllers\PermissionsController
 * @package Vokuro\Controllers
 */
class PermissionsController extends ControllerBase
{
    /**
     * View the permissions for a profile level, and change them if we have a POST.
     */
    public function indexAction()
    {
        $this->view->setTemplateBefore('private');

        if ($this->request->isPost()) {
            // Validate the profile
            $profile = Profiles::findFirstById($this->request->getPost('profileId'));

            if ($profile) {
                if ($this->request->hasPost('permissions') && $this->request->hasPost('submit')) {
                    // Deletes the current permissions
                    $profile->getPermissions()->delete();

                    // Save the new permissions
                    foreach ($this->request->getPost('permissions') as $permission) {
                        $parts = explode('.', $permission);

                        $permission = new Permissions();
                        $permission->profilesId = $profile->id;
                        $permission->resource = $parts[0];
                        $permission->action = $parts[1];

                        $permission->save();
                    }

                    $this->flash->success('Permissions were updated with success');
                }

                // Rebuild the ACL with
                $this->acl->rebuild();

                // Pass the current permissions to the view
                $this->view->permissions = $this->acl->getPermissions($profile);
            }

            $this->view->profile = $profile;
        }

        // Pass all the active profiles
        $this->view->profiles = Profiles::find([
            'active = :active:',
            'bind' => [
                'active' => 'Y'
            ]
        ]);
    }
}
