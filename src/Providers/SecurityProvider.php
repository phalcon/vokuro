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

use Phalcon\Beta2FixSecurity;
use Phalcon\Di\DiInterface;
use Phalcon\Di\ServiceProviderInterface;
use Phalcon\Security;
use Phalcon\Version;

class SecurityProvider implements ServiceProviderInterface
{
    /**
     * @var string
     */
    protected $providerName = 'security';

    /**
     * @param DiInterface $di
     *
     * @return void
     */
    public function register(DiInterface $di): void
    {
        $that = $this;
        $di->set($this->providerName, function () use ($di, $that) {
            return $that->getSecurity($di);
        });
    }

    /**
     * Remove current method after after next release of Phalcon 4
     *
     * @see https://github.com/phalcon/cphalcon/issues/14346
     *
     * @param DiInterface $di
     *
     * @return Security
     */
    protected function getSecurity(DiInterface $di): Security
    {
        if (Version::get() !== '4.0.0-beta.2') {
            $security = new Security();
        } else {
            $security = new Beta2FixSecurity();
        }

        $security->setDI($di);

        return $security;
    }
}
