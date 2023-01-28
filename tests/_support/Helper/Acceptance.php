<?php

namespace Helper;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

use Codeception\TestInterface;
use Exception;
use Phinx\Console\PhinxApplication;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Output\NullOutput;

class Acceptance extends \Codeception\Module
{
    /**
     * @param TestInterface $test
     * @throws Exception
     */
    public function _before(TestInterface $test)
    {
        parent::_before($test);

        $app = new PhinxApplication();
        $app->setAutoExit(false);
        $app->run(new StringInput('rollback -e testing -t 0'), new NullOutput());
        $app->run(new StringInput('migrate -e testing'), new NullOutput());
        $app->run(new StringInput('seed:run -e testing'), new NullOutput());
    }
}
