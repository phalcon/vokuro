<?php
declare(strict_types=1);

namespace Vokuro\Migrations;

use Phinx\Migration\AbstractMigration;

final class CreateUsers extends AbstractMigration
{
    public function change(): void
    {
        $table = $this->table('users');
        if ($table->exists()) {
            return;
        }

        $table->addColumn('name', 'string', ['limit' => 255])
            ->addColumn('email', 'string', ['limit' => 255])
            ->addColumn('password', 'char', ['limit' => 60])
            ->addColumn('mustChangePassword', 'char', ['limit' => 1])
            ->addColumn('profilesId', 'integer')
            ->addColumn('banned', 'char', ['limit' => 1])
            ->addColumn('suspended', 'char', ['limit' => 1])
            ->addColumn('active', 'char', ['limit' => 1, 'default' => null, 'null' => true])
            ->addIndex(['profilesId'])
            ->create();
    }
}
