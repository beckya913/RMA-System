<!DOCTYPE html>
<html>
<head>
	<title>RMA:::新增申請表</title>
</head>
<body>
	<h2>Serial Generator</h2>
	<?php 

		//查詢當日已有的筆數(即可得知最後一筆編號)
		$this->db->where('date',date('Ymd'));
		$this->db->from('rma_serial');
		$record= $this->db->count_all_results();

	?>
	<form action="generate_serial" method="POST" enctype="multipart/form-data" >
		<table>
			<tbody>
				<tr><td>Date</td>
					<td>
						<input type="text" name="date" value="<?php echo date('Ymd'); ?>" readonly >
					</td>
					<td>Serial Number</td>
					<td><input size="" type="text" name="serial_num" 
						value="<?php if ($record ==0) { 
							echo "001"; //如果沒有001的紀錄，就填入001
						} else { echo sprintf("%03d",$record+1); } // 不然就填入最後一筆流水號＋1} ?>" ></td>
				</tr>
			</tbody>
		</table>
		<input type="submit" name="submit" value="create" />
	</form>
</body>
</html>