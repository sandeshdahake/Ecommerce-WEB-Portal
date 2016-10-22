<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class ProductController extends My_SmartPriceController {

    function __construct() {
        parent::__construct();
    }

    function details($id){
		$this->load->helper('CompareDunia');
		$this->load->library('SmartPriceClientServices');
		$data = new StdClass();
		$data = $this->smartpriceclientservices->getProduct($id);
		if($data->Properties != null){
			$data->Properties->Price = moneyFormatIndia((integer)$data->Properties->Price);
			$this->smartpriceclientservices->incrementProductPopularity($id);
			
			// get featured products
			$products = array("listName" => "Featured Products");
			$products["productsList"] = $this->smartpriceclientservices->getFeaturedProducts();
			$data->featuredProducts = $this->load->view('client/productsVertcalList', $products, true);
			unset($products);
			
			// get new products
			$products = array("listName" => "Popular Products");
			$products["productsList"] = $this->smartpriceclientservices->getFeaturedProducts();
			$data->popularProducts = $this->load->view('client/productsVertcalList', $products, true);
			
			
			// get subcategory metada
			$propertiesMetadata['groupsList'] = $this->smartpriceclientservices->getSubcategoryPropertyDetailsMetadata($data->Properties->SubcategoryId);
			$propertiesMetadata['productDetails'] = $data->Properties;
			//echo json_encode($propertiesMetadata);
			$data->propertiesDetailTable = $this->load->view('client/products/mobile-details-template', $propertiesMetadata, true);
			
			$popularProductsList = array("ListName" => "Similar Products", "Products" => $this->smartpriceclientservices->getSimilarProducts($id));
			$data->similarProducts = $this->load->view('client/products_list_view', $popularProductsList, true);
			
			$reviewsWrapper["reviewsList"] = $this->smartpriceclientservices->getProductReviews($id);
			$reviewsWrapper["productId"] = $id;
			$data->reviewTemplate = $this->load->view('client/reviewForm', $reviewsWrapper , true);
			
			$this->middle = $this->load->view('client/product_details', $data, true);
		}
		else{
			$this->middle = "<div class='container'><h1>No Product Found</h1></div>";
		}
		$this->layout();
    }
	
	public function productSuggestions($key){
		$this->load->library('SmartPriceClientServices');
		echo json_encode($this->smartpriceclientservices->getProductSuggestions($key));
	}
	
	public function createReviewRec(){
		$this->load->model('UserRatingReviewModel');
		$review = $this->input->post('data');
		$review["UserId"] = $_SESSION['user']->Id;
		$this->UserRatingReviewModel->createProductReview($review);
	}
}
?>