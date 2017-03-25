<?php
/**
 * Created by PhpStorm.
 * User: Sinri
 * Date: 2017/3/25
 * Time: 16:01
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
    <div id="projects_pane" class="pane">
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        MusikagoJs.loadHeadBar('My Projects');

        MusikagoJs.ajaxGetJson(
            MusikagoJs.api('ProjectAgent','ajaxUserProjects',{'user_id':MusikagoJs.getCookie("user_id")}),
            function(data){
                console.log(data);
                var code='';
                if(data.projects){
                    code="<h1>User Projects Page</h1>" +
                        "<ul>";
                    for(var i=0;i<data.projects.length;i++){
                        var project_id=data.projects[i]['project_id'];
                        code+="<li>";
                        code+="<a href='javascript:void(0);' onclick='MusikagoJs.openProjectPage("+project_id+")'>";
                        code+=data.projects[i]['project_name'];
                        code+="</a>";
                        code+=" - ";
                        code+=data.projects[i]['status'];
                        code+="</li>";
                    }
                    code+="</ul>";
                }else{
                    code="<p>ERROR</p>";
                }
                $("#projects_pane").html(code);
            },
            function(data){
                alert(data);
            }
        )

    });
</script>
</body>
</html>