<?php



 $sqld="select * from tbl_site  where id=1";
$queryd=mysql_query($sqld);
$rowd=mysql_fetch_array($queryd);
$fxdomains=explode("|",$rowd['fxdomain']);
$suijishu=mt_rand(0,count($fxdomains)-1);
if(!empty($fxdomains[$suijishu])){
$fxdomain='http://'.$fxdomains[$suijishu];
}
$domain='http://'.$rowd['domain'];


