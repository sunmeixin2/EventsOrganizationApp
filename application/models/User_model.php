<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

/**
* 
*/
class User_model extends CI_Model
{
	
	public function select($sql,$data=""){

		$result = $this->db->query($sql,$data)->result_array();
		return $result;
	}

	public function insert($data){
		$status=$this->db->insert('user',$data);
		if($status){
			return 'true';
		}
		return 'false';
	}
	public function delete(){

	}
	public function update(){

	}
}





?>