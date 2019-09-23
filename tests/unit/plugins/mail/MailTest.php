<?php
declare(strict_types=1);

namespace Vokuro\Tests\Unit\Plugins;

use Codeception\Test\Unit;
use Phalcon\Di\Injectable;
use Vokuro\Plugins\Mail\Mail;

final class MailTest extends Unit
{
    public function testConstruct(): void
    {
        $class = $this->make(Mail::class);

        $this->assertInstanceOf(Injectable::class, $class);
    }
}
