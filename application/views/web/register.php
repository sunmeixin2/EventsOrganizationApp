<!DOCTYPE html>
<html>
<head>
	<title> 登录页面 </title>
</head>
<body>
	<form method="POST" action="<?php echo site_url('server/login_controller/sign_up') ?>">
		username：<input type="text" name="username">
		<br>
		password：<input type="password" name="pwd">
		<br>
		重复：
		<input type="password" name="pwd2"> -->
		 <br>
		 <p>验 证 码：<input type="text" name="captcha" id="yzm">
 		<img src="<?php echo site_url('server/login_controller/captcha')?>" onClick="this.src='<?php echo site_url('server/login_controller/captcha')?>?nocache='+Math.random()" style="cursor:hand"></p> 
		<input type="submit" value="登录" >
	</form>

</body>
</html>