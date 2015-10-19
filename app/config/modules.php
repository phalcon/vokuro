<?php

// @todo [phalconbegins][multi modules] register modules here.
// register modules -------------------------------------------------------------------------

$application->registerModules(
    array(
        'companies' => array(
            'namespace' => 'Modules\Companies',
            'className' => 'Modules\Companies\Module',
            'path' => APP_DIR . '/../modules/companies/Module.php',
        ),

        'relations' => array(
            'namespace' => 'Modules\Relations',
            'className' => 'Modules\Relations\Module',
            'path' => APP_DIR . '/../modules/relations/Module.php',
        ),

        'invoices' => array(
            'namespace' => 'Modules\Invoices',
            'className' => 'Modules\Invoices\Module',
            'path' => APP_DIR . '/../modules/invoices/Module.php',
        ),
        'products' => array(
            'namespace' => 'Modules\Products',
            'className' => 'Modules\Products\Module',
            'path' => APP_DIR . '/../modules/products/Module.php',
        ),

        /*
         *  That is the Base module, the index, the about page, redirect to login, etc
         **/
        'core' => array(
            'namespace' => 'Vokuro',
            'className' => 'Vokuro\Module',
            'path' => APP_DIR . '/Module.php',
        ),
    )
);  /* End register modules --------------------------------------------------------------------*/