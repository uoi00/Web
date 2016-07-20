<?php
namespace Home\Controller;
use Think\Controller;
session_start();//开启session
class FrdactController extends ContController {
    //开始上传
    private function uploads($upsize,$upext,$uppath){
        try{
            $upload = new \Think\Upload();// 实例化上传类
            $upload->maxSize   =     3145728 ;// 设置附件上传大小
            $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
            $upload->autoSub    =   false;
            $upload->savePath  =      ''; // 设置附件上传目录    // 上传文件
            $info   =   $upload->upload();
        }catch (\Exception $e){
            $this->error($e->getError());
        }
    }
    //随机生成id
    private function randid(){
        $id=''; //创建id
        for($i=1;$i<9;$i++){   //随机产生id
            $id.=rand(0,10);
        }
        //判定是否重复
        try {
            $mod = M($_SESSION['user']);
            $u["id"] = $id;
            $a = $mod->where($u)->select();
        }catch (Exception $e){
            $this->error("发生错误");
            exit;
        }
        if($a){
            $this->randid();
        }
        return $id;
    }
    //创建说说文件 并写入
    private function file($files,$body,$pic,$id){
        try {
            $xmls = "<?xml version='1.0' encoding='utf-8'?><says><say id='$id'><body>$body</body><pic>$pic</pic><zan num='0'></zan><gz num='0'></gz></say></says>";
            $file = file_put_contents($files, $xmls);
            if(!$file){
                $this->error("发生错误");
                exit;
            }
        }catch (Exception $e){
            $this->error("发生错误");
            exit;
        }
    }
    private function write($file,$body, $pic,$id){
        try {
            $xml = new \DOMDocument('1.0', 'utf-8');//创建xml解析对象
            $xml->load($file);//载入文件
            $say = $xml->createElement("say");//创建say节点
            $say->setAttribute('id', $id);//为say节点添加id属性
            $body = $xml->createElement("body", $body);//创建body节点
            $pic = $xml->createElement("pic", $pic);//创建pic节点
            $zan = $xml->createElement("zan", '');//创建zan节点
            $zan->setAttribute('num', '0');//为zan节点添加num属性
            $gz = $xml->createElement('gz', '');//创建gz节点
            $gz->setAttribute('num', '0');//为gz节点添加num属性
            $say->appendChild($body);//将body节点添加到say节点
            $say->appendChild($pic);//将pic节点添加到say节点
            $say->appendChild($zan);//将zan节点添加到say节点
            $say->appendChild($gz);//将gz节点添加到say节点
            $root = $xml->documentElement;//根节点
            $root->appendChild($say);//添加say到根节点
            $xml->save($file);//保存
        }catch (\Exception $e){
            $this->error("发生错误");
        }
    }
    //写入数据库
    private function addsql($id,$addr='',$file){
        $mod=M("`$_SESSION[id]`");
        $u['id']=$id;
        $u['Ctime']=date("Y-m-d h:m:s");
        $u['addr']=$addr;
        $u['device']=PHP_OS;
        $u['body']=$file;
        $rzt=$mod->add($u);
        if($rzt===false){
            $this->error("发生错误");
        }
    }
    //处理说说
    public function subsay(){
        if($_POST['sub']!=''){
            //上传图片
            $upext=array('jpg', 'gif', 'png', 'jpeg');
            $info=$this->uploads(3145728,$upext,'');
            //保存说说
            $file=$_SERVER['DOCUMENT_ROOT'].__ROOT__.'/Public/conf/'.$_SESSION['id'].'.say.xml';         //说说文件名
            $body=htmlspecialchars($_POST['saytext']);  //说说文字内容
            $pic='';        //说说图片 名称 位置
            if($info) {
                foreach ($info as $val) {
                    $pic = $pic . $val['savename'] . ';';
                }
            }
            $id=$this->randid();
            $this->addsql($id,'',$file);    //将部分数据写入数据库
            //是否存在说说文件
            if(file_exists($file)){
                $this->write($file,$body, $pic,$id);         //调用写入方法
            }else {
                $this->file($file, $body, $pic,$id);    //调用创建方法并写入
            }
        }
    }
    //准备读取说说
    public function zgetsay(){
        $this->getsay();
    }
    //读取说说
    private  function getsay(){
        $use=$_SESSION['id'];
        $mod=M();
        $u = $this->getus($use);//查找所有好友
        $sql = "select * from $u order by Ctime";
        echo $sql;
        var_dump($mod->query($sql));
    }
    //获取好友列表好友
    private function getus($use){
        $file = $_SERVER['DOCUMENT_ROOT'].__ROOT__.'/Public/conf/'.$use.'.xml';         //好友文件名
        $u = '';//返回内容
        $xml=new \DOMDocument();
        $xml->load($file);
        //$xml = $this->domx($file);
        $bdy = $xml->getElementsByTagName('bdy');
        for($i=0;$bdy->item($i);$i++){
            $n=$bdy->item($i)->nodeValue;
            echo $n;
            $u = $u .'`'.$n.'`' . ',';
        }
        return $u;
    }
}