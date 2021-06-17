<?php

defined('DS') ? null : define('DS', DIRECTORY_SEPARATOR);

define('SITE_ROOT', DS. 'opt' . DS . 'lampp' . DS . 'htdocs' . DS . 'gallery_db');

defined('INCLUDES_PATH') ? null : define('INCLUDES_PATH', SITE_ROOT.DS.'admin'.DS.'includes');


//what we're going to have is a file that is going to initialize everything in our CMS system
require_once("functions.php");
require_once("config.php");
require_once("database.php");
require_once("user.php");
require_once("photo.php");
require_once("session.php");
require_once("db_object.php");



?>