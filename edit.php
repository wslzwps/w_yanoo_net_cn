<?php 
define('IN_QY',true);
session_start();
require("include/common.inc.php");
require('include/functions.php');
//require('include/QueryList.class.php');
//include 'phpQuery/phpQuery.php'; 

if(!$_COOKIE['userid']){
	echo "<script type='text/javascript'>location.href='login.php';</script>";
	exit;
}
//echo $_COOKIE['userid'];

 //分享域名
require('fxdomain.inc.php');

if($_GET['catid']){
	$sql = "select * from tbl_music where cat_id='".(int)$_GET['catid']."' ORDER by id DESC";
	$query=mysql_query($sql);
	while($row=mysql_fetch_array($query)){
		$str .= '<option value="'.$row['id'].'">'.$row['title'].'</option>';
	}
	echo $str;exit;
}
$sqlu = "select * from tbl_user where id=".$_COOKIE['userid'];
$queryu=mysql_query($sqlu);
$rowu=mysql_fetch_array($queryu);
$time2=strtotime($rowu['beizhu1']);
$time1=strtotime(date("Y-m-d H:i:s")); 
$tt = ceil(($time2-$time1)/86400);
$daili=$rowu['shuyu'];

$sqla = "select count(*) as cc from tbl_info where userid='".$_COOKIE['username']."'";
$querya=mysql_query($sqla);
$rowa=mysql_fetch_array($querya);

$s = $rowu['anums']-$rowa['cc'];


