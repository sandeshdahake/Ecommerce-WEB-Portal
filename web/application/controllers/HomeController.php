<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class HomeController extends My_SmartPriceController {

    function __construct() {
        parent::__construct();
    }

    function index() {
		$this->load->library('SmartPriceClientServices');
		$this->load->helper('CompareDunia');
		$data = array();
		$data['menu'] = $this->load->view('client/subcategorynavigation', null, true);
		
		// featured products
		$featuredProductsList = $this->smartpriceclientservices->getFeaturedProducts();
		
		if(isset($featuredProductsList) && count($featuredProductsList) > 0){
			forEach($featuredProductsList as $product){
				$product->Price = moneyFormatIndia((integer)$product->Price);
			}
		}
		
		$featuredProductsView = array("ListName" => "New Products", "Products" => $featuredProductsList);
		
		$data['featuredProducts'] = $this->load->view('client/products_list_view', $featuredProductsView, true);
		
		// popular products
		$popularProductsList = $this->smartpriceclientservices->getPopularProducts();
		
		if(isset($popularProductsList) && count($featuredProductsList) > 0){
			forEach($popularProductsList as $product){
				$product->Price = moneyFormatIndia((integer)$product->Price);
			}
		}
		$popularProductsView = array("ListName" => "Popular Products", "Products" => $popularProductsList);
		$data['popularProducts'] = $this->load->view('client/products_list_view', $popularProductsView, true);
		
		
		
		// banners
		$bannersList = array("banners" => $this->smartpriceclientservices->getSliderImages());
		$data['slider'] = $this->load->view('client/slider', $bannersList, true);
		$data['singleCaerosel'] = $this->load->view('client/singleCaerosel', null, true);
		
		$data['highlights'] = $this->load->view('client/highlights', null, true);
		$data['suscribeSection'] = $this->load->view('client/subscribe_template', null, true);
		$data['brandCaerosel'] = $this->load->view('client/brand_caerosel', null, true);
		
		$this->middle = $this->load->view('client/home', $data, true);
		$this->layout();
    }
	
	function addToSubscribe($email){
		$email = urldecode($email);
		$this->load->model('HomePageModel');
		echo $this->HomePageModel->addToSubscribe($email);
	}
}
?>