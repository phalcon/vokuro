<?php
declare(strict_types=1);

namespace Vokuro\Providers;

use Phalcon\Plugin;

abstract class AbstractProvider extends Plugin implements ProviderInterface
{
    /**
     * @var string
     */
    protected $providerName;

    /**
     * @return void
     */
    public function register(): void
    {
        // Implement in child class
    }

    /**
     * @return void
     */
    public function boot(): void
    {
        // Implement in child class
    }
}
