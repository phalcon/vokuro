<?php
declare(strict_types=1);

namespace Phalcon;

use function Vokuro\container;

/**
 * Extended class for fixing phalcon/cphalcon#14346 issue
 *
 * @see https://github.com/phalcon/cphalcon/pull/14347
 */
class Beta2FixSecurity extends Security
{
    /**
     * @inheritDoc
     */
    public function getRequestToken(): string
    {
        if (empty($this->requestToken)) {
            return $this->getSessionToken();
        }

        return (string) $this->requestToken;
    }

    /**
     * @inheritDoc
     *
     * @return string
     * @throws Exception
     */
    public function getSessionToken(): string
    {
        if (!container()->has('session')) {
            throw new Exception(
                Exception::containerServiceNotFound("the 'session' service")
            );
        }

        $session = container()->getShared('session');
        return (string) $session->get($this->tokenValueSessionId);
    }
}
