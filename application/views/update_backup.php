<!DOCTYPE html>
<html>
<head>
	<title>RMA:::新增申請表</title>
	<!-- install UIKit powered by Yootheme -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/uikit.css" />
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/custom.css" />
    <script src="<?php echo base_url(); ?>js/jquery.js"></script>
    <script src="<?php echo base_url(); ?>js/uikit.min.js"></script>
    <!-- Finish installation -->
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
			$deliver_date= $row->deliver_date;
			$quotation_num= $row->quotation_num;
			$receive_date= $row->receive_date;
			$engineer= $row->engineer;
			$install_date= $row->install_date;
			$status= $row->status;

			echo $attachment;
	
		} ?>
			<form action="action_create" method="POST" enctype="multipart/form-data" class="uk-form">
				<!-- 基本資料 -->
				<fieldset data-uk-margin>
					<legend>更新基本資料</legend>
					<table width="700">
						<tbody>
							<tr>
								<td>RMA單號</td>
								<td colspan="3">
									<?php echo $form_num; ?>
								</td>
							</tr>
							<tr>
								<td>日期</td>
								<td>
									<input size="" type="text" name="submit_date" value="<?php echo $submit_date; ?>" >
								</td>
								<td>申請人</td>
								<td><input size="" type="text" name="applicant" value="<?php echo $applicant; ?>" ></td>
							</tr>
							<tr>
								<td>客戶負責人</td>
								<td><input size="" type="text" name="contact_winodw" value="<?php echo $contact_winodw; ?>"  ></td>
								<td>Email</td>
								<td><input size="" type="text" name="email" value="<?php echo $email; ?>" ></td>
							</tr>
							<tr>
								<td>客戶名稱</td>
								<td><input size="" type="text" name="company" value="<?php echo $company; ?>" ></td>
								<td>客戶廠別</td>
								<td><input size="" type="text" name="factory" value="<?php echo $factory; ?>" ></td>
							</tr>
							<tr>
								<td>地區</td>
								<td>
									<select name="area">
										<?php 
											//取得地區列表
											$query = $this->db->get('rma_area');
											foreach ($query->result() as $row2)
											{ ?>
											<option value="<?php echo $row2->area; ?>" 
												<?php if ($area == $row2->area ) {
													echo 'selected = "selected"';
												} ?>><?php echo $row2->area; ?></option>  
											<?php } ?>
									</select>
								</td>
								<td>附件</td>
								<td><a href="<?php echo base_url(); ?>uploads/<?php echo $attachment; ?>" target="_blank"><?php echo $attachment; ?></a></td>
							</tr>
							<tr>
								<td>備註</td>
								<td colspan="3"><textarea name="remark" rows="5" cols="70" ><?php echo $remark; ?></textarea></td>
							</tr>
						</tbody>
					</table>
				</fieldset>
				<br><br>
				<!-- 故障品敘述 -->
				<fieldset data-uk-margin>
				<legend>新增故障品敘述</legend>
				<input id="add" value="新增一列" type="button" class="uk-button">
				<input id="remove" value="移除最後一列" type="button" class="uk-button">
				<table id="items" class="uk-table" border="0" cellspacing="0" cellpadding="0">
					<tbody>				
					    <tr>
					          
					          <th>申請類別</th>
					          <th>GIT手臂序號</th>
					          <th>客戶機台號碼</th>
					          <th>客戶Robot號碼</th>
					          <th>產品料號</th>
					          <th>產品序號</th>
					          <th>數量</th>
					          <th>單位</th>
					          <th>產品規格/名稱</th>
					          <th>原因</th>
					          <th>運送方式</th>
					    </tr>
					    <?php 
							//取得退回品清單
							$query = $this->db->get_where('rma_item',array('form_num'=>$form_num));
							foreach ($query->result() as $row3)
							{ ?>
					    <tr>
					          <td>
					          	<?php if ($row4->category == $row3->category) {
												echo 'selected = "selected"';
											} ?>>
												<?php echo $row4->category; ?>
											</option>  
										<?php } ?>
								</select>
					          </td>
					          <td><input type="text" name="git_robot[]" value="<?php echo $row3->git_robot; ?>" class="uk-form-small"></td>
					          <td><input type="text" name="station_number[]" value="<?php echo $row3->station_number; ?>" class="uk-form-small"></td>
					          <td><input type="text" name="client_robot[]" value="<?php echo $row3->client_robot; ?>" class="uk-form-small"></td>
					          <td><input type="text" name="material_num[]" value="<?php echo $row3->material_num; ?>" class="uk-form-small"></td>
					          <td><input type="text" name="product_num[]" value="<?php echo $row3->product_num; ?>" class="uk-form-small"></td>
					          <td><input type="text" size="3" name="quantity[]" value="<?php echo $row3->quantity; ?>" class="uk-form-small"></td>
					          <td><input type="text" size="3" name="unit[]" value="<?php echo $row3->unit; ?>" class="uk-form-small"></td>
					          <td>
					          	<select name="spec[]">
										<?php 
											//取得產品規格
											$query = $this->db->get('rma_spec');
											foreach ($query->result() as $row)
											{ ?>
											<option value="<?php echo $row->spec; ?>"><?php echo $row->spec; ?></option>  
											<?php } ?>
								</select>
					          </td>
					          <td>
					          	<select name="issue[]">
										<?php 
											//取得原因
											$query = $this->db->get('rma_issue');
											foreach ($query->result() as $row)
											{ ?>
											<option value="<?php echo $row->issue; ?>"><?php echo $row->issue; ?></option>  
											<?php } ?>
								</select>
					          </td>
					          <td><input type="text" name="shipment[]" value="" class="uk-form-small"></td>
					    </tr>
					    <?php } ?>
					</tbody>
				</table>
		  		</fieldset>
		  		<hr>
		  		<input type="submit" name="submit" value="送出表單" class="uk-button" />
		  		<!-- Hidden fields -->
			</form>
		</div>
	</div>
</body>
</html>