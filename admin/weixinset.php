<?php
header('Content-Type:text/html; charset=utf-8');
define('IN_QY',true);
require("../include/common.inc.php");
require("../include/functioned.php");
require("check.php");
$shuyu =  $_SESSION['admin_user'];
if($_GET['act']=='add'){
	
	$sql = "INSERT INTO tbl_weixin (name,add_time) value ('".$_POST['name']."','".time()."')";
	//echo $sql;exit;
	mysql_query($sql);
	if(mysql_affected_rows() == 1){
		qy_close();
		echo "<script>alert('添加成功！');window.location.href='music_cat_list.php';</script>";
		exit;
	}else{
		qy_close();
		qy_alert_back('信息添加失败或无修改动作!');
	}
}
if($_GET['act']=='edit'){
	$sql="UPDATE tbl_weixin SET  APPID='".$_POST["APPID"]."', APPSECRET='".$_POST["APPSECRET"]."' WHERE id=".$_POST["id"];
	mysql_query($sql);
	if(mysql_affected_rows() == 1){
		qy_close();
		echo "<script>alert('编辑成功！');window.location.href='weixinset.php?id=1';</script>";
		exit;
	}else{
		qy_close();
		qy_alert_back('信息编辑失败或无修改动作!');
	}
}
$id=(int)$_GET['id'];
if($id){
	$query=mysql_query("SELECT * FROM tbl_weixin WHERE id=".$id);
	$row=mysql_fetch_array($query);
	
}


if($id){
		$action = "?id=$id&act=edit";
	}else{
		$action = "?act=add";
	}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>鸿林微盟</title>
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
			    <li><a href="#">配置分享接口参数</a></li>
		    </ul>
	    </div>
	
	    <form action="<?=$action?>" method="post" name="newsform"  enctype="multipart/form-data">
	    	<input name="id" value="<?=$id?>" type="hidden">
		    <div class="formbody">
		    <div class="formtitle"><span>微信接口参数</span></div>
			<div>（去公众号后台取）</div>
		    <ul class="forminfo">
				<li><label>APPID</label><input name="APPID" type="text"  class="dfinput" value="<?=$row['APPID']?>"/></li>
				<li><label>APPSECRET</label><input name="APPSECRET" type="text"  class="dfinput" value="<?=$row['APPSECRET']?>"/></li>
			    <li><label>&nbsp;</label><input name="add" type="submit" class="btn" value="提交"/></li>
		    </ul>
		    </div>
		</form>
	
	</body>
</html>
