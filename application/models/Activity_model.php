<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 
*/
class Activity_model extends CI_Model
{
	
	public function select($sql,$data=""){

		$result = $this->db->query($sql,$data)->result_array();
		return $result;
	}

	public function edit($data){
		var_dump($data);
		$this->db->where('id',$data['id']);
		$status1=$this->db->update('activity',array('picture' => $data['picture'] ));
		if($status){
			return 'true';
		}
		return 'false';
	}

	public function insert($data){

		$status=$this->db->insert('activity',$data);
		if($status){
			return $this->db->insert_id();
		}
		return 0;

	}

}