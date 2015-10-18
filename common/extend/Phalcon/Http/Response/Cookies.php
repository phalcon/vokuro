<?php


namespace Extend\Phalcon\Http\Response;

class Cookies extends \Phalcon\Http\Response\Cookies implements \Phalcon\Http\Response\CookiesInterface, \Phalcon\DI\InjectionAwareInterface
{

  /**
   * Renove a cookie by its name from the $_COOKIE superglobal
   *
   * @param string $name
   */
  public function remove($name) {
    $this->set($name, null, time() - (99 * 86400));
  }// remove

  /**
   * Gets a cookie from the bag
   *
   * @param string $name
   *
   * @return \Phalcon\Http\Cookie
   */
  public function get($name) {
    $prefix = $this->getCookiesPrefix();

    return parent::get($prefix . $name);
  }// get

  /**
   * get cookies prefix
   *
   * @return string
   */
  private function getCookiesPrefix() {
    $di = $this->getDI();
    $config = $di->getShared('config');

    unset($di);

    return $config->cookies->prefix;
  }// getCookiesPrefix

  /**
   * Check if a cookie is defined in the bag or exists in the $_COOKIE superglobal
   *
   * @param string $name
   *
   * @return boolean
   */
  public function has($name) {
    $prefix = $this->getCookiesPrefix();

    return parent::has($prefix . $name);
  }// has

  /**
   * Sets a cookie to be sent at the end of the request
   * This method overrides any cookie set before with the same name
   *
   * @param string  $name
   * @param mixed   $value
   * @param int     $expire
   * @param string  $path
   * @param boolean $secure
   * @param string  $domain
   * @param boolean $httpOnly
   *
   * @return \Phalcon\Http\Response\Cookies
   */
  public function set($name, $value = null, $expire = null, $path = null, $secure = null, $domain = null, $httpOnly = null) {
    $prefix = $this->getCookiesPrefix();

    return parent::set($prefix . $name, $value, $expire, $path, $secure, $domain, $httpOnly);
  }// set
} /* End the Cookies Extend Class */