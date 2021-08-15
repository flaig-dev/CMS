<?php

  // load Smarty library
  require('Smarty.class.php');

  $smarty = new Smarty;

  $smarty->template_dir = 'C:\wamp64\www\WEBD325Project\src Public\includes\smarty\templates';
  $smarty->config_dir = 'C:\wamp64\www\WEBD325Project\src Public\includes\smarty\configs';
  $smarty->cache_dir = 'C:\wamp64\smarty\cache';
  $smarty->compile_dir = 'C:\wamp64\smarty\templates_c';

?>