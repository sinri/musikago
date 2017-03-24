<?php
/**
 * Created by PhpStorm.
 * User: Sinri
 * Date: 2017/3/23
 * Time: 23:26
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
        .box {
            text-align: center;
            font-family: "Lucida Console",monospace;
        }
    </style>
</head>
<body>
<div id="head_bar">
    <div class="bar_item left">Musikago Login</div>
    <!-- Left | Right -->
<!--    <button class="bar_item right">Log Out</button>-->
    <div class="bar_item right" id="head_bar_user_div"></div>
    <!-- clear -->
    <div class="clear"></div>
</div>
<div id="container">
    <div class="box">
        <div>
            <div class="bar_item">Username: </div>
            <div class="bar_item"><input id="username" type="text"></div>
            <div class="clear"></div>
        </div>
        <div>
            <div class="bar_item">Password:</div>
            <div class="bar_item"><input id="password" type="password"></div>
            <div class="clear"></div>
        </div>
        <div>
            <button id="login_btn">Login</button>
        </div>
        <p id="message">

        </p>
    </div>
</div>
<script>
    $(document).ready(function () {
        $("#login_btn").bind("click",function (event) {
            var username_value=$("#username").val();
            var password_value=$("#password").val();
            var message=$("#message");

            if(!/^[A-Za-z0-9_\/]+$/.test(username_value)){
                message.val("Username should me empty!");
                return false;
            }
            if(password_value.length===0){
                message.val("Password should me empty!");
                return false;
            }
            $.ajax({
                url:MusikagoJs.api('SessionAgent','login'),
                method:'POST',
                data:{
                    username:username_value,
                    password:password_value
                },
                dataType:'json'
            }).done(function(result){
                if(result.code && result.code==='OK'){
                    location.href=MusikagoJs.api('HomeAgent','index');
                }else{
                    var error='Unknown Error';
                    if(result.data){
                        error=result.data;
                    }
                    $("#message").val(error);
                }
            }).fail(function(err){
                $("#message").val('AJAX Failed');
            })
        })
    })

</script>
</body>
</html>