<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class AdminController extends My_SmartPriceController {

    function __construct() {
        parent::__construct();
    }

    function index() {
		if($this->checkSession()) {
			$this->load->library('form_validation');
			$this->load->library('SmartPriceAdminServices');
			$data = Array();
			
			// Below Data added for testing purpose
			$data["subcategory"] = array("CategoryId"=>1,
										 "Name"=>"Test25");
			$data["field1"] = array("Name"=>"Field1",
									"Label"=>"Field1",
									"DataType"=>"Text");
									
			$data["field2"] = array("Name"=>"Field2",
									"Label"=>"Field2",
									"DataType"=>"INT");
									
			
			$data = array();
			$this->middle = $this->load->view('admin/home', $data, true);
			$this->adminLayout();	
		}
		else{
			$this->login();
		}
    }
	public function subcategories(){
		if($this->checkSession()) {
			$this->load->library('SmartPriceAdminServices');
			$data['records'] = $this->smartpriceadminservices->getAllRecordsOf('productsubcategories');
			$this->middle = $this->load->view('admin/subcategories',$data,true);
			$this->adminLayout();
		}else{
			$this->login();
		}
	}
	public function filter(){
		if($this->checkSession()) {
			$this->load->library('SmartPriceAdminServices');
			$data['filters'] = $this->smartpriceadminservices->getAllRecordsOf('filters');
			$data['subcategories'] = $this->smartpriceadminservices->getAllRecordsOf('productsubcategories');
			$this->middle = $this->load->view('admin/filter',$data,true);
			$this->adminLayout();
		}else{
			$this->login();
		}
	}
	public function filterdetails(){
		if($this->checkSession()){
			$fid = $_GET['fid'];
			$table = 'filters';
			if($fid!=0){
				$this->load->library('SmartPriceAdminServices');
				$data = $this->smartpriceadminservices->getfilterdetails($fid);
				$this->middle = $this->load->view('admin/filterdetails',$data,true);
				$this->adminLayout();
			}
		}
		else{
			$this->login();
		}
	}
	public function updateFilterDetails(){
		$data = json_decode($this->input->post('data'));
		$this->load->library('SmartPriceAdminServices');
		echo $this->smartpriceadminservices->updateFilterDetails((array)$data);	
	}
	
	public function login(){
		if(!$this->checkSession()){
			$this->middle = $this->load->view('admin/login', null, true);
			$this->adminLayout();
		}
		else{
			$this->index();
		}
	}
	
	public function addsubcategory(){
		$data = json_decode($this->input->post('data'));
		$this->load->library('SmartPriceAdminServices');
		echo json_encode($this->smartpriceadminservices->insertSubcategory((array)$data));	
	}
	public function addfilter(){
		$data = json_decode($this->input->post('data'));
		$this->load->library('SmartPriceAdminServices');
		echo json_encode($this->smartpriceadminservices->insertFilter((array)$data));	
	}
	public function editsubcategory(){
		if($this->checkSession()){
			$sid = $_GET['sid'];
			$table = 'productsubcategories';
			if($sid!=0){
				$this->load->model('AdminModel');
				$data['Id']=$sid;
				$data['record'] = $this->AdminModel->getRecord($table,$data);
				$this->middle = $this->load->view('admin/editsubcategory',$data,true);
				$this->adminLayout();
			}
		}
		else{
			$this->login();
		}
	}
	public function updatesubcategory(){
		// json
		// create/delete/update  fields
		// 
		$data = json_decode($this->input->post('data'));
		$this->load->library('SmartPriceAdminServices');
		echo $this->smartpriceadminservices->updateSubcategory((array)$data);	
	}
	public function checkSession(){
		$this->load->library('session');
		if(isset($_SESSION['user'])){
			return true;
		}
		return false;
	}
}
?>