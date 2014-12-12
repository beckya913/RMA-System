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
	<p>RMA單號 <?php echo $form_num; ?> 已建立。</p>
	<table><tbody>
		<tr><td colspan="2"><hr></td></tr>
		<tr><td>時間：</td><td><?php echo date('Y-m-d H:i:s'); ?></td></tr>
		<tr><td>發文者：</td><td><?php echo $applicant; ?></td></tr>
		<tr><td>客戶：</td><td><?php echo $company; ?></td></tr>
		<tr><td>聯絡窗口：</td><td><?php echo $contact_winodw; ?></td></tr>
		<tr><td colspan="2"><a href="<?php echo site_url('manage/overview/'); ?>">詳細內容請登入RMA系統查看</a></td></tr>
		<tr><td colspan="2"><hr></td></tr>
		<tr><td colspan="2">本通知信由RMA系統自動發出，請勿直接回覆，謝謝！</td></tr>
	</tbody></table>
</body>
</html>