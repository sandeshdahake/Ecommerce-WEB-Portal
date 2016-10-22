<?php
require(APPPATH.'/libraries/REST_Controller.php');
class ProductAPI extends REST_Controller {
	
	
	function product_get() {
		if(!$this->get('id')){
            $this->response(NULL, 400);
        }
		$this->load->library('SmartPriceClientServices');
		$data = $this->smartpriceclientservices->getProduct($this->get('id'));
		if($data){
			$this->response($data, 200);
		}
		else
			$this->response(NULL, 400);
	}
	
	
	/*-------------------------------------------- Home page services ---------------------------------------------------------------**/
	/*
	 *@Description		: Returns featured products list
	 */
	function featured_products_get(){
		$this->load->library('SmartPriceClientServices');
		$data = $this->smartpriceclientservices->getFeaturedProducts();
		$this->response($data, 200);
	}
	
	/*
	 *@Description		: Returns popular products list
	 */
	function popular_products_get(){
		$this->load->library('SmartPriceClientServices');
		$data = $this->smartpriceclientservices->getPopularProducts();
		$this->response($data, 200);
	}
	
	function homepage_slider_get(){
		$this->load->library('SmartPriceClientServices');
		$bannersList = $this->smartpriceclientservices->getSliderImages();
		
		if(count($bannersList) > 0){
			foreach($bannersList as $banner){
				$banner->Url = base_url(). 'assets/images/banners/'. $banner->Value;
				unset($banner->Key);
				unset($banner->Value);
			}
		}
		
		$this->response($bannersList, 200);
	}
}
?>