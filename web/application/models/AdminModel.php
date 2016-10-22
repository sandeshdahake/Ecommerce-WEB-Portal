<?php

class AdminModel extends CI_Model {

    public function __construct()
	{
        $this->load->database();
    }
	
	public function insertSubcategory($data){
		
		
		// Transaction Start
		$this->db->trans_start();
		
		$record = $this->insertRecord("productsubcategories",$data);
		
		// create table for subcategory
		$this->createTable($data);
		
		return $record;
		// Transaction Completed
		$this->db->trans_complete();
		return null;
	}
	public function insertfilter($data){

		$record = $this->insertRecord("filters",$data);
		return $record;
		
	}
	public function insertfilterdetails($data){
		
		// Transaction Start
		$this->db->trans_start();
		$record = $this->insertRecord("filterdetails",$data);
		
		// create table for subcategory
		$this->createTable($data);
		
		return $record;
		// Transaction Completed
		$this->db->trans_complete();
		return null;
	}
	
	//public function insertSubcategoryProperties();
	//public function updateSubcategoryProperties();
	
	public function createTable($data){
		
		// Load DatabaseForge Model
		$this->load->model('DatabaseForgeModel');
		$this->DatabaseForgeModel->createSubcategoryTable($data);
	}
	
	
	public function insertRecord($table,$data){
		$this->db->insert($table,$data);
		return $this->getRecord($table,$data);
	}
	public function insertRecords($table,$data){
		return $this->db->insert_batch($table,$data);
	}
	public function getRecord($table,$data){
		$this->db->select("*");
		$this->db->from($table);
		$this->db->where($data);
		return $this->db->get()->row();
	}
	public function getRecords($table,$data){
		$this->db->select("*");
		$this->db->from($table);
		$this->db->where($data);
		return $this->db->get()->result();
	}
	public function getAllRecords($table){
		$this->db->select("*");
		$this->db->from($table);
		return $this->db->get()->result();
	}
	public function update_batch($table,$data,$field){
		return $this->db->update_batch($table,$data,$field);
	}
	
}

?>