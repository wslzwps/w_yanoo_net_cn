<?php
header('Content-Type:text/html; charset=utf-8');
define('IN_QY',true);
require("../include/common.inc.php");
require("../include/functioned.php");
require("check.php");
$shuyu =  $_SESSION['admin_user'];




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
		var_dump($filehouzhui);
		$yunxuhouzhui = array("mp3");
	
		if (in_array($filehouzhui, $yunxuhouzhui))  {
		  }	else  {
		  echo ("图片必须是mp3格式");
		  exit;
		  }

		$type=$upfile["type"];//上传文件的类型 
		$tmp_name=$upfile["tmp_name"];//上传文件的临时存放路径
		
		var_dump($tmp_name);
		
	switch ($type){ 
			case 'audio/mp3':$okType=true;  
			$houzhui="mp3";
			break; 


		}
				
		$name = 'upload/music/'.time().rand(10,100).'a.'.$houzhui;
		var_dump($name);var_dump("<hr>");
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












if($_POST['add']=='添加'){
	if(is_uploaded_file($_FILES['upfile']['tmp_name'])){
		$upfile=$_FILES["upfile"]; 
		//获取数组里面的值 
		//$name=time().$upfile["name"];//上传文件的文件名
		//$string = ($_FILES['upfile']['name']);
		$array = explode('.',$_FILES['upfile']['name']);
		
		
		$yunxuhouzhui = array("mp3");
	
		if (in_array($array[1], $yunxuhouzhui))  {
		  }	else  {
		  echo ("必须是mp3格式");
		  exit;
		  }
		
		
		$type=$upfile["type"];//上传文件的类型 
		$size=$upfile["size"];//上传文件的大小 
		$tmp_name=$upfile["tmp_name"];//上传文件的临时存放路径 
		$name = '/upload/music/'.iconv('UTF-8', 'GBK', $array[0]).'.'.$array[1];
		//判断是否为图片 
		
		switch ($type){ 
			case 'audio/mpeg':$okType=true; 
			break; 
			case 'audio/mp3':$okType=true; 
			break; 
		}
		if($okType){ 
			$error=$upfile["error"];//上传后系统返回的值 
			//把上传的临时文件移动到up目录下面 
			if (!move_uploaded_file($tmp_name,dirname(dirname(__FILE__)).$name)){
				qy_alert_back('上传失败');
			}
		}else{ 
			qy_alert_back('请上传mp3文件');
		}
	
	
		//$sql="UPDATE tbl_music SET  title='".iconv('UTF-8', 'GBK', $array[0])."', path='".$name."', add_time='".time() ;
		$sql = "INSERT INTO tbl_music (title,path,add_time,cat_id) value ('".$array[0]."','".'/upload/music/'.$_FILES['upfile']['name']."','".time()."',".$_POST['cat_id'].")";
		
		//echo $sql;exit;
		mysql_query($sql);
		if(mysql_affected_rows() == 1){
			qy_close();
			echo "<script>alert('添加成功！');window.location.href='music_list.php';</script>";
			exit;
		}else{
			qy_close();
			qy_alert_back('信息编辑失败或无修改动作!');
		}
	}else{
		qy_alert_back('请上传mp3文件');
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>鸿林微盟</title>
		<link href="css/style.css" rel="stylesheet" type="text/css" />
	
		<script type="text/javascript" src="js/jquery.js"></script>
		<script type="text/javascript" src="js/select-ui.min.js"></script>
	</head>
	<body>
	
		<div class="place">
		    <span>位置：</span>
		    <ul class="placeul">
			    <li><a href="#">首页</a></li>
			    <li><a href="#">音乐管理</a></li>
		    </ul>
	    </div>
	
	    <form action="" method="post" name="newsform"  enctype="multipart/form-data">
		    <div class="formbody">
		    <div class="formtitle"><span>添加音乐</span></div>
		    <ul class="forminfo">
		    	<li><label>分类</label>
		    		<select name="cat_id" >
		    		<?
						$page_sql = "select * from tbl_music";
						
					
						$sql = "select * from tbl_music_cat ORDER by id DESC";
					
						$query=mysql_query($sql);
						while($rowc=mysql_fetch_array($query)){
					?>
						<option   value="<?=$rowc['id']?>"><?=$rowc['name']?></option>
						
				    <?
					}
					?>  
					</select> 
				</li> 
				<li><label>上传</label><input name="upfile" type="file"  class=""/></li>
			    <li><label>&nbsp;</label><input name="add" type="submit" class="btn" value="添加"/></li>
		    </ul>
		    </div>
		</form>
	
	</body>
</html>
