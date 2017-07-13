<?php 
error_reporting(0);
define('IN_QY',true);
session_start();
require("include/common.inc.php");
if(!$_COOKIE['userid']){
	echo "<script type='text/javascript'>location.href='login.php';</script>";
	exit;
}

function upimg($imgformname){
$type="";
$filehouzhui="";
$name="";
$tmp_name="";

$upfile=$_FILES[$imgformname]; 
		//获取数组里面的值 
		//$name=time().$upfile["name"];//上传文件的文件名
		$string = strtolower(strrev($_FILES[$imgformname]['name']));
		$array = explode('.',$string);
		$filehouzhui=strrev($array[0]);
		//var_dump($filehouzhui);
		$yunxuhouzhui = array("jpg", "jpeg", "gif", "png");
	
		if (in_array($filehouzhui, $yunxuhouzhui))  {
		  }	else  {
		  echo ("\u56fe\u7247\u5fc5\u987b\u662f\u0020\u006a\u0070\u0067\u0020\u006a\u0070\u0065\u0067\u0020\u0067\u0069\u0066\u0020\u0070\u006e\u0067\u7b49\u683c\u5f0f");
		
		  exit;
		  }

		$type=$upfile["type"];//上传文件的类型 
		$tmp_name=$upfile["tmp_name"];//上传文件的临时存放路径
		
		//var_dump($tmp_name);
		
	switch ($type){ 
			case 'image/pjpeg':$okType=true; 
			$houzhui="jpg";
			break; 
			case 'image/jpeg':$okType=true; 
			$houzhui="jpeg";
			break; 
			case 'image/gif':$okType=true; 
			$houzhui="gif";
			break; 
			case 'image/png':$okType=true; 
			$houzhui="png";
			break; 
		}
				
		$name = 'upload/'.time().rand(10,100).'a.'.$houzhui;
		//var_dump($name);
		//var_dump("<hr>");
		//判断是否为图片 
	
		//二维码
		 
		if($okType){ 
			$error=$upfile["error"];//上传后系统返回的值 
			//把上传的临时文件移动到up目录下面 
			move_uploaded_file($tmp_name,$name); 
			return $name;
		}else{ 
			qy_alert_back('\u8bf7\u4e0a\u4f20\u006a\u0070\u0067\u002c\u0067\u0069\u0066\u002c\u0070\u006e\u0067\u7b49\u683c\u5f0f\u7684\u56fe\u7247\uff01');
		} 
} 


if($_GET['act']=='add'){
	if(is_uploaded_file($_FILES['upfile']['tmp_name'])){ 
	$name=upimg("upfile");
	}
	if(is_uploaded_file($_FILES['qrcode']['tmp_name'])){ 
		$ewname = upimg("qrcode");
	}
	
	if(is_uploaded_file($_FILES['quanping']['tmp_name'])){ 
		$quanpingt =  upimg("quanping");
	}
	
	if(is_uploaded_file($_FILES['quanping2']['tmp_name'])){ 
		$quanpingt2 = upimg("quanping2");
	}
	
	$adtelnumber=trim($_POST['adtelno']);
	$qq=trim($_POST['qq']);
	 
	$gzhname=trim($_POST['gzhname']);
	$gzhurl=trim($_POST['gzhurl']);
	 
	$pmd_top=trim($_POST['pmd_top']);
	$pmd_footer=trim($_POST['pmd_footer']);
	 
	 //$erweima=trim($_POST['qrcode']);
	$sql = "insert into tbl_ad values (0,'".$_POST['adtitle']."','".$_POST['adlink']."','".$name."','".$_COOKIE['userid']."','".$_COOKIE['username']."','".date('Y-m-d H:i:s')."','".$adtelnumber."','".$ewname."','".$quanpingt."','".$_POST['adlink2']."','".$quanpingt2."','".$_POST['adlink3']."','".$qq."','".$gzhname."','".$gzhurl."','".$pmd_top."','".$pmd_footer."')";

	mysql_query($sql);
	echo "<script>alert('\u63d0\u4ea4\u6210\u529f\uff01');window.location.href='ad_edit.php';</script>";
}

