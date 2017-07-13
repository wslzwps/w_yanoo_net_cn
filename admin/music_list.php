<?
header('Content-Type:text/html; charset=utf-8');
define('IN_QY',true);
require('../include/common.inc.php');
define('SCRIPT','userlist');
require("check.php");
session_start();
if($_GET["act"]=="del")
{
	 $sql="delete from tbl_music  where id=".$_GET['id'];
	 mysql_query($sql);
	 mysql_close();
	 echo "<script type='text/javascript'>alert('成功删除!');location.href='music_list.php';</script>";
	 exit;
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>鸿林微盟</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery.js"></script>

<script language="javascript">
$(function(){	
	//导航切换
	$(".imglist li").click(function(){
		$(".imglist li.selected").removeClass("selected")
		$(this).addClass("selected");
	})	
})	
</script>
<script type="text/javascript">
$(document).ready(function(){
  $(".click").click(function(){
  $(".tip").fadeIn(200);
  });
  
  $(".tiptop a").click(function(){
  $(".tip").fadeOut(200);
});

  $(".sure").click(function(){
  $(".tip").fadeOut(100);
});

  $(".cancel").click(function(){
  $(".tip").fadeOut(100);
});

});
</script>
</head>
<body>

	<div class="place">
    <span>位置：</span>
    <ul class="placeul">
    <li><a href="index.html">首页</a></li>
    <li><a href="#">音乐列表</a></li>
    </ul>
    </div>
    
    <div class="rightinfo">
    <div class="tools">
    	<ul class="toolbar">
        <li class="click"><a href="music_add.php"><span><img src="images/t01.png" /></span>添加音乐</a></li>
		
        </ul>

    </div>

    <table class="imgtable">
    <thead>
    <tr>
    <th>ID</th>
    <th>歌名</th>
    <th>分类</th>
    <th>操作</th>
    </tr>
    </thead>
    
    <tbody>
    <?
	$page_sql = "select * from tbl_music";
	
	qy_page($page_sql,20);
	$sql = "select tm.*,tmc.name from tbl_music tm left outer join tbl_music_cat tmc on tmc.id = tm.cat_id ORDER by id DESC LIMIT $_pagenum,$_pagesize";

	$query=mysql_query($sql);
	while($row=mysql_fetch_array($query)){
	?>
	    <tr height="35px">
	    	<td><?=$row['id']?></td>
			<td><?=$row['title']?></td>
			<td><?=$row['name']?></td>
			<td><a href="music_list.php?id=<?=$row['id']?>&act=del" onclick="if (confirm('确定要删除吗？')) return true; else return false;" class="tablelink"> 删除</a></td>
	    </tr>
    <?
	}
	?>    
    </tbody>
    
    </table>
    
    <div class="pagin">
    	<?=qy_paginga()?>
    </div>
</div>
<script type="text/javascript">
	$('.imgtable tbody tr:odd').addClass('odd');
</script>
</body>
</html>
