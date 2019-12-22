<?php
declare(strict_types=1);

namespace Vokuro\Migrations;

use Phinx\Migration\AbstractMigration;

final class CreateRememberTokens extends AbstractMigration
{
    public function change(): void
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
