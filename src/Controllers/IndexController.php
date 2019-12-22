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

namespace Vokuro\Controllers;

/**
 * Display the default index page.
 */
class IndexController extends ControllerBase
{
    /**
     * Default action. Set the public layout (layouts/public.volt)
     */
    public function indexAction(): void
    {
        $this->view->setVar('logged_in', is_array($this->auth->getIdentity()));
        $this->view->setTemplateBefore('public');
    }
}
