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
				'image'=>$this->input->post('image'),
				'id_user'=>$this->session->userdata['logged_in']['id'],
				'create_at'=>date("Y-m-d H:i:s")

			);

			$result = $this->Madmin->save_new_post($data);
			$data=null;
			if(!empty($this->input->post('category'))){
				if($result != false){
					$id_category=$this->input->post('category'); 
					$data=array();
					foreach($id_category as $key => $val){
						$data[]=array(
							'category_id'=>$_POST['category'][$key],
							'post_id'=>$result,
							
						);
					}
					
				}


			}else{
				$data[]=array(
					'category_id'=>1,
					'post_id'=>$result,
					
				);
			}

			$result=$this->Madmin->save_category_relationships($data);
			if($result){
				echo "true";
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
		$result =true;

		
		$id=$this->input->post('id');
		$data=array(
			'title' => $this->input->post('title') ,
			'content'=>$this->input->post('editor1'),
			'image'=>$this->input->post('image'),
			'modify_at'=>date("Y-m-d H:i:s"),
		
		);

		$this->Madmin->save_edit_post($id,$data);


		$data=$this->Madmin->check_category($id)->result();

		if(!empty($this->input->post('category'))){
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
		}else{
			$this->Madmin->delete_category_relationships($id,null);
			$data_category[]=array(
				'category_id'=>1,
				'post_id'=>$id,
				
			);
		}
		

		if(!empty($data_category)){
			$result=$this->Madmin->save_category_relationships($data_category);
		}

		
		if($result){
			echo "true";
		}
				
			
			
		
	}
	public function all_post(){
		//konfigurasi pagination
        $config['base_url'] = site_url('admin/all_post'); //site url
        $config['total_rows'] = $this->db->count_all('dc_post'); //total row
        $config['per_page'] = 5;  //show record per halaman
        $config["uri_segment"] = 3;  // uri parameter
        $choice = $config["total_rows"] / $config["per_page"];
        $config["num_links"] = floor($choice);
 
        // Membuat Style pagination untuk BootStrap v4
     	$config['first_link']       = 'First';
        $config['last_link']        = 'Last';
        $config['next_link']        = 'Next';
        $config['prev_link']        = 'Prev';
        $config['full_tag_open']    = '<div class="pagging text-center"><nav><ul class="pagination justify-content-center">';
        $config['full_tag_close']   = '</ul></nav></div>';
        $config['num_tag_open']     = '<li class="page-item"><span class="page-link">';
        $config['num_tag_close']    = '</span></li>';
        $config['cur_tag_open']     = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close']    = '<span class="sr-only">(current)</span></span></li>';
        $config['next_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['next_tagl_close']  = '<span aria-hidden="true">&raquo;</span></span></li>';
        $config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['prev_tagl_close']  = '</span>Next</li>';
        $config['first_tag_open']   = '<li class="page-item"><span class="page-link">';
        $config['first_tagl_close'] = '</span></li>';
        $config['last_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['last_tagl_close']  = '</span></li>';
 
        $this->pagination->initialize($config);
		$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
           
 
        $data['pagination'] = $this->pagination->create_links();
		$data['data']=$this->Madmin->get_all_post($config["per_page"], $page)->result();

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
		
		$data=array(
			'delete_at' =>date("Y-m-d H:i:s") ,
			
		);
		$result = $this->Madmin->delete_post($id,$data);

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

	public function change_password($id){

		$this->load->view('admin/change_password');
	}


	//slider 

	public function new_slider(){
		$this->load->view('admin/new_slider');
	}

	public function save_new_slider(){
		
		$publish=1;
		if(empty($this->input->post('publish'))){
			$publish=0;
		}
		
		$data=array(
			'name'=>$this->input->post('name'),
			'slug'=>$this->input->post('slug'),
			'publish'=>$publish,
			'create_at'=>date("Y-m-d H:i:s")
			
		);

		$result = $this->Madmin->save_new_slider($data);

		if($result){
			redirect('admin/all_slider');
		}
	}

	public function all_slider(){
		$data['data']=$this->Madmin->get_all_slider()->result();

		$this->load->view('admin/all_slider',$data);
	}

	public function all_slide($id){
		$data['data']=$this->Madmin->get_all_sliderimage($id)->result();
		$data['id']=$id;
		$this->load->view('admin/all_slide',$data);
	}

	public function new_slider_image(){
		$this->load->view('admin/new_slider_image');
	}

	public function save_new_sliderimage(){
		
		
		$data=array(
			'title'=>$this->input->post('title'),
			'image'=>$this->input->post('image'),
			'id_slider'=>$this->input->post('id_slider'),
			
			
		);

		$result = $this->Madmin->save_new_sliderimage($data);

		if($result){
			redirect('admin/all_slide/'.$this->input->post('id_slider'));
		}
	}

	public function delete_slider($id){
		$data=array(
			'delete_at' =>date("Y-m-d H:i:s") ,
			
		);
		$result = $this->Madmin->delete_slider($id,$data);

		if($result){
			redirect('admin/all_slider');
		}
	}
	
	public function edit_slider($id){
		$data['data']=$this->Madmin->get_slider($id)->result();
		

		$this->load->view('admin/edit_slider',$data);
	}

	public function save_edit_slider(){
		$id=$this->input->post('id');
		
		$publish=1;
		if(empty($this->input->post('publish'))){
			$publish=0;
		}
		
		$data=array(
			'name'=>$this->input->post('name'),
			'slug'=>$this->input->post('slug'),
			'publish'=>$publish,
			'modify_at'=>date("Y-m-d H:i:s")
		);

		$result=$this->Madmin->save_edit_slider($id,$data);

		if($result){
			redirect('admin/all_slider');
		}
	}

	public function delete_sliderimage($id){
		
		$result = $this->Madmin->delete_sliderimage($id);

		if($result){
			echo "true";
		}
	}

	public function edit_sliderimage($id){
		$data['data']=$this->Madmin->get_sliderimage($id)->result();
		

		$this->load->view('admin/edit_sliderimage',$data);
	}

	public function save_edit_sliderimage(){
		$id=$this->input->post('id');
		
		
		$data=array(
			'title'=>$this->input->post('title'),
			'image'=>$this->input->post('image'),
		);

		$result=$this->Madmin->save_edit_sliderimage($id,$data);

		if($result){
			redirect('admin/all_slide/'.$this->input->post('id_slider'));
		}
	}

	public function settings(){
		$this->load->view("admin/settings");
	}

	public function save_seo(){
		$data=array(
			'code'=>$this->input->post('code'),
			'value'=>$this->input->post('value'),
		);

		$result=$this->Madmin->save_seo($data);

		if($result){
			echo "true";
		}
	}
	

}