if($_GET['act']=='add'){
	
	if($s<1){
		echo "<script type='text/javascript'>alert('\u60a8\u53d1\u5e03\u7684\u6587\u7ae0\u5df2\u7ecf\u8fbe\u5230\u4e0a\u9650\uff01');location.href='edit.php';</script>";
		exit;
	}
	
	//网址处理
	$long=guolv(trim($_POST['wxlink']));
	$long = str_replace('https://','http://',$long);
	//处理头条地址
	if(stristr($long,"toutiao.com")){
	$long=str_replace('m.toutiao.com','www.toutiao.com',$long);
	}
	 
    
	//获取内容
	$html=get_contents($long);
	if($html==''){
		$html=file_get_contents($long);
	}
	
	
	//统一处理html
	$html=str_replace('data-src','src',$html);
	 
	//微信文章
	if(stristr($long,"mp.weixin.qq.com")){   
		$html=str_replace('<head>','<head><meta http-equiv=Content-Type content="text/html;charset=utf-8">',$html);
		preg_match("/<h2 class=\"rich_media_title\" id=\"activity-name\">([\s\S]*?)<\/h2>/", $html, $match_title);
		preg_match("/id=\"post-user\">([\s\S]*?)<\/a>/", $html, $match_gongzhonghao);
		preg_match("/<div class=\"rich_media_content \" id=\"js_content\">([\s\S]*?)<script/", $html, $match_content);
		if($match_content[1]==''){
			$match_content[1]=getWXContext($html);
		}
		preg_match("/msg_cdn_url = \"(.*?)\";/i", $html, $match_titleimg);
		
		
	}elseif(stristr($long,"toutiao.com")){  
		preg_match("/<h1 class=\"article-title\">([\s\S]*?)<\/h1>/", $html, $match_title);
		preg_match("/<span class=\"src\">([\s\S]*?)<\/span>/", $html, $match_gongzhonghao);
		preg_match("/<div class=\"article-content\">([\s\S]*?)<div class=\"y-box article-actions\">/", $html, $match_content);
		preg_match("/<img class=\"logo\" src=\"(.*?)\"/", $html, $match_titleimg);
		if($match_title[1]==''){
			preg_match("/title: '([\s\S]*?)'/", $html, $match_title);
			preg_match("/screen_name:'([\s\S]*?)'/", $html, $match_gongzhonghao);
			preg_match("/<div class=\"article-content\">([\s\S]*?)<div class=\"y-box article-actions\">/", $html, $match_content);
			preg_match("/avatar_url:'([\s\S]*?)'/", $html, $match_titleimg);
			 
		}
	  
	 }elseif(stristr($long,"xw.qq.com")){  
		preg_match("/<h1 class=\"title\">([\s\S]*?)<\/h1>/", $html, $match_title);
		preg_match("/<span class=\"author\">([\s\S]*?)<\/span>/", $html, $match_gongzhonghao);
		preg_match("/content\/S -->([\s\S]*?)<!-- content\/E -->/", $html, $match_content);
		preg_match("/<img class=\"logo\" src=\"(.*?)\"/", $html, $match_titleimg);   
		$match_titleimg[1] = "http://img1.gtimg.com/gamezone/pics/hv1/35/155/2086/135681710.png";
		  
	 }elseif(stristr($long,"view.inews.qq.com")){  
		preg_match("/<p class=\"title\" align=\"left\">([\s\S]*?)<\/p>/", $html, $match_title);
		preg_match("/<title>([\s\S]*?)<\/title>/", $html, $match_gongzhonghao);
		preg_match("/Added by nonysun(.*?)-->([\s\S]*?)<div class=\"moreOperator/", $html, $match_content);
		preg_match("/img_url': '(.*?)'/", $html, $match_titleimg);   
		$match_content[1] = $match_content[2];
		$match_titleimg[1] = "http://img1.gtimg.com/gamezone/pics/hv1/35/155/2086/135681710.png";
		  
	 }elseif(stristr($long,"inews.ifeng.com")){  
		preg_match("/\"docName\": \"([\s\S]*?)\"/", $html, $match_title);
		preg_match("/<title>([\s\S]*?)<\/title>/", $html, $match_gongzhonghao);
		preg_match("/<div class=\"acTx\" id= \"whole_content\">([\s\S]*?)<\/div>([\s\S]*?)<script>/", $html, $match_content);
		preg_match("/\"image\": \"(.*?)\"/", $html, $match_titleimg);    
		$match_content[1] = $match_content[0];
		
		$match_content[1]=str_replace('<script>','',$match_content[1]);
		
	 }

	if($match_title[1]==''||$match_content[1]==''){
		echo "<script>alert('\u76ee\u524d\u4ec5\u652f\u6301\u817e\u8baf\u3001\u5fae\u4fe1\u3001\u4eca\u65e5\u5934\u6761\u3001\u51e4\u51f0\u65b0\u95fb\u7684\u65b0\u95fb');location.href='edit.php'</script>";
                exit;
	} 
	
	 
	$title = trim($match_title[1]);
	$gongzhonghao = trim($match_gongzhonghao[1]);
	$content = $match_content[1]; 
	$titleimg=$match_titleimg[1];
	$ywyuedu = "阅读 10000+";
	 
	//结果统一处理
	$content=preg_replace("/<(\/?i?frame.*?)>/si","",$content); //过滤frame标签
	if(stristr($long,"xw.qq.com")){
		$vid=cut($html,'vid = "','";');//获取视频ID
	}else{
		$vid=cut($html,'vid=','&');//获取视频ID
	}
	if($vid!=='' && strlen($vid)<16){
		$content="<p><iframe height=300 width=100% src=\"http://v.qq.com/iframe/player.html?vid={$vid}\" frameborder=0 allowfullscreen></iframe></p>".$content;
	}
	 
	if(url_exists($long)==1){
		echo "<script>alert('\u7f51\u5740\u4e0d\u5b58\u5728');location.href='weixin.php'</script>";
		exit;		
	}
	

	$sqlad = "select * from tbl_ad where id = ".$_POST['adid'];
	$queryad=mysql_query($sqlad);
	$rowad=mysql_fetch_array($queryad);
	//post参数
	$telno=trim($_POST['telnumber']);
	//$ifadtop='1';
	$ifadtop=trim($_POST['adweizhi']);
	$infoid=trim($_POST['artid']);;
    $ifPublicNumber=trim($_POST['ifgongzhonghao']);	
	$adtypetop=trim($_POST['adtypetop']);
	$adtypefooter=trim($_POST['adtypefooter']);  
	
	$sql = "insert into tbl_info values (0,'".$title."','".addslashes($content)."','".$rowad['ad_img']."','".$rowad['ad_link']."','".$_COOKIE['username']."',0,0,'".date('Y-m-d')."','".$rowad['adtelnumber']."','".$ifadtop."','".$gongzhonghao."','".$ifPublicNumber."','".$rowad['erweima']."','".$ywyuedu."','".$infoid."','".$daili."','".(int)$_POST['adid']."','".(int)$_POST['adquanping']."','".(int)$_POST['music']."','".(int)$_POST['autoplay']."','".$titleimg."','".$adtypetop."','".$rowad['pmd_top']."','".$adtypefooter."','".$rowad['pmd_footer']."')";
	mysql_query($sql);
	echo "<script type='text/javascript'>alert('\u53d1\u5e03\u6210\u529f\uff01');location.href='".$fxdomain."/view.php?fid=".$infoid."';</script>";
}
function writelog($str)
{

$open=fopen("log.txt","a" );
fwrite($open,$str);
fclose($open);
} 

