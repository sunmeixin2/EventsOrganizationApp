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

}