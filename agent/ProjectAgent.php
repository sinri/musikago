<?php
/**
 * Created by PhpStorm.
 * User: Sinri
 * Date: 2017/3/25
 * Time: 15:37
 */

namespace sinri\musikago\agent;


use sinri\musikago\core\LibOutput;

class ProjectAgent extends BaseAgent
{
    public function __construct()
    {
        parent::__construct();
        //$this->Musikago->loadLibrary('UserKit');
        $this->Musikago->loadLibrary('ProjectKit');
        $this->Musikago->loadLibrary('IssueKit');
    }

    public function index(){
        $this->Musikago->output->view('ProjectAgent/IndexView');
    }

    public function ajaxUserProjects(){
        $user_id=$this->Musikago->input->readGet('user_id',0);
        $projects=$this->Musikago->ProjectKit->listProjectsOfUser($user_id);
        $data=[
            "projects"=>$projects
        ];
        $this->Musikago->output->jsonForAjax(LibOutput::AJAX_JSON_CODE_OK,$data);
    }

    public function projectDetailPage(){
        $project_id=$this->Musikago->input->readGet('project_id',0);
        $this->Musikago->output->view('ProjectAgent/ProjectDetailView',['project_id'=>$project_id]);
    }
    public function ajaxProjectDetail(){
        $project_id=$this->Musikago->input->readGet('project_id',0);
        $detail=$this->Musikago->ProjectKit->projectDetails($project_id);
        $data=[
            "project_detail"=>$detail
        ];
        $this->Musikago->output->jsonForAjax(LibOutput::AJAX_JSON_CODE_OK,$data);
    }
}