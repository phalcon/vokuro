<?php

/**
 * This file is part of the Vökuró.
 *
 * (c) Phalcon Team <team@phalcon.io>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Vokuro\Tests\Support;

use Vokuro\Plugins\Acl\Acl;

/**
 * Acl double that makes the APCu cache branches reachable without the ext-apcu
 * extension. It reports APCu as loaded and routes phalcon/traits' ApcuTrait
 * fetch/store wrappers through controllable in-memory values, so a test can
 * simulate a cache hit ({@see $fetched}) or capture a store ({@see $stored}).
 */
final class FakeApcuAcl extends Acl
{
    /**
     * Value the faked APCu fetch returns (false simulates a cache miss).
     *
     * @var mixed
     */
    public static mixed $fetched = false;

    /**
     * Payloads captured by the faked APCu store, keyed by cache key.
     *
     * @var array<string, mixed>
     */
    public static array $stored = [];

    public static function reset(): void
    {
        self::$fetched = false;
        self::$stored  = [];
    }

    /**
     * The parameter stays untyped to remain compatible with both parents: the
     * v5 C extension compiles the trait from Zephir with untyped parameters,
     * while the phalcon/traits package types them.
     *
     * @param array<string>|string $key
     *
     * @return mixed
     */
    protected static function phpApcuFetch($key): mixed
    {
        return self::$fetched;
    }

    /**
     * The parameters stay untyped for the same reason as {@see phpApcuFetch()}.
     *
     * @param array<array-key, mixed>|string $key
     * @param mixed                          $payload
     * @param int                            $ttl
     *
     * @return array<array-key, mixed>|bool
     */
    protected static function phpApcuStore($key, $payload, int $ttl = 0): bool | array
    {
        self::$stored[(string) $key] = $payload;

        return true;
    }

    protected static function phpExtensionLoaded(string $name): bool
    {
        return 'apcu' === $name || parent::phpExtensionLoaded($name);
    }
}
