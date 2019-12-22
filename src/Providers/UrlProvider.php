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

use Phalcon\Di\DiInterface;
use Phalcon\Di\ServiceProviderInterface;
use Phalcon\Url as UrlResolver;

class UrlProvider implements ServiceProviderInterface
{
    /**
     * @var string
     */
    protected $providerName = 'url';

    /**
     * @param DiInterface $di
     */
    public function register(DiInterface $di): void
    {
        /** @var string $baseUri */
        $baseUri = $di->getShared('config')->path('application.baseUri');

        $di->setShared($this->providerName, function () use ($baseUri) {
            $url = new UrlResolver();
            $url->setBaseUri($baseUri);

            return $url;
        });
    }
}
