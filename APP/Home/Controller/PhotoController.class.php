<?php
namespace Home\Controller;
use Think\Controller;
session_start();//开启session
class PhotoController extends ContController
{
    //显示
    public function Index()
    {
        $a = $this->getpts();
        $i = 0;
        foreach ($a as $b) {
            $cxnm[$i]['id'] = $b['psid'];
            $cxnm[$i]['name'] = $b['name'];
            ++$i;
        }
        $this->assign('cxnm', $cxnm);
        $this->display('photo');
    }
    //相册数据库
    private function ps()
    {
        $mod = M("phos");
        return $mod;
    }

    //相片数据库
    private function ph()
    {
        $mod = M("photo");
        return $mod;
    }

    //获取照片
    public function getph()
    {

    }

    //获取相册
    private function getpts()
    {
        $u['id'] = $_SESSION['id'];
        $mod = $this->ps();
        try {
            $a = $mod->where($u)->select();
        } catch (\Exception $e) {
            $this->jsec('alert("出错了");');
            return null;
        } finally {
            return $a;
        }
    }

    //获取相册名
    public function getps()
    {
        $a = $this->getpts();
        for ($i = 0; $dt = $a[$i]; $i++) {
            $aa[$i] = json_encode($dt);
        }
        echo json_encode($aa);
    }

    //添加相册
    public function addps()
    {
        $u['id'] = $_SESSION['id'];
        $u['name'] = htmlspecialchars($_POST['ps']);
        $u['bew'] = htmlspecialchars($_POST['bew']);
        $u['ctime'] = date("Y-m-d h:m:s");
        $mod = $this->ps();
        try {
            $a = $mod->data($u)->add();
        } catch (\Exception $e) {
            $this->jsec('出错了');
            exit;
        }
        $url = __APP__ . '/Home/Photo/Index';
        $a = "alert('创建成功'); window.location.href='$url';";
        $this->jsec($a);
    }
    //查看相册
    public function selps()
    {
        $u['cx'] = $_GET['cs'];
        $u['id'] = $_SESSION['id'];
        $mod = $this->ph();
        try{
            $a = $mod->where($u)->select();
        }catch (\Exception $e){
            $this->jsec('alert("出错了");');
            exit;
        }
        if(!$a){
            $pmn = '暂无照片';
        }else {
            $i = 0;
            foreach ($a as $v) {
                $pnm[$i]['name'] = $v['pname'];
                $pnm[$i]['id'] = $v['pid'];
                ++$i;
            }
        }
        $this->assign('phn',$pnm);
        $this->display('selph');
    }
    //修改相册
    public function upps()
    {
        $u['psid'] = $_GET['cs'];
        $mod = $this->ps();
        try{
            $a = $mod-> where($u)->select();
        }catch (\Exception $e){
            echo '出错了';
            exit;
        }
        $id = $a[0]['psid'];
        $name = $a[0]['name'];
        $bew = $a[0]['bew'];
        $this->assign('id',$id);
        $this->assign('name',$name);
        $this->assign('bew',$bew);
        $this->display('psup');
    }
    //修改相册数据
    public function updps(){
        $a['psid'] = $_POST['sub'];
        $u['name'] = $_POST['ps'];
        $u['bew'] = $_POST['bew'];
        $mod = $this->ps();
        try{
            $mod->where($a)->save($u);
        }catch (\Exception $e){
            $this->jsec('alert("出错了");');
        }
        $a = "alert('修改成功'); close();";
        $this->jsec($a);

    }
    //删除相册
    public function delps()
    {
        $u['psid'] = $_POST['cs'];
        $mod = $this->ps();
        try{
            $mod-> where($u)->delete();
        }catch (\Exception $e){
            echo '出错了';
        }
        echo 1;
    }

    //添加照片
    public function addph()
    {
        $this->addpht();
    }
    private function addpht(){
        if( empty($_FILES['pic']) ){
            $this->jsec('alert("请上传照片");');
            exit;
        }
        $upload = new \Think\Upload();// 实例化上传类
        $upload->maxSize   =     3145728 ;// 设置附件上传大小
        $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
        $upload->autoSub    =   false;
        $upload->savePath  =      ''; // 设置附件上传目录    // 上传文件
        $upload->saveName = '';
        $inf = $upload->upload();
        if(!$inf) {
            $this->jsec("alert('$upload->getError();');");
            exit;
        }
        $u['cx'] = $_POST['cxt'];
        $u['id'] = $_SESSION['id'];
        $u['ctime'] = date("Y-m-d h:m:s");
        foreach( $inf as $v ){
            $u['pname'] = $v['name'];
            $mod = $this->ph();
            $mod->startTrans();  //开启事务
            try{
                $mod->data($u)->add();
            }catch (\Exception $e){
                $mod->rollback();
                $this->jsec('alert("出错了")');  //事务回滚
                exit;
            }
        }
        $mod->commit();     //提交事务
        $url=__APP__."/Home/Photo/Index";
        $this->jsec("alert('上传成功'); window.location.href='$url'");
        echo '<br>'.$inf[1]['name'].'<br>'.$inf[1]['type'];
    }
    //删除照片
    public function delph()
    {
        $u['pid'] = $_POST['id'];
        $mod = $this->ph();
        //查找照片名
        try{
            $cc = $mod->where($u)->select();
        }catch (\Exception $e){
            echo '错误';
            exit;
        }
        $mod->startTrans(); //开启一个事务
        //预备删除照片
        try {
            $mod->where($u)->delete();
        } catch (\Exception $e) {
            echo '错误';
            exit;
        }
        //照片路径
        $file = $_SERVER['DOCUMENT_ROOT'].__ROOT__.'/Uploads/'.$cc[0]['pname'];
        if(unlink($file)) {  //判断是否删除照片文件
            $mod->commit(); //删除数据库
        }else{
            $this->jsec('alert("出错了");');
            $mod->rollback();   //事务回滚
            exit;
        }
        echo 1;
    }
}