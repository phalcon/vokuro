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

namespace Vokuro\Tests\Browser;

use Phalcon\Talon\Browser\Client;
use Phalcon\Talon\PHPUnit\AbstractUnitTestCase;
use Symfony\Component\BrowserKit\Exception\LogicException;
use Vokuro\Tests\Support\FakeRedirectingApp;

/**
 * Guards against the segfault captured in core.771: an app that redirects to
 * itself made the in-process browser recurse until ext-phalcon crashed. The
 * Client now caps redirects so a cycle raises a clean exception instead.
 */
final class RedirectLoopGuardTest extends AbstractUnitTestCase
{
    public function testClientCapsRunawayRedirects(): void
    {
        $client = new Client(static fn () => new FakeRedirectingApp());

        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('maximum number');

        $client->request('GET', 'http://localhost/loop');
    }
}
