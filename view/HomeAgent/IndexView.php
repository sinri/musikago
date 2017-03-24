<?php
/**
 * Created by PhpStorm.
 * User: Sinri
 * Date: 2017/3/23
 * Time: 11:52
 */
?>
<!doctype html>
<html>
    <head>
        <title>Musikago</title>
        <script src="./asset/js/jquery/2.2.4/jquery.min.js"></script>
        <script src="./asset/js/AgentHeader.js"></script>
        <link rel="stylesheet" type="text/css" href="./asset/css/AgentStyle.css">
    </head>
    <body>
        <div id="head_bar"></div>
        <div id="container">
            Welcome!
        </div>
        <script type="text/javascript">
            $(document).ready(function(){
                MusikagoJs.loadHeadBar('Home');
            })
        </script>
    </body>
</html>
