<?php

/**
 * This file is part of the Vökuró.
 *
 * (c) Phalcon Team <team@phalcon.io>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Vokuro\Tests\Support;

use PDO;

use function Vokuro\env;

/**
 * Restores the database to the seeded baseline between tests. The in-process
 * browser rebuilds the app (and its DB connection) per request, so transaction
 * rollback cannot isolate tests - state is reset by truncate + reseed instead.
 */
trait DatabaseSeedTrait
{
    private static ?PDO $seedPdo = null;

    public function pdo(): PDO
    {
        if (null === self::$seedPdo) {
            $dsn = sprintf(
                'mysql:host=%s;port=%s;dbname=%s;charset=utf8',
                (string) env('DB_HOST', '127.0.0.1'),
                (string) env('DB_PORT', '3306'),
                (string) env('DB_NAME', 'vokuro')
            );

            self::$seedPdo = new PDO(
                $dsn,
                (string) env('DB_USERNAME', 'root'),
                (string) env('DB_PASSWORD', ''),
                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
            );
        }

        return self::$seedPdo;
    }

    public function reseedDatabase(): void
    {
        $pdo = $this->pdo();

        $tables = [
            'email_confirmations',
            'failed_logins',
            'password_changes',
            'permissions',
            'profiles',
            'remember_tokens',
            'reset_passwords',
            'success_logins',
            'users',
        ];

        $pdo->exec('SET FOREIGN_KEY_CHECKS = 0');
        foreach ($tables as $table) {
            $pdo->exec('TRUNCATE TABLE ' . $table);
        }

        $this->seedProfiles($pdo);
        $this->seedUsers($pdo);
        $this->seedPermissions($pdo);

        $pdo->exec('SET FOREIGN_KEY_CHECKS = 1');
    }

    private function seedPermissions(PDO $pdo): void
    {
        // profilesId, resource, action - mirrors resources/seeds/PermissionsSeeder.
        $rows = [
            [3, 'users', 'index'],
            [3, 'users', 'search'],
            [3, 'profiles', 'index'],
            [3, 'profiles', 'search'],
            [1, 'users', 'index'],
            [1, 'users', 'search'],
            [1, 'users', 'edit'],
            [1, 'users', 'create'],
            [1, 'users', 'delete'],
            [1, 'users', 'changePassword'],
            [1, 'profiles', 'index'],
            [1, 'profiles', 'search'],
            [1, 'profiles', 'edit'],
            [1, 'profiles', 'create'],
            [1, 'profiles', 'delete'],
            [1, 'permissions', 'index'],
            [2, 'users', 'index'],
            [2, 'users', 'search'],
            [2, 'users', 'edit'],
            [2, 'users', 'create'],
            [2, 'profiles', 'index'],
            [2, 'profiles', 'search'],
        ];

        $stmt = $pdo->prepare('INSERT INTO permissions (profilesId, resource, action) VALUES (?, ?, ?)');
        foreach ($rows as $row) {
            $stmt->execute($row);
        }
    }

    private function seedProfiles(PDO $pdo): void
    {
        // id, name, active - mirrors resources/seeds/ProfilesSeeder.
        $rows = [
            [1, 'Administrators', 'Y'],
            [2, 'Users', 'Y'],
            [3, 'Read-Only', 'Y'],
        ];

        $stmt = $pdo->prepare('INSERT INTO profiles (id, name, active) VALUES (?, ?, ?)');
        foreach ($rows as $row) {
            $stmt->execute($row);
        }
    }

    private function seedUsers(PDO $pdo): void
    {
        // id, name, email, password (bcrypt of passwordN), mustChangePassword,
        // profilesId, banned, suspended, active - mirrors resources/seeds/UsersSeeder.
        $rows = [
            [
                1, 'Sarah Connor', 'sarah.connor@skynet.dev',
                '$2y$08$L3Vqdk9ydm9PZktqMWRQO.bjO.rV4a7GJACZKEeCskzxWbT570Z2a',
                'N', 1, 'N', 'N', 'Y',
            ],
            [
                2, 'John Connor', 'john.connor@skynet.dev',
                '$2y$08$YU16R3VJV2tVQ3ZhYkdPROaeb9Pvem5jvCPsb95/aB8B6T12wB6Qy',
                'N', 1, 'N', 'N', 'Y',
            ],
            [
                3, 'Miles Dyson', 'miles.dyson@cyberdyne.dev',
                '$2y$08$VHR0Q2FyMDIzUkdpQllrQeSXJUl.H91aLDm/tclX2VGvpqxpFog52',
                'N', 1, 'N', 'N', 'Y',
            ],
            [
                4, 'Tarissa Dyson', 'tarissa.dyson@cyberdyne.dev',
                '$2y$08$Ykw4b0ZNU3VYZUxWRlpEZ.2f0p3OPhjIEVJbh6CGHlYm8XtIeLRqy',
                'N', 2, 'N', 'N', 'Y',
            ],
        ];

        $stmt = $pdo->prepare(
            'INSERT INTO users'
            . ' (id, name, email, password, mustChangePassword, profilesId, banned, suspended, active)'
            . ' VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)'
        );
        foreach ($rows as $row) {
            $stmt->execute($row);
        }
    }
}
