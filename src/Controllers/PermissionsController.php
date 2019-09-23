<?php
declare(strict_types=1);

/**
 * This file is part of the Vökuró.
 *
 * (c) Phalcon Team <team@phalcon.io>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Vokuro\Controllers;

use Vokuro\Models\Permissions;
use Vokuro\Models\Profiles;

/**
 * View and define permissions for the various profile levels.
 */
class PermissionsController extends ControllerBase
{
    /**
     * View the permissions for a profile level, and change them if we have a
     * POST.
     */
    public function indexAction(): void
    {
        $this->view->setTemplateBefore('private');

        if ($this->request->isPost()) {
            $profile = Profiles::findFirstById($this->request->getPost('profileId'));
            if ($profile) {
                if ($this->request->hasPost('permissions') && $this->request->hasPost('submit')) {
                    // Deletes the current permissions
                    $profile->getPermissions()->delete();

                    // Save the new permissions
                    foreach ($this->request->getPost('permissions') as $permission) {
                        $parts = explode('.', $permission);

                        $permission             = new Permissions();
                        $permission->profilesId = $profile->id;
                        $permission->resource   = $parts[0];
                        $permission->action     = $parts[1];

                        $permission->save();
                    }

                    $this->flash->success('Permissions were updated with success');
                }

                // Rebuild the ACL with
                $this->acl->rebuild();

                // Pass the current permissions to the view
                $this->view->setVar('permissions', $this->acl->getPermissions($profile));
            }

            $this->view->setVar('profile', $profile);
        }

        $profiles = Profiles::find([
            'active = :active:',
            'bind' => [
                'active' => 'Y',
            ],
        ]);

        $profilesSelect = $this->tag->select([
            'profileId',
            $profiles,
            'using'      => [
                'id',
                'name',
            ],
            'useEmpty'   => true,
            'emptyText'  => '...',
            'emptyValue' => '',
            'class'      => 'form-control mr-sm-2',
        ]);

        $this->view->setVar('profilesSelect', $profilesSelect);
    }
}
