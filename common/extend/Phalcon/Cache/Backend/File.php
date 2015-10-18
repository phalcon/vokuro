<?php


namespace Extend\Phalcon\Cache\Backend;

class File extends \Phalcon\Cache\Backend\File
{

  /**
   * Phalcon\Cache\Backend\File
   *
   * Allows to cache output fragments using a file backend
   *
   *<code>
   *    //Cache the file for 2 days
   *    $frontendOptions = array(
   *        'lifetime' => 172800
   *    );
   *
   *  //Create a output cache
   *  $frontCache = \Phalcon\Cache\Frontend\Output($frontOptions);
   *
   *    //Set the cache directory
   *    $backendOptions = array(
   *        'cacheDir' => '../app/cache/'
   *    );
   *
   *  //Create the File backend
   *  $cache = new \Phalcon\Cache\Backend\File($frontCache, $backendOptions);
   *
   *    $content = $cache->start('my-cache');
   *    if ($content === null) {
   *      echo '<h1>', time(), '</h1>';
   *      $cache->save();
   *    } else {
   *        echo $content;
   *    }
   *</code>
   */
  public function __construct($frontend, $options = null) {

    if (is_array($options) && array_key_exists('cacheDir', $options)) {
      if (!file_exists($options['cacheDir'])) {
        mkdir($options['cacheDir']);
      }
    }

    parent::__construct($frontend, $options);
  } /* End __Construct for phalcon\cache\backend\file */


}