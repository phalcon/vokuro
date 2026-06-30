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

use Phalcon\Http\Response;

/**
 * App double whose every dispatch redirects to itself. Used to drive the
 * in-process browser Client into a redirect cycle so its redirect cap can be
 * exercised without standing up the real application.
 */
final class FakeRedirectingApp
{
    public function handle(string $uri): Response
    {
        $response = new Response();
        $response->setStatusCode(302);
        $response->setHeader('Location', 'http://localhost/loop');

        return $response;
    }
}
