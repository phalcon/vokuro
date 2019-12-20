<?php
declare(strict_types=1);

namespace Vokuro\Migrations;

use Phinx\Migration\AbstractMigration;

final class CreatePermissions extends AbstractMigration
{
    public function change(): void
    {
        $table = $this->table('permissions');
        if ($table->exists()) {
            return;
        }

        $table->addColumn('profilesId', 'integer')
            ->addColumn('resource', 'string', ['limit' => 245])
            ->addColumn('action', 'string', ['limit' => 245])
            ->addIndex(['profilesId'])
            ->create();
    }
}
