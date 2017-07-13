<script>
 $(document).ready(function() {  
     $(".copyurl").click(function() {
		 var fburl=$(this).attr("id"); 
		//alert(fburl);
		 //$("#wxlink").html(fburl);
		 $("#wxlink").val(fburl);
$("html,body").animate({scrollTop:$("#wxlink").offset().top},1000);
		 });
	 }); 
    </script>
	
		
		<script>
    $(function() {
        var pattern = /^http:\/\/mmbiz/;
        var prefix = 'http://img01.store.sogou.com/net/a/04/link?appid=100520029&url=';
        $(".img").each(function(){
            var src = $(this).attr('src');
            if(pattern.test(src)){
                var newsrc = prefix+src;
                $(this).attr('src',newsrc);
            }
			//$('#js_content').autoIMG();
        });
    });
</script>
<script type="text/javascript" src="js/jquery-1.0.1.min.js" ></script>
	
<?php
error_reporting(0); 
header("content-Type: text/html; charset=Utf-8");
set_time_limit(60);
$cjid=$_POST['cjid'];
$cjurl="http://weixin.sogou.com/pcindex/pc/".$cjid."/".$cjid.".html";//要采集地址
$html=get_contents($cjurl);
 //writelog($html);
 
preg_match_all('/<h3><a uigs=".*?" href="([\s\S]*?)" target="_blank">([\s\S]*?)<\/a><\/h3>/is', $html, $arrone);
preg_match_all('/<span id="sg_readNum3">([\s\S]*?)<\/span>/is', $html, $yuedu);
preg_match_all('/<a class="account".*?href="([\s\S]*?)".*?>([\s\S]*?)<\/a>/is', $html, $wcate);
preg_match_all('/<img src="(.*?)" onload="resizeImage/is', $html, $aimg);
 
$cjtitle = "";
for ($x=0; $x<=count($arrone[1])-1; $x++) {
	//echo $arrone[1][$x];
    //echo $arrone[2][$x];
	$tHref=$arrone[1][$x];//链接
	$ttitle = $arrone[2][$x]; //标题
	$ydmatch = $yuedu[1][$x];//阅读量
	$ywcatehref = $wcate[1][$x];// 
	$ywcate = $wcate[2][$x];// 
	$img = $aimg[1][$x];//阅读量
	$img = preg_replace("/http:\/\/img(.*?)url=/is", "image_proxy2.php?1=1&siteid=1&url=", $img);  
	//$gtHref = str_replace('&amp;',"|",$tHref);
	$gtHref=str_replace(array("&amp;","#"),array("|",".."),$tHref);
 // $cjtitle=$cjtitle."<li>".$cont.$tHref."</li>";  
 $cjtitle=$cjtitle."<li><ul><li style='width:80px;height:65px;float:left;margin-right:10px;'><a href='".$gtHref."' target='_blank'><img style='wdith:80px;height:65px;' src='".$img."' /></a></li><li class='tit'><a href='".$gtHref."' target='_blank'>".$ttitle."</a></li>";
 $cjtitle=$cjtitle."<li class='cont'><span class='ydl'><a href='".$ywcatehref."' target='_blank' style='background:none;color:#000;'>公众号：".$ywcate."</a></span><span><a href='javascript:void(0);' class='copyurl' id=".$tHref.">复制地址</a><a href='cjsave.php?xz=1&ad=".time().rand(10,100)."22&ur=".$gtHref."'>立即分享</a></span></li></ul></li>";   

} 
 
 
echo $cjtitle;
function writelog($str)
{

$open=fopen("log.txt","a" );
fwrite($open,$str);
fclose($open);
} 
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