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
use Phalcon\Html\Escaper;
use Phalcon\Html\TagFactory;

class AssetsProvider implements ServiceProviderInterface
{
    protected const VERSION = "1.0.3";
    /**
     * @var string
     */
    protected $providerName = 'assets';

    /**
     * @param DiInterface $di
     *
     * @return void
     */
    public function register(DiInterface $di): void
    {
        $assetManager = new Manager(new TagFactory(new Escaper()));

        $di->setShared($this->providerName, function () use ($assetManager) {
            $assetManager->collection('css')
                ->addCss('/css/style.css?v=' . self::VERSION, true, true, [
                    "media" => "screen,projection"
                ]);

            $assetManager->collection('js')
                ->addJs('/js/app.js?v=' . self::VERSION, true, true);

            return $assetManager;
        });
    }
}
