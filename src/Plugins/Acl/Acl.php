<?php

/**
 * This file is part of the Vökuró.
 *
 * (c) Phalcon Team <team@phalcon.io>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Vokuro\Plugins\Acl;

use Phalcon\Acl\Adapter\AbstractAdapter;
use Phalcon\Acl\Adapter\Memory as AclMemory;
use Phalcon\Acl\Component as AclComponent;
use Phalcon\Acl\Enum as AclEnum;
use Phalcon\Acl\Role as AclRole;
use Phalcon\Di\Injectable;
use Phalcon\Traits\Php\ApcuTrait;
use Phalcon\Traits\Php\InfoTrait;
use Vokuro\Models\Profiles;

/**
 * Vokuro\Acl\Acl
 */
class Acl extends Injectable
{
    use ApcuTrait;
    use InfoTrait;

    private const APCU_CACHE_VARIABLE_KEY = 'vokuro-acl';

    /**
     * The ACL Object
     *
     * @var AbstractAdapter|null
     */
    private $acl;

    /**
     * Human-readable descriptions of the actions used in
     * {@see $privateResources}
     *
     * @var array<string, string>
     */
    private array $actionDescriptions = [
        'index'          => 'Access',
        'search'         => 'Search',
        'create'         => 'Create',
        'edit'           => 'Edit',
        'delete'         => 'Delete',
        'changePassword' => 'Change password',
    ];

    /**
     * The file path of the ACL cache file.
     *
     * @var string
     */
    private string $filePath;

    /**
     * Define the resources that are considered "private". These controller =>
     * actions require authentication.
     *
     * @var array<string, list<string>>
     */
    private array $privateResources = [];

    /**
     * Adds an array of private resources to the ACL object.
     *
     * @param array<string, list<string>> $resources
     */
    public function addPrivateResources(array $resources): void
    {
        if (empty($resources)) {
            return;
        }

        $this->privateResources = array_merge($this->privateResources, $resources);
        if (is_object($this->acl)) {
            $this->acl = $this->rebuild();
        }
    }

    /**
     * Returns the ACL list
     *
     * @return AbstractAdapter|mixed
     */
    public function getAcl()
    {
        // Check if the ACL is already created
        if (is_object($this->acl)) {
            return $this->acl;
        }

        // Check if the ACL is in APCu
        if ($this->phpExtensionLoaded('apcu')) {
            $acl = $this->phpApcuFetch(self::APCU_CACHE_VARIABLE_KEY);
            if ($acl !== false) {
                $this->acl = $acl;

                return $acl;
            }
        }

        $filePath = $this->getFilePath();

        // Check if the ACL is already generated
        if (!file_exists($filePath)) {
            $this->acl = $this->rebuild();
            return $this->acl;
        }

        // Get the ACL from the data file
        $data      = (string) file_get_contents($filePath);
        $this->acl = unserialize($data);

        // Store the ACL in APCu
        if ($this->phpExtensionLoaded('apcu')) {
            $this->phpApcuStore(self::APCU_CACHE_VARIABLE_KEY, $this->acl);
        }

        return $this->acl;
    }

    /**
     * Returns the action description according to its simplified name
     *
     * @param string $action
     *
     * @return string
     */
    public function getActionDescription(string $action): string
    {
        return $this->actionDescriptions[$action] ?? $action;
    }

    /**
     * Returns the permissions assigned to a profile
     *
     * @param Profiles $profile
     *
     * @return array<string, bool>
     */
    public function getPermissions(Profiles $profile): array
    {
        $permissions = [];
        foreach ($profile->getRelated('permissions') as $permission) {
            $permissions[$permission->resource . '.' . $permission->action] = true;
        }

        return $permissions;
    }

    /**
     * Returns all the resources and their actions available in the application
     *
     * @return array<string, list<string>>
     */
    public function getResources(): array
    {
        return $this->privateResources;
    }

    /**
     * Checks if the current profile is allowed to access a resource
     *
     * @param string $profile
     * @param string $controller
     * @param string $action
     *
     * @return boolean
     */
    public function isAllowed($profile, $controller, $action): bool
    {
        return $this->getAcl()->isAllowed($profile, $controller, $action);
    }

    /**
     * Checks if a controller is private or not
     *
     * @param string $controllerName
     *
     * @return boolean
     */
    public function isPrivate($controllerName): bool
    {
        $controllerName = strtolower($controllerName);
        return isset($this->privateResources[$controllerName]);
    }

    /**
     * Rebuilds the access list into a file
     *
     * @return AclMemory
     */
    public function rebuild(): AclMemory
    {
        $acl = new AclMemory();
        $acl->setDefaultAction(AclEnum::DENY);

        $profiles = Profiles::find([
            'active = :active:',
            'bind' => [
                'active' => 'Y',
            ],
        ]);
        foreach ($profiles as $profile) {
            $acl->addRole(new AclRole($profile->name));
        }

        foreach ($this->privateResources as $resource => $actions) {
            $acl->addComponent(new AclComponent($resource), $actions);
        }

        // Grant access to private area to role Users
        foreach ($profiles as $profile) {
            // Grant permissions in "permissions" model
            foreach ($profile->getRelated('permissions') as $permission) {
                $acl->allow($profile->name, $permission->resource, $permission->action);
            }

            // Always grant these permissions
            $acl->allow($profile->name, 'users', 'changePassword');
        }

        $filePath = $this->getFilePath();
        if (touch($filePath) && is_writable($filePath)) {
            file_put_contents($filePath, serialize($acl));

            // Store the ACL in APCu
            if ($this->phpExtensionLoaded('apcu')) {
                $this->phpApcuStore(self::APCU_CACHE_VARIABLE_KEY, $acl);
            }
        } else {
            $this->flash->error('The user does not have write permissions to create the ACL list at ' . $filePath);
        }

        return $acl;
    }


    /**
     * Set the acl cache file path
     *
     * @return string
     */
    protected function getFilePath()
    {
        if (!isset($this->filePath)) {
            $this->filePath = rtrim($this->config->application->cacheDir, '\\/') . '/acl/data.txt';
        }

        return $this->filePath;
    }
}
