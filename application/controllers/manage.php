<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Manage extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$this->load->view('dashboard');
	}

	public function create()
	{
		$this->load->model('Git_db');
		$this->load->view('create');
	}

	public function action_create(){

		//啟用表單驗證功能
		$this->load->library('form_validation');
		
		//定義驗證原則
		$this->form_validation->set_rules('contact_winodw', '客戶負責人', 'required');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
		$this->form_validation->set_rules('company', '客戶名稱', 'required');
		$this->form_validation->set_rules('factory', '客戶廠別', 'required');
		$this->form_validation->set_rules('demand_date', '客戶需求日', '');
		$this->form_validation->set_rules('area', '地區', '');
		$this->form_validation->set_rules('file_name', '附件', '');
		$this->form_validation->set_rules('remark', '備註', '');
		$this->form_validation->set_rules('category[]', '申請類別', 'required');
		$this->form_validation->set_rules('git_robot[]', '手臂序號', 'required');
		$this->form_validation->set_rules('station_number[]', '客戶使用機種/
機台編號', 'required');
		$this->form_validation->set_rules('client_robot[]', '控制器序號', '');
		$this->form_validation->set_rules('material_num[]', '產品料號/規格/名稱', 'required');
		$this->form_validation->set_rules('product_num[]', '產品序號', '');
		$this->form_validation->set_rules('quantity[]', '數量', 'required');
		$this->form_validation->set_rules('unit[]', '單位', '');
		$this->form_validation->set_rules('issue[]', '原因', 'required');
		$this->form_validation->set_rules('shipment[]', '運送方式', 'required');

		//設定驗證後的動作，不符合原則就返回表單，符合則寫入資料庫
		if ($this->form_validation->run() == FALSE){

			$this->load->view('create');

		} else {

			// Send mail to ram@gi-techie.com
				$newRow_email = array(
						'form_num' => $this->input->post('serial_num'),
						'applicant' => $this->input->post('applicant'),
						'contact_winodw' => $this->input->post('contact_winodw'),
						'company' => $this->input->post('company'),
						'current_post' => $this->input->post('id'),
					);

				$to= 'becky@gi-techie.com';
				$subject= $this->input->post('serial_num').' 已建立';
				$headers  = 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
				$headers .= 'From: RMA系統管理員 <no-reply@gi-techie.com>' . "\r\n";
				$message = $this->load->view('mail_new_post',$newRow_email,true);

				mail($to, $subject, $message, $headers);

			$this->config =  array(

	                  'upload_path'     => "./uploads/",
	                  'allowed_types'   => "gif|jpg|png|jpeg|pdf|doc|xml|zip|rar",
	                  'overwrite'       => TRUE,
	                  'max_size'        => "5000KB",
	                  /*'max_height'      => "3000",
	                  'max_width'       => "3000"*/

	                );

			$this->load->library('upload', $this->config);
			$this->load->model('Git_db');

			if($this->upload->do_upload("attachment"))

			{
				//取得附件檔案名稱
				$upload_data = $this->upload->data();
				$file_name = $upload_data['file_name'];

				//寫入記錄至 ram_detail (有附件)
				$newRow = array(
				'submit_date' => $this->input->post('submit_date'),
				'post_num' => $this->input->post('post_num'),
				'applicant' => $this->input->post('applicant'),
				'form_num' => $this->input->post('serial_num'),
				'contact_winodw' => $this->input->post('contact_winodw'),
				'email' => $this->input->post('email'),
				'company' => $this->input->post('company'),
				'factory' => $this->input->post('factory'),
				'area' => $this->input->post('area'),
				'demand_date' => $this->input->post('demand_date'),
				'remark' => $this->input->post('remark'),
				'attachment' => $file_name,

				);

				$newRow_item =array();
				$count = count($this->input->post('product_num'));
				for($i=0; $i<$count; $i++) {
				$newRow_item[] = array(
				'form_num' => $this->input->post('serial_num'),
				'category' => $this->input->post('category')[$i], 
				'git_robot' => $this->input->post('git_robot')[$i],
				'station_number' => $this->input->post('station_number')[$i],
				'client_robot' => $this->input->post('client_robot')[$i],
				'material_num' => $this->input->post('material_num')[$i], 
				'product_num' => $this->input->post('product_num')[$i],
				'quantity' => $this->input->post('quantity')[$i],
				'unit' => $this->input->post('unit')[$i],
				'issue' => $this->input->post('issue')[$i],
				'shipment' => $this->input->post('shipment')[$i],

				           );
				}
				
				$this->Git_db->insert($newRow);
				$this->db->insert_batch('rma_item', $newRow_item);
				echo "<html><head><meta charset='utf-8'></head><body><script type='text/javascript'>
					alert('表單新增成功！');
					window.location.href='create';
				  </script></body></html>";

			} else {

				//寫入記錄至 ram_detail (無附件)
				$newRow = array(
					'submit_date' => $this->input->post('submit_date'),
					'post_num' => $this->input->post('post_num'),
					'applicant' => $this->input->post('applicant'),
					'form_num' => $this->input->post('serial_num'),
					'contact_winodw' => $this->input->post('contact_winodw'),
					'email' => $this->input->post('email'),
					'company' => $this->input->post('company'),
					'factory' => $this->input->post('factory'),
					'area' => $this->input->post('area'),
					'demand_date' => $this->input->post('demand_date'),
					'remark' => $this->input->post('remark'),
				);

				$newRow_item =array();
				$count = count($this->input->post('product_num'));
				for($i=0; $i<$count; $i++) {
					$newRow_item[] = array(
					'form_num' => $this->input->post('serial_num'),
					'category' => $this->input->post('category')[$i], 
					'git_robot' => $this->input->post('git_robot')[$i],
					'station_number' => $this->input->post('station_number')[$i],
					'client_robot' => $this->input->post('client_robot')[$i],
					'material_num' => $this->input->post('material_num')[$i], 
					'product_num' => $this->input->post('product_num')[$i],
					'quantity' => $this->input->post('quantity')[$i],
					'unit' => $this->input->post('unit')[$i],
					'issue' => $this->input->post('issue')[$i],
					'shipment' => $this->input->post('shipment')[$i],
					);
				}
				
				$this->Git_db->insert($newRow);
				$this->db->insert_batch('rma_item', $newRow_item);

			    echo "<html><head><meta charset='utf-8'></head><body><script type='text/javascript'>
					alert('表單新增成功！');
					window.location.href='create';
				  </script></body></html>";

			}
		}
	}

	public function overview(){
		
		$this->load->model('Git_db');
		$data['results'] = $this->Git_db->get_detail_open();
		$this->load->view('overview', $data);
		
	}

	public function overview_open(){
		
		$this->load->model('Git_db');
		$data['results'] = $this->Git_db->get_detail_open();
		$this->load->view('overview', $data);
		
	}

	public function overview_close(){
		
		$this->load->model('Git_db');
		$data['results'] = $this->Git_db->get_detail_close();
		$this->load->view('overview', $data);
		
	}


	public function overview_filter() {

		$query=$this->db->where('submit_date >=', $this->input->post('startdate'))
					->where('submit_date <=', $this->input->post('enddate'))
					->get('rma_detail');

		$data['results'] = $query->result();
		$this->load->view('overview',$data);
	}

	public function update(){

		$this->load->model('Git_db');
		$id= $this->uri->segment(3);
		$data['results_all'] = $this->Git_db->get_detail_all($id);
		$this->load->view('update', $data);
	}

	public function action_update(){

		$this->load->model('Git_db');
		$newRow = array(
				'demand_date' => $this->input->post('demand_date'),
				'release_num' => $this->input->post('release_num'),
				'git_po_num' => $this->input->post('git_po_num'),
				'git_material_num' => $this->input->post('git_material_num'),
				'git_station_type' => $this->input->post('git_station_type'),
				'customer_po_num' => $this->input->post('customer_po_num'),
				'vendor_ram' => $this->input->post('vendor_ram'),
				'deliver_date' => $this->input->post('deliver_date'),
				'quotation_num' => $this->input->post('quotation_num'),
				'receive_date' => $this->input->post('receive_date'),
				'engineer' => $this->input->post('engineer'),
				'install_date' => $this->input->post('install_date'),
				'status' => $this->input->post('status'),
			);

			$this->Git_db->update($newRow);
		    echo "<html><head><meta charset='utf-8'></head><body><script type='text/javascript'>
				alert('表單更新成功！');
				window.location.href='overview';
			  </script></body></html>";
		
	}

	public function action_create_comment(){

		$this->load->model('Git_db');
		$newRow = array(
				'message' => $this->input->post('message'),
				'form_num' => $this->input->post('form_num'),
				'person' => $this->input->post('person'),
			);

		$current_post = $this->input->post('current_post');
		$this->Git_db->insert_comment($newRow);

		// Send mail to ram@gi-techie.com
		$newRow_email = array(
				'message' => $this->input->post('message'),
				'form_num' => $this->input->post('form_num'),
				'person' => $this->input->post('person'),
				'current_post' => $this->input->post('current_post'),
			);

		$to= 'becky@gi-techie.com';
		$subject= $this->input->post('form_num').' 有新留言';
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
		$headers .= 'From: RMA系統管理員 <no-reply@gi-techie.com>' . "\r\n";

		mail($to, $subject, $this->load->view('mail_message',$newRow_email,true), $headers);
		//Redirect page to the updated record.
		
		redirect('manage/update/'.$current_post,'refresh');

	}

	public function dashboard(){

		$this->load->view('dashboard');
	}

	public function display_cal($year = FALSE, $month =FALSE){

		if( $year === FALSE ) $year = date( 'Y' );
    	if( $month === FALSE ) $month = date( 'm' );

		$this->load->model('Git_db');
		$date['calendar'] = $this->Git_db->generate_calendar($year, $month);
		$this->load->view('mycal',$date);
	}



//End
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */