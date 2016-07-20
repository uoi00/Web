<?php
namespace Home\Controller;
use Think\Controller;
session_start();//开启session
class FriendController extends ContController {
    //添加分组
    public function tjfz(){
        try {
            $name = $_POST['name'];
            $xml = $this->domx();
            $f = $xml->createElement('friend');
            $f->setAttribute('name', $name);
            $root = $xml->documentElement;
            $root->appendChild($f);
        }catch (\Exception $e){
            echo '<script type="text/javascript">alert("出错了！！");</script>';
            exit("发生错误！");
        }
        $file=$_SERVER['DOCUMENT_ROOT'].__ROOT__.'/Public/conf/'."$_SESSION[id].xml";//配置文件名
        $xml->save($file);
        echo '1';
    }
    //判断分组是否为空
    public function isnull(){
        $node=(int)$_POST['va'];
        $xml=$this->smpx();
        $c=$xml->friend[$node]->children();
        echo count($c);
    }
    //删除分组
    public function fzsc(){
        $node=(int)$_POST['va'];
        $xml=$this->domx();
        $root=$xml->documentElement;
        $c=$xml->getElementsByTagName('friend')->item($node);
        try {
            $rt = $root->removeChild($c);
        }catch (\Exception $e){
            echo '<script type="text/javascript">alert("出错了！！");</script>';
            exit("发生错误！");
        }
        $file=$_SERVER['DOCUMENT_ROOT'].__ROOT__.'/Public/conf/'."$_SESSION[id].xml";//配置文件名
        $xml->save($file);
        echo 1;
    }
    //重命名分组
    public function fzxg(){
        $node=(int)$_POST['va'];
        $val=htmlspecialchars($_POST['name']);
        $xml=$this->domx();
        $c=$xml->getElementsByTagName('friend')->item($node)->setAttribute('name',$val);
        try {
            $file = $_SERVER['DOCUMENT_ROOT'] . __ROOT__ . '/Public/conf/' . "$_SESSION[id].xml";//配置文件名
        }catch (\Exception $e){
            echo '<script type="text/javascript">alert("出错了！！");</script>';
            exit("发生错误！");
        }
        $xml->save($file);
        echo 1;
    }
    //查看好友信息
    public function fdsel(){
        $node=(int)$_GET['va'];
        $node1=(int)$_GET['va1'];
        $xml=$this->domx();
        $name=$xml->getElementsByTagName('friend')->item($node)->childNodes->item($node1)->nodeValue;
        try {
            $mod1 = M('user');
            $n['mail'] = $name;
            $cc = $mod1->where($n)->select();
            if($cc){
                $kk=$cc[0]['id'];
            }
        }catch (\Exception $e){
            $mod1->getLastSql();
            echo '<script type="text/javascript">alert("出错了！！");</script>';
        }
        $mod=M('info');
        $u['id']=$kk;
        $a=$mod->where($u)->select();
        if($a){
            $data['user']=$_SESSION['user'];
            $data['sex']=$a[0]['sex'];
            $data['name']=$a[0]['name'];
            $data['tel']=$a[0]['tel'];
            $data['mail']=$a[0]['mail'];
            $data['zhz']=$a[0]['zhuz'];
            $data['zhy']=$a[0]['zhiye'];
            $data['bth']=$a[0]['brith'];
            $this->assign('data',$data);
        }else{
            echo '<script type="text/javascript">alert("出错了！！"); window.close();</script>';
            exit;
        }
        $this->assign('title',$name);
        $this->display("info");
    }
    //查找好友
    public function czfrd(){
        $va=$_POST['va'];
        $xml=$this->domx();
        $frd=$xml->getElementsByTagName('bdy');
        for($i=0;$f=$frd->item($i);$i++){
            if(ereg($va,$f->nodeValue)||ereg($va,$f->getAttribute('name'))){
                echo $f->nodeValue."——".$f->getAttribute('name').'->'.$f->parentNode->getAttribute('name').'<br>';
            }
        }
    }
    //修改备注
    public function fdup(){
        $no=(int)$_POST['va'];
        $no1=(int)$_POST['va1'];
        $name=htmlspecialchars($_POST['name']);
        $xml=$this->domx();
        try{
            $c=$xml->getElementsByTagName('friend')->item($no)->childNodes->item($no1)->setAttribute("name",$name);
        }catch (\Exception $e){
            echo '<script type="text/javascript">alert("出错了！！");</script>';
            exit("发生错误！");
        }
        $file=$_SERVER['DOCUMENT_ROOT'].__ROOT__.'/Public/conf/'."$_SESSION[id].xml";//配置文件名
        $xml->save($file);
        echo 1;
    }
    //删除好友
    public function fddel(){
        $no=(int)$_POST['va'];
        $no1=(int)$_POST['va1'];
        $xml=$this->domx();
        try {
            $c = $xml->getElementsByTagName('friend')->item($no)->childNodes->item($no1);
            $xml->removeChild($c);
        }catch (\Exception $e){
            echo '<script type="text/javascript">alert("出错了！！");</script>';
            exit("发生错误！");
        }
        $file=$_SERVER['DOCUMENT_ROOT'].__ROOT__.'/Public/conf/'."$_SESSION[id].xml";//配置文件名
        $xml->save($file);
        echo 1;
    }
    //条件搜索
    public function tjss(){
        $year=(int)date("Y");
        $sex=htmlspecialchars($_POST['sex']);
        $age=(int)$_POST['age'];
        $prov=htmlspecialchars($_POST['prov']);
        $city=htmlspecialchars($_POST['city']);
        if($sex!=''){
            $data['sex']=$sex;
        }
        if($age!=''){
            if($age==2){
                $ag[0]=($year-20).'-1-1';
                $ag[1]=$year.'-1-1';
                $data['brith']=array('between',$ag);
            }else{
                $ag[1]=($year-($age-1)*10).'-1-1';
                $ag[0]=($year-$age*10).'-1-1';
                $data['brith']=array('between',$ag);
            }
        }
        if($prov!=''){
            $data['zhuz']=array('like','%'.$prov.$city.'%');
        }
        $mod=M('info');
        try {
            $a = $mod->where($data)->select();
        }catch (\Exception $e){
            echo "<script type='text/javascript'> alert('错误'); window.location.href=url + '/Home/User/friend';</script>";
            exit;
        }
        foreach ($a as $val) {
            echo '<div class="jghy"><input type="radio" name="d" class="hyid" value="'.$val['id'].'"><span>'.$val["user"].'</span>&nbsp; &nbsp;<button onclick="ckinfo('.$val['id'].')">查看信息</button><button data-toggle="collapse" data-target="#addhy">添加好友</button></div>';
        }
    }
    //帐号搜索
    public  function zhss(){
        $va=htmlspecialchars($_POST['va']);
        $mod=M('user');
        $u['mail']=array('like',"%$va%");
        $a=$mod->where($u)->select();
        foreach ($a as $val) {
            echo '<div class="jghy"><input type="radio" name="hytj" class="hyid" value="'.$val[id].'"><span>'.$val["mail"].'</span>&nbsp; &nbsp;<button onclick="ckinfo('.$val['id'].')">查看信息</button><button data-toggle="collapse" data-target="#addhy" value="'.$val[id].'">添加好友</button></div>';
        }
    }
    //查看信息
    public function ckinfo(){
        $mod=M('info');
        $u['id']=htmlspecialchars($_GET['va']);
        $a=$mod->where($u)->select();
        if($a){
            $data['user']=$a[0]['user'];
            $data['sex']=$a[0]['sex'];
            $data['name']=$a[0]['name'];
            $data['tel']=$a[0]['tel'];
            $data['mail']=$a[0]['mail'];
            $data['zhz']=$a[0]['zhuz'];
            $data['zhy']=$a[0]['zhiye'];
            $data['bth']=$a[0]['brith'];
            $this->assign('data',$data);
        }else{
            echo '<script type="text/javascript">alert("出错了！！"); window.close();</script>';
            exit;
        }
        $this->assign('title',$u['mail']);
        $this->display("info");
    }
    //编写xml文件
    private function wxml($file,$time,$tid,$bid,$bz,$yz,$fz,$type){
        $xm=new \DOMDocument(); //引用功能
        $xm->load($file);//加载文件
        $c=$xm->getElementsByTagName('inf')->length;
        //创建节点
        $inf=$xm->createElement('inf');
        $inf->setAttribute('id',$c);
        $tm=$xm->createElement('time',$time);//为节点添加ID属性
        $t=$xm->createElement('tid',$tid);
        $b=$xm->createElement('bid',$bid);
        $tjbz=$xm->createElement('bz',$bz);
        $tjfz=$xm->createElement('fz',$fz);
        $yzxx=$xm->createElement('yz',$yz);
        $tj=$xm->createElement('tj');
        //添加节点
        $inf->appendChild($tm);
        $inf->appendChild($t);
        $inf->appendChild($b);
        $inf->appendChild($tjbz);
        $inf->appendChild($yzxx);
        $inf->appendChild($tjfz);
        $inf->appendChild($tj);
        if($type==0){
            $cc=$xm->getElementsByTagName('ztj')->item(0);
            $cc->appendChild($inf);
        }else{
            $cc=$xm->getElementsByTagName('btj')->item(0);
            $cc->appendChild($inf);
        }
        $xm->save($file);
    }
    //验证是否存在好友
    private function isfrd($id){
        $xml=$this->domx();
        $frd=$xml->getElementsByTagName('bdy');
        for($i=0;$hy=$frd->item($i);$i++){
            if($hy->nodeValue==$id){
                return true;
            }
        }
    }
    //准备添加好友
    public function addhy(){
        $id=$_POST['id'];//帐号id
        //判断是否存在好友
        if($this->isfrd($id)){
            echo "<script type='text/javascript'>alert('$id 已经是您的好友');</script>";
            exit;
        }
        $time=date("Y-m-d h:m");
        $yz=htmlspecialchars($_POST['yz']);//验证消息内容
        $bz=htmlspecialchars($_POST['bz']);//备注
        $fz=(int)$_POST['fz'];//分组
        $filez=$_SERVER['DOCUMENT_ROOT'].__ROOT__.'/Public/conf/'.$_SESSION['id'].'.inf.xml';
        $fileb=$_SERVER['DOCUMENT_ROOT'].__ROOT__.'/Public/conf/'.$id.'.inf.xml';
        $zxml = "<?xml version='1.0' encoding='utf-8'?><infos><news><ztj><inf id='0'><time>$time</time><tid>$_SESSION[id]</tid><bid>$id</bid><bz>$bz</bz><yz>$yz</yz><fz>$fz</fz><tj></tj></inf></ztj><btj></btj></news><hst><ztj></ztj><btj></btj></hst></infos>";
        $bxml = "<?xml version='1.0' encoding='utf-8'?><infos><news><ztj></ztj><btj><inf id='0'><time></time><tid>$_SESSION[id]</tid><bid>$id</bid><bz></bz><yz>$yz</yz><fz></fz><tj></tj></inf></btj></news><hst><ztj></ztj><btj></btj></hst></infos>";
        try {
            if(!file_exists($filez)){
                $file1 = file_put_contents($filez, $zxml);
                if(!$file1){
                    echo '<script type="text/javascript">alert("出错了！！");</script>';
                    exit;
                }
            }else{
                $this->wxml($filez,$time,$_SESSION['id'],$id,$bz,$yz,$fz,0);
            }
            if(!file_exists($fileb)){
                $file2 = file_put_contents($fileb, $bxml);
                if(!$file2){
                    echo '<script type="text/javascript">alert("出错了！！");</script>';
                    exit;
                }
            }else{
                $this->wxml($fileb,'',$_SESSION['id'],$id,'',$yz,'',1);
            }

        }catch (Exception $e){
            echo '<script type="text/javascript">alert("出错了！！");</script>';
            exit;
        }
    }
}