<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Privacy_Policies extends My_SmartPriceController {

    function __construct() {
        parent::__construct();
		$this->load->library('SmartPriceClientServices');
    }

    function index(){
		$data['name'] = 'Privacy Policy';
		$data['content'] = $this->load->view("client/terms_and_conditions", $data, true);
		
		$data['headingBanner'] = $this->load->view("client/headingBanner", $data, true);
		$this->middle = $this->load->view("client/about_us_format", $data, true);
		$this->layout();
    }
}
?>