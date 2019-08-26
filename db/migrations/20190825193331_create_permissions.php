<?php

use Phinx\Migration\AbstractMigration;

class CreatePermissions extends AbstractMigration
{
    public function change()
    {
        $table = $this->table('permissions');
        if ($table->exists()) {
            return;
        }

        $table->addColumn('profilesId', 'integer')
            ->addColumn('resource', 'string', ['limit' => 16])
            ->addColumn('action', 'string', ['limit' => 16])
            ->addIndex(['profilesId'])
            ->create();
    }
}
