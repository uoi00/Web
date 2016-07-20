<?php
namespace Home\Controller;
use Think\Controller;
session_start();//开启session
class UserController extends ContController {
    public function index(){
        $this->display('index');
    }
    //好友动态
    public function frdact(){
        //加载配置
        $this->display("frdact");
    }
    //与我相关
    public  function nexme(){
        echo "与我相关";
    }
    //好友
    public function friend(){
        $this->confxml();
    }
    //个人信息
    public  function myinfo(){
        echo "个人信息";
    }
    //加载好友配置
    private function confxml(){
        $file=$_SERVER['DOCUMENT_ROOT'].__ROOT__.'/Public/conf/'."$_SESSION[id].xml";//配置文件名
        $xml=simplexml_load_file($file);// 加载文件
        $friend=$xml->friend; //寻找friend节点
        for($i=0;$friend[$i];$i++){
            $fz[$i]=$friend[$i]->attributes()['name'];//查找name属性的值
            $cld[$i]=$friend[$i]->children();
            for($j=0;$cld[$i][$j];$j++){
                $frd[$i][$j]=$cld[$i][$j]->attributes()['name'];
            }
        }
        $this->assign('ff',$fz);
        $this->assign('frd',$frd);
        $this->display("friend");
    }
    //test
    public function test(){
        $fz=$_GET['va'];
        $frd=$_GET['va1'];
        $this->assign('ff',$fz);
        $this->assign('frd',$frd);
        $this->display("info");
    }
}