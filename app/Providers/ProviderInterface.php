<?php
declare(strict_types=1);

namespace Vokuro\Providers;

use Phalcon\Di\InjectionAwareInterface;

interface ProviderInterface extends InjectionAwareInterface
{
    /**
     * Register application service
     *
     * @return void
     */
    public function register(): void;

    /**
     * Boot service provider after registration
     *
     * @return void
     */
    public function boot(): void;
}
