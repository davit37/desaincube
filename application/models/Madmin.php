<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Madmin extends CI_Model {

    public function __construct()
	{
		parent::__construct();

    }
    
    public function save_new_post($data){
        $this->db->insert('dc_post',$data);
        $insert_id = $this->db->insert_id();
   
        if($this->db->affected_rows()=='1'){
			return  $insert_id;
		}
		else{
			return false;
		}
	} 
	
	public function get_all_post(){
		$this->db->select('dc_post.*');
		$this->db->select('dc_users.display_name');
		$this->db->select('GROUP_CONCAT(dc_category.name SEPARATOR ", ") AS category_name');
		$this->db->from('dc_post');
		$this->db->join('dc_users', 'dc_users.id =dc_post.id_user', 'left');
		$this->db->join('dc_category_relationships', 'dc_post.id = dc_category_relationships.post_id', 'left');
		$this->db->join('dc_category', 'dc_category.id = dc_category_relationships.category_id', 'left');
		$this->db->order_by('id', 'desc');
		$this->db->group_by('id', 'desc');
		return $this->db->get();
	}

	public function get_post(){
		$this->db->select('*');
		$this->db->from('dc_post');
		$this->db->order_by('id', 'desc');
		$this->db->limit(5);
		return $this->db->get();
	}

	public function save_edit_post($id,$data){
		$this->db->where('id', $id);
		$this->db->update('dc_post', $data);
		$message=$this->db;
        if($this->db->affected_rows()=='1'){
			return true;
		}
		else{
			return false;
		}
	}

	public function save_new_user($data){
		$this->db->insert('dc_users', $data);
        
   
        if($this->db->affected_rows()>='1'){
			return  true;
		}
		else if($this->db->_error_number()==1062){
			return 'duplicate';
		}
	}

	public function read_post($id){
		$this->db->select('*');
		$this->db->from('dc_post');
		$this->db->where('id',$id);

		
		return $this->db->get();
	}

	public function delete_post($id){
		$this->db->where('id', $id);
		$this->db->delete('dc_post');
		if($this->db->affected_rows()>='1'){
			return true;
		}
		else{
			return false;
		}
	}

	public function get_all_user(){

		$this->db->select('*');
		$this->db->from('dc_users');

		$this->db->order_by('id', 'desc');
		return $this->db->get();
	}

	public function get_user($id){
		$this->db->select('*');
		$this->db->from('dc_users');
		$this->db->where('id',$id);
		return $this->db->get();
	}

	public function save_edit_user($id, $data){
		$this->db->where('id', $id);
		$this->db->update('dc_users', $data);
        if($this->db->affected_rows()=='1'){
			return true;
		}
		else{
			return false;
		}
	}

	public function delete_user($id){
		$this->db->where('id', $id);
		$this->db->delete('dc_users');
		if($this->db->affected_rows()>='1'){
			return true;
		}
		else{
			return false;
		}
	}

	public function save_new_category($data){
		$this->db->insert('dc_category', $data);
        
   
        if($this->db->affected_rows()>='1'){
			return  true;
		}
		else if($this->db->_error_number()==1062){
			return 'duplicate';
		}
	}

	public function get_category(){
		$this->db->select('*');
		$this->db->from('dc_category');
		$this->db->order_by('id', 'desc');
		return $this->db->get();
	}

	public function save_category_relationships($data) {
		$this->db->insert_batch('dc_category_relationships', $data);
        
        if($this->db->affected_rows()>='1'){
			return  true;
		}
		else{
			return false;
		}
	}

	public function check_category($id){
		$this->db->select('*');
		$this->db->from('dc_category_relationships');
		$this->db->where('post_id', $id);
		return $this->db->get();
	}

	public function delete_category_relationships($post_id,$category_id){
		$this->db->where('post_id', $post_id);
		$this->db->where('category_id', $category_id);
		$this->db->delete('dc_category_relationships');
		if($this->db->affected_rows()>='1'){
			return true;
		}
		else{
			return false;
		}
	}
}

