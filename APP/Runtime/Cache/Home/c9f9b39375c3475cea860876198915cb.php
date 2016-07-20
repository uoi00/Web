<?php if (!defined('THINK_PATH')) exit();?><html lang="zh-cn">
<head>
    <title>主页</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link type="text/css" rel="stylesheet" href="/uweb/Public/css/bootstrap.min.css">
    <style type="text/css">
        <!--
        #bdy{
            height: 100%;
            float: none;
            display: block;
            margin-left: auto;
            margin-right: auto;
        }
        #had{
            height: 40px;
            background: cornsilk;
            padding-top: auto;
            padding-bottom: auto;
        }
        .hed{
            margin-left: 8%;
            color: dodgerblue;
            text-decoration: none;
        }
        #bna{
            height: 20%;
            //background: cyan;
            width: 100%;
        }
        #dh{
            width: 100%;
            height: 50px;
        }
        #info{
            color: dodgerblue;
            margin-right: 4%;
            float: right
        }
        #main{
            height: 70%;
        }
        #btm{
            height: 40px;
            margin-top: 100%;
            padding-bottom: auto;
            padding-top: auto;
        }
        #mdlMain {
            height: 100%;
            width: 100%;
        }
        -->
    </style>
</head>
<body>
    <div id="bdy" class="col-xs-12 col-md-9">
        <div id="had">
            <span><a class="hed" href="#">了解梵火</a></span>
            <span><a class="hed" href="#">问题反馈</a></span>
            <span><a class="hed" href="#">联系客服</a></span>
            <span style="" id="info"><?php echo ($user); ?> 欢迎回来 &nbsp; &nbsp;<a href="/uweb/index.php/Home/Cont/desc">注销</a></span>
        </div>
        <img id="bna" src="/uweb/Public/img/bg.PNG" />
        <div id="dh">
            <ul class="nav nav-pills">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        动态<span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a target="mdl" href="/uweb/index.php/Home/User/frdact" class="active">好友动态</a></li>
                        <li><a target="mdl" href="/uweb/index.php/Home/User/nexme">与我相关</a></li>
                    </ul>
                </li>
                </li>
                <li><a target="mdl" href="/uweb/index.php/Home/User/friend" class="a-nav">好友</a></li>
                <li><a target="mdl" href="/uweb/index.php/Home/Photo/Index" class="a-nav">我的相册</a></li>
                <li><a target="mdl" href="/uweb/index.php/Home/Rizhi/Rizhi" class="a-nav">我的日志</a></li>
                <li><a target="mdl" href="/uweb/index.php/Home/Info/info" class="a-nav ">消息<span class="badge" id="xxts"></span></a></li>
            </ul>
        </div>
        <div id="main">
            <iframe name="mdl" id="mdlMain" src="/uweb/index.php/Home/User/frdact" frameborder="no" scrolling="auto" width="100%" height="auto" allowtransparency="true"></iframe>
        </div>
        <div id="btm" align="center">
            adfadfadfafdafdsf
        </div>
    </div>

</body>
<script src="/uweb/Public/js/jquery-1.12.3.min.js"></script>
<script src="/uweb/Public/js/bootstrap.min.js"></script>
<script src="/uweb/Public/js/frd.js"></script>
<script type="text/javascript">
    var url="/uweb/index.php";
    var pb="/uweb/Public";
</script>
</html>