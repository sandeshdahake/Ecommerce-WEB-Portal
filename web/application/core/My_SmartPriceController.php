<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class My_SmartPriceController extends CI_Controller{
	function __construct()
    {
        parent::__construct();
        // do some stuff
		date_default_timezone_set('Asia/Kolkata');
    }
	
	var $data = array();
	
	//Load layout    
	public function layout() {
		$userSectionTemplate = null;
		if(isset($_SESSION['user'])){
			$user = $_SESSION['user'];
			if($user->Type == 'siteUser'){
				$uTemplateData = array();
				$uTemplateData['user'] = $user;
				$userSectionTemplate = $this->load->view('layouts/user/headerLoginSection', $uTemplateData, true);
			}
		}
		else{
			$userSectionTemplate = $this->load->view('layouts/user/headerLoginSection', null, true);
		}
		
		$this->data['userSectionTemplate'] = $userSectionTemplate;
		
		// making temlate and send data to view.
		$this->template['header']   = $this->load->view('layouts/client/header', $this->data, true);
		
		$this->template['middle'] = $this->middle;
		$this->template['footer'] = $this->load->view('layouts/client/footer', $this->data, true);
		$this->load->view('layouts/client/index', $this->template);
	}
	
	public function adminLayout(){
		// making temlate and send data to view.
		$this->template['header']   = $this->load->view('layouts/admin/header', $this->data, true);
		$this->template['middle'] = $this->middle;
		$this->template['footer'] = $this->load->view('layouts/admin/footer', $this->data, true);
		$this->load->view('layouts/admin/index', $this->template);
	}
}
?>