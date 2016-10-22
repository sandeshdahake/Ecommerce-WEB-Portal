<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class SubcategoryControllerNew extends My_SmartPriceController {

    function __construct() {
        parent::__construct();
		$this->load->library('SmartPriceClientServices');
    }

    function index($subcategory){
		$data = (Object)array('params');
		$data->params = $this->uri->uri_to_assoc(4);
		
		$subcategoryRecord = $this->smartpriceclientservices->getSubcategoryRecord($subcategory);
		if($subcategoryRecord){
			$data->filtersList = $this->smartpriceclientservices->getFilters($subcategoryRecord->Id);
			$data->filtersView = $this->load->view("client/filters_list", $data, true);
			
			$category = array('name' => $subcategory);
			
			$data->headingBanner = $this->load->view("client/headingBanner",$category , true);
			$data->subcategoryName= $subcategory;
			
			$this->middle = $this->load->view("client/products_list", $data, true);
		}
		else{
			$this->middle = "Invalid Category";
		}
		$this->layout();
    }
	
	function products($subcategory){
		$params = $this->input->get('filters');
		$params = urldecode($params);
		$sortBy = "popularity";
		$sortOrder = "ASC";
		
		$params = explode("&", $params, 20);
		$filtrsArr = [];
		foreach($params as $param){
			$keyVal  = explode("=", $param, 20);
			if($keyVal[1]){
				$filtrsArr[$keyVal[0]] = $keyVal[1];
			}
		}
		
		$sorting = $filtrsArr["sortby"];
		if(isset($filtrsArr["pageNumber"])){
			$pageNumber = (Integer)$filtrsArr["pageNumber"];
		}
		else{
			$pageNumber = 1;
		}
		unset($filtrsArr["sortby"]);
		
		
		switch($sorting ){
			case "priceLowToHigh":
				$sortBy = "Price";
				$sortOrder = "ASC";
				break;
			case "priceHighToLow":
				$sortBy = "Price";
				$sortOrder = "DESC";
				break;
			case "popularity":
				$sortBy = "Popularity";
				$sortOrder = "DESC";
				break;
		}
		
		$data = (Object)array("products");
		$data->productsList = $this->smartpriceclientservices->getProducts($subcategory, $filtrsArr, $pageNumber, $pageSize=21, $sortBy, $sortOrder);
		//$products = $this->load->view('client/products_list_view1', $data, true);
		echo json_encode($data->productsList);
	}
	
	
	
	function filters($subcategory){
		$subcategoryRecord = $this->smartpriceclientservices->getSubcategoryRecord($subcategory);
		if($subcategoryRecord){
			echo json_encode($this->smartpriceclientservices->getFilters($subcategoryRecord->Id));
		}
	}
}
?>