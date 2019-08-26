<?php

use Phinx\Migration\AbstractMigration;

class CreateEmailConfirmations extends AbstractMigration
{
    public function change()
    {
        $table = $this->table('email_confirmations');
        if ($table->exists()) {
            return;
        }

        $table->addColumn('usersId', 'integer')
            ->addColumn('code', 'char', ['limit' => 32])
            ->addColumn('createdAt', 'integer')
            ->addColumn('modifiedAt', 'integer', ['null' => true])
            ->addColumn('confirmed', 'char', ['limit' => 1, 'default' => 'N'])
            ->create();
    }
}
