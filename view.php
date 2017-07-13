<?php
define('IN_QY',true);
session_start();
require("include/common.inc.php");

 //分享域名 北京云里科技开发
require('fxdomain.inc.php');

//北京云里科技开发 微信 244178528
//配置平台名字和链接
//当用户不设置公众号和链接时，下面的配置才生效，用户配置优先
//如果系统想统一替换成平台的名字填入1，想保留原来文章的公众号名称 填0
$tihuan=0;
$sysgzhname="北京云里科技";
$sysgzhurl=$domain;


$query=mysql_query("SELECT * FROM tbl_weixin WHERE id=1");
$rowweixin=mysql_fetch_array($query);




/*
require("weixin.php");
$jsinfo= new bbb($rowweixin);
$agui=$jsinfo->getSignPackage();
*/


$infoid=trim($_GET['fid']);
//echo $infoid;
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
	
	
	
	//处理公众号问题
	$gzhname=$row['gongzhonghao'];
	$gzhurl="#";
	//echo $gzhname;exit;
	if($tihuan==1){
	$gzhname=$sysgzhname;
	$gzhurl=$sysgzhurl;
	} //echo $gzhname;exit;
	if($rowad['gzhname']){
	$gzhname=$rowad['gzhname'];
	$gzhurl=$rowad['gzhurl'];
	}
	
	
    if($rowad['adtelnumber'] != ""){
		$telnum .= '<a href="tel:'.$rowad['adtelnumber'].'" class="am-icon-btn am-success" style="width: 35px;height: 35px;padding-top: 5px;"><i class="am-icon-phone"></i></a>';
	}
	else{
	   $telnum="";
	}
	  
	if(!empty($rowad['erweima'])){
		$telnum .= '<a href="javascript:void(0)" onClick="dakaiewm();" class="am-icon-btn am-success am-margin-left-xs" style="width: 35px;height: 35px;padding-top: 5px;"><i class="am-icon-weixin"></i></a>';
	}
//

	$sql="update tbl_info set wcount=wcount+1 where infoid=".$infoid;
	mysql_query($sql);
}else{
	echo "<script type='text/javascript'>alert('\u6587\u7ae0\u4e0d\u5b58\u5728\uff01');history.go(-1);</script>";
	exit;
}


//弄个图片


if($row['titleimg']) { 
  $tupian='http://w.xt199.com/image_proxy2.php?1=1&siteid=1&url='.$row['titleimg']; 
  
  //  $tupian='http://img01.store.sogou.com/net/a/04/link?appid=100520029&url=http://'.str_replace('"','',$match[0]).'wx_fmt=jpeg'; 
 } else { 
if(preg_match("/mmbiz.qpic.cn\/(.*?)\"/i", $row['content'] ,$match)) { 
  $tupian='http://w.xt199.com/image_proxy2.php?1=1&siteid=1&url=http://'.str_replace('"','',$match[0]); 
  
  //  $tupian='http://img01.store.sogou.com/net/a/04/link?appid=100520029&url=http://'.str_replace('"','',$match[0]).'wx_fmt=jpeg'; 
 } else { 
  $tupian= "http://h.hiphotos.baidu.com/zhidao/wh%3D600%2C800/sign=05e1074ebf096b63814c56563c03ab7c/8b82b9014a90f6037c2a5c263812b31bb051ed3d.jpg"; 
 }  } 

//弄个图片




function trimall($str){
    $qian=array(" ","　","\t","\n","\r");
    return str_replace($qian, '', $str);   
}

$zhaiyao=substr(strip_tags($row['content']),0,98);
$zhaiyao=trimall($zhaiyao); 

