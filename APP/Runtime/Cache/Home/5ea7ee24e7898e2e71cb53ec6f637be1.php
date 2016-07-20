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
        #cjps,#tjph{
            margin-right: 20px;
            position: relative;
            left: 5px;
            top: 3px;
        }
        #crtps,#istph{
            position: relative;
            margin-top: 3px;
        }
        #psbd{
            margin-top: 5px;
            position: relative;
        }
        .psk{
            width: 180px;
            height: 160px;
            position: relative;
            float: left;
        }
        .tb{
            width: 180px;
            height: 130px;
        }
        .cxn{
            font-size: 18px;
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
<div id="bdy" class="col-xs-12 col-md-8">
    <button id="cjps" class="btn btn-info" data-toggle="collapse" data-target="#crtps">创建相册</button>
    <button id="tjph" class="btn btn-info" data-toggle="collapse" data-target="#istph">添加照片</button>
    <div id="crtps" class="collapse">
        <form action="/uweb/index.php/Home/Photo/addps" method="post" onsubmit="return addcx();">
            <input type="text" placeholder="相册名称" name="ps" id="ps"><br>
            <textarea name="bew" placeholder="相册描述" cols="40" rows="4"></textarea><br>
            <button type="submit" name="sub">发表</button>
        </form>
    </div>
    <div id="istph" class="collapse">
        <form action="/uweb/index.php/Home/Photo/addph" method="post" enctype="multipart/form-data" onsubmit="return shch()">
            添加相册：<select id="xct" name="cxt"><?php if(is_array($cxnm)): foreach($cxnm as $key=>$vo): ?><option value="<?php echo ($vo["id"]); ?>"><?php echo ($vo["name"]); ?></option><?php endforeach; endif; ?></select><br>
            <input class="bqz" type="file" name="pic[]" multiple="multiple"><br>
            <button type="submit">上传</button>
        </form>
    </div>
    <div id="psbd">

    </div>
</div>
</body>
<script src="/uweb/Public/js/jquery-1.12.3.min.js"></script>
<script src="/uweb/Public/js/bootstrap.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $.post("/uweb/index.php/Home/Photo/getps",'',function(msg){
            var a = JSON.parse(msg);
            var ccc = '';
            for(i=0;a[i];i++) {
                var json = JSON.parse(a[i]);
                ccc = ccc +'<div class="psk"><img src="/uweb/Public/img/cx.png" class="tb"><div class="nmk"><div class="btn cxn" id="'+ json['psid'] +'">' + json['name'] + '</div><select name="gn" class="gn"><option onclick="ck(' + json["psid"] + ')"> 查看 </option><option onclick="xg('+ json["psid"] +')"> 修改 </option><option onclick="sc('+ json["psid"] +')"> 删除 </option></select></div></div>';
            }
            $("#psbd").html(ccc);
        });
    });
    function addcx() {
        if ($("#ps").val() == '') {
            alert('相册名称不能为空');
            return false;
        } else {
            return true;
        }
    }
    function ck(cs){
        open("/uweb/index.php/Home/Photo/selps?cs="+cs);
    }
    function xg(cs){
        open("/uweb/index.php/Home/Photo/upps?cs="+cs);
    }
    function sc(cs){
        if (confirm("点击确认后删除！！！")) {
            $.post("/uweb/index.php/Home/Photo/delps",{cs: cs},function(msg){
                if(msg == 1){
                    alert('删除成功！');
                }else{
                    alert('删除失败！');
                }
                window.location.href="/uweb/index.php/Home/Photo/Index";
            });
        }
    }
    function shch(){
        var aa = $('.bqz').val();
        if( aa == ''){
            alert('请选择要上传的照片');
            return false;
        }else{
            return true;
        }
    }
</script>
</html>