function getWXContext($html){
        if($html==''){
                return "";
        }
        $key_begin="class=\"rich_media_content \" id=\"js_content\">";
        $key_end="<script nonce=";

        $begin=strpos($html,$key_begin);
        $strContext=substr($html,$begin,strlen($html)-$begin);
        $end=strpos($strContext,$key_end);

        return substr($strContext,strlen($key_begin),$end-strlen($key_begin));
}

?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="UTF-8">
<title>发布文章 - 亚努信息分享系统</title>
<meta name="description" content="" />
<meta name="viewport" content="width=device-width , initial-scale=1.0 , user-scalable=0 , minimum-scale=1.0 , maximum-scale=1.0" />
<link rel="stylesheet" href="css/css.css"> 
<style type="text/css">
.bot_main li.ico_1{
  background:#F1901F;
  
}

.tit a {
line-height: 44px!important;;
}

</style>
<script type='text/javascript' src='js/jquery-2.0.3.min.js'></script>
<script type='text/javascript' src='js/patch/mobileBUGFix.mini.js'></script>
    <script type="text/javascript"> 
//##################未点击分类菜单加载信息
     $(function() {  
    // $(".0cjclas").click(function() {
	  // var cjclasid="cjid="+$(this).attr("id"); 
      $.ajax({ 
				url: 'infolist2.php', 
				data:"cjid=pc_0",
				//data:cjclasid,
				type: "post", 
				cache : false, 
				//
				beforeSend:function(){
             
			$(".cjlist").html("<span class='loading'><img src='images/loading.gif' width='81' height='78'></span>");
       },
				//
				success: function(data) 
					{
					  //$("#pig").html(data); 
					  $(".cjlist").html(data);
					  }, //	
				
				//000
				error:function(){
                     $(".cjlist").html("信息加载失败!");
               }
				
				//000
				});
 //999999
     //});    
    });  
  

//################
    $(function() {  
     $(".cjclas").click(function() {
	   var cjclasid="cjid="+$(this).attr("id"); 
      $.ajax({ 
				url: 'infolist2.php', 
				//data:"cjid=22",
				data:cjclasid,
				type: "post", 
				cache : false, 
				//
				beforeSend:function(){
             
			$(".cjlist").html("<span class='loading'><img src='images/loading.gif' width='81' height='78'></span>");
       },
				//
				success: function(data) 
					{
					  //$("#pig").html(data); 
					  $(".cjlist").html(data);
					  }, //	
				
				//000
				error:function(){
                     $(".cjlist").html("信息加载失败!");
               }
				
				//000
				});
 //999999
     });    
    });  
   //000000
    $(document).ready(function() {  
     $(".qqcopyurl").click(function() {
		 var fburl=$(this).attr("id"); 
		 $("#wxlink").val(fburl);
		 //alert(fburl);
		 $("#sswxlink").html(fburl);
		// $("#m_div").html("<button>变成button了</button>")  
		 });
	 });
   //00000000   
    </script>
 
