<?php
	if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class APIIntegrationLibrary{
		// flip kart configuration
		public $f_affiliateKey = "";
		public $f_affiliateToken = "";
		
		// Amazon configuration
		public $aws_access_key_id =  "";
		public $aws_secret_key = "";
		
		public function __construct(){
                // Assign the CodeIgniter super-object
            $this->CI =& get_instance();
				
        }
		
		public function getFlipkartProductNode($f_productId){
			$endPoint = "https://affiliate-api.flipkart.net/affiliate/1.0/product.json";
			$endPoint .= "?id=" . $f_productId;
			return array("Name" => "Flipkart", "url" => $endPoint, "headersArray" => array("Fk-Affiliate-Id: " . $this->f_affiliateKey, "Fk-Affiliate-Token: " .$this->f_affiliateToken));
		}
		
		public function getAmazonProductNode($asin){
			// The region you are interested in
			$endpoint = "webservices.amazon.in";
			$uri = "/onca/xml";

			$params = array(
				"Service" => "AWSECommerceService",
				"Operation" => "ItemLookup",
				"AWSAccessKeyId" => $this->aws_access_key_id,
				"AssociateTag" => "product marketing",
				"ItemId" => $asin,
				"IdType" => "ASIN",
				"ResponseGroup" => "Offers,Reviews",
				"Version" => "2015-10-01"
			);

			// Set current timestamp if not set
			if (!isset($params["Timestamp"])) {
				$params["Timestamp"] = gmdate('Y-m-d\TH:i:s\Z');
			}

			// Sort the parameters by key
			ksort($params);
			$pairs = array();
			foreach ($params as $key => $value) {
				array_push($pairs, rawurlencode($key)."=".rawurlencode($value));
			}
			// Generate the canonical query
			$canonical_query_string = join("&", $pairs);
			// Generate the string to be signed
			$string_to_sign = "GET\n".$endpoint."\n".$uri."\n".$canonical_query_string;
			// Generate the signature required by the Product Advertising API
			$signature = base64_encode(hash_hmac("sha256", $string_to_sign, $this->aws_secret_key, true));
			// Generate the signed URL
			$request_url = 'http://'.$endpoint.$uri.'?'.$canonical_query_string.'&Signature='.rawurlencode($signature);
			return array("Name" => "Amazon", "url" => $request_url, "headersArray" => null);
		}
		
		public function getAmazonProductDetails($aProductResponse){
			if($aProductResponse != NULL){
				$product = simplexml_load_string($aProductResponse);
				// die(json_encode($product));
				$aDetails = new stdClass();
				$currencyCode = $product->Items->Item->OfferSummary->LowestNewPrice->CurrencyCode;
				//echo $currencyCode;
				$aDetails->Price = new stdClass();
				if(isset($product->Items->Item->OfferSummary->LowestNewPrice->Amount)){
					$aDetails->Price->amount = intval($product->Items->Item->OfferSummary->LowestNewPrice->Amount/100);
					$aDetails->Price->currency = $currencyCode;
				}
				else return null;
				$aDetails->Sheeping = "Free Shiping";
				
				$aDetails->productUrl = $product->Items->Item->Offers->MoreOffersUrl;
				$aDetails->CodAvailable = "Cash on delivery available";
				$aDetails->DeliveryInfo = "2 - 4 days delivery";
				$aDetails->ReviewPageUrl = $product->Items->Item->CustomerReviews->IFrameURL;
				return $aDetails;
			}
		}
		
		public function getFlikartProductDetails($fproductResponse){
			//die($fproductResponse);
			if($fproductResponse != NULL){
				$product = json_decode($fproductResponse);
				$fdetails = new stdClass();
				if(isset($product->productBaseInfoV1->flipkartSpecialPrice)){
					$fdetails->Price = $product->productBaseInfoV1->flipkartSpecialPrice;
				}
				else $fdetails->Price = $product->productBaseInfoV1->flipkartSellingPrice;
				
				$fdetails->Sheeping ="";
				if($product->productShippingInfoV1->shippingCharges->amount == 0.0){
					 $fdetails->Sheeping = "Free Shipping";
				}	
				else{
					
				}
				// In stock
				if($product->productBaseInfoV1->inStock){
					$fdetails->InStock = "In stock";
				}
				else{
					$fdetails->InStock = "Not in stock";
				}
				
				// Cash on delivery
				$fdetails->CodAvailable = "-";
				if($product->productBaseInfoV1->codAvailable){
					$fdetails->CodAvailable = "Cash on delivery";
				}
				$fdetails->DeliveryInfo ="";
				if(trim($product->productShippingInfoV1->estimatedDeliveryTime) != ""){
					$fdetails->DeliveryInfo = "3 - 5 Days delivery";
				}
				$fdetails->productUrl = $product->productBaseInfoV1->productUrl;
				$fdetails->ReviewPageUrl = "https://www.flipkart.com/".str_replace(" ", "-",$product->productBaseInfoV1->title)."/product-reviews/itm?pid=".$product->productBaseInfoV1->productId;
				//die(json_encode($product));
				return $fdetails;
			}
		}
		
		public function getProductFromAvailableStores($productId){
			$this->CI->load->model('SmartPriceAppModel');
			$productWebstoreDetails = $this->CI->SmartPriceAppModel->getProductWebStoreDetails($productId);
			$allWebStores = $this->CI->SmartPriceAppModel->getWebstoresInfo();
			//die(json_encode($allWebStores));
			// List to store nodes
			$nodesList = array();
			if(count($productWebstoreDetails) > 0){
				// node for each store
				foreach($productWebstoreDetails as $webstore => $detail){
					$webstore = strtolower($webstore);
					switch($webstore){
						case 'flipkart' : 
							$node = $this->getFlipkartProductNode($detail->WebstoreProductId);
							array_push($nodesList, $node);
							break;
						case 'amazon' : 
							$node = $this->getAmazonProductNode($detail->WebstoreProductId);
							array_push($nodesList, $node);
							break;
					}
					
				}
				
				$this->CI->load->helper('curl');
				$results  = executeParallelCallOuts($nodesList);
				
				$logosBasePath = base_url().'assets/images/webstoreslogos/';
				$productDetailsFromStoresList = array();
				if($results != NULL){
					foreach($results as $webstore => $details){
						switch($webstore){
							case 'Flipkart' : 
								$product = $this->getFlikartProductDetails($details);
								if($product){
									$product->storeLogo = $logosBasePath. $allWebStores['Flipkart']->LogoUrl;
									$product->label = $allWebStores['Flipkart']->Label;
								}
								break;
								
							case 'Amazon' :
								$product = $this->getAmazonProductDetails($details);
								if($product){
									$product->storeLogo = $logosBasePath. $allWebStores['Amazon']->LogoUrl;
									$product->label = $allWebStores['Amazon']->Label;
								}
								break;
						}
						if(isset($product) && $product){
							array_push($productDetailsFromStoresList, $product);
						}
					}
				}
				usort($productDetailsFromStoresList, function ($a, $b){
					return $a->Price->amount > $b->Price->amount;
				});
				return $productDetailsFromStoresList;
			}
			return null;
		}
	}	
?>