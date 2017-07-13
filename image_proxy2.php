<?php
/**
 * Created by IntelliJ IDEA.
 * User: Administrator
 * Date: 2016/7/1
 * Time: 13:45
 */

header("Content-type: image/jpeg");

function curlGetPic($url){
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_HEADER,false);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $temp=curl_exec($ch);
    return $temp;
}

$url=$_GET['url'];

$content=curlGetPic($url);

echo $content;

?>
