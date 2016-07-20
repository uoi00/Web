//表单提交事件onsubmit
window.a=false;
window.mailt=false;
window.ckmail=false;
$(document).ready(function(){
    //鼠标离开邮箱输入框，调用邮箱验证
    $("#user").blur(function(){mail()});
    $("#fmail").blur(function(){ffmail()});
    //鼠标离开邮箱输入框，调用密码检测
    $("#pwd").blur(function(){pwd()});
    //鼠标离开邮箱输入框，校对验证码
    $("#ym").blur(function(){ym()});
    //邮箱验证
    $("#mail").blur(function(){mails()});
    //监听获取验证码按钮
    $("#hq").click(function(){hq()});
    //核对邮箱验证码
    $("#yzm").blur(function(){mailyzm();});
    //判断重复密码
    $("#rpwd").blur(function(){rpwd()});
});
//邮箱验证
function mail() {
    var name = $("#user").val().length;  //用户
    //检测账户
    if (name < 5) {
        $("#inf").html("帐号不正确");
        return false;
    } else {
        $("#inf").html("");
        return true;
    }
}
function ffmail(){
    var m=$("#fmail").val();
    var ru=/^(\w)+\@(\w)+\.(\w){2,5}$/;
    var rzt= m.match(ru);
    if(rzt==null){
        $("#inf").html("请填写正确邮箱");
        return;
    }else{
        $.ajax({
            url:url+"/Home/Index/mail",
            data: {mail : m},
            dateType:'json',
            async:false,
            type:'post',
            success:function(msg){
                if (msg==1) {
                    mailt=true;
                }else {
                    $("#inf").html('该用户不存在，<a href='+url+"/Home/Index/register"+'>点击注册</a>');

                }
            }
        });
    }
}
//密码检测
function pwd(){
    var pwd=$("#pwd").val().length;    //密码
    if(pwd<5){
        $("#inf").html("密码过短");
        return false;
    }else{
        $("#inf").html("");
        return true;
    }
}
//验证码校对
function ym(){
    var ym=$("#ym").val();
    $.ajax({
        url:url+"/Home/Index/yzms",
        data: {ym : ym},
        dateType:'json',
        async:false,
        type:'post',
        success:function(msg){
            if (msg==1) {
                $("#inf").html("");
                a=true;
            }else {
                $("#inf").html("验证码错误");
                a=false;
            }
        }
    });
}
function mails(){
    var m=$("#mail").val();
    var ru=/^(\w)+\@(\w)+\.(\w){2,5}$/;
    var rzt= m.match(ru);
    if(rzt==null){
        $("#inf").html("请填写正确邮箱");
        return;
    }else{
        $.ajax({
            url:url+"/Home/Index/mail",
            data: {mail : m},
            dateType:'json',
            async:false,
            type:'post',
            success:function(msg){
                if (msg==1) {
                    $("#inf").html("该邮箱已注册");
                    return;
                }else {
                    $("#inf").html("");
                    mailt=true;
                }
            }
        });
    }
}
function hq(){
    console.log(mailt +' '+ a);
    if(mailt&& a){
        $("#mail").attr("readonly","readonly");
        $("#hq").attr("value","重新发送");
        $.post(url+"/Home/Index/atcmail",{mail:$("#mail").val()});
    }
}
function mailyzm(){
    var mailyzm=$("#yzm").val();
    if(mailyzm==''){
        $("#inf").html("请输入邮箱验证码");
        return;
    }else {
        $.ajax({
            url: url + "/Home/Index/ckmail",
            data: {mailyzm: mailyzm},
            dateType: 'json',
            async: false,
            type: 'post',
            success: function (msg) {
                if (msg == 1) {
                    $("#inf").html("");
                    ckmail = true;
                } else {
                    $("#inf").html("邮箱验证码错误");
                }
            }
        });
    }
}
function rpwd(){
    if($("#pwd").val()!=$("#rpwd").val()){
        $("#inf").html("密码不一致");
        return false;
    }else {
        $("#inf").html("");
        return true;
    }
}
function dl(){
    if(mail()&&pwd()&&a){
        return true;
    }else{
        return false;
    }
}
function zc(){
    if(ckmail&&pwd()&&rpwd()){
        return true;
    }else{
        return false;
    }
}
function fod(){
    if(ckmail){
        return true;
    }else{
        return false;
    }
}
function up(){
    if(pwd()&&rpwd()){
        return true;
    }else{
        return false;
    }
}
