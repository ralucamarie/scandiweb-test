<?php
defined('DS')? null : define('DS', DIRECTORY_SEPARATOR);

define ('SITE_ROOT', 'C:' .DS. 'xampp' .DS.'htdocs' .DS. 'WebShop');
defined('INCLUDES_PATH')? null : define ('INCLUDES_PATH', SITE_ROOT .DS. 'includes');

// require_once ("functions.php");
require_once ("functions.php");
require_once ("config.php");
require_once ("database.php");
require_once ("classes/db_object.php");
require_once ("classes/product.php");
require_once ("classes/product_entry.php");
require_once ("classes/product_type.php");
require_once ("classes/product_attribute.php");


// require_once ("session.php");

?>