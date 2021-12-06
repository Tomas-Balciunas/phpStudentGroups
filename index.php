<?php 

error_reporting(E_ALL);
ini_set('display_errors', '1');
require "vendor/autoload.php";

use NFQ\Request;
use NFQ\Router;

require Router::load('routes.php')->direct(Request::uri());