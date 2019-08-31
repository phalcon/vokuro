<?php
declare(strict_types=1);

/**
 * This file is part of the Vökuró.
 *
 * (c) Phalcon Team <team@phalcon.io>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Vokuro\Providers;

interface ProviderInterface
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
