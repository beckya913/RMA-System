<!DOCTYPE html>
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
	<title>RMA:::瀏覽申請表</title>
	<!-- install UIKit powered by Yootheme -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/uikit.css" />
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/custom.css" />
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/jquery-ui.css">
    <script src="<?php echo base_url(); ?>js/jquery.js"></script>
    <script src="<?php echo base_url(); ?>js/uikit.min.js"></script>
    <script src="<?php echo base_url(); ?>js/jquery-ui.js"></script>
    <script src="<?php echo base_url(); ?>js/jquery.dataTables.min.js"></script>
    <!-- Finish installation -->
    <script type="text/javascript">// Enable date picker
		 $(function() {
		    $( ".datepicker" ).datepicker({ dateFormat: 'yy-mm-dd' });
		  });	
	</script>
    <script type="text/javascript"> // Launch serch function

		$(document).ready(function(){

			$('#search').keyup(function(){
				searchTable($(this).val());
			});
		});

		function searchTable(inputVal){

			var table = $('#rma_list');

			table.find('tr').each(function(index, row){

				var allCells = $(row).find('td');
				if(allCells.length > 0){

					var found = false;
					allCells.each(function(index, td){

						var regExp = new RegExp(inputVal, 'i');
						if(regExp.test($(td).text())){
							found = true;
							return false;
						}
					});

					if(found == true)$(row).show();else $(row).hide();
				}
			});
		}
	</script>
	
</head>
<body>
	<?php include("header.php"); //表頭 ?>
    <div id="main" class="uk-grid">
    	<div class="uk-width-1-1">
    		<h1>瀏覽申請單</h1>
    			<table cellpadding="10" cellspacing="0" border="0" class="uk-float-right uk-width-1-1">
    				<tbody>
    					<tr>
    						<td class="uk-width-2-6">
    							<nav class="uk-navbar uk-float-left">
								    <ul class="uk-navbar-nav">
								      
								        <li><a href="<?php echo base_url(); ?>manage/overview">進行中</a></li>
								        <li><a href="<?php echo base_url(); ?>manage/overview_close">已結案</a></li>
								    </ul>
								</nav>
    						</td>
    						<td><h5>關鍵字搜尋</h5></td>
    						<td><form class="uk-form"><input class="uk-form-small" type="text" id="search"></form></td>
    						<td><h5>日期區間搜尋</h5></td>
    						<td>
    							<form id="date_serch" action="overview_filter" method="POST" class="uk-form">
								    <input type="text" class="datepicker uk-form-small" name="startdate" value=""/> 至
								    <input type="text" class="datepicker uk-form-small" name="enddate" value=""/>
								    <input type="submit" name="submit" value="確定" class="uk-button uk-button-primary" />
								</form>
    						</td>
    						<td><a class="uk-button uk-button-success" href="<?php echo base_url(); ?>manage/overview">重置</a></td>
    					</tr>
    				</tbody>
    			</table>
			<table class="uk-table uk-table-hover uk-table-striped" id="rma_list">
				<thead>
					<tr style="background-color: #03a5e5;">
						<th>RMA單號</th>
						<th>申請人</th>
						<th>客戶名稱</th>
						<th>需求日</th>
						<th>預估交期</th>
						<th>最新留言</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($results as $row){ ?>
					<?php //需求日在一週內，以紅字顯示
						$one_week = date('Y-m-d', strtotime( 'now +7 day' )); 
						$today = date('Y-m-d', strtotime('now')); //End ?>
					<tr>
						<td><?php echo $row->form_num; ?></td>
						<td><?php echo $row->applicant; ?></td>
						<td><?php echo $row->company; ?></td>
						<td><span style="<?php if ($row->demand_date >= $today && $row->demand_date <= $one_week) {
							echo 'color:#db4865;';} ?>"><?php echo $row->demand_date; ?></span></td>
						<td><?php echo $row->deliver_date; ?></td>
						<td>
							<?php 
								$query = $this->db->where('form_num =', $row->form_num)
												  ->order_by("time", "desc")
												  ->limit(1)
							                      ->get('rma_comment');
							    $result = $query->result();
							    foreach ($result as $row2) { ?>
							    	<?php echo $row2->message; ?> by <?php echo $row2->person; ?>
							   <?php }?>
						</td>
						<td>
							<a href="<?php echo site_url("manage/update/".$row->id); ?>" class="uk-button">細節</a>
						</td>
					</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
</body>
</html>