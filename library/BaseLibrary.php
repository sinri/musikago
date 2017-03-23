<?php
/**
 * Created by PhpStorm.
 * User: Sinri
 * Date: 2017/3/23
 * Time: 11:10
 */

namespace sinri\musikago\library;
use sinri\musikago\core\Musikago;


class BaseLibrary
{
    protected $Musikago;

    public function __construct()
    {
        $this->Musikago=Musikago::getInstance();
    }
}