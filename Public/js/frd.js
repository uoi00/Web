window.ab=0;
function fzxg(va){
    var name=prompt("请输入要修改的名子");
    if(name==null){
        alert('请输入内容！');
        return;
    }else {
        $.post(url + '/Home/Friend/fzxg', {va: va, name: name}, function (msg) {
            if (msg == 1) {
                window.location.href = url + '/Home/User/friend';
            }
        });
    }
}
function fzsc(va){
    $.ajax({
        url:url+"/Home/Friend/isnull",
        data: {va:va},
        dateType:'json',
        async:false,
        type:'post',
        success:function(msg) {
            ab=msg;
        }
    });
    if(ab<1) {
        if (confirm("点击确认后删除！！！")) {
            $.post(url + '/Home/Friend/fzsc', {va: va},function(msg){
                if(msg==1) {
                    window.location.href = url + '/Home/User/friend';
                }
            });
        }
    }
}
function czfrd(){
    var sou=$("#sou").val();
    if(sou.length<1){
        alert('请输入搜索内容');
    }else{
        $.post(url+'/Home/Friend/czfrd',{va:sou},function(msg){
            $("#czfrd").css('display','');
            $("#czfrd").html(msg);
        });
    }
}
function fdsel(va,va1){
    open(url+'/Home/Friend/fdsel?va='+va+'&va1='+va1);
}
function fdup(va,va1){
    var name=prompt("请输入要修改的名子");
    if(name==null){
        alert('请输入内容！');
        return;
    }else {
        $.post(url + '/Home/Friend/fdup', {va: va, va1: va1, name: name}, function (msg) {
            if (msg == 1) {
                window.location.href = url + '/Home/User/friend';
            }
        });
    }
}
function fddel(va,va1){
    if (confirm("点击确认后删除！！！")) {
        $.post(url + '/Home/Friend/fddel', {va: va, va1: va1},function(msg){
            if(msg==1) {
                window.location.href = url + '/Home/User/friend';
            }
        });
    }
}
function zhss(){
    var sou=$("#iptj").val();
    if(sou.length<1){
        alert('请输入搜索内容');
    }else{
        $.post(url+'/Home/Friend/zhss',{va:sou},function(msg){
            $("#zyss").html(msg);
        });
    }
}
function tjss(){
    var sex=$("#sex").val();
    var age=$("#age").val();
    var prov=$("#prov").val();
    var city=$("#city").val();
    $.post(url+'/Home/Friend/tjss',{sex:sex,age:age,prov:prov,city:city},function(msg){
        $("#zyss").html(msg);
    });
}
function ckinfo(info){
    open(url+'/Home/Friend/ckinfo?va='+info);
}

function addhy(){
    var id=$(".hyid:checked").val();
    var bz=$("#bz").val();
    var yz=$("#yzxx").val();
    var fz=$("#hyfz").val();
    $.post(url + '/Home/Friend/addhy', {id: id,bz: bz,yz: yz,fz: fz},function(msg){

    });
}

function cxinfo(){
    $.post(url + '/Home/Info/selinfo','',function(msg){
        $("#xxts").text(msg);
    })
}
function tyadd(){
    var id=$(".xox:checked").val();
    var fz=$("#hyfz").val();
    var bz=$("#bz").val();
    if(id==''|| id==undefined){
        alert('请选择要添加的好友');
        return;
    }
    $.post(url + '/Home/Info/tyadd',{id: id,fz: fz,bz: bz});
}
function juadd(){
    var ly=prompt("您可以输入拒绝理由：");
    var id=$(".xox:checked").val();
    if(id==''|| id==undefined){
        alert('请选择要拒绝的用户');
        return;
    }
    $.post(url + '/Home/Info/juadd',{id: id,ly: ly});
}
$(document).ready(function(){
    $("#tjfz").click(function(){
        var name=prompt("请输入要添加分组的名子：");
        if(name.length<1){
            alert('请输入内容！');
            return;
        }
        $.post(url+'/Home/Friend/tjfz',{name:name},function(msg){
            if(msg==1) {
                window.location.href = url + '/Home/User/friend';
            }
        });
    });
    $("#cz").click(function(){czfrd();});
    $("#zhss").click(function(){zhss();});
    $("#tjss").click(function(){tjss();});
    $("#tjhy").click(function(){addhy();});
    $("#tyadd").click(function(){tyadd();});
    cxinfo();
});