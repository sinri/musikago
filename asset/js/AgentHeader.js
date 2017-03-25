/**
 * Created by Sinri on 2017/3/24.
 */
var MusikagoJs = {
    setCookie: function (c_name, value, expire_days) {
        var ex_date = new Date();
        ex_date.setDate(ex_date.getDate() + expire_days);
        document.cookie = c_name + "=" + encodeURIComponent(value) +
            ((!expire_days) ? "" : ";expires=" + ex_date.toGMTString())
    },
    getCookie: function (c_name) {
        if (document.cookie.length > 0) {
            c_start = document.cookie.indexOf(c_name + "=");
            if (c_start !== -1) {
                c_start = c_start + c_name.length + 1;
                c_end = document.cookie.indexOf(";", c_start);
                if (c_end === -1) c_end = document.cookie.length;
                return decodeURIComponent(document.cookie.substring(c_start, c_end));
            }
        }
        return ""
    },
    apiBase: '.',
    api: function (agent, action, params) {
        var url = MusikagoJs.apiBase + '/?agent=' + agent + '&action=' + action;
        if (params) {
            for (var key in params) {
                url += "&" + key + "=" + encodeURIComponent(params[key]);
            }
        }
        return url;
    },
    loadHeadBar: function (title) {
        if (!title) {
            title = 'Home';
        }
        var headBarCode = '<div class="bar_item left">';
        headBarCode += '<a href="javascript:void(0);" onclick="MusikagoJs.openHome()">Musikago</a> - ' + title;
        headBarCode += '</div>';
        headBarCode += '<button class="bar_item right" id="logout_btn" onclick="MusikagoJs.logout();">Log Out</button>';
        headBarCode += '<div class="bar_item right" id="head_bar_user_div"></div>';
        headBarCode += '<div class="bar_item right" id="head_bar_projects_div">';
        headBarCode += '<a href="javascript:void(0);" onclick="MusikagoJs.openMyProjects()">Projects</a>';
        headBarCode += '</div>';
        headBarCode += '<div class="clear"></div>';
        $("#head_bar").html(headBarCode);


        $.ajax({
            url: MusikagoJs.api('SessionAgent', 'currentUserInfo'),
            method: 'GET',
            dataType: 'json'
        }).done(function (result) {
            console.log(result);
            if (result && result.code === 'OK') {
                console.log("-> ", result.data.user_name);
                MusikagoJs.setCookie("user_id",result.data.user_id);
                var block = $("#head_bar_user_div");
                console.log(block);
                if (block) {
                    var code = "<a href='javascript:void(0);' class='head' ";
                    code += " onclick='MusikagoJs.openUserProfile(" + result.data.user_id + ")'>";
                    code += result.data.display_name;
                    code += "</a>";
                    block.html(code);
                } else {
                    console.log("not found head_bar_user_div !");
                }
            } else {
                var err = "unknown";
                if (result && result.data) {
                    err = result.data;
                }
                alert("loadHeadBar failed: " + err);
                MusikagoJs.logout();
            }
        }).fail(function () {
            alert("loadHeadBar ajax failed");
            MusikagoJs.logout();
        });
    },
    ajaxGetJson:function(url,callback_for_ok,callback_for_fail){
        $.ajax({
            url:url,
            method:'GET',
            dataType:'json'
        }).done(function(result){
            if(result && result.code==='OK'){
                callback_for_ok(result.data);
            }else{
                callback_for_fail(result.data);
            }
        }).fail(function(){
            callback_for_fail("AJAX Failed");
        })
    },
    logout: function () {
        top.location = MusikagoJs.api('SessionAgent', 'entrance');
    },
    openHome: function () {
        top.location = MusikagoJs.api('HomeAgent', 'index');
    },
    openUserProfile: function () {
        top.location = MusikagoJs.api('UserAgent', 'userProfile');
    },
    openMyProjects:function(){
        top.location = MusikagoJs.api('ProjectAgent', 'index');
    },
    openProjectPage:function(project_id){
        top.location = MusikagoJs.api('ProjectAgent', 'projectDetailPage',{project_id:project_id});
    },
    openIssuePage:function (issue_id) {
        top.location = MusikagoJs.api('IssueAgent','index',{issue_id:issue_id});
    }
}