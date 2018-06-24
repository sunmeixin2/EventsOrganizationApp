<html>
<head>
<title>多文件上传</title>
</head>
<body>


<form action='<?php echo site_url("server/home_controller/do_upload") ?>' method="post"  enctype="multipart/form-data">
<input type="file" name="image[]"  multiple="multiple" >

<input type="submit" value="upload" />

</form>

</body>
</html>