if ($_GET['act']=='updata'){
	$sqlu = "select * from tbl_ad where id=".(int)$_GET['id'];
	$queryu=mysql_query($sqlu);
	$rowu=mysql_fetch_array($queryu);
	$form  = 1;
}
if ($_GET['act']=='upd'){
	
	if(is_uploaded_file($_FILES['upfile']['tmp_name'])){ 
		$name =  upimg("upfile");
		$setimg=" ,ad_img='".$name."'";
	}
	if(is_uploaded_file($_FILES['qrcode']['tmp_name'])){ 
		$erweima = upimg("qrcode");
		$seterweima=" ,erweima='".$erweima."'";
	}
	
	if(is_uploaded_file($_FILES['quanping']['tmp_name'])){ 
			$quanping =  upimg("quanping");
			$setquanping=" ,quanping='".$quanping."'";
	}

	if(is_uploaded_file($_FILES['quanping2']['tmp_name'])){ 
		$quanping2 = upimg("quanping2");
		$setquanping2=" ,quanping2='".$quanping2."'";
	}
	
	 $adtelnumber=trim($_POST['adtelno']);
	  $qq=trim($_POST['qq']);
	 
	 	 
	 $gzhname=trim($_POST['gzhname']);
	 $gzhurl=trim($_POST['gzhurl']);
	 
	 $pmd_top=trim($_POST['pmd_top']);
	$pmd_footer=trim($_POST['pmd_footer']);
	 //$erweima=trim($_POST['qrcode']);
	//$sql = "insert into tbl_ad values (0,'".$_POST['adtitle']."','".$_POST['adlink']."','".$name."','".$_COOKIE['userid']."','".$_COOKIE['username']."','".date('Y-m-d H:i:s')."','".$adtelnumber."','".$ewname."','".$quanpingt."')";
	$id = (int)$_GET['id'];
	//,'".$_POST['ad_link2']."','".$quanpingt2."','".$_POST['ad_link3']."'
	$sql = "update tbl_ad set ad_title='".$_POST['adtitle']."',ad_link='".$_POST['adlink']."',ad_link2='".$_POST['adlink2']."',ad_link3='".$_POST['adlink3']."',adtelnumber='".$adtelnumber."' ,qq='".$qq."' ,gzhname='".$gzhname."',gzhurl='".$gzhurl."'".$setimg.$seterweima.$setquanping.$setquanping2.",pmd_top='".$pmd_top."' ,pmd_footer='".$pmd_footer."' where id=".$id;
	 
	//var_dump($sql);
	mysql_query($sql);
	echo "<script>alert('修改成功');window.location.href='ad_edit.php?id=".$id."&act=updata';</script>";
}
?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="UTF-8">
<title>添加广告 - 亚努掌上分享系统</title>
<meta name="description" content="" />
<meta name="viewport" content="width=device-width , initial-scale=1.0 , user-scalable=0 , minimum-scale=1.0 , maximum-scale=1.0" />
<script type='text/javascript' src='js/jquery-2.0.3.min.js'></script>
<script type='text/javascript' src='js/patch/mobileBUGFix.mini.js'></script>
<link rel="stylesheet" href="css/css.css">   
</head>
<body>
<div class="apply" id="apply">
	<p>添加广告</p>
	<div class="blank10"></div>
	<?php 
		if(empty($form)) echo '<form action="?act=add" id="signupok" method="post" name="addform"  enctype="multipart/form-data">';
		else echo '<form action="?act=upd&id='.(int)$_GET['id'].'" id="signupok" method="post" name="addform"  enctype="multipart/form-data">';
	 ?>
		<dl class="clearfix">
			<dd>广告标题：</dd>
			<dd><input type="text" class="input_txt" value="<?php echo $rowu['ad_title']; ?>" name="adtitle" id="adtitle" placeholder="请输入广告标题" style="height:50px;"></dd>
		</dl>		
        <dl class="clearfix">
			<dd>联系电话：</dd>
			<dd><input type="tel" class="input_txt" value="<?php echo $rowu['adtelnumber']; ?>" name="adtelno" id="adtelno" placeholder="请输入联系电话" style="height:50px;"></dd>
		</dl>
		 <dl class="clearfix">
			<dd>联系qq：</dd>
			<dd><input type="text" class="input_txt" value="<?php echo $rowu['qq']; ?>" name="qq" id="qq" placeholder="qq" style="height:50px;"></dd>
		</dl>
        
		<dl class="clearfix">
			<dd>广告图片：<span style="font-size:13px; color:#666;">(尺寸：750像素*150像素)</span></dd>
			<dd style="margin-bottom:10px;"><img src="<?php echo $rowu['ad_img']; ?>" style="max-width:600px; max-height:150px;"/></dd>
			<dd><input type="file" class="input_txt"   placeholder="选择上传广告图片" name="upfile" style="width: 100%;height: 50px;box-sizing: border-box;padding: 14px;color: #696969;font-size: 12px;line-height: 12px;border: #e6e6e6 1px solid;
