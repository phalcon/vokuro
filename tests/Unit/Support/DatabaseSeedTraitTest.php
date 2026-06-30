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

namespace Vokuro\Tests\Unit\Support;

use Phalcon\Talon\PHPUnit\AbstractUnitTestCase;
use Vokuro\Tests\Support\DatabaseSeedTrait;

final class DatabaseSeedTraitTest extends AbstractUnitTestCase
{
    use DatabaseSeedTrait;

    public function testReseedRestoresBaseline(): void
    {
        $this->reseedDatabase();

        $pdo = $this->pdo();

        $this->assertSame(4, (int) $pdo->query('SELECT COUNT(*) FROM users')->fetchColumn());
        $this->assertSame(3, (int) $pdo->query('SELECT COUNT(*) FROM profiles')->fetchColumn());
        $this->assertSame(22, (int) $pdo->query('SELECT COUNT(*) FROM permissions')->fetchColumn());
        $this->assertSame(
            'sarah.connor@skynet.dev',
            $pdo->query('SELECT email FROM users WHERE id = 1')->fetchColumn()
        );
    }
}
