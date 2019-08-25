<?php

use Phinx\Migration\AbstractMigration;

class CreateProfiles extends AbstractMigration
{
    public function change()
    {
        $table = $this->table('profiles');
        if ($table->exists()) {
            return;
        }

        $table->addColumn('name', 'string', ['limit' => 64])
            ->addColumn('active', 'char', ['limit' => 1])
            ->addIndex(['active'])
            ->create();
    }
}
