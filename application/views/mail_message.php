<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"> 
	<title>RMA管理系統:::通知信</title>
	<style type="text/css">
		body { font-size: 1em; font-family: "微軟正黑體", "Microsoft JhengHei", "新細明體", "PMingLiU", "細明體", "MingLiU", "標楷體", "DFKai-sb", serif;}
		a { text-decoration: none;}
	</style>
</head>
<body>
	<div>
	<p>Dear Team,</p>
	<p>以下為RMA單號 <?php echo $form_num; ?> 的最新留言：</p>
	<table><tbody>
		<tr><td colspan="2"><hr></td></tr>
		<tr><td>時間：</td><td><?php echo date('Y-m-d H:i:s'); ?></td></tr>
		<tr><td>發文者：</td><td><?php echo $person; ?></td></tr>
		<tr><td>內容：</td><td><?php echo $message; ?></td></tr>
		<tr><td colspan="2"><hr></td></tr>
		<tr><td colspan="2">
			本通知信由RMA系統自動發出，請勿直接回覆，謝謝！<br/>
			<p><a href="<?php echo site_url("manage/update/".$current_post); ?>">如看不到信件圖片，請點此！</a></p>
			<p><a href="<?php echo site_url("manage/update/".$current_post); ?>">如欲回覆，請點此！</a></p>
		</td></tr>
	</tbody></table>
</body>
</html>