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
<?php 
	$query = $this->db->get_where('rma_user', array('username'=>$_SESSION['username']));
	foreach ($query->result() as $row3){ 
	$name= $row3->name;
	$level= $row3->level;
} ?>
<html>
<head>
	<title>RMA:::更新申請表</title>
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/uikit.css" />
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/custom.css" />
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/jquery-ui.css">
    <script src="<?php echo base_url(); ?>js/jquery.js"></script>
    <script src="<?php echo base_url(); ?>js/uikit.min.js"></script>
    <script src="<?php echo base_url(); ?>js/jquery-ui.js"></script>
    <script src="<?php echo base_url(); ?>js/tinymce/tinymce.min.js"></script>
    <script type="text/javascript"> // Prevent press Enter to submit the form
    	$(document).on("keypress", 'form', function (e) {
		    var code = e.keyCode || e.which;
		    console.log(code);
		    if (code == 13) {
		        console.log('Inside');
		        e.preventDefault();
		        return false;
		    }
		});
    </script>

	<script type="text/javascript">// Enable date picker
		 $(function() {
		    $( ".datepicker" ).datepicker({ dateFormat: 'yy-mm-dd' });
		  });	
	</script>
	<script type="text/javascript"> // Enable Tinymce
		tinymce.init({
		    selector: "textarea",
		    language : 'zh_TW',
		    plugins: [
			    "advlist autolink lists link image autoresize",
			    "insertdatetime media table contextmenu paste jbimages"
			  ],
  			toolbar: "insertfile undo redo | bold italic | alignleft aligncenter alignright | bullist numlist | link image jbimages",
  			relative_urls: false
		 });
	</script>

	<script type="text/javascript"> // 如果權限不足，最新消息設唯讀。
	$(document).ready(function(){
		var permission = <?php echo json_encode($level); ?>;
		if (permission == '2') {
		$('#form_update input').prop('readonly', true);
		$('#btn_update').hide();
		 }; 
	});
	
	</script>
