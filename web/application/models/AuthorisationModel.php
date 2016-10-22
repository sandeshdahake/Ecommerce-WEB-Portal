<?php

class AuthorisationModel extends CI_Model {

    function __construct() {
        parent::__construct();
    }
	
	public function getUserFromEmail($email){
		$this->db->start_cache();
		$this->db->select('*');
		$this->db->from('users');
		$this->db->where('Email', $email);
		$this->db->stop_cache();
		$query = $this->db->get();
		$this->db->flush_cache();
		if ( $query->num_rows() > 0 ){
			return (Object)$query->result()[0];
		}
		return null;
	}

	public function getUser($email, $password){
		$this->db->start_cache();
		$this->db->select('*');
		$this->db->from('users');
		$this->db->where('Email', $email);
		$this->db->where('Password', $password);
		$this->db->stop_cache();
		$query = $this->db->get();
		$this->db->flush_cache();
		if ( $query->num_rows() > 0 ){
			return (Object)$query->result()[0];
		}
		return null;
	}
	
	public function createNewUser($userDetails){
		
		$this->db->insert('users', $userDetails);
		$insert_id = $this->db->insert_id();
		return  $insert_id;
	}
}
?>