<?php
/**
 * Created by PhpStorm.
 * User: Sinri
 * Date: 2017/3/25
 * Time: 17:35
 */

namespace sinri\musikago\library;


use sinri\musikago\core\BaseLibrary;

class IssueKit extends BaseLibrary
{
    public function __construct()
    {
        parent::__construct();
    }

    public function issueDetail($issue_id){
        $issue_id=intval($issue_id);
        $sql="select i.issue_id,i.issue_title,i.current_status,i.create_time,i.update_time,
          p.project_id,p.project_name,p.status as project_status,
          i.report_user_id,ur.user_name as report_user_name,ur.display_name as report_user_display_name,
          ur.disabled as report_user_disabled,
          i.assigned_user_id,ua.user_name as assigned_user_name,ua.display_name as assigned_user_display_name,
          ua.disabled as assigned_user_disabled
        FROM issue i
        left join project p on i.project_id=p.project_id
        LEFT JOIN user ur on i.report_user_id=ur.user_id
        LEFT JOIN user ua on i.assigned_user_id=ua.user_id
        where i.issue_id={$issue_id}
        ";
        $row=$this->db->getRow($sql);
        return $row;
    }

    public function issueEvents($issue_id){
        $issue_id=intval($issue_id);
        $sql="SELECT
          e.event_id,
          e.user_id,
          ur.user_name,
          ur.display_name,
          e.event_status,
          e.description,
          e.create_time,
          e.update_time,
          e.assigned_user_id,
          ua.user_name assigned_user_name,
          ua.display_name assigned_display_name
        FROM event e
        left join user ur on e.user_id=ur.user_id
        left join user ua on e.user_id=ua.user_id
        WHERE e.issue_id = {$issue_id}
        ";
        $event_list=$this->db->getAll($sql);
        return $event_list;
    }

    public function issueEventAttributes($event_id){
        $sql="select attribute_id,`key`,value from event_attribute WHERE event_id={$event_id}";
        $attribute_list=$this->db->getAll($sql);
        return $attribute_list;
    }

    public function canUserEditIssue($user_id,$issue_id){
        $user_id=intval($user_id);
        $issue_id=intval($issue_id);
        $sql="select count(*) from issue i
        inner join project p on i.project_id=p.project_id
        inner join project_user pu on p.project_id = pu.project_id
        inner join user u on pu.user_id=u.user_id
        where p.status='normal'
        and pu.role in ('admin','developer','reporter')
        and u.disabled!='YES'
        and u.user_id={$user_id} and i.issue_id={$issue_id}
        ";
        $count=$this->db->getOne($sql);
        if($count){
            return true;
        }
        return false;
    }
}