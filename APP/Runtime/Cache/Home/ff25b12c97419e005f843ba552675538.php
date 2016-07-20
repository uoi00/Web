<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link type="text/css" rel="stylesheet" href="/uweb/Public/css/bootstrap.min.css">
    <style type="text/css">
        <!--
        #bdy{
            float: none;
            position: absolute;
            left: 10%;
        }
        #cwrz,#wrz,#rz{
            position: relative;
        }
        .rzs{
            height: 80px;
            position: relative;
            background: lightyellow;
        }
        .rzbd{
            position: relative;
            top: 2px;
            left: 2px;
        }
        .tb{
            height: 75px;
            width: 75px;
            float: left;
            position: relative;
            left: 2px;
            top: 2px;
        }
        .titl{
            height: 28px;
            position: relative;
            top: 1px;
            left: 2px;
            font-size: 16px;
            font-weight: bold;
        }
        .gn{
            position: relative;
            bottom: 3px;
            right: 3px;
            font-weight: 300;
        }

        -->
    </style>
</head>
<body>
<div id="bdy" class="col-xs-12 col-md-6">
    <button data-toggle="collapse" data-target="#wrz" id="cwrz">写日志</button>
    <div class="collapse" id="wrz">
        <form action="/uweb/index.php/Home/Rizhi/wrz" method="post" onsubmit="return fb()">
            <input type="text" name="til" id="til" size="20" align="center" placeholder="日志标题"><br><br>
            <textarea cols="80" rows="8" name="cont"></textarea><br>
            <div align="right">
                <select name="power"><option value="2">仅好友</option><option value="1">仅自己</option><option value="3">不限制</option></select> &nbsp; &nbsp; &nbsp; &nbsp;
                <button type="submit" name="sub">发表</button>
            </div>
        </form>
    </div>
    <div id="rz">

    </div>
</div>


</body>
<script src="/uweb/Public/js/jquery-1.12.3.min.js"></script>
<script src="/uweb/Public/js/bootstrap.min.js"></script>
<script src="/uweb/Public/js/jquery.cityselect.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $.post("/uweb/index.php/Home/Rizhi/getrz",'',function(msg){
            var a = JSON.parse(msg);
            var ccc = '';
            for(i=0;a[i];i++) {
                var json = JSON.parse(a[i]);
                ccc = ccc +'<div class="rzs" id="' + json["rid"] + '"><img src="/uweb/Public/img/rz.jpg" class="tb"><div class="rzbd"><div class="titl">' + json['title'] + '<div class="gnk"><select name="gn" class="gn"><option onclick="ck(' + json["rid"] + ')"> 查看 </option><option onclick="xg('+ json["rid"] +')"> 修改 </option><option onclick="sc('+ json["rid"] +')"> 删除 </option></select></div></div></div></div>';
            }
            $("#rz").html(ccc);
        });
    });
    function fb(){
        if($("#til").val() == ''){
            alert('标题不能为空');
            return false;
        }else{
            return true;
        }
    }
    function ck(cs){

    }
    function xg(cs){
        open("/uweb/index.php/Home/Rizhi/upd?cs="+cs);
    }
    function sc(cs){
        if (confirm("点击确认后删除！！！")) {
            $.post("/uweb/index.php/Home/Rizhi/dlt",{cs: cs},function(msg){
               if(msg == 1){
                   alert('删除成功！');
               }else{
                   alert('删除失败！');
               }
                window.location.href="/uweb/index.php/Home/Rizhi/Rizhi";
            });
        }
    }
</script>
</html>