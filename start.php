<?php
        $aid=$_GET['id'];
	$cmd="nohup php /www/web/w_yanoo_net_cn/public_html/uu.php $aid > /www/web/w_yanoo_net_cn/public_html/out.file 2>&1 &";
	print_r($cmd);

 	exec($cmd,$out,$status); 
	print_r($out);
	print_r($status);

	
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
</head>

<body>
	<h1>已启动</h1>
</body>
