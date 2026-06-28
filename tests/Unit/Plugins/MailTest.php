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

namespace Vokuro\Tests\Unit\Plugins;

use Phalcon\Di\Injectable;
use Phalcon\Talon\PHPUnit\AbstractUnitTestCase;
use Vokuro\Plugins\Mail\Mail;

final class MailTest extends AbstractUnitTestCase
{
    public function testBuildMessageSetsHeadersAndBody(): void
    {
        $mail = $this->mockWithoutConstructor(Mail::class);

        $email = $mail->buildMessage(
            ['jane@example.com' => 'Jane Doe'],
            'Welcome',
            '<p>Hello</p>',
            'noreply@vokuro.test',
            'Vokuro'
        );

        $this->assertSame('Welcome', $email->getSubject());
        $this->assertSame('<p>Hello</p>', $email->getHtmlBody());

        $from = $email->getFrom();
        $this->assertSame('noreply@vokuro.test', $from[0]->getAddress());
        $this->assertSame('Vokuro', $from[0]->getName());

        $to = $email->getTo();
        $this->assertSame('jane@example.com', $to[0]->getAddress());
        $this->assertSame('Jane Doe', $to[0]->getName());
    }

    public function testConstruct(): void
    {
        $class = $this->mockWithoutConstructor(Mail::class);

        $this->assertInstanceOf(Injectable::class, $class);
    }
}
