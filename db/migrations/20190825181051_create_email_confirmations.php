<?php
declare(strict_types=1);

namespace Vokuro\Migrations;

use Phinx\Migration\AbstractMigration;

final class CreateEmailConfirmations extends AbstractMigration
{
    public function change(): void
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
