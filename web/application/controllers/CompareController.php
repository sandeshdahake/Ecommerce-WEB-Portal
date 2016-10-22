<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class CompareController extends My_SmartPriceController {

    function __construct() {
        parent::__construct();
    }
	
	function index($subcategory){
		$this->load->library('session');
		$this->load->helper('file');
		$this->load->library('SmartPriceClientServices');
		$compareProductsList = $_SESSION['compare_products_list'][$subcategory];
		$data = new StdClass();
		
		$data->products = $this->smartpriceclientservices->getProductsForCompare($compareProductsList);
		
		$subcategoryRec = $this->smartpriceclientservices->getSubcategoryRecord($subcategory);
		if(isset($subcategoryRec)){
			// get compare template metadata
			$data->template = $this->smartpriceclientservices->getSubcategoryCompareMetadata($subcategoryRec->Id);
			
			$this->middle = $this->load->view('client/compare', $data, true);
		}
		else{
			$this->middle = "<h1>Invalid Subcategory</h1>";
		}
			$this->layout();
	}
	
	function handleAddToCompare($subcategory){
		$this->load->library('session');
		$product = $this->input->get('product');
		
		$product = json_decode($product);
		$compareProductsList = array();
		/*
			compare rpoducts session management
		*/
		if(isset($_SESSION['compare_products_list'][$subcategory])){
			$compareProductsList = $_SESSION['compare_products_list'][$subcategory];
		}
		
		// check if product already exists
		// if exists remove product
		// else add product
		
		$productIndex = -1;
		for($i =0; $i < count($compareProductsList); $i++){
			if($compareProductsList[$i]->Id == $product->Id){
				$productIndex = $i;
				break;
			}
		}
		
		if($productIndex > -1){
			array_splice($compareProductsList,$productIndex , 1);
		}
		else{
			if($productIndex < 4)
			array_push($compareProductsList, $product);
		}
			
		$_SESSION['compare_products_list'][$subcategory] = $compareProductsList;
		echo json_encode($_SESSION['compare_products_list'][$subcategory]);
	}
	
	function getCompareAddedProducts($subcategory){
		if(isset($_SESSION['compare_products_list'][$subcategory])){
			echo json_encode($_SESSION['compare_products_list'][$subcategory]);
		}
		
	}
}
?>
