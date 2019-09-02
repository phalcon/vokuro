<?php
declare(strict_types=1);

namespace Vokuro\Migrations;

use Phinx\Migration\AbstractMigration;

final class CreateProfiles extends AbstractMigration
{
    public function change(): void
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
