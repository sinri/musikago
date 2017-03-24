<?php
/**
 * Created by PhpStorm.
 * User: Sinri
 * Date: 2017/3/23
 * Time: 23:20
 */

namespace sinri\musikago\agent;


class UserAgent extends BaseAgent
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index(){
        $this->Musikago->output->view('UserAgent/IndexView');
    }

    public function userProfile(){
        $this->Musikago->output->view('UserAgent/UserProfileView');
    }
}