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
        $this->Musikago = Musikago::getInstance();
        $this->Musikago->session->sessionStart();
        if($this->needLogin() && !$this->holdingLoginSession()){
            //$this->entrance();
            header("Location: ./?agent=SessionAgent&action=entrance");
            exit();
        }
    }

    public function index()
    {
        echo "Under Construction...";
    }

    public function needLogin(){
        return true;
    }

    public final function holdingLoginSession(){
        if(isset($_SESSION['user_id'])){
            return true;
        }else{
            return false;
        }
    }

    public final function entrance()
    {
        $this->Musikago->session->sessionRestart();
        $this->Musikago->output->view('SessionAgent/GateView');
        exit();
    }

    /**
     * @deprecated
     */
    public final function logout(){
        $this->Musikago->session->sessionRestart();
        header("Location: ./?agent=SessionAgent&action=entrance");
        exit();
    }
}