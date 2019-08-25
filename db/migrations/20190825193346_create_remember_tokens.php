<?php

use Phinx\Migration\AbstractMigration;

class CreateRememberTokens extends AbstractMigration
{
    public function change()
    {
        $table = $this->table('remember_tokens');
        if ($table->exists()) {
            return;
        }

        $table->addColumn('usersId', 'integer')
            ->addColumn('token', 'char', ['limit' => 32])
            ->addColumn('userAgent', 'text')
            ->addColumn('createdAt', 'integer')
            ->addIndex(['token'])
            ->create();
    }
}
