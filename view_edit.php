<?php
header("Content-type: text/html; charset=utf-8"); 

define('IN_QY',true);
session_start();
require("include/common.inc.php");
$infoid=trim($_GET['fid']);
//echo $infoid;


 //分享域名 一度网络开发
require('fxdomain.inc.php');


if ($_GET['act']=='edit'){




if (!empty($_POST['title']) && !empty($_POST['gongzhonghao']) && !empty($_POST['content'])){

	//$content=preg_replace("/<(\/?i?frame.*?)>/si","",$_POST['content']); //过滤frame标签
	$content=$_POST['content'];

	//$sql = 'UPDATE tbl_info SET title="'.$_POST['title'].'",gongzhonghao="'.$_POST['gongzhonghao'].'",addtime="'.$_POST['addtime'].'", content="'.addslashes($content).'" where infoid="'.$infoid.'"';
	$sql = 'UPDATE tbl_info SET title="'.$_POST['title'].'",gongzhonghao="'.$_POST['gongzhonghao'].'",addtime="'.$_POST['addtime'].'", content="'.$content.'" where infoid="'.$infoid.'"';
//var_dump($sql);
	$query = mysql_query($sql);
	echo "<script>alert('编辑成功');window.location.href='".$fxdomain."/view.php?fid=".$infoid."';</script>";
	exit;
}else{
echo "<script>alert('失败');window.location.href='".$fxdomain."/view.php?fid=".$infoid."';</script>";
}



}



