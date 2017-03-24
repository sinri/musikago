/**
 * Created by Sinri on 2017/3/24.
 */
var MusikagoJs={
    apiBase:'.',
    api:function (agent,action) {
        return MusikagoJs.apiBase+'/?agent='+agent+'&action='+action;
    },
    loadHeadBar:function(title){
        if(!title){
            title='Home';
        }
        var headBarCode='<div class="bar_item left">';
        headBarCode+='<a href="javascript:void(0);" onclick="MusikagoJs.openHome()">Musikago</a> - '+title;
        headBarCode+='</div>';
        headBarCode+='<button class="bar_item right" id="logout_btn" onclick="MusikagoJs.logout();">Log Out</button>';
        headBarCode+='<div class="bar_item right" id="head_bar_user_div"></div>';
        headBarCode+='<div class="clear"></div>';
        $("#head_bar").html(headBarCode);


        $.ajax({
            url:MusikagoJs.api('SessionAgent','currentUserInfo'),
            method:'GET',
            dataType:'json'
        }).done(function(result){
            console.log(result);
            if(result && result.code==='OK'){
                console.log("-> ",result.data.user_name);
                var block=$("#head_bar_user_div");
                console.log(block);
                if(block){
                    var code="<a href='javascript:void(0);' class='head' ";
                    code += " onclick='MusikagoJs.openUserProfile("+result.data.user_id+")'>";
                    code += result.data.display_name;
                    code += "</a>";
                    block.html(code);
                }else{
                    console.log("not found head_bar_user_div !");
                }
            }else{
                var err="unknown";
                if(result && result.data){
                    err=result.data;
                }
                alert("loadHeadBar failed: "+err);
                MusikagoJs.logout();
            }
        }).fail(function(){
            alert("loadHeadBar ajax failed");
            MusikagoJs.logout();
        });
    },
    logout:function(){
        top.location=MusikagoJs.api('SessionAgent','entrance');
    },
    openHome:function(){
        top.location=MusikagoJs.api('HomeAgent','index');
    },
    openUserProfile:function(){
        top.location=MusikagoJs.api('UserAgent','userProfile');
    }
}