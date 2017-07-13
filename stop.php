<?php
        $aid=$_GET['id'];//
	$cmd="ps -ef |grep 'uu.php $aid'|grep -v grep|awk '{print $2}'";
	exec($cmd,$out,$status);
	
	exec("nohup kill -9 $out[0]");
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
</head>

<body>
        <h1>已停止</h1>
</body>