background: #fff;"></dd>
		</dl>
		<dl class="clearfix">
			<dd>广告链接：</dd>
			<dd><input type="text" class="input_txt" value="<?php echo $rowu['ad_link']; ?>" name="adlink" id="adlink" placeholder="请输入广告链接（包含：http://）" style="height:50px;"></dd>
		</dl>
		<br />
        <dl class="clearfix">
			<dd>二维码：<span style="font-size:13px; color:#666;">(尺寸：258像素*258像素)</span></dd>
			<dd style="margin-bottom:10px;"><img src="<?php echo $rowu['erweima']; ?>" style="max-width:258px; max-height:258px;" /></dd>
			<dd><input type="file" class="input_txt"   placeholder="选择上传二维码图片" name="qrcode" style="width: 100%;height: 50px;box-sizing: border-box;padding: 14px;color: #696969;font-size: 12px;line-height: 12px;border: #e6e6e6 1px solid;
background: #fff;"></dd>
		</dl>
        <dl class="clearfix">
			<dd>顶部广告跑马灯：</dd>
			<dd><input type="text" class="input_txt" value="<?php echo $rowu['pmd_top']; ?>" name="pmd_top" id="pmd_top" placeholder="微信广告招商，让您的广告跟着热文传遍朋友圈" style="height:50px;"></dd>
		</dl>	
		<dl class="clearfix">
			<dd>底部广告跑马灯</dd>
			<dd><input type="text" class="input_txt" value="<?php echo $rowu['pmd_footer']; ?>" name="pmd_footer" id="pmd_footer" placeholder="微信广告招商，让您的广告跟着热文传遍朋友圈" style="height:50px;"></dd>
		</dl>
        <dl class="clearfix">
			<dd>全屏图(全屏显示3秒)：<span style="font-size:13px; color:#666;">(尺寸：480像素*800像素)</span></dd>
			<dd style="margin-bottom:10px;"><img src="<?php echo $rowu['quanping']; ?>" style="max-width:480px; max-height:800px;" /></dd>
			<dd><input type="file" class="input_txt"   placeholder="选择上传图片图片" name="quanping" style="width: 100%;height: 50px;box-sizing: border-box;padding: 14px;color: #696969;font-size: 12px;line-height: 12px;border: #e6e6e6 1px solid;
background: #fff;"></dd>
		</dl>
		<br />
		<dl class="clearfix">
			<dd>全屏广告链接：</dd>
			<dd><input type="text" class="input_txt" value="<?php echo $rowu['ad_link2']; ?>" name="adlink2" id="adlink2" placeholder="请输入广告链接（包含：http://）" style="height:50px;"></dd>
		</dl>
		
		<dl class="clearfix">
			<dd>全屏后顶部广告图：<span style="font-size:13px; color:#666;">(尺寸：480像素*150像素)</span></dd>
			<dd style="margin-bottom:10px;"><img src="<?php echo $rowu['quanping2']; ?>" style="max-width:480px; max-height:150px;" /></dd>
			<dd><input type="file" class="input_txt" placeholder="选择上传图片图片" name="quanping2" style="width: 100%;height: 50px;box-sizing: border-box;padding: 14px;color: #696969;font-size: 12px;line-height: 12px;border: #e6e6e6 1px solid; background: #fff;"></dd>
		</dl>
		
		<dl class="clearfix">
			<dd>全屏后广告链接：</dd>
			<dd><input type="text" class="input_txt" value="<?php echo $rowu['ad_link3']; ?>" name="adlink3" id="adlink3" placeholder="请输入广告链接（包含：http://）" style="height:50px;"></dd>
		</dl>
		
			
		
		<dl class="clearfix">
			<dd>公众号名称：</dd>
			<dd><input type="text" class="input_txt" value="<?php echo $rowu['gzhname']; ?>" name="gzhname" id="gzhname" placeholder="公众号名称（需要替换原文章发布者则填入）" style="height:50px;"></dd>
		</dl>
		
	
		<dl class="clearfix">
			<dd>公众号链接：</dd>
			<dd><input type="text" class="input_txt" value="<?php echo $rowu['gzhurl']; ?>" name="gzhurl" id="gzhurl" placeholder="公众号的链接（包含：http://）" style="height:50px;"></dd>
		</dl>
		
		
		
		
		
		<div class="btn_box" style="margin-bottom:50px;">
			<input type="name" name="signup" class="button" value="确认提交"  onclick="return postcheck();">
		</div>
		<div class="blank10"></div>
		
	</form>
</div>

<? include('foot.php');?>
<script type="text/javascript">
function postcheck(){
	if (document.addform.adtitle.value=="" ){
		alert('请填写广告标题！');
		document.addform.adtitle.focus();
		return false;
	}
	//if (document.addform.adlink.value=="" ){
	//	alert('请填写广告链接！');
	//	document.addform.adlink.focus();
	//	return false;
	//}
	<?php 
		//if(empty($form)) echo "if (document.addform.upfile.value=='' ){
		//	alert('请上传广告图片！');
		//	document.addform.upfile.focus();
		//	return false;
		//}";
	?>
	
	document.addform.submit();
	return true;	
}
</script>
</body>
</html>
