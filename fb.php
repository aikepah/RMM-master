<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8">
	<title>Restaurant Info</title>
</head>
<body>
<p>Test</p>
<?php
if(isset($_GET))
{
	echo 'get';
    var_dump($_GET);
}
if(isset($_POST))
{
	echo 'post';
    var_dump($_POST);
}


?>
</body>
</html>


