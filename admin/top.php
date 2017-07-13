<?php
session_start();


header('Content-Type:text/html; charset=utf-8');
define('IN_QY',true);
require("../include/common.inc.php");

require("check.php");

$shuyu =  $_SESSION['admin_user'];




	//读取代理开户数量
	

	$dailikaihushu=mysql_query("select * from tbl_admin where id = ".$_SESSION['adminid']);
	while($row1=mysql_fetch_array($dailikaihushu)){
		$row4=$row1;
		}
	$kaihushu=$row4["kehushu"];
		//$kaihushu=2;
	//	var_dump($kaihushu);
	//统计代理已经开出的数量
	$tongji = "select  COUNT(id) from tbl_user where shuyu = '".$shuyu."'";
	$tongjikehu=mysql_query($tongji);
	$row2=mysql_fetch_array($tongjikehu);
	
	//var_dump($row2[0]);
	$shengyushu=$kaihushu-$row2[0];





?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>火速推</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<script language="JavaScript" src="js/jquery.js"></script>
<script type="text/javascript">
$(function(){	
	//顶部导航切换
	$(".nav li a").click(function(){
		$(".nav li a.selected").removeClass("selected")
		$(this).addClass("selected");
	})	
})	
</script>

</head>
<body style="background:url(images/topbg.gif) repeat-x;">

    <div class="topleft">
    <a href="main.php" target="_parent"><img src="images/logo.png" title="系统首页" /></a>
    </div>
        
    <ul class="nav">
		<li><a href="repass.php"  target="rightFrame"><img src="images/icon06.png" title="修改密码" /><h2>修改密码</h2></a></li>
    </ul>
	
		<?php if($shuyu=="admin"){ ?>
	<ul class="nav">
		<li><a href="setdomain.php"  target="rightFrame"><img src="images/icon06.png" title="设置分享域名" /><h2>设置分享域名</h2></a></li>

		
    </ul>
	<?php } ?>
                  <li style="padding-top:30px; color:#FFFFFF; font-size:16px">剩余开户数：<?=$shengyushu?></li>      
    <div class="topright">    
    <ul>
    <li><span><img src="images/help.png" title="帮助"  class="helpimg"/></span><a href="#">帮助</a></li>
    <li><a href="#">关于</a></li>
    <li><a href="check.php?action=loginout" target="_parent">退出</a></li>
    </ul>
    <div class="user">
    <span><?=$_SESSION['admin_user']?></span>
    </div>    
    </div>

</body>
</html>
