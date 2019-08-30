<?php
declare(strict_types=1);

namespace Vokuro\Providers;

use Phalcon\Url as UrlResolver;

class UrlProvider extends AbstractProvider
{
    protected $providerName = 'url';

    public function register(): void
    {
        $this->di->setShared('url', function () {
            $config = $this->getConfig();

            $url = new UrlResolver();
            $url->setBaseUri($config->application->baseUri);
            return $url;
        });
    }
}
