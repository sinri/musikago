<?php
/**
 * Created by PhpStorm.
 * User: Sinri
 * Date: 2017/3/25
 * Time: 19:01
 */

namespace sinri\musikago\agent;


use sinri\musikago\core\LibOutput;

class IssueAgent extends BaseAgent
{
    public function __construct()
    {
        parent::__construct();
        $this->Musikago->loadLibrary('ProjectKit');
        $this->Musikago->loadLibrary('IssueKit');
    }

    public function index(){
        $issue_id=$this->Musikago->input->readGet('issue_id',0);
        $this->Musikago->output->view('IssueAgent/IndexView',["issue_id"=>$issue_id]);
    }

    public function ajaxIssueDetail(){
        $issue_id=$this->Musikago->input->readGet('issue_id',0);
        $issue_detail=$this->Musikago->IssueKit->issueDetail($issue_id);

        $event_list=$this->Musikago->IssueKit->issueEvents($issue_id);

        if(!empty($event_list)){
            foreach ($event_list as $event_index => $event){
                $event_id=intval($event['event_id']);
                $attribute_list=$this->Musikago->IssueKit->issueEventAttributes($event_id);
                $event_list[$event_index]['attribute_list']=$attribute_list?$attribute_list:[];
            }
        }
        $event_list=$event_list?$event_list:[];

        $can_edit_issue=$this->Musikago->IssueKit->canUserEditIssue($_SESSION['user_id'],$issue_id);

        $data=[
            "issue_detail"=>$issue_detail,
            "event_list"=>$event_list,
            "can_edit_issue"=>$can_edit_issue,
        ];
        $this->Musikago->output->jsonForAjax(LibOutput::AJAX_JSON_CODE_OK,$data);
    }
}