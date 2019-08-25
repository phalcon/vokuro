<?php

use Phinx\Migration\AbstractMigration;

class CreateFailedLogins extends AbstractMigration
{
    public function change()
    {
        $table = $this->table('failed_logins');
        if ($table->exists()) {
            return;
        }

        $table->addColumn('userId', 'integer', ['null' => true])
            ->addColumn('ipAddress', 'char', ['limit' => 15])
            ->addColumn('attempted', 'integer')
            ->addIndex(['userId'])
            ->create();
    }
}
