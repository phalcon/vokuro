<?php

use Phinx\Migration\AbstractMigration;

class CreateResetPasswords extends AbstractMigration
{
    public function change()
    {
        $table = $this->table('reset_passwords');
        if ($table->exists()) {
            return;
        }

        $table->addColumn('usersId', 'integer')
            ->addColumn('code', 'integer')
            ->addColumn('createdAt', 'integer')
            ->addColumn('modifiedAt', 'integer')
            ->addColumn('reset', 'char', ['limit' => 1])
            ->addIndex(['usersId'])
            ->create();
    }
}
