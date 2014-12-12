<div id="top">
	<table width="100%" border="0" cellpadding="0" cellspacing="0">
		<tbody>
			<tr>
				<td><a href="<?php echo base_url(); ?>manage/dashboard"><img src="<?php echo base_url(); ?>images/logo-tw_black.png" width="250" height="48" /></a></td>
				<td><h1>RMA申請系統</h1></td>
			</tr>
		</tbody>
	</table>
</div>
<nav class="uk-navbar">
			    <ul class="uk-navbar-nav">
			        <li class="uk-active"><a href="<?php echo base_url(); ?>manage/create">新增</a></li>
			        <li><a href="<?php echo base_url(); ?>manage/overview">瀏覽</a></li>
			        <li><a href="<?php echo base_url(); ?>manage/display_cal">日曆</a></li>
			        <li class="uk-parent"><a href="<?php echo base_url(); ?>authorize/logout">登出</a></li>
			    </ul>
			    <div class="uk-navbar-flip">
			        <ul class="uk-navbar-nav">
			            <li><a href="">登入帳號： <?php echo $_SESSION['username']; ?></a></li>
			        </ul>
			    </div>
			</nav>