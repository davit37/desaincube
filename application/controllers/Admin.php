<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');
class Admin extends CI_Controller

{
			
		

	public

	function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
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

	public function new_post(){
		$data['data']=$this->Madmin->get_category()->result();
		$this->load->view('admin/new_post',$data);
	}

	public function save_new_post(){
		$this->form_validation->set_rules('title', 'title', 'required');
        $this->form_validation->set_rules('editor1', 'editor1', 'required');

		if ($this->form_validation->run() == FALSE) {
		
			$this->load->view('admin/new_post');
		}
		else {
			$data=array(
				'title' => $this->input->post('title') ,
				'content'=>$this->input->post('editor1'),
				'id_user'=>$this->session->userdata['logged_in']['id'],
				'post_date'=>date("Y-m-d H:i:s")

			);

			$result = $this->Madmin->save_new_post($data);
			if($result != false){
				$id_category=$this->input->post('category'); 
				$data=array();
				foreach($id_category as $key => $val){
					$data[]=array(
						'category_id'=>$_POST['category'][$key],
						'post_id'=>$result,
						
					);
				}
				$result=$this->Madmin->save_category_relationships($data);
				if($result){
					echo "true";
				}
			}
			
		}
	}

	public function edit_post($id){
		$data['post']=$this->Madmin->read_post($id)->result();
		$data['data']=$this->Madmin->get_category()->result();
		$data['check_category']=$this->Madmin->check_category($id)->result();

		$this->load->view('admin/edit_post',$data);
	}

	public function save_edit_post(){
		$i=0;
		$data_category;

		$this->form_validation->set_rules('title', 'title', 'required');
        $this->form_validation->set_rules('editor1', 'editor1', 'required');

		if ($this->form_validation->run() == FALSE) {
		
			
		}
		else {
			$id=$this->input->post('id');
			$data=array(
				'title' => $this->input->post('title') ,
				'content'=>$this->input->post('editor1'),
			
			);

			$result = $this->Madmin->save_edit_post($id,$data);
			if($result){

				$data=$this->Madmin->check_category($id)->result();


				foreach($data as $obj){
					$category_id=$obj->category_id;

					if ( !in_array($category_id, $this->input->post('category'))){
						$this->Madmin->delete_category_relationships($id,$category_id);
					}
				}
				foreach($this->input->post('category') as $obj){
					$str=$obj;

					if ( !in_array($str, array_column($data, 'category_id'))){
						
						$data_category[]=array(
							'category_id'=>$str,
							'post_id'=>$id,
							
						);
					}
				}

				if(!empty($data_category)){
					$result=$this->Madmin->save_category_relationships($data_category);
				}

				
				if($result){
					echo "true";
				}
				
			}
			
		}
	}
	public function all_post(){
		$data['data']=$this->Madmin->get_all_post()->result();

		$this->load->view('admin/all_post',$data);
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

	public function delete_post($id){
		
		$result = $this->Madmin->delete_post($id);

		if($result){
			redirect('admin/all_post');
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

	
	

}