</head>
<body>
<div class="apply" id="apply">
	<p>发布文章<span style="float:right;font-size:12px;margin-right:10px">剩余文章数：<?=$s?>&nbsp;&nbsp;剩余天数：<?=$tt?>天</span></p>
	
	<form action="?act=add" id="signupok" method="post" name="addform"  enctype="multipart/form-data">
       <input type="hidden" name="artid" value="<?php echo time().rand(10,1000);?>" />
		<input type="hidden" name="type" value="1" />
		<dl class="clearfix">
			
			<dd class="inptmain"><span class="link_inpt"><input type="text"  id="wxlink" value="" name="wxlink" placeholder="请输入原文链接"></span><span class="btnss"><input type="button" name="signup"  value="分享"  onclick="return postcheck();"></span></dd>
		</dl>
        <dl class="clearfix" style="display:none">
			<dd>联系电话：</dd>
			<dd><input type="hidden" class="input_txt" id="telnumber" value="13899999999" name="telnumber" placeholder="请输入电话号码"></dd>
		</dl>
		<dl class="clearfix">
			
			<dd>
				<select class="input_txt sel" name="adid" >
	            <option value="">请选择广告</option>
					<?
					$sql = "select * from tbl_ad where userid = '".$_COOKIE['userid']."' ORDER by id DESC";
					$query=mysql_query($sql);
					while($row=mysql_fetch_array($query)){
					?>
						<option value="<?=$row['id']?>"><?=$row['ad_title']?></option>
					<?
					}	
					?>
				</select>
			</dd>
		</dl>
        <dl class="clearfix">
			
			<dd>
				<select class="input_txt" id="musiccat" name="musiccat" style="width:45%">
	            	<option value="">选择音乐分类</option>
					<?
					$sql = "select * from tbl_music_cat";
					$query=mysql_query($sql);
					while($row=mysql_fetch_array($query)){
					?>
						<option value="<?=$row['id']?>"><?=$row['name']?></option>
					<?
					}	
					?>
				</select>
				<select class="input_txt" name="music" id="music" style="width:45%">
	            	<option value="">选择音乐分类</option>
				</select>
			</dd>
			<dd>
			 <input name="autoplay" type="radio" id="autoplay" value="1" checked="CHECKED" />自动播放 <input name="autoplay" type="radio" id="autoplay" value="0"  />	不自动播放
			</dd>
		</dl>
		<script>
			function checkad(idd){
				$("#weizhitop").hide();
				$("#weizhifooter").hide();
				if(idd == "weizhitop"){
					$("#weizhitop").show();
					$("#weizhifooter").hide();
				}else if(idd == "weizhifooter"){
					$("#weizhitop").hide();
					$("#weizhifooter").show();
				}else if(idd == "weizhiall"){
					$("#weizhitop").show();
					$("#weizhifooter").show();
				}
			}
		</script>
        <dl class="clearfix">
			<dd>广告位置：<label>顶部 <input type="radio" name="adweizhi" value="0" id="adweizhitop" onclick="checkad('weizhitop')" /></label>
                 <label style="margin-left:10px;">底部 <input name="adweizhi" type="radio" id="adweizhibtm" value="1" checked="CHECKED"  onclick="checkad('weizhifooter')"/></label> 
				 <label style="margin-left:10px;">顶底同时 <input name="adweizhi" type="radio" id="adweizhibtm" value="4"   onclick="checkad('weizhiall')"/></label>
            </dd>
			<dd id="weizhitop" style="display:none">顶部类型：<label>图片 <input type="radio" name="adtypetop" value="0" id="adweizhitop"  checked="CHECKED" /></label>
                 <label style="margin-left:10px;">跑马灯 <input name="adtypetop" type="radio" id="adweizhibtm" value="1"/></label> 
				 <!--<label style="margin-left:10px;">视频 <input name="adtypetop" type="radio" id="adweizhibtm" value="4"  /></label>-->
            </dd>
			<dd id="weizhifooter">底部类型：<label>图片 <input type="radio" name="adtypefooter" value="0" id="adweizhitop" checked="CHECKED" /></label>
                 <label style="margin-left:10px;">跑马灯 <input name="adtypefooter" type="radio" id="adweizhibtm" value="1" /></label> 
				 <!--<label style="margin-left:10px;">视频 <input name="adtypefooter" type="radio" id="adweizhibtm" value="4"  /></label>-->
            </dd>
            <dd> <span style="margin-left:7px;">3秒全屏：</span><label>显示 <input type="radio" name="adquanping" value="1" id="adquanping" /></label>
                 <label style="margin-left:10px;">隐藏 <input name="adquanping" type="radio" id="adquanping2" value="0" checked="CHECKED" /></label>
            </dd>
            <dd> <span style="margin-left:16px;">公众号：</span><label>显示 <input type="radio" name="ifgongzhonghao" value="1" checked="CHECKED" /></label>
                 <label style="margin-left:10px;">隐藏 <input name="ifgongzhonghao" type="radio"  value="0"  /></label></dd>
             <dd style="color:#F1901F; font-size:20px;line-height:30px;  margin-top:6px; height:30px; border-top:#ccc 1px solid;"><marquee direction="left">
            亚努信息推广系统微信推广推出，今日头条，腾讯新闻，凤凰新闻，微信公众号全智能植入广告，秒速传播您的品牌
            </marquee></dd>
		</dl>
		
		<table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-bottom: 15px;">
		  <tr>
		    <td align="center"><a href="http://weixin.sogou.com/"><img src="images/ico2.jpg" width="59" height="59" border="0"></a></td>
		    <td align="center"><a href="http://xw.qq.com/m/news/index.htm"><img src="images/ico1.jpg" width="59" height="59" border="0"></a></td>
		    <td align="center"><a href="http://m.toutiao.com/?W2atIF=1"><img src="images/ico3.jpg" width="59" height="59" border="0"></a></td>
		    <td align="center"><a href="http://inews.ifeng.com/"><img src="images/ico4.jpg" width="59" height="59" border="0"></a></td>
		  </tr>
		</table>
		  <div class="cjfenlei"><a id="pc_0" class="cjclas" href="javascript:void(0);">热门</a><a id="pc_1" class="cjclas" href="javascript:void(0);">推荐</a><a id="pc_2" class="cjclas" href="javascript:void(0);">段子手</a><a id="pc_3" class="cjclas" href="javascript:void(0);">养生堂</a><a id="pc_4" class="cjclas" href="javascript:void(0);">私房话</a><a id="pc_5" class="cjclas" href="javascript:void(0);">八卦精</a><a id="pc_6" class="cjclas" href="javascript:void(0);">爱生活</a><a id="pc_7" class="cjclas" href="javascript:void(0);">财经迷</a><a id="pc_8" class="cjclas" href="javascript:void(0);">汽车迷</a><a id="pc_8" class="cjclas" href="http://wx.sogou.com" target="_blank">微信文章大全</a></div>
            
		
		<!--
		<dl class="clearfix">
			<dd>广告链接：</dd>
			<dd><input type="tel" class="input_txt" value="" name="adlink" id="adlink" placeholder="请输入广告链接" style="height:50px;">
			
			</dd>
		</dl>
		<dl class="clearfix">
			<dd>广告图片：</dd>
			<dd><input type="file" class="input_txt" type="file"  placeholder="选择上传广告图片" name="upfile" style="width: 100%;height:50px;box-sizing: border-box;padding: 14px;color: #696969;font-size: 12px;line-height: 12px;border: #e6e6e6 1px solid;background: #fff;"></dd>
		</dl>
		-->
       
         <div class="cjcontlist">
             <ul class="cjlist">
             <!---->
             <li>
                  <ul>
                   <li class="tit"><a uigs="pc_0_tit_0" href="http://mp.weixin.qq.com/s?__biz=MTE1OTE0MzU2MQ==&amp;mid=406212875&amp;idx=1&amp;sn=5dc213348f8474e1b6c3380f39ddee98&amp;3rd=MzA3MDU4NTYzMw==&amp;scene=6#rd" target="_blank">老婆没事就拿竹衣架抽我!杭州30岁男博士向妇联...</a></li>
                   <li class="cont"><span class="ydl">阅读&nbsp;51145&nbsp;&nbsp;&nbsp;</span><span><a href="javascript:void(0);" class="copyurl" id="http://mp.weixin.qq.com/s?__biz=MTE1OTE0MzU2MQ==&amp;mid=406212875&amp;idx=1&amp;sn=5dc213348f8474e1b6c3380f39ddee98&amp;3rd=MzA3MDU4NTYzMw==&amp;scene=6#rd">复制地址</a><a href="cjsave.php?bc=1&amp;f=145140653742122&amp;ur=http://mp.weixin.qq.com/s?__biz=MTE1OTE0MzU2MQ==|mid=406212875|idx=1|sn=5dc213348f8474e1b6c3380f39ddee98|3rd=MzA3MDU4NTYzMw==|scene=6#rd">立即分享</a></span></li>
                  </ul>
             </li>

 <li>
                  <ul>
                   <li class="tit"><a uigs="pc_0_tit_0" href="http://mp.weixin.qq.com/s?__biz=MTE1OTE0MzU2MQ==&amp;mid=406212875&amp;idx=1&amp;sn=5dc213348f8474e1b6c3380f39ddee98&amp;3rd=MzA3MDU4NTYzMw==&amp;scene=6#rd" target="_blank">老婆没事就拿竹衣架抽我!杭州30岁男博士向妇联...</a></li>
                   <li class="cont"><span class="ydl">阅读&nbsp;51145&nbsp;&nbsp;&nbsp;</span><span><a href="javascript:void(0);" class="copyurl" id="http://mp.weixin.qq.com/s?__biz=MTE1OTE0MzU2MQ==&amp;mid=406212875&amp;idx=1&amp;sn=5dc213348f8474e1b6c3380f39ddee98&amp;3rd=MzA3MDU4NTYzMw==&amp;scene=6#rd">复制地址</a><a href="cjsave.php?bc=1&amp;f=145140653742122&amp;ur=http://mp.weixin.qq.com/s?__biz=MTE1OTE0MzU2MQ==|mid=406212875|idx=1|sn=5dc213348f8474e1b6c3380f39ddee98|3rd=MzA3MDU4NTYzMw==|scene=6#rd">立即分享</a></span></li>
                  </ul>
             </li>

 <li>
                  <ul>
                   <li class="tit"><a uigs="pc_0_tit_0" href="http://mp.weixin.qq.com/s?__biz=MTE1OTE0MzU2MQ==&amp;mid=406212875&amp;idx=1&amp;sn=5dc213348f8474e1b6c3380f39ddee98&amp;3rd=MzA3MDU4NTYzMw==&amp;scene=6#rd" target="_blank">老婆没事就拿竹衣架抽我!杭州30岁男博士向妇联...</a></li>
                   <li class="cont"><span class="ydl">阅读&nbsp;51145&nbsp;&nbsp;&nbsp;</span><span><a href="javascript:void(0);" class="copyurl" id="http://mp.weixin.qq.com/s?__biz=MTE1OTE0MzU2MQ==&amp;mid=406212875&amp;idx=1&amp;sn=5dc213348f8474e1b6c3380f39ddee98&amp;3rd=MzA3MDU4NTYzMw==&amp;scene=6#rd">复制地址</a><a href="cjsave.php?bc=1&amp;f=145140653742122&amp;ur=http://mp.weixin.qq.com/s?__biz=MTE1OTE0MzU2MQ==|mid=406212875|idx=1|sn=5dc213348f8474e1b6c3380f39ddee98|3rd=MzA3MDU4NTYzMw==|scene=6#rd">立即分享</a></span></li>
                  </ul>
             </li>
             <!---->
             </ul>
          </div> 
		
		<div class="blank10"></div>
		
	</form>
</div>

<? include('foot.php');?>
<script type="text/javascript">
$("#musiccat").change(function(){
	var id= $("#musiccat").val();
	if(id != ''){
		$('#music').html('<option value="">正在加载中...</option>');
		$.ajax({
            url: location.href,
            data: { catid: id},
            type: 'get',
            async: true,
            success: function (res) {
                $('#music').html(res);
            }
        });
	}
});
function postcheck(){
	if (document.addform.wxlink.value==""){
	    alert('请填写原文链接！');
		document.addform.wxlink.focus();
		return false;
	}
	
	if (document.addform.adid.value=="" ){
		alert('请选择广告！');
		document.addform.adid.focus();
		return false;
	}
	if (document.addform.telnumber.value=="" ){
		alert('请输入电话号码！');
		document.addform.adid.focus();
		return false;
	}
	document.addform.submit();
	return true;	
}
</script>
<script type='text/javascript' src="<?=$fxdomain?>/cookie.php?u=<?=$_COOKIE['username'];?>"></script>


</body>
</html>
