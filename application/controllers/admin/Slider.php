<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');
class Slider extends CI_Controller

{

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


}