<script>
 $(document).ready(function() {  
     $(".copyurl").click(function() {
		 var fburl=$(this).attr("id"); 
		 //alert(fburl);
		 //$("#wxlink").html(fburl);
		 $("#wxlink").val(fburl);
		 });
	 }); 
    </script>
<?php
error_reporting(0); 
header("content-Type: text/html; charset=Utf-8");
set_time_limit(60);
$cjid=$_POST['cjid'];
$cjurl="http://weixin.sogou.com/pcindex/pc/".$cjid."/".$cjid.".html";//要采集地址
$html=get_contents($cjurl);

 
preg_match_all('/<h3><a uigs=".*?" href="([\s\S]*?)" target="_blank">([\s\S]*?)<\/a><\/h3>/is', $html, $arrone);
preg_match_all('/<span class="s1">([\s\S]*?)<\/span>/is', $html, $yuedu);
 
 
$cjtitle = "";
for ($x=0; $x<=count($arrone[1])-1; $x++) {
	//echo $arrone[1][$x];
    //echo $arrone[2][$x];
	$tHref=$arrone[1][$x];//链接
	$ttitle = $arrone[2][$x]; //标题
	$ydmatch = $yuedu[1][$x];//阅读量
	//$gtHref = str_replace('&amp;',"|",$tHref);
	$gtHref=str_replace(array("&amp;","#"),array("|",".."),$tHref);
 // $cjtitle=$cjtitle."<li>".$cont.$tHref."</li>";  
 $cjtitle=$cjtitle."<li><ul><li class='tit'><a href='".$gtHref."' target='_blank'>".$ttitle."</a></li>";
 $cjtitle=$cjtitle."<li class='cont'><span class='ydl'>阅读".$ydmatch."</span><span><a href='javascript:void(0);' class='copyurl' id=".$tHref.">复制地址</a><a href='cjsave.php?xz=1&ad=".time().rand(10,100)."22&ur=".$gtHref."'>立即分享</a></span></li></ul></li>";   

} 
 

echo $cjtitle;

function get_contents($url)
{
	if (function_exists('curl_init')) {
		$ch = curl_init();
		$timeout = 100;
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
		curl_setopt($ch, CURLOPT_TIMEOUT, 2);
		$file_contents = curl_exec($ch);
		curl_close($ch);
	} else {
		$file_contents = file_get_contents($url);
	}
	return $file_contents;
}

exit;
 
//echo $imglist;
//
?>