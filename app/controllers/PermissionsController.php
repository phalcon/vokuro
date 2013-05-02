<?php

namespace Vokuro\Controllers;

use Vokuro\Models\Profiles,
	Vokuro\Models\Permissions;

class PermissionsController extends ControllerBase
{

	public function indexAction()
	{
		$this->view->setTemplateBefore('private');

		if ($this->request->isPost()) {

			//Validate the profile
			$profile = Profiles::findFirstById($this->request->getPost('profileId'));

			if ($profile) {

				if ($this->request->hasPost('permissions')) {

					//Deletes the current permissions
					$profile->getPermissions()->delete();

					//Save the new permissions
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

				//Rebuild the ACL with
				$this->acl->rebuild();

				//Pass the current permissions to the view
				$this->view->permissions = $this->acl->getPermissions($profile);

			}

			$this->view->profile = $profile;
		}

		//Pass all the active profiles
		$this->view->profiles = Profiles::find('active = "Y"');
	}

}

