<?php
/**
 * Created by PhpStorm.
 * User: Sinri
 * Date: 2017/3/25
 * Time: 00:13
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
    </style>
</head>
<body>
<div id="head_bar"></div>
<div id="container">
    <h1>User Profile Page</h1>
    <div id="user_info_pane">
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        MusikagoJs.loadHeadBar('My Profile');

        $.ajax({
            url:MusikagoJs.api('UserAgent','ajaxUserInfo',{"user_id":MusikagoJs.getCookie("user_id")}),
            method:'GET',
            dataType:'json'
        }).done(function(result){
            console.log(result);

            if(result.code==='OK'){
                loadUserProfilePage(result.data);
            }else{
                alert('api error: '+result.data);
            }
        }).fail(function(){
            alert('ajax failed');
        });

        function loadUserProfilePage(data){
            // user info
            var code='';

            code="<p>";
            code+="Username: <span id='user_name_span'>";
            code+=data.user_info.user_name;
            code+="</span>&nbsp;&nbsp;";
            code+="Display Name: <span id='display_name_span'>";
            code+=data.user_info.display_name;
            code+="</span>&nbsp;&nbsp;";
            code+="Email: <span id='email_span'>";
            code+=data.user_info.email;
            code+="</span>&nbsp;&nbsp;";
            code+="</p>";
            code+="<p>";
            code+="Since <span id='since_span'>";
            code+=data.user_info.create_time;
            code+="</span>&nbsp;&nbsp;";
            code+="</p>";

            code+="<p>";
            code+="Site Role: <span id='site_role_span'>";
            code+=(data.user_info.site_role==='ADMIN')?'ADMIN':'Common User';
            code+="</span>";
            code+="</p>";

            $("#user_info_pane").html(code);

        }
    })
</script>
</body>
</html>