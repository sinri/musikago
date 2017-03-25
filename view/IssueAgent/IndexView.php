<?php
/**
 * Created by PhpStorm.
 * User: Sinri
 * Date: 2017/3/25
 * Time: 19:04
 */
?>
<!doctype html>
<html>
<head>
    <title>Musikago</title>
    <script src="./asset/js/jquery/2.2.4/jquery.min.js"></script>
    <script src="./asset/js/AgentHeader.js"></script>
    <script src="./asset/js/markdown/markdown.min.js"></script>
    <link rel="stylesheet" type="text/css" href="./asset/css/AgentStyle.css">
    <link rel="stylesheet" type="text/css" href="./asset/css/MarkdownStyle.css">
    <style type="text/css">
        #user_info_pane p {
            margin: 10px;
        }

        ul {
            margin: 10px;
        }
        .event_list_div {
            width: 90%;
        }
        .event_div {
            margin-top: 10px;
        }
        .event_div:hover {
            background-color: lightgrey;
        }
        #edit_model_pane textarea{
            width: 90%;
            height: 150px;
        }
    </style>
</head>
<body>
<div id="head_bar"></div>
<div id="container">
    <div id="project_pane" class="pane"></div>
    <div id="issue_pane" class="pane"></div>
    <div id="event_pane" class="pane"></div>
    <div id="edit_model_pane" class="hide">
        <div>Add Comment:</div>
        <div><textarea id="edit_md"></textarea></div>
        <div><button>Submit</button></div>
    </div>
</div>
<script type="text/javascript">
    var issue_id = '<?php echo $issue_id;?>';
    $(document).ready(function () {
        MusikagoJs.loadHeadBar('Issue #'+issue_id);

        MusikagoJs.ajaxGetJson(
            MusikagoJs.api('IssueAgent', 'ajaxIssueDetail', {'issue_id': issue_id}),
            function (data) {
                console.log(data);

                var issue = data.issue_detail;

                var issueCode = "<h1>Issue #" + issue.issue_id + " - " + issue.issue_title + "</h1>";
                issueCode += "<p>" +
                    "Reported by " + issue.report_user_display_name + " " +
                    "on " + issue.create_time + " " +
                    "</p>" +
                    "<p>" +
                    "Assigned to "+issue.assigned_user_display_name +
                    "</p>" +
                    "<p>" +
                    "Current Status: " + issue.current_status + " as of " + issue.update_time +
                    "</p>";
                $("#issue_pane").html(issueCode);
                var projectCode = "<p>" +
                    "Project: " +
                    "<a href='javascript:void(0);' onclick='MusikagoJs.openProjectPage(" + issue.project_id + ")'>" +
                    issue.project_name +
                    "</a>" +
                    "</p>";
                $("#project_pane").html(projectCode);

                // events
                var events=data.event_list;
                var eventsCode='<div class="event_list_div">' +
                    '<p>Events:</p>';
                for(var i=0;i<events.length;i++){
                    var event=events[i];
                    eventsCode+='<div class="event_div">' +
                        '<p>Event ('+event.event_id+') ['+event.event_status+'] posted on '+event.create_time+
                        (event.create_time!==event.update_time?(' edited on '+event.update_time):'')+
                        '</p>' +
                        '<div class="markdown">'+markdown.toHTML(event.description)+'</div>' +
                        '</div>';
                }
                eventsCode+="</div>";
                $("#event_pane").html(eventsCode);

                //new
                if(data.can_edit_issue){
                    $("#edit_model_pane").attr("class","pane");
                }
            },
            function (data) {
                alert(data);
            }
        );

        document.onpaste = function(event){
            var items = (event.clipboardData || event.originalEvent.clipboardData).items;
            console.log(items);
            console.log('ITEMS->MIME',JSON.stringify(items)); // will give you the mime types
            for (var index in items) {
                if(!items.hasOwnProperty(index)){
                    continue;
                }
                var item = items[index];
                if (item.kind === 'file') {
                    var blob = item.getAsFile();
                    var reader = new FileReader();
                    reader.onload = function(event_load){
                        console.log('DATA_URL',event_load.target.result);
                    }; // data url!
                    reader.readAsDataURL(blob);
                }else{
                    if ((item.kind === 'string') &&
                        (item.type.match('^text/plain'))) {
                        // This item is the target node
                        item.getAsString(function (s){
                            console.log(s);
                        });
                    } else if ((item.kind === 'string') &&
                        (item.type.match('^text/html'))) {
                        // Drag data item is HTML
                        console.log("... Drop: HTML");
                    } else if ((item.kind === 'string') &&
                        (item.type.match('^text/uri-list'))) {
                        // Drag data item is URI
                        console.log("... Drop: URI");
                    }
                }
            }
        }
    });
</script>
</body>
</html>