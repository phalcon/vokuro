<?php

declare(strict_types=1);

namespace Vokuro\Tests\Unit\Plugins;

use Codeception\Test\Unit;
use Phalcon\Di\Injectable;
use Vokuro\Plugins\Mail\Mail;

final class MailTest extends Unit
{
    public function testBuildMessageSetsHeadersAndBody(): void
    {
        $mail = $this->make(Mail::class);

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
        $class = $this->make(Mail::class);

        $this->assertInstanceOf(Injectable::class, $class);
    }
}
