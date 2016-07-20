<?php
function sendmail(){
    Vendor('PHPMailer.PHPMailerAutoload');
    $mail=new PHPMailer();
    var_dump($mail);
    $mail->IsSMTP();  // 用smtp协议来发

    $mail->Host = 'smtp.qq.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'uoi00';
    $mail->Password = 'quilgadcqrlxiaig';
    $mail->CharSet='UTF-8';

    $mail->From = 'uoi00@qq.com';
    $mail->FromName = 'uoi00';
    $mail->Subject = '帐号激活';
    $mail->Body = "请将一下验证码输入注册页面激活账户：12334";

    //设置收信人
    $mail->AddAddress('uoi475@163.com');
    var_dump($mail->send());  //发送邮件
}