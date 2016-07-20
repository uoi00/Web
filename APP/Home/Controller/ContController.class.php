<?php
namespace Home\Controller;
use Think\Controller;
session_start();//开启session
class ContController extends Controller {
    public function _initialize(){
        if(empty($_SESSION["user"])){
            $this->error("登录超时，请重新登录",__APP__."/Home/Index/index");
        }
        $this->assign('user',$_SESSION['user']);
    }
    public function desc(){
       unset($_SESSION);
       session_destroy();
       $this->success("注销成功",__APP__."/Home/Index/index",0);
    }
    protected function domx($file){
        if($file=='') {
            $file = $_SERVER['DOCUMENT_ROOT'] . __ROOT__ . '/Public/conf/' . "$_SESSION[id].xml";//配置文件名
        }
        $xml=new \DOMDocument();
        $xml->load($file);
        return $xml;
    }
    protected function smpx($file){
        if($file=='') {
            $file = $_SERVER['DOCUMENT_ROOT'] . __ROOT__ . '/Public/conf/' . "$_SESSION[id].xml";//配置文件名
        }
        $xml=simplexml_load_file($file);// 加载文件
        return $xml;
    }
    protected function jsec($c){
        echo "<script type='text/javascript'> $c </script>";
    }
}