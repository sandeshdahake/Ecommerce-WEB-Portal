<?php
	if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class SmartPriceClientServices{
		
		public function __construct(){
                // Assign the CodeIgniter super-object
                $this->CI =& get_instance();
				$this->CI->load->model('SmartPriceAppModel');
        }
		
		
		public function getProduct($product_id){
			$this->CI->load->library("APIIntegrationLibrary");
			$product = new StdClass();
			$product->Properties = $this->CI->SmartPriceAppModel->get_product_details($product_id);
			$product->webStoreProductDetails = $this->CI->apiintegrationlibrary->getProductFromAvailableStores($product_id);
			//echo json_encode($product);
			if(count($product->webStoreProductDetails) > 0){
				$minPrice = 999999999999999;
				if(count($product->webStoreProductDetails) > 0 ){
					foreach($product->webStoreProductDetails as $webstore => $webstoreProduct){
						//die(json_encode($product->webStoreProductDetails));
						if($webstoreProduct->Price->amount < $minPrice){
							$minPrice = $webstoreProduct->Price->amount;
							$minPriceWebstore = $webstoreProduct;
							$minPriceWebstore->storeName = $webstore;
						}
					}
					$this->CI->SmartPriceAppModel->updateProductPrice($product_id, $minPrice);
					$product->Properties->MinPriceWebstore = $minPriceWebstore;
				}
				
			}
			return $product;
		}
		
		
		public function getProductsForCompare($productList){
			$this->CI->load->model('CompareModel');
			return $this->CI->CompareModel->getProductsForCompare($productList);
		}
		
		
		public function getProductSuggestions($key){
			
			return $this->CI->SmartPriceAppModel->getProductSuggestions($key);
		}
		
		/*
		 *@Description		: Returns featured products list
		 */
		public function getFeaturedProducts(){
			$this->CI->load->model('HomePageModel');
			$featuredProducts = $this->CI->HomePageModel->getProducts('FeaturedProduct');
			return $featuredProducts;
		}
		
		/*
		 *@Description		: Returns popular products list
		 */
		public function getPopularProducts(){
			$this->CI->load->model('HomePageModel');
			$popularProducts = $this->CI->HomePageModel->getProducts('PopularProduct');
			return $popularProducts;
			//die(json_encode($popularProducts));
		}
		
		public function getSliderImages(){
			$this->CI->load->model('HomePageModel');
			$popularProducts = $this->CI->HomePageModel->getBanners();
			return $popularProducts;
		}
		
		function getSubcategoryRecord($subcategoryName){
			$this->CI->load->model('SmartPriceAppModel');
			return $this->CI->SmartPriceAppModel->get_subcategory_record($subcategoryName);
		}
		
		public function getFilters($subcategory_id){
			$this->CI->load->model('SmartPriceAppModel');
			$product_filters = $this->CI->SmartPriceAppModel->get_subcategory_filters($subcategory_id);
			return $product_filters;
		}
		
		public function getProducts($subcategory, $filtersArray, $pageNumber, $pageSize, $sortBy, $sortOrder){
			$this->CI->load->model('SmartPriceAppModel');
			$productResponse = $this->CI->SmartPriceAppModel->get_products($subcategory, $filtersArray, $pageNumber, $pageSize, $sortBy, $sortOrder);
			if($productResponse){
				if(count($productResponse->Products) > 0 && count($productResponse->hotProperties) > 0){
					foreach($productResponse->Products as $product){
						foreach($product as $productProperty => $productPropertyValue){
							foreach($productResponse->hotProperties as $hotProperty){
								if($hotProperty->PropertyName == $productProperty){
									$product->{$productProperty} = $this->createProductPropertyValueForHotProperty($hotProperty, $productPropertyValue);
								}
							}
						}
					}
				
					foreach($productResponse->hotProperties as $hotProperty){
						unset($hotProperty->PrependText);
						unset($hotProperty->AppendText);
						unset($hotProperty->Id);
						unset($hotProperty->SubcategoryId);
					}
				}
				return $productResponse;
			}
			else{
				return null;
			}
			
		}
		
		public function getSubcategoryPropertyDetailsMetadata($subcategoryId){
			$this->CI->load->helper('file');
			$filename = $this->CI->SmartPriceAppModel->getSubcategoryPropertyDetailsMetadata($subcategoryId);
			return json_decode( read_file(base_url().'assets/' .$filename));
		}
		
		public function getSubcategoryCompareMetadata($subcategoryId){
			$this->CI->load->helper('file');
			$filename = $this->CI->SmartPriceAppModel->getSubcategoryCompareMetadata($subcategoryId);
			return json_decode( read_file(base_url().'assets/' .$filename));
		}
		
		function createProductPropertyValueForHotProperty($hotProperty, $productPropertyValue){
			if(trim($productPropertyValue)){
				return $hotProperty->PrependText . " " . $productPropertyValue . " " .$hotProperty->AppendText;
			}
			return '';
		}
		
		public function incrementProductPopularity($productId){
			$this->CI->load->model('SmartPriceAppModel');
			return $this->CI->SmartPriceAppModel->incrementProductPopularity($productId);
		}
		
		public function getSimilarProducts($productId){
			$this->CI->load->model('SmartPriceAppModel');
			return $this->CI->SmartPriceAppModel->getSimilarProducts($productId);
		}
		
		public function getProductReviews($productId){
			$this->CI->load->model('UserRatingReviewModel');
			return $this->CI->UserRatingReviewModel->getProductReviews($productId);
		}
		
	
	}
?>