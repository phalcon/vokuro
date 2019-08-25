<?php

use Phinx\Seed\AbstractSeed;

class UsersSeeder extends AbstractSeed
{
    public function run()
    {
        $data = [
            [
                'id' => 1,
                'name' => 'Bob Burnquist',
                'email' => 'bob@phalconphp.com',
                'password' => '$2a$08$Lx1577KNhPa9lzFYKssadetmbhaveRtCoVaOnoXXxUIhrqlCJYWCW',
                'mustChangePassword' => 'N',
                'profilesId' => 1,
                'banned' => 'N',
                'suspended' => 'N',
                'active' => 'Y',
            ],
            [
                'id' => 2,
                'name' => 'Erik',
                'email' => 'erik@phalconphp.com',
                'password' => '$2a$08$f4llgFQQnhPKzpGmY1sOuuu23nYfXYM/EVOpnjjvAmbxxDxG3pbX.',
                'mustChangePassword' => 'N',
                'profilesId' => 1,
                'banned' => 'N',
                'suspended' => 'N',
                'active' => 'Y',
            ],
            [
                'id' => 3,
                'name' => 'Veronica',
                'email' => 'veronica@phalconphp.com',
                'password' => '$2a$08$NQjrh9fKdMHSdpzhMj0xcOSwJQwMfpuDMzgtRyA89ADKUbsFZ94C2',
                'mustChangePassword' => 'N',
                'profilesId' => 1,
                'banned' => 'N',
                'suspended' => 'N',
                'active' => 'Y',
            ],
            [
                'id' => 4,
                'name' => 'Yukimi Nagano',
                'email' => 'yukimi@phalconphp.com',
                'password' => '$2a$08$cxxpy4Jvt6Q3xGKgMWIILuf75RQDSroenvoB7L..GlXoGkVEMoSr.',
                'mustChangePassword' => 'N',
                'profilesId' => 2,
                'banned' => 'N',
                'suspended' => 'N',
                'active' => 'Y',
            ],
        ];

        $posts = $this->table('users');
        $posts->insert($data)
            ->save();
    }
}
