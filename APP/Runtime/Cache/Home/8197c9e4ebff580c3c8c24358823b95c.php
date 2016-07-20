<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="UTF-8">
    <title></title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link type="text/css" rel="stylesheet" href="/uweb/Public/css/bootstrap.min.css">
    <style type="text/css">
        <!--
        #bdy{
            float: none;
            margin-right: auto;
            margin-left: auto;
        }
        #hed{
            height: 40px;
        }
        .fzhed{
            margin-top: 3px;
            height: 20px;
            margin-bottom: 3px;
        }
        .fzbm{
            margin-top:3px ;
            margin-bottom: 3px;
        }
        .jghy{
            height: 30px;
            margin-top: 3px;
            margin-bottom: 3px;
            background-color: gold;
        }

        -->
    </style>
</head>
<body>
<div id="bdy" class="col-xs-12 col-md-9">
    <div id="hed" align="center">
        <button id="tjfz">添加分组</button>&nbsp; &nbsp; &nbsp; &nbsp;
        <input type="text" id="sou" placeholder="请输入搜索信息">&nbsp; &nbsp;
        <button id="cz">查找好友</button>&nbsp; &nbsp;
        <button id="ss" data-toggle='collapse' data-target='#zyss'>搜索帐号</button>
    </div>
    <div id="czfrd"  style="display: none">

    </div>
    <div id="zyss" class="collapse" align="center">
        帐号搜索：<input type="text" id="iptj">&nbsp; &nbsp;
        <button id="zhss">搜索</button><hr>
        条件搜索：<br>
        性别：<select id="sex"><option value="">不限</option><option value="男"> 男 </option><option value="女"> 女 </option></select>&nbsp; &nbsp;
        年龄：<select id="age"><option value="">不限</option><option value="2">小于20</option><option value="3">小于30</option><option value="4">小于40</option><option value="5">小于50</option><option value="6">大于50</option></select>&nbsp; &nbsp;
        住址：<span id="city_1"><select class="prov" id="prov"></select><select class="city" id="city" disabled="disabled"></select></span>&nbsp; &nbsp;
        <button id="tjss">条件搜索</button>
    </div>
    <div id="addhy" class="collapse" align="center">
        <table>
            <tr>
                <td>备注：</td><td><input type="text" maxlength="20" id="bz"></td>
            </tr>
            <tr>
                <td>验证消息：</td><td><input type="text" maxlength="20" id="yzxx"></td>
            </tr>
            <tr>
                <td>分组：</td><td><select id="hyfz"><?php if(is_array($ff)): foreach($ff as $k=>$vo): ?><option value="<?php echo ($k); ?>"><?php echo ($vo); ?></option><?php endforeach; endif; ?></select></td>
            </tr>
            <tr>
                <td colspan="2" align="center"><button id="tjhy">添加</button></td>
            </tr>
        </table>
    </div>
    <div id="main">
        <?php if(is_array($ff)): foreach($ff as $k=>$vo): ?><div>
                <button class="btn btn-info btn-block" data-toggle="collapse" data-target="#fz<?php echo ($k); ?>">
                    <?php echo ($vo); ?>
                </button>
                <div class="collapse" id="fz<?php echo ($k); ?>">
                    <div class="fzhed" align="center">
                        <button id="fzxg<?php echo ($k); ?>" onclick='fzxg(<?php echo ($k); ?>)'>分组命名</button>&nbsp; &nbsp;
                        <button id="fzsc<?php echo ($k); ?>" onclick='fzsc(<?php echo ($k); ?>)'>删除分组</button>
                    </div>
                    <div class="fzbm">
                        <?php foreach($frd["$k"] as $key=>$val){ echo "<button class='btn btn-info btn-block' data-toggle='collapse' data-target='#fd$k$key'>"; echo $val; echo "</button><div class='collapse' id='fd$k$key'><div class='fdhed' align='center'>"; echo "<button id='fdsel$k$key' onclick='fdsel($k,$key)'>查看信息</button>&nbsp; &nbsp;
                                <button id='fdup$k$key' onclick='fdup($k,$key)'>修改备注</button>&nbsp; &nbsp;
                                <button id='fddel$k$key' onclick='fddel($k,$key)'>删除好友</button>
                            </div>
                            </div>"; } ?>
                    </div>
                </div>
            </div><?php endforeach; endif; ?>
    </div>
</div>
</body>
<script src="/uweb/Public/js/jquery-1.12.3.min.js"></script>
<script src="/uweb/Public/js/bootstrap.min.js"></script>
<script src="/uweb/Public/js/jquery.cityselect.js"></script>
<script src="/uweb/Public/js/frd.js"></script>
<script type="text/javascript">
    var url="/uweb/index.php";
    var pb="/uweb/Public";
    $(function(){
        $("#city_1").citySelect({
            nodata:"none",
            required:false
        });
    });
</script>
</html>