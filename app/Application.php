<?php
declare(strict_typesr=1);

/**
 * This file is part of the Vökuró.
 *
 * (c) Phalcon Team <team@phalcon.io>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Vokuro;

use Phalcon\Application\AbstractApplication;
use Phalcon\Di\FactoryDefault;
use Phalcon\Mvc\Application as MvcApplication;

class Application
{
    /**
     * @var MvcApplication
     */
    protected $app;

    /**
     * @var
     */
    protected $di;

    /**
     * Project root path
     *
     * @var string
     */
    protected $rootPath;

    /**
     * @param string $rootPath
     */
    public function __construct(string $rootPath)
    {
        $this->di = new FactoryDefault();
        $this->app = $this->createApplication();
        $this->rootPath = $rootPath;
    }

    /**
     * Run Vökuró Application
     *
     * @return string
     */
    public function run(): string
    {
        return $this->app->handle($_SERVER['REQUEST_URI'])->getContent();
    }

    /**
     * Get Project root path
     *
     * @return string
     */
    public function getRootPath(): string
    {
        return $this->rootPath;
    }

    /**
     * @return AbstractApplication
     */
    protected function createApplication(): AbstractApplication
    {
        return new MvcApplication($this->di);
    }
}
