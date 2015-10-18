<?php

namespace Extend\Phalcon\Mvc;

class Url extends \Phalcon\Mvc\Url
{

  /**
   * Generates a URL
   *
   *<code>
   *
   * //Generate a URL appending the URI to the base URI
   * echo $url->get('products/edit/1');
   *
   * //Generate a URL for a predefined route
   * echo $url->get(array('for' => 'blog-post', 'title' => 'some-cool-stuff', 'year' => '2012'));
   *
   *</code>
   *
   * @param string|array $uri
   * @param array|object args Optional arguments to be appended to the query string
   * @param bool|null    $local
   *
   * @return string
   */
  public function get($uri = null, $args = null, $local = null) {
    // get the value from parent class.
    $got_uris = parent::get($uri, $args, $local);

    // remove double slash and return.
    if (strpos($got_uris, '://') === false) {
      return str_replace('//', '/', $got_uris);
    } else {
      return $got_uris;
    }
  }// get

  /**
   * Returns the prefix for all the generated urls. By default /
   *
   * @return string
   */
  public function getBaseUri($with_lang = true) {
    //$disp = new \Phalcon\Mvc\Dispatcher();
    $dispatcher = $this->_dependencyInjector->getShared('dispatcher');
    if ($dispatcher->getParam('lang') == null) {
      $config = $this->_dependencyInjector->getShared('config');
      $current_lang = $config->language->defaultLang;
    } else {
      $current_lang = $dispatcher->getParam('lang');
    }
    unset($dispatcher, $config);

    if ($with_lang === true) {
      return parent::getBaseUri() . $current_lang . '/';
    } else {
      return parent::getBaseUri();
    }
  }// getBaseUri

  /**
   * get current uri.
   *
   * @return string example: /installed-path/{lang}/current-controller/current-action
   */
  public function getCurrentUri() {
    $router = $this->_dependencyInjector->getShared('router');
    $dispatcher = $this->_dependencyInjector->getShared('dispatcher');

    return $this->getBaseUri() . str_replace('/' . $dispatcher->getParam('lang') . '/', '', $router->getRewriteUri());
  }// getCurrentUri

  /**
   * get current uri from base uri.
   *
   * @param boolean $with_lang
   *
   * @return string example: /{lang}/current-controller/current-action
   */
  public function getCurrentUriFromBase($with_lang = true) {
    $router = $this->_dependencyInjector->getShared('router');
    $dispatcher = $this->_dependencyInjector->getShared('dispatcher');

    if ($with_lang === true) {
      return $router->getRewriteUri();
    } else {
      return str_replace('/' . $dispatcher->getParam('lang'), '', $router->getRewriteUri());
    }
  }// getCurrentUriFromBase

  /**
   * get current url with new language.
   *
   * @param string $lang_name
   *
   * @return string example: http://domain.tld/installed-path/{lang}/current-controller/current-action
   */
  public function getCurrentUrlNewLanguage($lang_name = '') {
    $request = new \Phalcon\Http\Request();

    return $request->getScheme() . '://' . $request->getServer('SERVER_NAME') . $this->getBaseUri(false) . $lang_name . $this->getCurrentUriFromBase(false);
  }// getCurrentUrlNewLanguage


}