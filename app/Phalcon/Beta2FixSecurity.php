<?php
declare(strict_types=1);

namespace Phalcon;

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
        $di = $this->getDI();

        if (!is_object($di)) {
            throw new Exception(
                Exception::containerServiceNotFound("the 'session' service")
            );
        }

        if ($di->has('session')) {
            $session = $di->getShared('session');
            return (string) $session->get($this->tokenValueSessionId);
        }

        return '';
    }
}
