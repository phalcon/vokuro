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
