<?php
define('IN_QY',true);
require("include/common.inc.php");
require('include/functions.php');
$long='https://mp.weixin.qq.com/s?src=3&timestamp=1499746076&ver=1&signature=DqVMIt*U*vxoPMuYVV-PVk0j4kD2wocMs-1*E6bZ25lx4PndMDWk8ENjb9v*BgHJO3WH83REdfmuHtTUb7hOD-Zyse9A0IBvypySsHtBY8O2goJ9RajVepclzCBHWCL8hjWo9HajfQfN1szzCTH8XdBv0jF4evEoLbGxmpD8cYw=';

$long = str_replace('https://','http://',$long);
$html=get_contents($long);
if($html==''){
	
	$html=file_get_contents($long);
}

echo getWXContext($html);

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
