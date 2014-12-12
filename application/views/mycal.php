<?php 
	
if(!isset($_SESSION)) {

session_start();

}  

if(!isset($_SESSION['username'])){

echo "<html><head><meta charset='utf-8'></head><body><script type='text/javascript'>
		alert('請先登入，謝謝。');
	  </script></body></html>";

redirect('authorize/login/','refresh');

}

?>
<html>
<head>
	<meta charset="utf-8">
	<title>RMA申請系統 ::: 日曆</title>
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/uikit.css" />
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/custom.css" />
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/jquery-ui.css">
    <script src="<?php echo base_url(); ?>js/jquery.js"></script>
    <script src="<?php echo base_url(); ?>js/uikit.min.js"></script>
    <!-- Finish installation -->
    <script src="<?php echo base_url(); ?>js/jquery-ui.js"></script>
    <style type="text/css">
    	#cal { width: 800px; margin-right: auto; margin-left: auto; margin-top: 50px; margin-bottom: 10px;}
    	#cal table { border-collapse: collapse; font-size: 0.8em; }
		#cal table td {border: 1px solid black;}
		#cal td { width: 100px; height: 80px; vertical-align: top; padding: 5px;}
		#cal td:hover { background-color: #dff0ff;}
		#cal .row_start { height: 30px; font-size: 1.2em;}
		#cal .highlight { background-color: #ffd940;}
    </style>
</head>
<body>
	<?php include("header.php"); //表頭 ?>

	<div id="cal">
		<center><h1>客戶需求日</h1></center>
		<?php echo $calendar; ?>
	</div>
</body>
</html>