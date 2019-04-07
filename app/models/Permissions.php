<?php
namespace Vokuro\Models;

use Phalcon\Mvc\Model;

/**
 * Permissions
 * Stores the permissions by role
 */
class Permissions extends Model
{

    /**
     *
     * @var integer
     */
    public $id;

    /**
     *
     * @var integer
     */
    public $roleID;

    /**
     *
     * @var string
     */
    public $resource;

    /**
     *
     * @var string
     */
    public $action;

    public function initialize()
    {
        $this->belongsTo('roleID', __NAMESPACE__ . '\Roles', 'id', [
            'alias' => 'role'
        ]);
    }
}
