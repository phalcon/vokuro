<?php

use Phinx\Migration\AbstractMigration;

class CreatePasswordChanges extends AbstractMigration
{
    public function change()
    {
        $table = $this->table('password_changes');
        if ($table->exists()) {
            return;
        }

        $table->addColumn('usersId', 'integer')
            ->addColumn('ipAddress', 'char', ['limit' => 15])
            ->addColumn('userAgent', 'text')
            ->addColumn('createdAt', 'integer')
            ->addIndex(['usersId'])
            ->create();
    }
}
