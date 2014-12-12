<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Authorize extends CI_Controller {

	public function __construct(){
		
	      session_start();
	      parent::__construct();
      	
     }

    public function login(){

	if ( isset($_SESSION['username'])) {
         header("location: ".base_url()."manage/dashboard");
      }
		$this->load->view('login');
	}

	public function checklogin(){
	
	$query=$this->db->where('username', $this->input->post('username'))
					->where('password', $this->input->post('password'))
					->get('rma_user');
		
	$res= $query->num_rows();
	$row = $query->row();
	$level = $row->level;

	if($res == 1){

		$_SESSION['username']= $this->input->post('username');
		redirect('manage/dashboard', 'refresh');
		
	} else {

		echo "<html><head><meta charset='utf-8'></head><body><script type='text/javascript'>
				alert('帳號密碼錯誤！');
				window.location.href='login';
			  </script></body></html>";

		} 
	}

	public function logout(){
		
		session_destroy();
		header("location: ".base_url()."authorize/login");
	 }
//End
}