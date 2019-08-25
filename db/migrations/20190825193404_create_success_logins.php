<?php

use Phinx\Migration\AbstractMigration;

class CreateSuccessLogins extends AbstractMigration
{
    public function change()
    {
        $table = $this->table('success_logins');
        if ($table->exists()) {
            return;
        }

        $table->addColumn('usersId', 'integer')
            ->addColumn('ipAddress', 'char', ['limit' => 15])
            ->addColumn('userAgent', 'text')
            ->addIndex(['usersId'])
            ->create();
    }
}
