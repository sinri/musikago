<?php
/**
 * Created by PhpStorm.
 * User: Sinri
 * Date: 2017/3/23
 * Time: 11:04
 */

namespace sinri\musikago\agent;


class HomeAgent extends BaseAgent
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index($params=[]){
        $assigned_data=["post"=>json_encode($params)];
        $this->Musikago->LibOutput->view("HomeAgent/IndexView",$assigned_data);
    }
}