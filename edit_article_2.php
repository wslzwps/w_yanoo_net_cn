<?php
define('IN_QY',true);
session_start();
require("include/common.inc.php");
require('include/functions.php');
require('include/QueryList.class.php');
//include 'phpQuery/phpQuery.php'; 

$infoid=trim($_GET['fid']);
  $fid=trim($_GET['fid']);
	$sql = "select * from tbl_info where infoid = ".$infoid;
	$query=mysql_query($sql);
	$row=mysql_fetch_array($query);

if($_GET["act"]=="del"){
	$infoid=trim($_POST['fid']);
	$title=trim($_POST['title']);
	$content=trim($_POST['content']);;
	
	$sqlt="UPDATE tbl_info SET title='$title',content='$content' WHERE infoid=".$infoid; 
	  mysql_query($sqlt);
	 mysql_close();
	 
	 echo "<script type='text/javascript'>alert('\u7f16\u8f91\u6210\u529f\uff01');location.href='view.php?fid=".$infoid."';</script>";
	 exit;
}


?>

<!DOCTYPE HTML>
<html>
<head>
<meta charset="UTF-8">
<title>发布文章 - 亚努信息分享系统</title>
<meta name="description" content="" />
<meta name="viewport" content="width=device-width , initial-scale=1.0 , user-scalable=0 , minimum-scale=1.0 , maximum-scale=1.0" />
<script type='text/javascript' src='js/jquery-2.0.3.min.js'></script>
<script type='text/javascript' src='js/patch/mobileBUGFix.mini.js'></script>
<link rel="stylesheet" href="css/css.css"> 
<style type="text/css">
.bot_main li.ico_1{
  background:#F1901F;
}
</style>

	</head>
<body>
<div class="apply" id="apply">
	<p>编辑文章</p>

	<script src="static/jquery.js" type="text/javascript"></script> 
	<script charset="utf-8" src="../editor/kindeditor.js"></script>
	<script charset="utf-8" src="../editor/lang/zh_CN.js"></script>
	<script charset="utf-8" src="../editor/plugins/code/prettify.js"></script>
	<script>
		KindEditor.ready(function(K) {
			var editor1 = K.create('textarea[name="content"]', {
				cssPath : '../editor/plugins/code/prettify.css',
				uploadJson : '../editor/php/upload_json.php',
				fileManagerJson : '../editor/php/file_manager_json.php',
				allowFileManager : true,
				filterMode: false,//是否开启过滤模式
			});
			prettyPrint();
		});
	</script>
<script>
			KindEditor.ready(function(K) {
				var uploadbutton = K.uploadbutton({
					button : K('#uploadButton')[0],
					fieldName : 'imgFile',
					url : '../../editor/php/upload_json.php?dir=image',
					afterUpload : function(data) {
						if (data.error === 0) {
							var url = K.formatUrl(data.url, 'absolute');
							K('#img').val(url);
                            $.post("../../editor/php/dunling.php",{
                            url:url
                            },function(slta,sltb){
                            //****//
                            });
						} else {
							alert(data.message);
						}
					},
					afterError : function(str) {
						alert('自定义错误信息: ' + str);
					}
				});
				uploadbutton.fileBox.change(function(e) {
					uploadbutton.submit();
				});
			});
</script>	



<div class="apply" id="apply">
<div class="blank10"></div>  
		<form action="?act=del" id="signupok" method="post" name="addform"  enctype="multipart/form-data">
		<input type="hidden" name="fid" value="<?php echo $fid?>">
		<dl class="clearfix">
		<dd>标题：</dd>
       <dd> <input type="text" value="<?php echo $row['title']?>" style="width:500px" name="title"></dd>
		</dl>
		<dl class="clearfix">
		<dd>文章内容：</dd>
		<dd> <textarea value="Smith" rows="10" name="content" style="width:100%;height:500%;visibility:hidden;">
		<?php  $html_content=str_replace('http://mmbiz','http://mmbiz',$row['content']);echo $html_content;?>
		</textarea></dd></dl>
		 <label></label><div class="blank10"></div> 
		<div class="btn_box" style="margin-bottom:50px;" align="center">
			<button class="btn btn-primary"> 确认提交</button>
		</div>
		<div class="blank10"></div>
		</form>
      </div>
  </div>



   
  </body>
</html>
