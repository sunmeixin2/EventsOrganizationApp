<!DOCTYPE html>
<html>
<head>
	<title> 登录页面 </title>
</head>
<body>
	<form method="POST" action="<?php echo site_url('server/login_controller/sign_in') ?>">
		username：<input type="text" name="username">
		<br>
		password：<input type="password" name="pwd">		
		<input type="submit" value="登录" >
	</form>

</body>
</html>