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
<!DOCTYPE html>
<html>
<head>
	<title>RMA:::新增申請表</title>
	<!-- install UIKit powered by Yootheme -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/uikit.css" />
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/custom.css" />
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/jquery-ui.css">
    <script src="<?php echo base_url(); ?>js/jquery.js"></script>
    <script src="<?php echo base_url(); ?>js/uikit.min.js"></script>
    <!-- Finish installation -->
    <script src="<?php echo base_url(); ?>js/jquery-ui.js"></script>
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
	<!-- Add/Remove rows dynamiclly -->
	<script type="text/javascript">
    $(document).ready(function() {

        $("#add").click(function() {
          $('#items tbody>tr:last').clone(true).insertAfter('#items tbody>tr:last');
          $('#items tbody>tr:last').find("input:text").val('');
          return false;
        });
        $("#remove").click(function() {
        	if ($('#items tbody>tr').size()>2) {
        		$('#items tbody>tr:last').remove();
        	} else { alert('表格至少要有一列');
        	};
        });

    });
</script>
</head>
<body>
	<?php include("header.php"); //表頭 ?>
    <div id="main" class="uk-grid">
    	<div class="uk-width-1-1">
    		<h1>新增申請單</h1>
			<div class="uk-alert uk-alert-danger">尚未取得RMA 號碼時，請勿將故障產品先行寄出。</div>
			
			<div style="color:red;"><?php echo validation_errors(); ?></div>
			<?php 

				//查詢當日已有的筆數(即可得知最後一筆編號)
				$this->db->where('submit_date',date('Ymd'));
				$this->db->from('rma_detail');
				$record= $this->db->count_all_results();

			?>
			<form action="action_create" method="POST" enctype="multipart/form-data" class="uk-form">
				<!-- 基本資料 -->
				<fieldset data-uk-margin>
					<legend>新增基本資料 ( * 為必填欄位)</legend>
					<table width="700">
						<tbody>
							<!--<tr>
								<td class="uk-text-large uk-text-primary">RMA單號</td>
								<td colspan="3" class="uk-text-large uk-text-primary">
									GIR<?php echo date('Ymd'); ?><?php if ($record ==0) { 
										echo "001"; //如果沒有001的紀錄，就填入001
									} else { echo sprintf("%03d",$record+1); } // 不然就填入最後一筆流水號＋1} ?>
								</td>
							</tr>-->
							<tr>
								<td>日期</td>
								<td>
									<input size="" type="text" name="" value="<?php echo date('Y-m-d'); ?>" readonly>
								</td>
								<td>申請人</td>
								<td>
								<?php 
								$query = $this->db->get_where('rma_user', array('username'=>$_SESSION['username']));
								foreach ($query->result() as $row){ ?>
									<input size="" type="text" name="applicant" value="<?php echo $row->name; ?>" readonly >
								<?php } ?></td>
							</tr>
							<tr>
								<td>客戶負責人*</td>
								<td><input size="" type="text" name="contact_winodw" value="<?php echo set_value('contact_winodw'); ?>" placeholder="必填"  ></td>
								<td>Email*</td>
								<td><input size="" type="text" name="email" value="<?php echo set_value('email'); ?>" placeholder="必填" ></td>
							</tr>
							<tr>
								<td>客戶名稱*</td>
								<td><input size="" type="text" name="company" value="<?php echo set_value('company'); ?>" placeholder="必填" ></td>
								<td>客戶廠別*</td>
								<td><input size="" type="text" name="factory" value="<?php echo set_value('factory'); ?>" placeholder="必填" ></td>
							</tr>
							<tr>
								<td>客戶需求日</td>
								<td><input size="" type="text" name="demand_date" value="<?php echo set_value('demand_date'); ?>" class="datepicker" ></td>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<td>地區</td>
								<td>
									<select name="area" value="<?php echo set_value('area'); ?>">
										<?php 
											//取得地區列表
											$query = $this->db->get('rma_area');
											foreach ($query->result() as $row)
											{ ?>
											<option value="<?php echo $row->area; ?>"><?php echo $row->area; ?></option>  
											<?php } ?>
									</select>
								</td>
								<td>附件</td>
								<td><input type="file" name="attachment" value="<?php echo set_value('attachment'); ?>" /></td>
							</tr>
							<tr>
								<td>備註</td>
								<td colspan="3"><textarea name="remark" rows="5" cols="70"><?php echo set_value('remark'); ?></textarea></td>
							</tr>
						</tbody>
					</table>
				</fieldset>
				<br><br>
				<!-- 故障品敘述 -->
				<fieldset data-uk-margin>
				<legend>新增故障品敘述 ( * 為必填欄位)</legend>
				<input id="add" value="新增一列" type="button" class="uk-button">
				<input id="remove" value="移除最後一列" type="button" class="uk-button">
				<table id="items" class="uk-table" border="0" cellspacing="0" cellpadding="0">
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
					          <th>原因*</th>
					          <th>運送方式*</th>
					    </tr>
					    <tr>
					          
					          <td>
					          	<select name="category[]" value="<?php echo set_value('category[]'); ?>">
										<?php 
											//取得類別
											$query = $this->db->get('rma_category');
											foreach ($query->result() as $row)
											{ ?>
											<option value="<?php echo $row->category; ?>"><?php echo $row->category; ?></option>  
											<?php } ?>
								</select>
					          </td>
					          <td><input type="text" name="git_robot[]" value="<?php echo set_value('git_robot[]'); ?>" class="uk-form-small" placeholder="ex:06P465 (必填)"></td>
					          <td><input type="text" name="station_number[]" value="<?php echo set_value('station_number[]'); ?>" class="uk-form-small" placeholder="ex:WM1205 (必填)"></td>
					          <td><input type="text" name="client_robot[]" value="<?php echo set_value('client_robot[]'); ?>" class="uk-form-small"></td>
					          <td><input type="text" name="material_num[]" value="<?php echo set_value('material_num[]'); ?>" class="uk-form-small" placeholder="ex:SR 600"></td>
					          <td><input type="text" name="product_num[]" value="<?php echo set_value('product_num[]'); ?>" class="uk-form-small" placeholder="ex:二維條碼- A3110094"></td>
					          <td><input type="text" size="3" name="quantity[]" value="<?php echo set_value('quantity[]'); ?>" class="uk-form-small" placeholder="必填"></td>
					          <td><input type="text" size="3" name="unit[]" value="<?php echo set_value('unit[]'); ?>" class="uk-form-small"></td>
					          <td>
					          	<select name="issue[]" value="<?php echo set_value('issue[]'); ?>">
										<?php 
											//取得原因
											$query = $this->db->get('rma_issue');
											foreach ($query->result() as $row)
											{ ?>
											<option value="<?php echo $row->issue; ?>"><?php echo $row->issue; ?></option>  
											<?php } ?>
								</select>
					          </td>
					          <td><input type="text" name="shipment[]" value="<?php echo set_value('shipment[]'); ?>" class="uk-form-small" placeholder="必填"></td>
					    </tr>
					</tbody>
				</table>
		  		</fieldset>
		  		<hr>
		  		<input type="submit" name="submit" value="送出表單" class="uk-button" />
		  		<!-- Hidden fields -->
				<input type="hidden" name="submit_date" value="<?php echo date('Ymd'); ?>">
				<input type="hidden" name="post_num" value="<?php if ($record ==0) { 
									echo "001"; //如果沒有001的紀錄，就填入001
								} else { echo sprintf("%03d",$record+1); } // 不然就填入最後一筆流水號＋1} ?>">
				<input type="hidden" name="serial_num" 
									value="GIR<?php echo date('Ymd'); ?><?php if ($record ==0) { 
										echo "001"; //如果沒有001的紀錄，就填入001
									} else { echo sprintf("%03d",$record+1); } // 不然就填入最後一筆流水號＋1} ?>">
						
			</form>
		</div>
	</div>
</body>
</html>