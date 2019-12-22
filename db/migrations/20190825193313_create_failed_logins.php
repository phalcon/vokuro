<?php
declare(strict_types=1);

namespace Vokuro\Migrations;

use Phinx\Migration\AbstractMigration;

final class CreateFailedLogins extends AbstractMigration
{
    public function change(): void
    {
        $table = $this->table('failed_logins');
        if ($table->exists()) {
            return;
        }

        $table->addColumn('usersId', 'integer', ['null' => true])
            ->addColumn('ipAddress', 'char', ['limit' => 15])
            ->addColumn('attempted', 'integer')
            ->addIndex(['usersId'])
            ->create();
    }
}
