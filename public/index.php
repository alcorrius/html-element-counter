<?php
/**
 * Created by PhpStorm.
 * User: alcorrius
 * Date: 19.08.17
 * Time: 15:39
 */

require_once __DIR__ . '/../app/autoloader.php';

$router = new core\Router();
$router->route($_SERVER['REQUEST_URI']);