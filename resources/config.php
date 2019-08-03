<?php

ob_start();
session_start();
// session_destroy();

defined("DS")? null: define("DS",DIRECTORY_SEPARATOR);

__DIR__;


defined("TEMPLATE_FRONT")? null: define("TEMPLATE_FRONT", __DIR__ .DS. "template/front" );
defined("TEMPLATE_BACK")? null: define("TEMPLATE_BACK", __DIR__ .DS. "template/back" );

defined("DB_HOST")? null: define("DB_HOST", "localhost" );
defined("DB_USER")? null: define("DB_USER", "root" );
defined("PASSWORD")? null: define("PASSWORD", "" );
defined("DB_NAME")? null: define("DB_NAME", "ecom_db" );

$connection = mysqli_connect(DB_HOST, DB_USER,PASSWORD,DB_NAME);

require_once("functions.php");
require_once('cart.php');

