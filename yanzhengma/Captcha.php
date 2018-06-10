<?php

require 'ValidateCode.php';
session_start();
$_vc = new ValidateCode();  //实例化一个对象
$_vc->doimg();  
$_SESSION['captcha'] = $_vc->getCode();//验证码保存到SESSION中
