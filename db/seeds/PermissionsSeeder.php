<?php
declare(strict_types=1);

namespace Vokuro\Seeds;

use Phinx\Seed\AbstractSeed;

final class PermissionsSeeder extends AbstractSeed
{
    public function run(): void
    {
        $data = [
            [
                'id' => 1,
                'profilesId' => 3,
                'resource' => 'users',
                'action' => 'index',
            ],
            [
                'id' => 2,
                'profilesId' => 3,
                'resource' => 'users',
                'action' => 'search',
            ],
            [
                'id' => 3,
                'profilesId' => 3,
                'resource' => 'profiles',
                'action' => 'index',
            ],
            [
                'id' => 4,
                'profilesId' => 3,
                'resource' => 'profiles',
                'action' => 'search',
            ],
            [
                'id' => 5,
                'profilesId' => 1,
                'resource' => 'users',
                'action' => 'index',
            ],
            [
                'id' => 6,
                'profilesId' => 1,
                'resource' => 'users',
                'action' => 'search',
            ],
            [
                'id' => 7,
                'profilesId' => 1,
                'resource' => 'users',
                'action' => 'edit',
            ],
            [
                'id' => 8,
                'profilesId' => 1,
                'resource' => 'users',
                'action' => 'create',
            ],
            [
                'id' => 9,
                'profilesId' => 1,
                'resource' => 'users',
                'action' => 'delete',
            ],
            [
                'id' => 10,
                'profilesId' => 1,
                'resource' => 'users',
                'action' => 'changePassword',
            ],
            [
                'id' => 11,
                'profilesId' => 1,
                'resource' => 'profiles',
                'action' => 'index',
            ],
            [
                'id' => 12,
                'profilesId' => 1,
                'resource' => 'profiles',
                'action' => 'search',
            ],
            [
                'id' => 13,
                'profilesId' => 1,
                'resource' => 'profiles',
                'action' => 'edit',
            ],
            [
                'id' => 14,
                'profilesId' => 1,
                'resource' => 'profiles',
                'action' => 'create',
            ],
            [
                'id' => 15,
                'profilesId' => 1,
                'resource' => 'profiles',
                'action' => 'delete',
            ],
            [
                'id' => 16,
                'profilesId' => 1,
                'resource' => 'permissions',
                'action' => 'index',
            ],
            [
                'id' => 17,
                'profilesId' => 2,
                'resource' => 'users',
                'action' => 'index',
            ],
            [
                'id' => 18,
                'profilesId' => 2,
                'resource' => 'users',
                'action' => 'search',
            ],
            [
                'id' => 19,
                'profilesId' => 2,
                'resource' => 'users',
                'action' => 'edit',
            ],
            [
                'id' => 20,
                'profilesId' => 2,
                'resource' => 'users',
                'action' => 'create',
            ],
            [
                'id' => 21,
                'profilesId' => 2,
                'resource' => 'profiles',
                'action' => 'index',
            ],
            [
                'id' => 22,
                'profilesId' => 2,
                'resource' => 'profiles',
                'action' => 'search',
            ],
        ];

        $posts = $this->table('permissions');
        $posts->insert($data)
            ->save();
    }
}
