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

namespace Vokuro\Plugins\Auth;

/**
 * Test-only shadow of sleep(). PHP resolves an unqualified sleep() call inside
 * the Vokuro\Plugins\Auth namespace to this function ahead of the global one,
 * so the brute-force login throttling never actually delays the suite. Loaded
 * from tests/bootstrap.php; never part of the production autoloader.
 */
function sleep(int $seconds): int
{
    return 0;
}
