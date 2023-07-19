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

namespace Vokuro\Providers;

use Phalcon\Assets\Manager;
use Phalcon\Di\DiInterface;
use Phalcon\Di\ServiceProviderInterface;
use Phalcon\Html\TagFactory;

class AssetsProvider implements ServiceProviderInterface
{
    protected const VERSION = '1.0.0';
    /**
     * @var string
     */
    protected string $providerName = 'assets';

    /**
     * @param DiInterface $di
     *
     * @return void
     */
    public function register(DiInterface $di): void
    {
        /** @var TagFactory $tagFactory */
        $tagFactory = $di->getShared('tag');

        $di->setShared(
            $this->providerName,
            function () use ($tagFactory) {
                $assetManager = new Manager($tagFactory);
                $assetManager->collection('css')
                             ->addCss(
                                 '//cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css?dc=' . self::VERSION,
                                 false,
                                 false,
                                 [
                                     'media'       => 'screen,projection',
                                     'integrity'   => 'sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N',
                                     'crossorigin' => 'anonymous'
                                 ]
                             )
                             ->addCss('/css/style.css?dc=' . self::VERSION, true, true, [
                                 'media' => 'screen,projection'
                             ])
                ;

                $assetManager->collection('js')
                             ->addJs(
                                 '//code.jquery.com/jquery-3.6.1.slim.min.js?dc=' . self::VERSION,
                                 false,
                                 true,
                                 [
                                     'integrity'   => 'sha256-w8CvhFs7iHNVUtnSP0YKEg00p9Ih13rlL9zGqvLdePA=',
                                     'crossorigin' => 'anonymous'
                                 ]
                             )
                             ->addJs(
                                 '//cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js?dc=' . self::VERSION,
                                 false,
                                 true,
                                 [
                                     'integrity'   => 'sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+',
                                     'crossorigin' => 'anonymous'
                                 ]
                             )
                ;

                return $assetManager;
            }
        );
    }
}
