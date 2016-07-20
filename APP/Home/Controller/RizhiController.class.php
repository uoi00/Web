<?php
namespace Home\Controller;
use Think\Controller;
session_start();//开启session
class RizhiController extends ContController {
    //链接数据库
    private function sql(){
        $mod = M('rizhi');
        return $mod;
    }
    //显示
    public function Rizhi(){
       $this->display('index');
    }
    //获取日志
    public function getrz(){
        $this->getrizhi();
    }
    //获取日志
    public function getrizhi(){
        $mod = $this->sql();
        $u['id']=$_SESSION['id'];
        $a=$mod->select($u);
        for($i=0;$dt=$a[$i];$i++){
            $aa[$i] = json_encode($dt);
        }
        echo json_encode($aa);
    }
    //写入日志
    public function wrz(){
        $this->wtrz();
    }
    //写入日志
    public function wtrz(){
        $u['id'] = $_SESSION['id'];
        $u['title'] = htmlspecialchars($_POST['til']);
        $u['content'] = htmlspecialchars($_POST['cont']);
        $u['power'] = $_POST['power'];
        $u['ctime'] = date("Y-m-d h:m");
        $mod = $this->sql();
        try{
            $mod->data($u)->add();
        }catch (\Exception $e){
            echo '出错了<br>';
            exit();
        }
        $url=__APP__.'/Home/Rizhi/Rizhi';
        echo "<script type='text/javascript'>
            alert('发表成功');
            window.location.href='$url';
        </script>";
    }
    //查看界面
    public function sel(){

    }
    //修改界面
    public function upd(){
        $u['rid'] = $_GET['cs'];
        $mod = $this->sql();
        try{
            $a = $mod->where($u)->select();
        }catch (\Exception $e){
            echo '出错了<br>';
            exit();
        }
        $id = $a[0]['rid'];
        $title = $a[0]['title'];
        $content =$a[0]['content'];
        $power = $a[0]['power'];
        $this->assign('id',$id);
        $this->assign('title',$title);
        $this->assign('cont',$content);
        $this->assign('power',$power);
        $this->display('upd');

    }
    //修改数据
    public function updata(){
        $id['rid'] = $_POST['sub'];
        $u['title'] = htmlspecialchars($_POST['til']);
        $u['content'] = htmlspecialchars($_POST['cont']);
        $u['power'] = $_POST['power'];
        $mod = $this->sql();
        try{
            $mod->where($id)->save($u);
        }catch (\Exception $e){
            echo '出错了<br>';
            exit();
        }
        $url=__APP__.'/Home/Rizhi/Rizhi';
        echo "<script type='text/javascript'>
            alert('修改成功');
            window.location.href='$url';
        </script>";
    }
    //删除界面
    public function dlt(){
        $u['rid'] = $_POST['cs'];
        $mod = $this->sql();
        try{
            $mod-> where($u)->delete();
        }catch (\Exception $e){
            echo '出错了';
        }
        echo 1;
    }
}