if (is_numeric($infoid)){
	
	//}
//	
//if($_GET['fid']){
	$sql = "select * from tbl_info where infoid = ".$infoid;
	$query=mysql_query($sql);
	$row=mysql_fetch_array($query);
//

		
	$sql = "select * from tbl_ad where id = ".$row['adid'];
	$query=mysql_query($sql);
	$rowad=mysql_fetch_array($query);
	
	
    if($row['telnum'] != ""){
		$telnum .= '<a href="tel:'.$row['telnum'].'" class="am-icon-btn am-success" style="width: 35px;height: 35px;padding-top: 5px;"><i class="am-icon-phone"></i></a>';
	 }
	else{
	   $telnum="";
	}
	  
	if(!empty($row['qrcode'])){
		$telnum .= '<a href="#weixin" class="am-icon-btn am-success am-margin-left-xs" style="width: 35px;height: 35px;padding-top: 5px;"><i class="am-icon-weixin"></i></a>';
		
	}
//

	$sql="update tbl_info set wcount=wcount+1 where infoid=".$infoid;
	mysql_query($sql);
}else{
	echo "<script type='text/javascript'>alert('\u6587\u7ae0\u4e0d\u5b58\u5728\uff01');history.go(-1);</script>";
	exit;
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"><meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0" />
<meta name="apple-mobile-web-app-capable" content="yes"><meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta name="format-detection" content="telephone=no">                        
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="black">
	<meta name="format-detection" content="telephone=no">
	<title><?=$row['title']?></title>
	<link rel="stylesheet" type="text/css" href="css/css_view.css">
	<link rel="stylesheet" type="text/css" href="http://cdn.amazeui.org/amazeui/2.5.0/css/amazeui.min.css" />
	<script type="text/javascript" src="js/jquery-2.0.3.min.js" ></script>






	<script>
    $(function() {
        var pattern = /^http:\/\/mmbiz/;
        var prefix = 'image_proxy2.php?1=1&siteid=1&url=';
        $("img").each(function(){
            var src = $(this).attr('src');
            if(pattern.test(src)){
                var newsrc = prefix+src;
                $(this).attr('src',newsrc);
            }
			//$('#js_content').autoIMG();
        });
    });
</script>



<script type='text/javascript'>
    setInterval(function(){
		var dd=document.getElementById('topad').style.display;
		if(dd=="none"){
			document.getElementById('topad').style.display='block';
			}
	},40000);//界面加载四十秒后执行弹出。
	//
	 setInterval(function(){
		var dd=document.getElementById('bannerDowm').style.display;
		if(dd=="none"){
			document.getElementById('bannerDowm').style.display='block';
			}
	},40000);//界面加载四十秒后执行弹出。
</script>
<script type="text/javascript" >
function menuFixed(id){
var obj = document.getElementById(id);
var _getHeight = obj.offsetTop;

window.onscroll = function(){
changePos(id,_getHeight);
}
}
function changePos(id,height){
var obj = document.getElementById(id);
var scrollTop = document.documentElement.scrollTop || document.body.scrollTop;
if(scrollTop < height){
obj.style.position = 'relative';
}else{
obj.style.position = 'fixed';
obj.style.top = '0';
}
}
</script>
<script type="text/javascript">
window.onload = function(){
menuFixed('topad');
}
//
$(function(){


$(".rich_media_meta_list span:first").css("display","none");
}); 
//
</script>
<style>
.topad{ margin:0 auto;left:0; right:0; position:relative;  width:100%; max-width:650px; text-align:right;}
/*.topad img{ width:100%;max-width:650px;}*/
.teltopimg{width:10%; max-width:80px; min-width:50px;}
.telimg{ width:10%; max-width:80px; min-width:50px;}
.app-guide1 {
	position:fixed;
	bottom:0px;
	left:0; right:0;
	width:100%;
	max-width:650px;
	margin:0 auto;
	background-color:rgba(0,0,0,0);
	/*box-shadow:0 -1px 1px rgba(0,0,0,.10);*/
	z-index:99999999999999999;
}
.app-guide1 .guide-cont {
	position:relative;
	display:block;
	-webkit-tap-highlight-color:rgba(0,0,0,0);
	padding:4px 0;
	margin:0 90px 0 20px
}
.app-guide1 .guide-cont.touch::before {
	content:"";
	width:100%;
	height:100%;
	background-color:rgba(0,0,0,.06);
	position:absolute;
	top:0;
	left:-20px;
	padding:0 90px 0 20px
}
.app-guide1 .guide-logo {
	float:left;
	width:42px;
	height:42px;
	vertical-align:top;
	margin-right:8px
}
.app-guide1 .guide-slogon,.app-guide1 .guide-dc {
	color:#fff;
	font-size:16px;
	line-height:20px;
	text-overflow:ellipsis;
	white-space:nowrap;
	overflow:hidden
}
.app-guide1 .guide-slogon span {
	color:#fff;
	font-size:16px;
	line-height:20px;
	margin-right:6px
}
.app-guide1 .guide-slogon span:last-of-type {
	margin-right:0
}
.app-guide1 .guide-dc {
	color:#ccc;
	font-size:14px;
	line-height:22px
}
.app-guide1 .guide-btn {
	position:absolute;
	top:10px;
	right:10px;
	width:80px;
	height:30px;
	background-color:#62af01;
	border:0 none;
	border-radius:3px;
	color:#fff;
	font:14px/30px microsoft yahei,helvetica,arial,sans-serif;
	text-align:center;
	padding:0
}
.app-guide1 .guide-btn.touch {
	background-color:#529301
}
.guide-close {
	position:absolute;
	top:10%;
	right:0;
	width:20px;
	height:20px;
	line-height:999em;
	overflow:hidden;
}
.guide-close::before {
	content:"";
	position:absolute;
	left:3px;
	bottom:2px;
	width:28px;
	height:28px;
	background-color:#262626;
	border-radius:28px
}
.guide-close::after {
	content:"";
	position:absolute;
	top:4px;
	right:2px;
	width:9px;
	height:9px;
	background:url(images/640.png) no-repeat 0 0;
	-webkit-background-size:9px auto;
	background-size:9px auto
}
.guide-fixed .footer {
	padding-bottom:65px
}
@-webkit-keyframes reverseRotataZ{
	0%{-webkit-transform: rotateZ(0deg);}
	100%{-webkit-transform: rotateZ(-360deg);}
}
@-webkit-keyframes rotataZ{
	0%{-webkit-transform: rotateZ(0deg);}
	100%{-webkit-transform: rotateZ(360deg);}
}
#musicControl {position:fixed;right:10px;top:50%;margin-top:0;display:inline-block;z-index:99999999}
#musicControl a {display:inline-block;width:52px;height:52px;overflow:hidden;background-image:url('/images/mcbg.png');background-repeat: no-repeat ;background-size:100%;}
#musicControl a.stop {background-position:left bottom;}
#musicControl a.on {background-position:0px 1px;-webkit-animation: reverseRotataZ 1.2s linear infinite;}
#music_play_filter{width:100%;height:100%;overflow:hidden;position:fixed;top:0;left:0;z-index:99999998;}
.quanjinga{position: absolute;right: 0;margin: 10px;font-size: 22px;}
#quanpingtime{color: red;font-size: 25px;}
.footermenu {	position: fixed;	bottom: 0;	left: 0;	right: 0;	width:100%;	height:44px;	z-index: 900;	padding-top:6px;border-top: 1px solid #D1D1D1;box-shadow: 0 0 5px 0 rgba(0, 0, 0, 0.15);-moz-box-shadow: 0 0 5px 0 rgba(0, 0, 0, 0.15);-webkit-box-shadow: 0 0 5px 0 rgba(0, 0, 0, 0.15);background-image: -webkit-gradient(linear, left top, left bottom, from(#FFFF99), to(#FFFF66));background-image: -webkit-linear-gradient(#FFFF99, #FFFF66);background-image: -moz-linear-gradient(#FFFF99, #FFFF66);background-image: -ms-linear-gradient(#FFFF99, #FFFF66);background-image: linear-gradient(#FFFF99, #FFFF66);background-image: -o-linear-gradient(#FFFF99, #FFFF66);opacity: 0.95;}
.float_top {    position: fixed; top: 250px;   right: 10px;    z-index: 100;    text-align: right;    background-color: #3FC1FD;    padding: 4px;    border-radius: 4px;    font-size: 16px;    line-height: 34px;    border: 1px solid #FFF;    width: 100px;    color: #FFF;}
.submit{width: 80%;}
</style>



<script type="text/javascript">
var UEURL = 'umeditor2/';
</script>
<link href="umeditor2/themes/default/css/umeditor.css" type="text/css" rel="stylesheet">
<script type="text/javascript" src="umeditor2/third-party/jquery.min.js"></script>
<script type="text/javascript" charset="utf-8" src="umeditor2/umeditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="umeditor2/umeditor.min.js?version=1.2.6"></script>
<script type="text/javascript" src="umeditor2/lang/zh-cn/zh-cn.js"></script>











</head>
<body id="activity-detail" class="zh_CN " > 
<?php 
if ($row['userid'] !=$_COOKIE['username']){
	echo '禁止访问';exit;
}
?>
<form name="form1" id="form1" method="post" action="?act=edit&fid=<?php echo $infoid;?>"> 
<div id="quanping2">
<div class="rich_media ">                
	<div class="rich_media_inner">
		标题：  <input name="title" type="text" value="<?=$row['title']?>" size="48" style="width: 98%;"/><br>

公众号：  <input name="gongzhonghao" type="text" value="<?=$row['gongzhonghao']?>" size="48" style="width: 98%;"/><br>
时间：  <input name="addtime" type="text" value="<?=$row['addtime']?>" size="48" style="width: 98%;"/>
		<div id="page-content">
			<div id="img-content">
				内容：
				<div class="rich_media_content" id="js_content">
				
				 <textarea style="width: 640px; height:100%" id="content" name="content">
	<?=$row['content']?>
												
</textarea>	
				

 					<input type="hidden" name="fid" value="<?php echo $infoid;?>"/>
				</div>
			</div>
		</div>
	</div>
</div>
<br>
</div>
<div class="footermenu" id="11" style="z-index:999">
	<table width="100%" border="0">
	  <tr>	
	    <td width="45%" align="center"><input name="" type="submit" value="保存发布" class="submit"/></td>
	    <td width="55%"> <a href="view.php?fid=<?php echo $infoid;?>"  class="submit" >放弃</a></td>
	  </tr>
	</table>
 </div>
 


 </form>
 
		<script type="text/javascript">
	    //实例化编辑器

var um = UM.getEditor('content',
{    autoHeightEnabled: true,
    autoFloatEnabled: true
});

	    um.addListener('blur',function(){
	        $('#focush2').html('编辑器失去焦点了')
	    });
	    um.addListener('focus',function(){
	        $('#focush2').html('')
	    });
	</script>

 <script language="javascript">
 
document.getElementById('content').style.width=document.body.clientWidth-9 + 'px';//设置宽度//设置宽度
$(window).load(function() {   
    $("img").each( function() {
  var maxwidth = document.body.clientWidth-9;
  if ($(this).width() > maxwidth) {
   $(this).width(maxwidth);
  }
});  
});  
	  </script>
 
 
</body>
</html>
