<?php
declare(strict_types=1);

namespace Vokuro\Migrations;

use Phinx\Migration\AbstractMigration;

final class CreateSuccessLogins extends AbstractMigration
{
    public function change(): void
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
