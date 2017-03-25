<?php
/**
 * Created by PhpStorm.
 * User: Sinri
 * Date: 2017/3/25
 * Time: 15:38
 */

namespace sinri\musikago\library;


use sinri\musikago\core\BaseLibrary;

class ProjectKit extends BaseLibrary
{
    public function __construct()
    {
        parent::__construct();
    }

    public function listAllProjects(){
        $sql="SELECT project_id, project_name,`status` FROM project WHERE `status`!='deleted'";
        $list=$this->db->getAll($sql);
        return $list;
    }

    public function listProjectsOfUser($user_id){
        $user_id=intval($user_id);
        $sql="SELECT p.project_id, p.project_name,p.`status`,pu.role
          FROM project_user pu
          inner join user u on pu.user_id=u.user_id and u.disabled!='YES'
          inner join project p on pu.project_id=p.project_id and p.status!='deleted'
          where u.user_id={$user_id} and pu.role!='disabled'
        ";
        $list=$this->db->getAll($sql);
        return $list;
    }

    public function projectInfo($project_id){
        $project_id=intval($project_id);
        $sql="SELECT p.project_id, p.project_name,p.`status` 
          FROM project p
          WHERE p.`project_id`={$project_id}";
        $project_info=$this->db->getRow($sql);
        return $project_info;
    }

    public function projectMembers($project_id){
        $project_id=intval($project_id);
        $sql="select pu.mapping_id,pu.user_id,pu.role,u.display_name,u.disabled
        from project_user pu
        inner join user u on pu.user_id=u.user_id
        where pu.project_id={$project_id}
        and pu.role!='disabled'
        ";
        $members=$this->db->getAll($sql);
        return $members;
    }

    public function projectIssues($project_id){
        $project_id=intval($project_id);
        $sql="select i.issue_id,i.issue_title,i.priority,i.current_status,
            i.create_time,i.update_time, 
            i.report_user_id,ur.user_name as report_user_name,ur.display_name as report_user_display_name,
            i.assigned_user_id,ua.user_name as assigned_user_name,ua.display_name as assigned_user_display_name
          from issue i
          left join user ur on ur.user_id=i.report_user_id
          left join user ua on ua.user_id=i.assigned_user_id
          where i.project_id={$project_id}
         ";
        $issue_list=$this->db->getAll($sql);
        return $issue_list;
    }

    public function projectDetails($project_id){
        $project_info=$this->projectInfo($project_id);
        if(!$project_info){
            return false;
        }
        $project_id=intval($project_id);

        $project_info['members']=$this->projectMembers($project_id);

        $issue_list=$this->projectIssues($project_id);

        if(!empty($issue_list)){
            foreach ($issue_list as $index => $issue){
                $issue_id=intval($issue['issue_id']);
                $event_list=$this->Musikago->IssueKit->issueEvents($issue_id);
                /*
                // This is not used yet, neglect deep information to save db time
                if(!empty($event_list)){
                    foreach ($event_list as $event_index => $event){
                        $event_id=intval($event['event_id']);
                        $attribute_list=$this->Musikago->IssueKit->issueEventAttributes($event_id);
                        $event_list[$event_index]['attribute_list']=$attribute_list?$attribute_list:[];
                    }
                }
                */
                $issue_list[$index]['event_list']=$event_list?$event_list:[];
            }
        }

        $project_info['issue_list'] = $issue_list?$issue_list:[];
        return $project_info;
    }
}