<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');
class Admin extends CI_Controller

{
			
		

	public

	function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->library('pagination');
		$this->load->model('Madmin');

		$user = ($this->session->userdata['logged_in']['user_login']);
		$login = ($this->session->userdata['logged_in']['loggedin']);
		$id_user = ($this->session->userdata['logged_in']['id']);

		if($login != true){
			redirect(site_url('login'));
		}
	

	}

	public

	function index()
	{
		$this->load->view('admin/index');
	}

	public function new_user(){
		$this->load->view('admin/new_user');
	}

	public function save_new_user(){
		$this->form_validation->set_rules('user_login', 'user_login', 'required');
		$this->form_validation->set_rules('display_name', 'display_name', 'required');
		$this->form_validation->set_rules('user_password', 'user_password', 'required');
		$this->form_validation->set_rules('user_email', 'email', 'required');
	


		if ($this->form_validation->run() == FALSE) {
		
			$this->load->view('admin/new_user');
		}
		else {

			$options = [
				'cost' => 12,
			];
		
			$password=password_hash($this->input->post('user_password') , PASSWORD_BCRYPT, $options);
			$data=array(
				'user_login' => $this->input->post('user_login') ,
				'user_password'=>$password,
				'display_name' => $this->input->post('display_name') ,
				'user_email'=>$this->input->post('user_email'),
				
			);

			$result = $this->Madmin->save_new_user($data);

			if($result){
				redirect('admin/all_user');
			}
			
		}
	}



	public function all_user()
	{
		$data['data']=$this->Madmin->get_all_user()->result();

		$this->load->view('admin/all_user',$data);
	}

	public function edit_user($id){
		$data['data']=$this->Madmin->get_user($id)->result();

		$this->load->view('admin/edit_user',$data);
	}

	public function save_edit_user(){

		$id=$this->input->post('id');

		if(empty($this->input->post('user_password'))){
			$data=array(
				'user_login' => $this->input->post('user_login') ,
				'display_name' => $this->input->post('display_name') ,
				'user_email'=>$this->input->post('user_email'),
				
			);
		}else{
			$options = [
				'cost' => 12,
			];
		
			$password=password_hash($this->input->post('user_password') , PASSWORD_BCRYPT, $options);
			$data=array(
				'user_login' => $this->input->post('user_login') ,
				'user_password'=>$password,
				'display_name' => $this->input->post('display_name') ,
				'user_email'=>$this->input->post('user_email'),
				
			);
		}
		

		$result = $this->Madmin->save_edit_user($id,$data);

		if($result){
			redirect('admin/all_user');
		}
	}

	
	public function delete_user($id){
		
		$result = $this->Madmin->delete_user($id);

		if($result){
			redirect('admin/all_user');
		}
	}



	public function save_new_category(){
		$data=array(
			'name'=>$this->input->post('name')
		);
		$result = $this->Madmin->save_new_category($data);

		if($result){
			$data=$this->Madmin->get_category()->result();

			echo json_encode($data);
		}

	}

	public function change_password($id){

		$this->load->view('admin/change_password');
	}

}