</head>
<body>
	<?php include("header.php"); //表頭 ?>
    <div id="main" class="uk-grid">
    	<div class="uk-width-1-1">
    		<h1>更新申請單</h1>
    		<?php foreach($results_all as $row){
			
			$id= $row->id;
			$submit_date= $row->submit_date;
			$applicant= $row->applicant;
			$form_num= $row->form_num;
			$contact_winodw= $row->contact_winodw;
			$email= $row->email;
			$company= $row->company;
			$factory= $row->factory;
			$area= $row->area;
			$remark= nl2br($row->remark);
			$attachment= $row->attachment;
			$demand_date= $row->demand_date;
			$release_num= $row->release_num;
			$git_po_num= $row->git_po_num;
			$git_material_num= $row->git_material_num;
			$git_station_type= $row->git_station_type;
			$customer_po_num= $row->customer_po_num;
			$vendor_ram= $row->vendor_ram;
			$deliver_date= $row->deliver_date;
			$quotation_num= $row->quotation_num;
			$receive_date= $row->receive_date;
			$engineer= $row->engineer;
			$install_date= $row->install_date;
			$status= $row->status;
	
		} ?>

			<?php
		$attributes = array('class' => 'uk-form', 'id' => 'form_update');
		echo form_open('manage/action_update', $attributes);  ?>
				<!--後續追蹤，由特定人員維護 -->
				<fieldset data-uk-margin>
					<legend><?php echo $form_num; ?> 最新訊息</legend>
					<table class="uk-table" border="1" id="update_table">
						<tbody>
							<tr>
								<td class="uk-width-1-6">客戶需求日</td>
								<td class="uk-width-2-6"><?php 
								$data = array( 'name' => 'demand_date','value' => $demand_date,'class' => 'datepicker','id' => 'datepicker');
							
								echo form_input($data);?></td>
								<td class="uk-width-1-6">客戶放行單號</td>
								<td class="uk-width-2-6"><?php echo form_input('release_num', $release_num); ?></td>
							</tr>
							<tr>
								<td>GIT訂單號碼</td>
								<td><?php echo form_input('git_po_num', $git_po_num); ?></td>
								<td>GIT產品型號</td>
								<td><?php echo form_input('git_material_num', $git_material_num); ?></td>
							</tr>
							<tr>
								<td>GIT機台型號</td>
								<td><?php echo form_input('git_station_type', $git_station_type); ?></td>
								<td>客戶訂單號碼</td>
								<td><?php echo form_input('customer_po_num', $customer_po_num); ?></td>
							</tr>
							<tr>
								<td>廠商 RMA#</td>
								<td><?php echo form_input('vendor_ram', $vendor_ram); ?></td>
								<td>預估交期</td>
								<td><?php 
								$data = array( 'name' => 'deliver_date','value' => $deliver_date,'class' => 'datepicker',);
								echo form_input($data); ?></td>
							</tr>
							<tr>
								<td>報價單號</td>
								<td><?php echo form_input('quotation_num', $quotation_num); ?></td>
								<td colspan="2">客戶收到日期 <?php 
								$data = array( 'name' => 'receive_date','value' => $receive_date,'class' => 'datepicker',);
								echo form_input($data); ?> / 
									已安裝：工程師 <?php echo form_input('engineer', $engineer); ?> on <?php 
								$data = array( 'name' => 'install_date','value' => $install_date,'class' => 'datepicker',);
								echo form_input($data); ?></td>
								
							</tr>
							<tr>
								<td>專案狀態</td>
								<td>
									<ul class="uk-list" id="status">
										<li class="uk-float-left"><input type="radio" name="status" value="open" <?php if ($status == "open") echo "checked=\"checked\""; ?>/>
											進行中</li>
    									<li class="uk-float-left"><input type="radio" name="status" value="close" <?php if ($status == "close") echo "checked=\"checked\""; ?>/>
											結案</li>
    									<li class="uk-float-left"><input type="radio" name="status" value="open"; />
											重啟</li>
									</ul>
    							</td>
								<td colspan="2">
									<?php $btn= array('type'=> 'submit', 'name' => 'submit', 'class' => 'uk-button', 'value' => '更新資料','id' => 'btn_update',);
		echo form_submit($btn); ?></td>
							</tr>
						</tbody>
					</table>
				</fieldset>
				<!-- 基本資料 -->
				<fieldset data-uk-margin>
					<legend><?php echo $form_num; ?> 基本資料</legend>
					<table class="uk-table" border="1">
						<tbody>
							<tr>
								<td class="uk-width-1-6">申請日期</td>
								<td class="uk-width-2-6"><?php echo $submit_date; ?></td>
								<td class="uk-width-1-6">申請人</td>
								<td class="uk-width-2-6"><?php echo $applicant; ?></td>
							</tr>
							<tr>
								<td>客戶負責人</td>
								<td><?php echo $contact_winodw; ?></td>
								<td>Email</td>
								<td><?php echo $email; ?></td>
							</tr>
							<tr>
								<td>客戶名稱</td>
								<td><?php echo $company; ?></td>
								<td>客戶廠別</td>
								<td><?php echo $factory; ?></td>
							</tr>
							<tr>
								<td>地區</td>
								<td><?php echo $area; ?></td>
								<td>附件</td>
								<td><a href="<?php echo base_url(); ?>uploads/<?php echo $attachment; ?>" target="_blank"><?php echo $attachment; ?></a></td>
							</tr>
							<tr>
								<td>備註</td>
								<td colspan="3"><?php echo $remark; ?></td>
							</tr>
						</tbody>
					</table>
				</fieldset>
				<br>
				<!-- 故障品敘述 -->
				<fieldset data-uk-margin>
				<legend>故障品列表</legend>
				<table id="items" class="uk-table uk-table-hover uk-table-striped" border="0" cellspacing="0" cellpadding="0">
					<tbody>				
					    <tr>
					          <th>申請類別*</th>
					          <th>手臂序號*</th>
					          <th>客戶使用機種/<br>機台編號*</th>
					          <th>控制器序號</th>
					          <th>產品料號/規格/名稱*</th>
					          <th>產品序號</th>
					          <th>數量*</th>
					          <th>單位</th>
					          <!-- <th>產品規格/名稱*</th> -->
					          <th>原因*</th>
					          <th>運送方式*</th>
					    </tr>
					    <?php 
							//取得退回品清單
							$query = $this->db->get_where('rma_item',array('form_num'=>$form_num));
							foreach ($query->result() as $row)
							{ ?>
					    <tr>
					          <td><?php echo $row->category; ?></td>
					          <td><?php echo $row->git_robot; ?></td>
					          <td><?php echo $row->station_number; ?></td>
					          <td><?php echo $row->client_robot; ?></td>
					          <td><?php echo $row->material_num; ?></td>
					          <td><?php echo $row->product_num; ?></td>
					          <td><?php echo $row->quantity; ?></td>
					          <td><?php echo $row->unit; ?></td>
					          <!-- <td><?php echo $row->spec; ?></td>-->
					          <td><?php echo $row->issue; ?></td>
					          <td><?php echo $row->shipment; ?></td>
					    </tr>
					    <?php } ?>
					</tbody>
				</table>
		  		</fieldset>
		  		<!-- Hidden fields -->
		  		<?php echo form_hidden('id', $id); ?>
			<?php echo form_close(); ?>
			<!-- Comment area -->
				<?php
		$attributes = array('class' => 'uk-form uk-width-medium-1-2', 'id' => 'form_create_comment');
		echo form_open('manage/action_create_comment', $attributes);  ?>
			<!-- Display the existing comments -->
				<legend>留言</legend>
				<ul class="uk-comment-list">
					<?php 
							//取得Comment
							$query = $this->db->get_where('rma_comment',array('form_num'=>$form_num));
							foreach ($query->result() as $row2)
							{ ?>
					<li>
						<article class="uk-comment">
						    <header class="uk-comment-header">
						        <h4 class="uk-comment-title"><?php echo $row2->person; ?> <span class="uk-comment-meta">於 <?php echo $row2->time; ?> 留言</span></h4> 
						    </header>
						    <div class="uk-comment-body"><?php echo $row2->message; ?></div>
						</article>
					</li>
				<?php } ?>
				</ul>
				<!-- Leave a new comments -->
				<article class="uk-comment">
				    <div class="uk-comment-body"><?php echo form_textarea('message', ''); ?></div>
				</article>
				<input type="submit" name="submit" value="送出留言" class="uk-button" />
				
				<?php echo form_hidden('form_num', $form_num); ?>
				<!-- in order to pass the post id to controller (action_create_commnet), 
				so that the page can reload the last page with the new comment -->
				<?php echo form_hidden('current_post', $id); ?>
				
				<?php echo form_hidden('person', $name); ?>
				
			<?php echo form_close(); ?> 
		</div>
	</div>
</body>
</html>