if(strlen($zhaiyao)<40){
$zhaiyao=$row['title'];
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
 
 
<script type="text/javascript" src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script>
	wx.config({
		debug: false, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
		appId: "<?=$agui['appid']?>", // 必填，公众号的唯一标识
		timestamp: "<?=$agui['timestamp']?>", // 必填，生成签名的时间戳
		nonceStr: "<?=$agui['noncestr']?>", // 必填，生成签名的随机串
		signature: "<?=$agui['signature']?>",// 必填，签名，见附录1
		jsApiList: [
			'checkJsApi',
		    'onMenuShareTimeline',
		    'onMenuShareAppMessage',
		    'onMenuShareQQ',
		    'onMenuShareWeibo',
			'openLocation',
			'getLocation',
			'addCard',
			'chooseCard',
			'openCard',
			'hideMenuItems',
			'scanQRCode',
			'startRecord',
			'stopRecord',
			'onVoiceRecordEnd',
			'playVoice',
			'pauseVoice',
			'stopVoice',
			'onVoicePlayEnd',
			'uploadVoice',
			'downloadVoice',
			'chooseImage',
			'previewImage',
			'uploadImage',
			'downloadImage'
			] // 必填，需要使用的JS接口列表，所有JS接口列表见附录2
	});
</script>
 
<script language="javascript" type="text/javascript">
wx.ready(function(){

   
  wx.onMenuShareAppMessage({
    title: '<?=$row['title']?>', // 分享标题
    desc: '<?=$zhaiyao?>', // 分享描述
    link: window.location.href, // 分享链接
    imgUrl: '<?=$tupian?>', // 分享图标
    type: '', // 分享类型,music、video或link，不填默认为link
    dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
    success: function () { 
        // 用户确认分享后执行的回调函数
    },
    cancel: function () { 
        // 用户取消分享后执行的回调函数
    }
});
  wx.onMenuShareTimeline({
    title: '<?=$row['title']?>', // 分享标题
    link: window.location.href, // 分享链接
    imgUrl: '<?=$tupian?>', // 分享图标
    success: function () { 
        // 用户确认分享后执行的回调函数
    },
    cancel: function () { 
        // 用户取消分享后执行的回调函数
    }
});
// 2.4 监听“分享到微博”按钮点击、自定义分享内容及分享结果接口
		wx.onMenuShareWeibo({
			title: '<?=$row['title']?>',
			desc: '<?=$zhaiyao?>',
			link: window.location.href,
			imgUrl: '<?=$tupian?>',
		    success: function () {
		    },
		    cancel: function () {
		    }
		});
   wx.error(function (res) {
			if(res.errMsg){
				
			}
		});
});
 
</script>
<script type="text/javascript">
	function move(){
		document.getElementById("move").style.display="block";
		document.getElementById("move").style.height = "106px";
	}
	setInterval(function(){
		document.getElementById("bgsound").load();
		　 $('#msplay').trigger('click');
		},1000);//界面加载四十秒后执行弹出


　　　　//adding your code here 
　　}); 
  
    $(function() {
        var pattern = /^http:\/\/mmbiz/;
       // var prefix = 'http://img01.store.sogou.com/net/a/04/link?appid=100520029&url=';
		 var prefix = 'http://w.xt199.com/image_proxy2.php?1=1&siteid=1&url=';
        $(".img").each(function(){
            var src = $(this).attr('src');
            if(pattern.test(src)){
                var newsrc = prefix+src;
                $(this).attr('src',newsrc);
            }
			//$('#js_content').autoIMG();
        });
    });
 
    setInterval(function(){
		var dd=document.getElementById('topad').style.display;
		if(dd=="none"){
			document.getElementById('topad').style.display='block';
			}
	},20000);//界面加载二十秒后执行弹出。
	 
	setInterval(function(){
		var dd=document.getElementById('bannerDowm').style.display;
		if(dd=="none"){
			document.getElementById('bannerDowm').style.display='block';
			}
	},20000);//界面加载二十秒后执行弹出。
