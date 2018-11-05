<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mlogin extends CI_Model {

	public $variable;

	public function __construct()
	{
		parent::__construct();

	}

	public function check_akun($akun){
		$this->db->select('*');
		$this->db->from('dc_users');
		$this->db->where('user_login', $akun['user_login']);
		$query = $this->db->get();
		
			if($query->num_rows() == 1){
				
				$data= $query->row();
		$hash = $data->user_password;
				if (password_verify($akun['user_password'], $hash)) {
					return $query->result();
				}else{
					return false;
				}
			}
			else{
				return false;
			}
	}
}