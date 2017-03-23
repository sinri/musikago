<?php
/**
 * Created by PhpStorm.
 * User: Sinri
 * Date: 2017/3/23
 * Time: 11:05
 */

namespace sinri\musikago\agent;

use sinri\musikago\core\Musikago;

class BaseAgent
{
    protected $Musikago;

    public function __construct()
    {
        $this->Musikago=Musikago::getInstance();
    }

    public function index($params=[]){
        echo "Under Construction...";
    }
}