</script>
<script type="text/javascript" >
function menuFixed(id){
	var obj = document.getElementById(id);
	if(obj==null){
		return;
	}
	var _getHeight = obj.offsetTop;

	window.onscroll = function(){
	changePos(id,_getHeight);
	}
}
function changePos(id,height){
var obj = document.getElementById(id);
if(obj==null){
		return;
	}
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
#musicControl {position:fixed;right:10px;top:15%;margin-top:0;display:inline-block;z-index:99999999}
#musicControl a {display:inline-block;width:52px;height:52px;overflow:hidden;background-image:url('/images/mcbg.png');background-repeat: no-repeat ;background-size:100%;}
#musicControl a.stop {background-position:left bottom;}
#musicControl a.on {background-position:0px 1px;-webkit-animation: reverseRotataZ 1.2s linear infinite;}
#music_play_filter{width:100%;height:100%;overflow:hidden;position:fixed;top:0;left:0;z-index:99999998;}
.quanjinga{position: absolute;right: 0;margin: 10px;font-size: 22px;}
#quanpingtime{color: red;font-size: 25px;}
.float_top{
	position: fixed;
	top: 0;
	left: 0;
	right: 0;
	width:100%;
	z-index: 100;
	background-color:#FFFF00
	-webkit-tap-highlight-color: rgba(0, 0, 0, 0);
	text-align: right;
	background-color: #FFFF00;
	padding: 4px 30px;
	border: 1px dashed #999999;
}




.meipian_meta {
position:fixed;
top:50px;
right:18px;
z-index:108;
 }
  .meipian_meta span {
    float: left;
    color: #8c8c8c;
    margin-right: 8px; }
  .meipian_meta .music {
    width: 42px;
    height: 42px;
    border-radius: 5px;
    margin: 10px 8px 0 0;
    padding: 0;
    line-height: 42px;
    cursor: pointer; }
    .meipian_meta .music i {
      float: left;
      width: 25px;
      height: 25px;
      background-size: contain;
      background-repeat: no-repeat;
      background-position: center;
      margin: 8px 10px 0 15px; }
      .meipian_meta .music i[play=on] {
        background-image: url("normalmusic.png");
		background-size: contain;
	background-repeat: no-repeat;
-moz-transform:rotate(90deg); 
-webkit-transform:rotate(90deg);
transform:rotate(90deg);
filter:progid:DXImageTransform.Microsoft.BasicImage(rotation=1);
		 }
      .meipian_meta .music i[play=stop] {
        background-image: url("normalmusic.png"); }
    .meipian_meta .music span {
      width: calc(100% - 70px);
      width: -webkit-calc(100% - 70px);
      margin: 0;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis; }



</style>

</head>
<body id="activity-detail" class="zh_CN " onScroll="move();"> 
 
<?php 

if($row['is_quanping']==1 && $rowad['quanping']!=''){
?>
<script type="text/javascript">
var daojs =3;
$(function(){
	setTimeout('daoJiShi()',1000); 
}); 
function daoJiShi(){
	if(daojs>0){　
		
		$('#quanpingtime').html(daojs);
		daojs--;
		setTimeout('daoJiShi()',1000); 
	}else{
		$('.quanping').css('display','none');
		$('#topad').css('display','block');
		$('#quanping2').css('display','block');
		move();
		$('#tanchudiv').html('');
	}
}
function tiaoguo(){
	$('.quanping').css('display','none');
	
}
</script>	
<div class="quanping" style="display:block; width:100%; margin-top: 25px;z-index:2147483650; ">
	<div class="quanjinga" style="padding:1px 10px; background-color:rgba(128,138,135,0.8);margin-top:50px;"><a href="javascript:void(0);" onClick="tiaoguo()">跳过</a>&nbsp;&nbsp;倒计时 <span id="quanpingtime">3</span> 秒</div>
	<div style="margin-top:-36px; min-height:100%; max-height:100%; overflow:hidden"  id="tanchudiv">
		<a href="<?php echo $rowad['ad_link2'];?>"><img src="<?php echo $rowad['quanping'];?>" style="width: 100%; height: 100%;" /></a>
	</div>
</div>
<div id="quanping2" style="display:none;" >
<?php }else{ ?>

<div id="quanping2" style="display:block;" >
<?php		 
	} 
?>

<?php 
//echo $row['userid'];exit;
if ($row['userid'] == $_COOKIE['username'] && $_COOKIE['userid']!='')
//echo '<div class="float_top" align="center"><a href="view_edit.php?fid='.$_GET['fid'].'"><font color="#FFF">修改编辑</font></a>&nbsp;&nbsp;&nbsp;&nbsp;</div>';
	echo '<div class="float_top" align="center">	<a href="'.$domain.'/edit.php" ><font color="#0033FF">①另选一篇</font></a>&nbsp;&nbsp;&nbsp;&nbsp;
		  	<a href="'.$domain.'/view_edit.php?fid='.$_GET['fid'].'" ><font color="#0033FF">②修改编辑</font></a>&nbsp;&nbsp;&nbsp;&nbsp;
		  </div><br>
	';
if($row['musicid']!=0){
	$sql = "select * from tbl_music where id = ".$row['musicid'];
	$query=mysql_query($sql);
	$rowmusic=mysql_fetch_array($query);
?>
<div class="meipian_meta" style="top:70px;">
	<span id="msplay" class="music" onClick="switchsound()">
		<i play="on" id="music_icon"></i>
		<span id="music_desc">清晨</span>
	</span>
	<script>
		var music_url = "<?php echo $rowmusic['path']; ?>";
	</script>
	<script src="music_autoplay.js"></script>
	<?php  
	if($row['autoplay']==1){
	?>
		<!--控制是否自动播放-->
	<script>
	if (audio == null)
	{
		audio = document.createElement('audio');
		audio.id = 'bgsound';
		audio.src = music_url;
		audio.loop = 'loop';
		audio.preload='auto';
		document.body.appendChild(audio);
	}
	if (audio.paused)
	{
		audio.play();
		icon.setAttribute("play","stop");
	}
	else if (new Date().getTime() > timestamp + 1000)
	{
	audio.pause();
	icon.setAttribute("play","on");
	}
	</script>
		<!--控制是否自动播放结束-->
<?php 
	}
?>
</div>

<?php } ?>

<div class="rich_media ">                
	<div class="rich_media_inner" style="margin-top:20px;">
		<h2 class="rich_media_title" id="activity-name"><?=$row['title']?></h2>
        <?php if($row['ifPublicNumber']==1){ ?>
			<div class="rich_media_meta_list">
				<em id="post-date" class="rich_media_meta rich_media_meta_text" style="font-size:18px;"><?=$row['addtime']?></em>
				<a class="rich_media_meta rich_media_meta_link rich_media_meta_nickname" href="<?=$gzhurl?>" id="post-user" style="font-size:18px;"><?=$gzhname?></a>
				<span class="rich_media_meta rich_media_meta_text rich_media_meta_nickname" style="font-size:18px;"><?=$gzhname?></span>
			</div>
			<br>
        <?php } ?> 
      
	  
	  
		<!---->
		<link rel="stylesheet" type="text/css" href="/css/liMarquee.css" media="all">		
		<script type="text/javascript" src="/js/jquery.liMarquee.js"></script>
		<?php if($row['ifweizhi']==0 ||$row['ifweizhi']==4  ){
					if($row['topad_type']==1){?>
						<script>
							$(window).load(function(){ 	$('.str1').liMarquee(); }); 
						</script> 
						<div class="dingpao" style="width: 100%; height: 72px; overflow: hidden; position: relative; z-index: 9999;">
							<img src="/images/zou_bg.jpg" style="width:100%;">
							<div class="str1 str_wrap" style="width:100%;position:absolute;left:0px;top:0px;height:72px;line-height:72px;vertical-align:middle;font-size:38px;font-weight:900;color:#fff;">
								<div class="str_move str_origin" style="left: -73.45px;">
									<?php echo $row['pmd_top'];  ?> 
								</div>
							</div>
						 </div>	  
				 
					<?php }else{?>
						<div style="display:block">
							<a href="ad.php?id=<?=$row['id']?>"><img src="<?=$rowad['ad_img']?>" style="width:100%;max-height:100px;" ></a>
							<?php echo $telnum;?>	
							<a href="javascript:;" class="am-icon-btn am-success am-margin-left-xs" style="width: 35px;height: 35px;padding-top: 5px;">
							<i class="am-icon-close" onClick="document.getElementById('topad').style.display='none'" data-gjalog="index_bottom_banner_close@atype=click"></i></a>
						</div>
					<?php }
			} ?> 

        <?php if( $row['ifweizhi']==4 && $rowad['quanping2']!=''){ ?>
         <div style="display:block">
         	<a href="<?=$rowad['ad_link3']?>"><img src="<?=$rowad['quanping2']?>" style="width:100%;max-height:100px;" ></a>
			 <?php echo $telnum;?>	
         	<a href="javascript:;" class="am-icon-btn am-success am-margin-left-xs" style="width: 35px;height: 35px;padding-top: 5px;">
         	<i class="am-icon-close" onClick="document.getElementById('topad').style.display='none'" data-gjalog="index_bottom_banner_close@atype=click"></i></a>
         </div>
		<?php }  ?> 
 
		<div id="page-content">
			<div id="img-content">
				<div class="rich_media_content" id="js_content">	
					<? 
					$html_content=str_replace('http://mmbiz','image_proxy2.php?1=1&siteid=1&url=http://mmbiz',$row['content']);
					$html_content=str_replace('https://mmbiz','image_proxy2.php?1=1&siteid=1&url=http://mmbiz',$html_content);
					echo $html_content;
					?>
					<br>
					<FONT face=黑体 color=grey size=1>本平台所收集的部分公开资料及文章来源于互联网，转载的目的在于传递更多信息及用于网络分享，并不代表本平台赞同其观点和对其真实性负责，也不构成任何其他建议。本平台部分作品是由网友自主分享发布、编辑整理上传，对此类作品本站仅提供交流平台，不为其版权负责。如果您发现平台上有侵犯您的知识产权的作品，请与我们取得联系，微信：联系开发者，我们会及时修改或删除。
					</FONT>
					<br>联系生意：<span style="text-align:center; margin-top:10px;"><img src="<?=$row['qrcode']?>" border="0"  width="100%"/></span>
				</div>
				<div class="rich_media_tool" id="js_toobar3"><?=$row['ywyuedu']?></div>
				<div style="text-align:center; margin-top:10px;"></div><!--公众号二维码-->
				 <div class="bdsharebuttonbox"><a href="#" class="bds_more" data-cmd="more">分享到：</a><a href="#" class="bds_qzone" data-cmd="qzone" title="分享到QQ空间">QQ空间</a><a href="#" class="bds_tsina" data-cmd="tsina" title="分享到新浪微博">新浪微博</a><a href="#" class="bds_tqq" data-cmd="tqq" title="分享到腾讯微博">腾讯微博</a><a href="#" class="bds_renren" data-cmd="renren" title="分享到人人网">人人网</a><a href="#" class="bds_weixin" data-cmd="weixin" title="分享到微信">微信</a><a href="#" class="bds_sqq" data-cmd="sqq" title="分享到QQ好友">QQ好友</a><a href="#" class="bds_tieba" data-cmd="tieba" title="分享到百度贴吧">百度贴吧</a><a href="#" class="bds_bdhome" data-cmd="bdhome" title="分享到百度新首页">百度新首页</a><a href="#" class="bds_ibaidu" data-cmd="ibaidu" title="分享到百度中心">百度中心</a><a href="#" class="bds_ty" data-cmd="ty" title="分享到天涯社区">天涯社区</a><a href="#" class="bds_meilishuo" data-cmd="meilishuo" title="分享到美丽说">美丽说</a><a href="#" class="bds_tqf" data-cmd="tqf" title="分享到腾讯朋友">腾讯朋友</a><a href="#" class="bds_huaban" data-cmd="huaban" title="分享到花瓣">花瓣</a><a href="#" class="bds_linkedin" data-cmd="linkedin" title="分享到linkedin">linkedin</a><a href="#" class="bds_mogujie" data-cmd="mogujie" title="分享到蘑菇街">蘑菇街</a><a href="#" class="bds_xinhua" data-cmd="xinhua" title="分享到新华微博">新华微博</a><a href="#" class="bds_people" data-cmd="people" title="分享到人民微博">人民微博</a><a href="#" class="bds_fbook" data-cmd="fbook" title="分享到Facebook">Facebook</a><a href="#" class="bds_wealink" data-cmd="wealink" title="分享到若邻网">若邻网</a><a href="#" class="bds_kaixin001" data-cmd="kaixin001" title="分享到开心网">开心网</a><a href="#" class="bds_douban" data-cmd="douban" title="分享到豆瓣网">豆瓣网</a><a href="#" class="bds_fx" data-cmd="fx" title="分享到飞信">飞信</a><a href="#" class="bds_iguba" data-cmd="iguba" title="分享到股吧">股吧</a><a href="#" class="bds_h163" data-cmd="h163" title="分享到网易热">网易热</a></div>
<script>window._bd_share_config={"common":{"bdSnsKey":{},"bdText":"","bdMini":"2","bdMiniList":["mshare","diandian","fx","qzone","tsina","bdysc","weixin","renren","tqq","bdxc","kaixin001","tqf","tieba","douban","bdhome","sqq","thx","ibaidu","meilishuo","mogujie","huaban","duitang","hx","youdao","sdo","qingbiji","people","xinhua","mail","isohu","yaolan","wealink","ty","iguba","fbook","twi","linkedin","h163","evernotecn","copy","print"],"bdPic":"","bdStyle":"0","bdSize":"16"},"share":{"bdSize":16},"image":{"viewList":["qzone","tsina","tqq","renren","weixin","sqq","tieba","bdhome","ibaidu","ty","meilishuo","tqf","huaban","linkedin","mogujie","xinhua","people","fbook","wealink","kaixin001","douban","fx","iguba","h163"],"viewText":"分享到：","viewSize":"16"},"selectShare":{"bdContainerClass":null,"bdSelectMiniList":["qzone","tsina","tqq","renren","weixin","sqq","tieba","bdhome","ibaidu","ty","meilishuo","tqf","huaban","linkedin","mogujie","xinhua","people","fbook","wealink","kaixin001","douban","fx","iguba","h163"]}};with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];</script> 
			</div>
            <div class="rich_media_tool" id="js_toobar3"><?=$row['ywyuedu']?></div>
		</div>
		
	</div>
