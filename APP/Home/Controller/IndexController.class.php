<?php
namespace Home\Controller;
use Think\Controller;
session_start();//开启session
class IndexController extends Controller {
    private $code;
    public function index(){
        $this->display("index");
    }
    //跳转密码找回页面
    public function found(){
        $this->display("found");
    }
    //跳转用户注册页面
    public  function register(){
        $this->display("register");
    }
    //跳转修改密码
    public function upda(){
        $this->display("update");
    }
    //制作验证码
    public function yzm(){
        $config =array('fontSize'    =>    30,    // 验证码字体大小
            'imageW'    =>  150,
            'imageH'    =>  35,
            'fontSize'  =>  18,
            'length'      =>    4,     // 验证码位数
            'useCurve'  =>  false
        );
        $Verify =     new \Think\Verify($config);
        $Verify->entry();
    }

    //核对验证码
    public function yzms(){
        $Verify =     new \Think\Verify();
        if($Verify->check($_POST['ym'])){
            echo 1;
        }
    }
    //验证登录
    public function land(){
        $user=$_POST["user"];
        $pwd=md5($_POST["pwd"]);
        $mod=M("user");
        $u["mail"]=$user;
        $a=$mod->where($u)->select();
        if($a[0]['pwd']==$pwd){
            $_SESSION["user"]=$user;
            $_SESSION["id"]=$a[0]['id'];
            $this->success('登录成功，请稍候',__APP__.'/Home/User/index','1');
        }else{
            $this->error("密码错误");
        }
    }
    //验证邮箱重复
    private function mails($mail){
        $mod=M("user");
        $u["mail"]=$mail;
        $a=$mod->where($u)->select();
        return $a;
    }
    public function mail(){
        $a=$this->mails($_POST["mail"]);
        if($a){
            echo 1;
        }
    }
    //激活邮箱
    public function atcmail(){
        $code=rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9);
        $this->code=$code;
        $body="请将以下验证码输入注册页面激活账户:".$code.'；请妥善保管该验证码，勿轻易交给他人。';
        Sendmail($_POST["mail"],'帐号激活',$body);
    }
    public function upmail(){
        $code=rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9);
        $this->code=$code;
        $body="尊敬的用户您好：
        您正在修改您的账户密码，如为本人操作请将该验证码填入修改界面:".$code.'；请妥善保管该验证码，勿轻易交给他人。';
        Sendmail($_POST["mail"],'帐号激活',$body);
    }
    //邮箱验证码核对
    public function ckmail(){
        if($_POST['mailyzm']!=$this->code){
            $this->code=null;
            echo 1;
        }
    }

    //配置用户数据
    private function config(){
        $mod=M("user");
        $u["mail"]=$_POST['mail'];
        $a=$mod->where($u)->select();
        $id=$a[0]['id'];
        try {
            //创建数据表
            $sql = "CREATE TABLE `$id` (
  `id` int(10) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `Ctime` datetime NOT NULL,
  `addr` varchar(32) DEFAULT NULL,
  `device` varchar(16) NOT NULL,
  `body` varchar(108) NOT NULL,
  `laud` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
            $mod=M();
            try {
                $del = $mod->execute("DROP TABLE IF EXISTS `$_POST[mail]`;");
                if($del===false){
                    $this->error("错误信息1");
                }
            }catch (Exception $e){
                $this->error("错误信息2");
            }
            try {
                $re = $mod->execute($sql);
                if ($re===false) {
                    $this->error("错误信息3");
                }
            }catch (Exception $e){
                $this->error("错误信息4");
            }
            //创建好友配置文件
            try {
                $current = "<?xml version='1.0' encoding='utf-8'?><friends><friend name='我'><bdy name='$_POST[mail]'>$_POST[mail]</bdy></friend><friend name='朋友'></friend><friend name='同事'></friend><friend name='家人'></friend>
<friend name='陌生人'></friend></friends>";   //要写入的配置信息
                $in=file_put_contents("./Public/conf/".$id.".xml", $current);  //写入
                if(!$in){
                    $this->error("错误信息6");
                }
            }catch (Exception $e){
                $this->error("好友错误信息");
            }
        }catch (Exception $e){
            $this->error("错误信息5");
        }
    }
    //注册账户
    public function reg(){
        //检测邮箱重复
        $a=$this->mails($_POST["mail"]);
        if($a){
            $this->error("发生错误");
        }
        if($_POST["pwd"]!=$_POST["rpwd"]){
            $this->error("发生错误");
        }
        $mod=M("user");

        $data["mail"]=$_POST["mail"];
        $data["pwd"]=md5($_POST["pwd"]);
        $data["Ctime"]=date("Y-m-d");
        $a=$mod->add($data);
        if($a){
            $this->config();
            $this->success("注册成功",__APP__.'/Home/Index/index',2);
        }else{
            $this->error("错误信息");
            exit;
        }
    }
    //找回密码
    public function founds(){
        $_SESSION['upmail']=$_POST['mail'];
        $this->success("跳转中",__APP__.'/Home/Index/upda',0);
    }
    //修改密码
    public function update(){
        if($_POST['pwd']==$_POST['rpwd']){
            $mod=M("user");
            $date['pwd']=md5($_POST['pwd']);
            $a=$mod->where("mail='$_SESSION[upmail]'")->save($date);
            if($a){
                $this->success("修改成功",__APP__.'/Home/Index/index',0);
            }else{
                $this->error("错误信息");
                eixt;
            }
        }
    }
}