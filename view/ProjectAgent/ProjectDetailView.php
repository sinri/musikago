<?php
/**
 * Created by PhpStorm.
 * User: Sinri
 * Date: 2017/3/25
 * Time: 16:43
 */
?>
<!doctype html>
<html>
<head>
    <title>Musikago</title>
    <script src="./asset/js/jquery/2.2.4/jquery.min.js"></script>
    <script src="./asset/js/AgentHeader.js"></script>
    <link rel="stylesheet" type="text/css" href="./asset/css/AgentStyle.css">
    <style type="text/css">
        #user_info_pane p{
            margin: 10px;
        }
        ul {
            margin: 10px;
        }
    </style>
</head>
<body>
<div id="head_bar"></div>
<div id="container">
    <div id="project_pane" class="pane">
    </div>
</div>
<script type="text/javascript">
    var the_project_id='<?php echo $project_id;?>';
    $(document).ready(function() {
        MusikagoJs.loadHeadBar('Project '+the_project_id);

        MusikagoJs.ajaxGetJson(
            MusikagoJs.api('ProjectAgent','ajaxProjectDetail',{'project_id':the_project_id}),
            function(data) {
                console.log(data);
                var project=data.project_detail;
                var code="";
                code+="<h1>Project "+project.project_id+": "+project.project_name+" ("+project.status+")</h1>";
                code+="<h2>Issues</h2>";
                code+="<table>";
                code+="<tr>";
                code+="<th>Issue ID</th>";
                code+="<th>Title</th>";
                code+="<th>Priority</th>";
                code+="<th>Reporter</th>";
                code+="<th>Assigned</th>";
                code+="<th>Status</th>";
                code+="<th>Since</th>";
                code+="<th>Recent</th>";
                code+="</tr>";
                for(var issue_index=0;issue_index<project.issue_list.length;issue_index++){
                    var issue=project.issue_list[issue_index];
                    code+="<tr>";
                    code+="<td>"+issue.issue_id+"</td>";
                    code+="<td>" +
                        "<a href='javascript:void(0);' onclick='MusikagoJs.openIssuePage("+issue.issue_id+")' >" +
                        issue.issue_title +
                        "</a>" +
                        "</td>";
                    code+="<td>"+issue.priority+"</td>";
                    code+="<td>"+issue.report_user_display_name+"</td>";
                    code+="<td>"+issue.assigned_user_display_name+"</td>";
                    code+="<td>"+issue.current_status+"</td>";
                    code+="<td>"+issue.create_time+"</td>";
                    code+="<td>"+issue.update_time+"</td>";
                    code+="</tr>";
                }
                code+="</table>";

                $("#project_pane").html(code);
            },
            function (data) {
                alert(data);
            }
        );
    });
</script>
</body>
</html>