</div>

</div>
<br>

<!-- 底部广告信息 -->
<?php
if($row['ifweizhi']==1 || $row['ifweizhi']==4){
?>
<?php if(is_numeric($row['adlink'])){   ?>
	<div class="app-guide1 adweix" id="bannerDowm" style="display:block">
		<div class="am-text-right">
		
			 <!--是否有电话微信-->
			 <?php 
		if($rowad['adtelnumber'] != ""){  ?>
		<a href="tel:<?=$rowad['adtelnumber']?>"  style="width: 35px;height: 35px;padding-top: 5px;"><img src="images/phone.png" style="width: 35px;height: 35px"/></a>
		<?php } ?>
		
		  <!--是否有qq-->
		 <?php  if(!empty($rowad['qq'])){ ?>
			<a href="http://wpa.qq.com/msgrd?v=3&amp;uin=<?=$rowad['qq']?>&amp;site=qq&amp;menu=yes&amp;kw=11;jh=sckc" class="am-margin-left" style="width: 35px;height: 35px;padding-top: 5px; margin-right:6px"><img src="images/qq.png" style="width: 35px;height: 35px"/></a>
	 <?php } ?>

		  
		  
		 <?php  if(!empty($rowad['erweima'])){ ?>
			<a href="javascript:void(0)" onClick="dakaiewm1();" class="am-margin-left-xs" style="width: 35px;height: 35px;padding-top: 5px;"><img src="images/wechat.png" style="width: 35px;height: 35px"/></a>
	 <?php } ?>
	 
	 <!--是否有电话微信-->
		<a href="javascript:;" class="am-margin-left-xs" style="width: 35px;height: 35px;padding-top: 5px;">
			<img src="images/close.png" style="width: 35px;height: 35px" onClick="document.getElementById('bannerDowm').style.display='none'" data-gjalog="index_bottom_banner_close@atype=click"/></a>

		</div>
		<a href="tel:<?=$rowad['ad_link']?>" ><img src="<?=$rowad['ad_img']?>" style="width:100%; max-height:150px;" ></a>
	</div>
	<?php }else{	?>
	<div class="app-guide1 adweix" id="bannerDowm" style="display:block;" >
		<div id="move" <?php if($row['is_quanping']==1 && $rowad['quanping']!=''){echo 'style="height:0px;overflow: hidden;"';}else{}?>>
			<div class="am-text-right">
			<!--是否有电话微信-->
				<?php  if($rowad['adtelnumber'] != ""){  ?>
					<a href="tel:<?=$rowad['adtelnumber']?>"  style="width: 35px;height: 35px;padding-top: 5px;"><img src="images/phone.png" style="width: 35px;height: 35px"/></a>
				<?php } ?>

				<!--是否有qq-->
				<?php  if(!empty($rowad['qq'])){ ?>
				<a href="http://wpa.qq.com/msgrd?v=3&amp;uin=<?=$rowad['qq']?>&amp;site=qq&amp;menu=yes&amp;kw=11;jh=sckc" class="am-margin-left" style="width: 35px;height: 35px;padding-top: 5px; margin-right:6px"><img src="images/qq.png" style="width: 35px;height: 35px"/></a>
				<?php } ?>
				 
			    <?php  if(!empty($rowad['erweima'])){ ?>
				<a href="javascript:void(0)" onClick="dakaiewm();" class="am-margin-left-xs" style="width: 35px;height: 35px;padding-top: 5px;"><img src="images/wechat.png" style="width: 35px;height: 35px"/></a>
				<?php } ?>
				<!--是否有电话微信-->
				<a href="javascript:;" class="am-margin-left-xs" style="width: 35px;height: 35px;padding-top: 5px;">
				<img src="images/close.png" style="width: 35px;height: 35px" onClick="document.getElementById('bannerDowm').style.display='none'" data-gjalog="index_bottom_banner_close@atype=click"/></a>

			</div> 
			
			<?php	if($row['footerad_type']==1){?>
				<script>
				$(function(){
					$('.str2').liMarquee();
				}); 
				</script> 
				<div class="dingpao" style="width: 100%; height: 72px; overflow: hidden; position: relative; z-index: 9999;">
					<img src="/images/zou_bg.jpg" style="width:100%;"> 
					<div class="str2" style="width:100%;position:absolute;left:0px;top:0px;height:72px;line-height:72px;vertical-align:middle;font-size:38px;font-weight:900;color:#fff;"> 
							<?php echo $row['pmd_footer'];  ?>  
					</div>
				</div>	  
         
			<?php }else{ ?> 
				<a href="ad.php?id=<?=$row['id']?>" ><img src="<?=$rowad['ad_img']?>" style="width:100%; max-height:100px;" ></a>
			<?php }?>
		</div>
	
	</div>
<?php 
}
?>
<?php
}
?> 

<style>
.detail_code {
position: fixed;
top: 20%;
left: 0;
right: 0;
width: 100%;
z-index: 100;
background-color: #dddddd -webkit-tap-highlight-color: rgba(0, 0, 0, 0);
text-align: center;
background-color: #dddddd;
padding: 4px 30px;
border: 1px #999999;

}
.close {
display: inline;
float: right;
width: 32px;
height: 22px;
background-color: #666;
}
.code {
margin: 40px auto 0;
width: 200px;
height: 200px;
}
 .desc {
padding-top: 12px;
color: #222;
font-size: 18px;
font-weight: bold;
}
</style>

<div class="detail_code" id="code_box" style="display:none" >

<div class="code">
<img src="<?=$rowad['erweima']?>" width="200"></div>
<div class="desc"><span>长按识别二维码</span></div>

<div class="desc"><span><a id="close_code"  href="javascript:void(0)" onClick="guanbiewm();">关闭</a></span></div>
</div>
<script type="text/javascript">
function dakaiewm(){

 document.getElementById("code_box").style.display="block";
}
function guanbiewm(){
 document.getElementById("code_box").style.display="none";
}

function dakaiewm1(){

 document.getElementById("code_box").style.display="block";
}
</script>



</body>
</html>
