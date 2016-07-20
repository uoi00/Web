<?php
namespace Home\Controller;
use Think\Controller;
session_start();//开启session
class InfoController extends ContController {
    //读取好友配置文件 并取得好友分组列表
    private function frd($file){
        $xml=$this->domx($file);
        $frd=$xml->getElementsByTagName('friend');
        for($i=0;$f=$frd->item($i);$i++){
            $a[$i]=$f->getAttribute('name');
        }
        return $a;
    }
    //读取添加好友消息内容
    public function info(){
        //获取好友列表的分组内容
        $file1=$_SERVER['DOCUMENT_ROOT'].__ROOT__.'/Public/conf/'."$_SESSION[id].xml";//配置文件名
        $fz=$this->frd($file1);
        //取得添加消息内容
        $file=$_SERVER['DOCUMENT_ROOT'].__ROOT__.'/Public/conf/'."$_SESSION[id].inf.xml";//配置文件名
        if(!file_exists($file)){ exit(''); }  //判断是否存在配置文件 没有退出
        $xml=$this->domx($file);    //使用xml dom打开xml文件
        $inf=$xml->getElementsByTagName('btj')->item(0)->childNodes;    // 查询被添加的信息
        for($i=0;$info=$inf->item($i);$i++){
            if($info->childNodes->item(6)->nodeValue=='1'){
                $b[$i]['id']=$info->getAttribute('id');                   //添加id
                $b[$i]['ztj']=$info->childNodes->item(2)->nodeValue;    //被添加人
                $b[$i]['ty']='同意';                                      //添加意见
            }else if($info->childNodes->item(6)->nodeValue!=''){
                $b[$i]['id']=$info->getAttribute('id');                   //添加id
                $b[$i]['ztj']=$info->childNodes->item(2)->nodeValue;    //被添加人
                $b[$i]['yz']=$info->childNodes->item(6)->nodeValue;     //拒绝理由
                $b[$i]['ty']='拒绝';
            }
        }
        //取得添加结果内容
        $tjg=$xml->getElementsByTagName('ztj')->item(0)->childNodes;    // 查询添加的信息
        for($i=0;$info=$inf->item($i);$i++){
            $a[$i]['id']=$info->getAttribute('id');                   //添加id
            $a[$i]['ztj']=$info->childNodes->item(1)->nodeValue;    //添加人
            $a[$i]['yz']=$info->childNodes->item(4)->nodeValue;     //验证消息
        }
        $test='消息中心';
        $this->assign('fz',$fz);    //好友分组
        $this->assign('test',$test);//消息中心
        $this->assign('inf',$a);    //添加消息
        $this->assign('tjg',$b);    //结果消息
        $this->display("index");    //显示页面
    }
    //读取添加好友消息条数
    public function selinfo(){
        $file=$_SERVER['DOCUMENT_ROOT'].__ROOT__.'/Public/conf/'."$_SESSION[id].inf.xml";//配置文件名
        if(!file_exists($file)){ exit(); }
        $xml=$this->domx($file);
        $inf=$xml->getElementsByTagName('btj')->item(0)->childNodes;
        $su=$inf->length;
        $inf1=$xml->getElementsByTagName('ztj')->item(0)->childNodes;
        for($i=0;$f=$inf1->item($i);$i++){
            if($f->childNodes->item(6)->nodeValue!=''){
                $su++;
            }
        }
        echo $su;
    }
    //同意添加
    public function tyadd(){
        $id=$_POST['id'];
        $fz=(int)$_POST['fz'];
        $bz=htmlspecialchars($_POST['bz']);
        try{
            $file=$_SERVER['DOCUMENT_ROOT'].__ROOT__.'/Public/conf/'."$_SESSION[id].inf.xml";//配置文件名
            $xml=$this->domx($file);
            $infs=$xml->getElementsByTagName('inf');
            for($i=0;$fid=$infs->item($i);$i++) {
                if ($fid->getAttribute('id') == $id) {
                    //修改配置
                    $fid->childNodes->item(0)->nodeValue = date("Y-m-d h:m");
                    $zid = $fid->childNodes->item(1)->nodeValue;
                    $fid->childNodes->item(3)->nodeValue = $bz;
                    $fid->childNodes->item(5)->nodeValue = $fz;
                    $fid->childNodes->item(6)->nodeValue = 1;
                    $cfid = $fid->cloneNode(true);//复制节点
                    $xml->getElementsByTagName('btj')->item(0)->removeChild($fid);//删除节点
                    $xml->getElementsByTagName('btj')->item(1)->appendChild($cfid);
                    $xml->save($file); //保存文件
                    //添加好友
                    $filefb = $_SERVER['DOCUMENT_ROOT'] . __ROOT__ . '/Public/conf/' . "$_SESSION[id].xml";//好友配置文件
                    $xmlfb = $this->domx($filefb);//使用dom打开
                    $hyfz = $xmlfb->getElementsByTagName('friend')->item($fz);//查找需要添加的分组
                    $newfrd = $xmlfb->createElement('bdy', $zid);//创建新的好友节点
                    if ($bz == '') {
                        $newfrd->setAttribute('name', $zid);//为该节点添加备注属性
                    } else {
                        $newfrd->setAttribute('name', $bz);//为该节点添加备注属性
                    }
                    $hyfz->appendChild($newfrd);//将新建的好友节点添加到目标分组上
                    $xmlfb->save($filefb);//保存文件

                    $filez = $_SERVER['DOCUMENT_ROOT'] . __ROOT__ . '/Public/conf/' . "$zid.inf.xml";//配置文件名
                    $xmlz = $this->domx($filez);
                    $infz = $xmlz->getElementsByTagName('inf');
                    for ($i = 0; $fidz = $infz->item($i); $i++) {
                        if ($fidz->getAttribute('id') == $id) {
                            $zbz = $fidz->childNodes->item(3)->nodeValue;
                            $zfz = $fidz->childNodes->item(5)->nodeValue;
                            $fidz->childNodes->item(6)->nodeValue = 1;
                            $filefz = $_SERVER['DOCUMENT_ROOT'] . __ROOT__ . '/Public/conf/' . "$zid.xml";//好友配置文件
                            $xmlfz = $this->domx($filefz);
                            $zhyfz = $xmlfz->getElementsByTagName('friend')->item($zfz);//查找需要添加的分组
                            $znewfrd = $xmlfz->createElement('bdy', $zid);//创建新的好友节点
                            $znewfrd->setAttribute('name', $zbz);//为该节点添加备注属性
                            $zhyfz->appendChild($newfrd);//将新建的好友节点添加到目标分组上
                            $xmlfz->save($filefb);//保存文件
                        }
                    }
                }
            }
        }catch (\Exception $e){
            exit('<script type="text/javascript">alert("未知错误,请联系客服");</script>');
        }
        echo '<script type="text/javascript">window.location.href=__ROOT__."/Home/Info/info"</script>';
    }
    //拒绝添加
    public function juadd(){
        $id=$_POST['id'];
        $ly=htmlspecialchars($_POST['ly']);
        try{
            $file=$_SERVER['DOCUMENT_ROOT'].__ROOT__.'/Public/conf/'."$_SESSION[id].inf.xml";//配置文件名
            $xml=$this->domx($file);
            $infs=$xml->getElementsByTagName('inf');
            for($i=0;$fid=$infs->item($i);$i++) {
                if ($fid->getAttribute('id') == $id) {
                    $fid->childNodes->item(0)->nodeValue=date("Y-m-d h:m"); //修改日期
                    $zid=$fid->childNodes->item(1)->nodeValue;
                    $fid->childNodes->item(6)->nodeValue=$ly; //添加结果
                    $cfid=$fid->cloneNode(true);//复制节点
                    $xml->getElementsByTagName('btj')->item(0)->removeChild($fid);//删除节点
                    $xml->getElementsByTagName('btj')->item(1)->appendChild($cfid); //添加节点
                    $xml->save($file);
                }
            }
            $filez=$_SERVER['DOCUMENT_ROOT'].__ROOT__.'/Public/conf/'."$zid.inf.xml";//配置文件名
            $xmlz=$this->domx($filez);
            $infz=$xmlz->getElementsByTagName('inf');
            for($i=0;$fidz=$infz->item($i);$i++) {
                if ($fidz->getAttribute('id') == $id) {
                    $fidz->childNodes->item(6)->nodeValue=$ly;
                    $xml->save($filez);
                }
            }
        }catch (\Exception $e){
            exit('<script type="text/javascript">alert("未知错误,请联系客服");</script>');
        }
        echo '<script type="text/javascript">window.location.href=__ROOT__."/Home/Info/info"</script>';
    }
}