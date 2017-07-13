<?php

define('IN_QY',true);

require("include/common.inc.php");


$query=mysql_query("SELECT * FROM tbl_weixin WHERE id=1");
$rowweixin=mysql_fetch_array($query);


$APPID=$rowweixin['APPID'];
$APPSECRET=$rowweixin['APPSECRET'];
var_dump($APPID);


