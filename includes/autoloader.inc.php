<?php
  spl_autoload_register('autoLoader');

  function autoLoader($className) {
    $url = $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

    if (strpos($url, 'includes') !== false) {
      $path = '../classes/';
    } else  {
      $path = "classes/";
    }

    $ext = ".class.php";

    $fullPath = $path . $className . $ext;

    if(!file_exists($fullPath)) {
      return false;
    }

    include_once $fullPath;
  }
