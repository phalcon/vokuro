<?php
return new \Phalcon\Config(array(
    /**
     * The name of the database, username,password for your script
     */
    'database' => array(
        'adapter' => 'Mysql',
        'host' => '127.0.0.1',
        'username' => 'username',
        'password' => 'password',
        'dbname' => 'databasename',
        'charset' => 'utf8',
    ),
    /**
     * Application settings
     */
    'application' => [
        /**
         * The sitename, you should change it to your name website
         */
        'name' => 'Your own Application title',
        'publicUrl' => 'http://vokuro.local',
        /**
         * Change timezone if you want to it
         */
        'timezone' => 'UTC',
        /**
         * Change URL cdn if you want it
         */
        'development' => [
            'staticBaseUri' => '/',
        ],
        'production' => [
            'staticBaseUri' => '/',
        ],
        /**
         * Please don't change it
         */
        'httpStatusCode' => 200, //503
        'appsDir' => ROOT_DIR . 'app/',
        'controllersDir' => APP_DIR . '/controllers/',
        'modelsDir' => APP_DIR . '/models/',
        'formsDir' => APP_DIR . '/forms/',
        'viewsDir' => APP_DIR . '/views/',
        'extendDir' => ROOT_DIR . '/common/extend/',
        'toolsDir' => ROOT_DIR . '/common/tools/',
        'libraryDir' => ROOT_DIR . '/common/library/',
        'pluginsDir' => ROOT_DIR . '/common/plugins/',
        'modulesDir' => ROOT_DIR . '/modules/',
        'cacheDir' => ROOT_DIR . '/storage/cache/',
        'logDir' => ROOT_DIR . '/storage/logs/',
        'languageDir' => ROOT_DIR . '/language/',
        'baseUri' => '/',
        'view' => [
            'compiledPath' => ROOT_DIR . 'storage/cache/volt/',
            'compiledSeparator' => '_',
            'compiledExtension' => '.php',
            'viewsDir' => ROOT_DIR . 'app/views/',
            'paginator' => [
                'limit' => 25,
            ],
        ],
        'templatesDir' => 'templatesDir/',
        'repo' => 'https://github.com/phalcon/vokuro/',
        'publicUrl' => 'vokuro.phalconphp.com',
        'cryptSalt' => 'eEAfR|_&G&f,+vU]:jFr!!A&+71w1Ms9~8_4L!<@[N@DyaIP_2My|:+.u>/6m,$D',
        /**
         * For developers: debugging mode.
         *
         * Change this to true to enable the display of notices during development.
         * It is strongly recommended that plugin and theme developers use
         * in their development environments.
         */
        'debug' => false,
        /**
         * The length password hash sent to you when you forget password
         * you can change it
         */
        'passwdResetInterval' => 10,
        /**
         * You can see from
         *
         * @link https://docs.phalconphp.com/en/latest/reference/logging.html
         */
        'logger' => [
            'enabled' => true,
            'path' => 'log/',
            'format' => '[%date %][%type %] %message % ',
        ],

        /**
         * Authentication Unique Keys and Salts. Change these to different unique key!
         *
         * @link https://docs.phalconphp.com/en/latest/api/Phalcon_Security.html
         */
        'cryptSalt' => '92*)(@#9834$#3rt',

        /**
         * Time life cookie defaut is 8 day, you can change anything day
         *
         * @link https://docs.phalconphp.com/en/latest/reference/cookies.html
         */
        'cookieLifetime' => 86400 * 8,

        /**
         * Improving Performance with Cache
         *
         * @link https://docs.phalconphp.com/en/latest/reference/cache.html
         */
        'cache' => [
            'lifetime' => '86400',
            'prefix' => 'cache_',
            'adapter' => 'File',
            'cacheDir' => ROOT_DIR . '/storage/cache/html/',
        ],

        'session' => [
            'adapter' => '\Phalcon\Session\Adapter\Files',
            'options' => [
                'lifetime' => 600,
                'uniqueId' => 'vokuro_'
            ]
        ],
    ],
    'models' => [
        'metadata' => ['adapter' => 'Memory']
    ],
    /**
     * The paramaster config for elastich you can change it or not
     *
     * @link https://www.elastic.co/blog/what-is-an-elasticsearch-index
     */
    'elasticsearch' => [
        'index' => 'vokuro',
        'type' => 'posts'
    ],
    'mail' => [
        'fromName' => 'Phanbook',
        'fromEmail' => 'phanbook@no-reply',
        'smtp' => [
            'server' => 'smtp.mandrillapp.com',
            'port' => '587',
            'security' => 'tls',
            'username' => 'phanbook@phanbook.com',
            'password' => ''
        ]
    ],

    /**
     * Your client ID and client secret keys come from
     *
     * @link https://github.com/settings/applications/new
     */
    'github' => array(
        'clientId' => '',
        'clientSecret' => '',
        'redirectUri' => 'http://vokuro.local/auth/github/access_token',
        'scopes' => ['user', 'email']
    ),

    /**
     * Your client ID and client secret keys come from
     *
     * @link https://developers.google.com/console/help/new/
     */
    'google' => array(
        'clientId' => 'yourclientid.apps.googleusercontent.com',
        'clientSecret' => '',
        'redirectUri' => 'http://vokuro.local/auth/google/access_token'
    ),
    /**
     * Your client ID and client secret keys come from
     *
     * @link https://developers.facebook.com/
     */
    'facebook' => [
        'clientId' => '',
        'clientSecret' => '',
        'redirectUri' => 'http://vokuro.local/auth/facebook/access_token'
    ],
    /**
     * Set languages you want to it, you can see example
     *
     * @link http://github.com/phanbook/docs/language.md
     */
    'language' => 'en_EN',
    /**
     * Set theme you want to use, for example 'discourse'
     *
     * @link http://github.com/phanbook/docs/theme.md
     */
    'theme' => null,
    /**
     * The paramater you get form
     *
     * @link http://www.google.com/analytics/
     */
    'googleAnalytic' => 'UA-47328645-4',
    /**
     * Queue Connections
     * We use Beanstalk is a simple, fast work queue.
     */
    'beanstalk' => [
        'disabled' => true,
        'host' => '127.0.0.1'
    ]
));
