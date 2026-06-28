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

namespace Vokuro\Tests\Functional\Controllers;

use Vokuro\Tests\Functional\AbstractFunctionalTestCase;

final class AboutControllerTest extends AbstractFunctionalTestCase
{
    public function testIndex(): void
    {
        $this->dispatch('/about');

        $this->assertResponseContentContains('About this demo');
    }
}
