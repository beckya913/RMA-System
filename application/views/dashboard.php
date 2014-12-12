<!DOCTYPE html>
<?php

if(!isset($_SESSION)) 
{ 
session_start(); 
}  

if(!isset($_SESSION['username'])){
header("location:authorize/login");
}
?>
<html>
<head>
	<meta charset="utf-8">
	<title>RMA申請系統 ::: 首頁</title>
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/uikit.css" />
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/custom.css" />
    <script src="<?php echo base_url(); ?>js/jquery.js"></script>
    <script src="<?php echo base_url(); ?>js/uikit.min.js"></script>
</head>
<body>
	<?php include("header.php"); //表頭 ?>
	 <div id="main" class="uk-grid">
    	<div class="uk-width-1-1">
			<br><br>
			<center><table id="dashboard" class="uk-table" style="width:600px;">
				<tbody>
					<tr>
						<td><a href="<?php echo base_url(); ?>manage/overview" ><img src="<?php echo base_url(); ?>images/icon_browse.png"></a></td>
						<td><a href="<?php echo base_url(); ?>manage/create"><img src="<?php echo base_url(); ?>images/icon_create.png"></a></td>
						<td><a href="<?php echo base_url(); ?>manage/display_cal"><img src="<?php echo base_url(); ?>images/icon_calendar.png"></a></td>
						<td><a href="<?php echo base_url(); ?>authorize/logout"><img src="<?php echo base_url(); ?>images/icon_logout.png"></a></td>
					</tr>
					<tr>
						<td><a href="<?php echo base_url(); ?>manage/overview" >瀏覽申請表</a></td>
						<td><a href="<?php echo base_url(); ?>manage/create">新增申請表</a></td>
						<td><a href="<?php echo base_url(); ?>manage/display_cal">日曆</a></td>
						<td><a href="<?php echo base_url(); ?>manage/logout">登出</a></td>
					</tr>
				</tbody>
			</table></center>
		</div>
	</div>	
</body>
</html>