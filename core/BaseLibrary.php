<?php
/**
 * Created by PhpStorm.
 * User: Sinri
 * Date: 2017/3/23
 * Time: 11:10
 */

namespace sinri\musikago\core;
use sinri\musikago\core\Musikago;


class BaseLibrary
{
    protected $Musikago;
    protected $db;

    public function __construct()
    {
        $this->Musikago=Musikago::getInstance();
        $this->db=$this->Musikago->db;
    }


    /**
     * The short name for the library if exists, or false when undefined.
     * @return mixed
     */
    public function shortName(){
        return false;
    }
}