<?php
session_start();

require 'ValidateCode.php';

$_vc = new ValidateCode(); 
$_SESSION['captcha'] = $_vc->getCode();//验证码保存到SESSION中
echo $_SESSION['captcha'];