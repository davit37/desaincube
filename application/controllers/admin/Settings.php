<?php

class Settings Extends CI_Controller{
    
	
	public function settings(){
		$data['seo']=$this->Madmin->get_seo()->result();
		$this->load->view("admin/settings",$data);
	}

	public function save_seo(){
		$data=null;
		foreach($this->input->post('id') as $key => $val){
			$data[]=array(
				'id'=>$_POST['id'][$key],
				'value'=>$_POST['value'][$key],
				
			);
		}

		$result=$this->Madmin->edit_seo($data);

		if($result){
			$data['seo']=$this->Madmin->get_seo()->result();
			$this->load->view("admin/settings",$data);
		}
	}

	public function all_settings(){
		$data['seo']=$this->Madmin->get_seo()->result();
		

		$this->load->view('admin/all_settings',$data);
	}
	
	public function delete_seo($id){
		$result = $this->Madmin->delete_seo($id);

		if($result){
			echo "true";
		}
	}
}