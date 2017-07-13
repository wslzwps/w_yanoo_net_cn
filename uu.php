<?php
error_reporting(0);
define('IN_QY',true);
session_start();
require("include/common.inc.php");

$id=$argv[1];
if($id){
	
	while(1){
			$rtime=rand(5,20);
			
			$sql="update tbl_info set acount=acount+1 where id=".$id;
			mysql_query($sql);
			
			sleep($rtime);
			
	}
}else{
	echo "<script type='text/javascript'>alert('\u5e7f\u544a\u4e0d\u5b58\u5728\uff01');history.go(-1);</script>";
	exit;
}

?>
