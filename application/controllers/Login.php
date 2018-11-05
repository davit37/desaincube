<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class login extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->model('Mlogin');
	}

	public function index()
	{
		$this->load->view('login/index');
	}
	public function check_login()
	{
		$this->form_validation->set_rules('user_login', 'user_login', 'required');
		$this->form_validation->set_rules('user_password', 'user_password', 'required');

		if($this->form_validation->run() == FALSE ){
			$this->load->view('login/index');
		}
		else{
			$akun = array(
			'user_login'	=> $this->input->post('user_login'),
			'user_password'	=>$this->input->post('user_password')
			);

			$result = $this->Mlogin->check_akun($akun);
			if($result != false){

		
					$session_data = array(
						
						'user_login'	=> $akun['user_login'],
						'display_name'	=> $result[0]->display_name,
						'id'=>$result[0]->id,
						'loggedin' => true,
						
						);
				$this->session->set_userdata('logged_in', $session_data);
				redirect('admin');
			}
			else
			{
				$data["error"]="Invalid User Id and Password combination";
				$this->load->view('login/index',$data);
			}
	}
}

	public function logout(){
		//menghapus data session
		$sess_array = array(
			'username'	=> '',
			'nama'	=> '',
			'id'=>'',
		);
		$this->session->unset_userdata('logged_in', $sess_array);
		redirect('login');
	}

	public function forgot_password(){
		$this->load->view("login/forgot_password");
	}


}

/* End of file login.php */
/* Location: ./application/controllers/login.php */
