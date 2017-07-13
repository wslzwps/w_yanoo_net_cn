<?php
header('Content-Type:text/html; charset=utf-8');
define('IN_QY',true);
require("../include/common.inc.php");
require("check.php");
$shuyu =  $_SESSION['admin_user'];
 if($shuyu!="admin"){
 exit;
 }
if($_GET['act']=="mod"){
	$domain=$_POST['domain'];
	$fxdomain=$_POST['fxdomain'];
	$sql="update tbl_site set
	domain='".$domain."',
	fxdomain='".$fxdomain."'
	where id=1";
	//echo $sql;exit;
	mysql_query($sql);
	if(mysql_affected_rows() == 1){
		qy_close();
		echo "<script type='text/javascript'>alert('修改成功!');location.href='setdomain.php';</script>";
		exit;
	}else{
		qy_close();
		qy_alert_back('信息修改失败!');
	}
}else{
	$sql="select * from tbl_site  where id=1";
$query=mysql_query($sql);
$row=mysql_fetch_array($query);
}




?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?=PT_NAME?></title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link href="css/select.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/select-ui.min.js"></script>


</head>

<body>

	<div class="place">
    <span>位置：</span>
    <ul class="placeul">
    <li><a href="#">首页</a></li>
    <li><a href="#">修改密码</a></li>
    </ul>
    </div>


    <form action="?act=mod" method="post" name="newsform">
    <div class="formbody">
    
    <div class="formtitle"><span>设置分享域名</span></div>

    <ul class="forminfo">

		<li>
		  <label>主域名：</label><input name="domain" type="text" class="dfinput" value="<?=$row['domain']?>"/><i></i></li>
		<li>
		  <label>分享域名：</label><input name="fxdomain" type="text" class="dfinput" value="<?=$row['fxdomain']?>"/>多个|隔开<i></i></li>

		<li><label>&nbsp;</label><input name="" type="submit" class="btn" value="确认保存"/></li>
    </ul>
    </div>
	</form>

</body>
</html>
