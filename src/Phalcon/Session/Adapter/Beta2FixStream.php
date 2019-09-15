<?php
declare(strict_types=1);

namespace Phalcon\Session\Adapter;

/**
 * Extended class for fixing phalcon/cphalcon#14265 issue
 *
 * @see https://github.com/phalcon/cphalcon/issues/14265
 * @see https://github.com/phalcon/cphalcon/commit/b6132eebb0b4165e8a43d870336b84584208a6f8#diff-7569882dd2736f23d2142a34913e6d7f
 */
final class Beta2FixStream extends Stream
{
    public function open($savePath, $sessionName): bool
    {
        return true;
    }
}
