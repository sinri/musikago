<?php
/**
 * Created by PhpStorm.
 * User: Sinri
 * Date: 2017/3/23
 * Time: 10:24
 */
require_once (__DIR__.'/vendor/autoload.php');
require_once (__DIR__.'/core/Musikago.php');
use sinri\musikago\core\Musikago;

$musikago=Musikago::getInstance();
$musikago->start();