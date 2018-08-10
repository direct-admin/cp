<?php if(!isset($_SESSION)){
session_start();	
}

// site domain name with http
define("SITE_URL","http://".$_SERVER['SERVER_NAME']);

// directory separator
define("DS", DIRECTORY_SEPARATOR);

// root path
define("ROOT_PATH", realpath(dirname(__FILE__) . DS . "..".DS));


// classes folder
define("CLASSES_DIR", "classes");

// library folder
define("LIBRARY_DIR", "library");

// add all above directories to the include path
set_include_path(implode(PATH_SEPARATOR,array(
realpath(ROOT_PATH.DS.LIBRARY_DIR.DS.CLASSES_DIR),
realpath(ROOT_PATH.DS.LIBRARY_DIR),
get_include_path()
)));