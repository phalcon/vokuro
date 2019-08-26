<?php

use Phinx\Seed\AbstractSeed;

class ProfilesSeeder extends AbstractSeed
{
    public function run()
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
