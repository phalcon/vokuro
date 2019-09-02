<?php
declare(strict_types=1);

namespace Vokuro\Seeds;

use Phinx\Seed\AbstractSeed;

final class ProfilesSeeder extends AbstractSeed
{
    public function run(): void
    {
        $data = [
            [
                'id' => 1,
                'name' => 'Administrators',
                'active' => 'Y',
            ],
            [
                'id' => 2,
                'name' => 'Users',
                'active' => 'Y',
            ],
            [
                'id' => 3,
                'name' => 'Read-Only',
                'active' => 'Y',
            ],
        ];

        $posts = $this->table('profiles');
        $posts->insert($data)
            ->save();
    }
}
