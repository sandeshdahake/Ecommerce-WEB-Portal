<?php

class SmartPriceAppModel extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get_product_images($product_id){
		$this->db->start_cache();
		$this->db->select('*');
		$this->db->from('productimages');
		$this->db->where('ProductId', $product_id );
		$this->db->stop_cache();
		$query = $this->db->get();
		$this->db->flush_cache();
		if ( $query->num_rows() > 0 ){
			$imagesList = array();
			foreach($query->result() as $imageRec){
				array_push($imagesList, (Object)$imageRec);
			}
			return $imagesList;
		}
		return null;
    }
	

	function get_product_details($productId){
		// get product subcategory record
		$subcategoryRecordsList = $this->getProductSubcategoryRecord($productId);
		
		$subcategoryRecord = $subcategoryRecordsList;
		if($subcategoryRecord != NULL){
			$this->db->start_cache();
			$this->db->select('*');
			$this->db->from('products');
			$this->db->where('products.Id', $productId);
			$this->db->join($subcategoryRecord->Name, $subcategoryRecord->Name . ".ProductId = products.Id");
			$this->db->stop_cache();
			$query = $this->db->get();
			$this->db->flush_cache();
			if ( $query->num_rows() > 0 ){
				//return (Object)$query->result()[0];
				$productsList = array();
				foreach($query->result() as $row){
					array_push($productsList, (Object)$row );
				}
				$imagesList = $this->get_product_images($productId);
				$productsList = relateRecords($productsList, 'ProductId', $imagesList, "ProductId", 'images');
				//die(json_encode($productsList));
				return $productsList[0];
			}
		}
		return null;
	}
	
	function getProductSubcategoryRecord($productId){
		$this->load->helper('Object');
		$this->db->start_cache();
		$this->db->select('productsubcategories.Id, productsubcategories.Name, productsubcategories.Label');
		$this->db->from('products');
		$this->db->where('products.Id', $productId );
		$this->db->join('productsubcategories',  'products.SubcategoryId = productsubcategories.Id');
		$this->db->stop_cache();
		$query = $this->db->get();
		$this->db->flush_cache();
		
		if ( $query->num_rows() >0 ){
			return (object)$query->result()[0];
		}
		else{
			return NULL;
		}
		
	}
	
	/**
	 *@Description	: retrieves subcategory record from subcategory name
	 *@Parameters	: subcategory name
	 *@Returns		: subcategory record
	 */
	function get_subcategory_record($subcategoryName){
		$this->db->start_cache();
		$this->db->select('*');
		$this->db->from('productsubcategories');
		$this->db->where('productsubcategories.Name', $subcategoryName );
		$this->db->limit(1);
		$this->db->stop_cache();
		$query = $this->db->get();
		$subcategoryRecord = null;
		if ( $query->num_rows() == 1 ){
			$subcategoryRecord = (Object)$query->result()[0];
		}
		$this->db->flush_cache();
		return $subcategoryRecord;
	}
	
	/*
	 *@Desc			: Returns filters with related detail records list
	 *@Parameters	: subcategory id
	 */
	function get_subcategory_filters($subcategory_id){
		$this->db->start_cache();
		$this->db->select('*');
		$this->db->from('filters');
		$this->db->where('ParentSubcategoryId', $subcategory_id );
		$this->db->stop_cache();
		$query = $this->db->get();
		$this->db->flush_cache();
		if ( $query->num_rows() >0 ){
			$filtersList = (Object)$query->result();
		}
		else{
			return NULL;
		}
		
		$listIds = array();
		foreach($filtersList as $filter ){
			array_push($listIds, $filter->Id);
		}
		$this->db->start_cache();
		$this->db->select('*');
		$this->db->from('filterdetails');
		$this->db->where_in('FilterId', $listIds);
		$this->db->order_by('Priority');
		
		$this->db->stop_cache();

		$query = $this->db->get();
		if($query->num_rows() >0){
			$filtersDeails = (Object)$query->result();
			$this->load->helper('Object');
			$filtersList = relateRecords($filtersList, 'Id', $filtersDeails, "FilterId", 'details');
		}
		$this->db->flush_cache();

		return $filtersList;
	}
	
	/**
	 *@Description	: retrieves products with specified subcategory and filters
	 *@Parameters	: subcategory name, filters list
	 *@Returns		: products list
	 */
	function get_products($subcategory, $filtersToApplyList, $pageNumber, $pageSize, $sortBy, $sortOrder){
		if($pageNumber < 1){
			$pageNumber = 1;
		}
		$this->load->helper('Object');
		$this->load->helper('CompareDunia');
		// get subcategory record
		$subcategoryRecord = $this->get_subcategory_record($subcategory);
		// get available filters
		$availableFilters = $this->get_subcategory_filters($subcategoryRecord->Id );
		// return json_encode($availableFilters);
		$clausesString = createWhereClauseFromFilters($filtersToApplyList, $availableFilters);
		
		$selectSubcategoryPropertiesQuery = '';
		$hotPropertiesList = $this->getHotProperties($subcategoryRecord->Id);
		
		// hot properties querygenerate
		$totalHotPropertiesCount = count($hotPropertiesList);
		if($totalHotPropertiesCount > 0){
			for($i = 0; $i<$totalHotPropertiesCount; $i++){
				$selectSubcategoryPropertiesQuery .= ($subcategoryRecord->Name . "." . $hotPropertiesList[$i]->PropertyName);
				if($i < $totalHotPropertiesCount-1 ){
					$selectSubcategoryPropertiesQuery .= ", ";
				}
			}
		}
		$selectQuery = 'products.Id, products.Price, products.Name, products.Image, AVG(userratings.Rating) as Rating, products.IsBestSeller';
		if($selectSubcategoryPropertiesQuery){
			$selectQuery .= ", ".$selectSubcategoryPropertiesQuery;
		}
		if($subcategoryRecord != null){
			$response = new stdClass();
			$response->Summary = new stdClass();
			
			$this->db->start_cache();
			$this->db->select($selectQuery );
			$this->db->from('products');
			$this->db->join($subcategoryRecord->Name, $subcategoryRecord->Name.'.ProductId = products.Id', 'RIGHT');
			$this->db->join('userratings', 'products.Id = userratings.ProductId', 'RIGHT');
			$this->db->where('products.SubcategoryId', $subcategoryRecord->Id );
			if($clausesString != NULL){
				$this->db->where($clausesString);
			}
			$this->db->group_by('products.Id');
			
			if(isset($sortBy) && $sortBy !=""){
				$this->db->order_by('products.'.$sortBy, $sortOrder);
			}
			
			$this->db->stop_cache();
			$query = $this->db->get();
		}
		
		$response->hotProperties = $hotPropertiesList;
		$response->Summary->PageSize = $pageSize;
		$response->Summary->PageNumber = $pageNumber;
		
		$this->db->flush_cache();
		$response->Products = array();
		if ( $query->num_rows() > 0 ){
			$response->Summary->TotalProducts = $query->num_rows();
			$limit = ($pageNumber-1)*$pageSize + $pageSize;
			if($response->Summary->TotalProducts < $limit ){
				$limit = $response->Summary->TotalProducts ;
			}
			for($i = ($pageNumber-1)*$pageSize ; $i < $limit; $i++){
				array_push($response->Products, (object)$query->result()[$i]);
			}
			
		}
		return $response;
	}
	
	function getProductWebStoreDetails($productId){
		$this->db->start_cache();
		$this->db->select('*');
		$this->db->from('productwebstores');
		$this->db->where('ProductId', $productId );
		$this->db->stop_cache();
		$query = $this->db->get();
		$this->db->flush_cache();
		$webStoreProductDetailsList = array();
		if ( $query->num_rows() >0 ){
			foreach($query->result() as $webStoreProductDetails){
				$webStoreProductDetailsList[$webStoreProductDetails->WebstoreLabel] = (Object)$webStoreProductDetails;
			 }
			 return $webStoreProductDetailsList;
		}
		else{
			return NULL;
		}
	}
	
	function updateProductPrice($productId, $minPrice){
		if(isset($productId) && isset($minPrice)){
			$data=array('Price' => $minPrice);
			$this->db->where('Id', $productId);
			$this->db->update('products',$data);
		}
	}
	
	/**
	 *@Purpose		: increases products popularity
	 *@Parameter	: Product Id
	 */
	function incrementProductPopularity($productId){
		if(isset($productId)){
			$this->db->where('Id', $productId);
			$this->db->set('Popularity', 'Popularity+1', FALSE);
			$this->db->update('products');
		}
	}
	
	function getProductSuggestions($key){
		$key = urldecode($key);
		$this->db->start_cache();
		$this->db->select('Id, Name');
		$this->db->from('products');
		$this->db->like('Name',$key);
		$this->db->limit(7);
		$this->db->stop_cache();
		$query = $this->db->get();
		$this->db->flush_cache();
		
		$productsList = array();
		if ( $query->num_rows() > 0 ){
			foreach($query->result() as $product){
				array_push($productsList, (Object)$product);
			}
			return $productsList;
		}
		else{
			return NULL;
		}
	}
	
	/**
	 *@Purpose		: increases products popularity
	 *@Parameter	: Product Id
	 */
	function getHotProperties($subcategoryId){
		$this->db->start_cache();
		$this->db->select('*');
		$this->db->from('subcategoryhotproperties');
		$this->db->where('SubcategoryId', $subcategoryId);
		$this->db->stop_cache();
		$query = $this->db->get();
		$this->db->flush_cache();
		
		$hotPropertiesList = array();
		if ( $query->num_rows() > 0 ){
			foreach($query->result() as $hotProperty){
				array_push($hotPropertiesList, (Object)$hotProperty);
			}
			return $hotPropertiesList;
		}
		else{
			return NULL;
		}
	}
	
	function getSimilarProducts($productId){
		$product = $this->getProduct($productId);
		$maxPrice = (float)$product->Price + 2000;
		$minPrice = (float)$product->Price - 2000;
		$this->db->start_cache();
		$this->db->select('products.Id, products.Price,products.Name, products.Image, AVG(userratings.Rating) as Rating, products.IsBestSeller');
		$this->db->from('products');
		$this->db->join('userratings', 'products.Id = userratings.ProductId', 'RIGHT');
		$this->db->group_by('products.Id');
		$this->db->where('products.Price >= '.$minPrice .' AND products.Price <= '.$maxPrice); 
		$this->db->where('products.Id != '.$productId);
		$this->db->where('products.SubcategoryId', (int)$product->SubcategoryId);
		$this->db->limit(8);
		$this->db->stop_cache();
		$query = $this->db->get();
		$this->db->flush_cache();
		
		$productsList = array();
		if ( $query->num_rows() > 0 ){
			foreach($query->result() as $product){
				array_push($productsList, (Object)$product);
			}
			return $productsList;
		}
		else{
			return NULL;
		}
	}
	
	function getProduct($productId){
		$this->db->start_cache();
		$this->db->select('Price, SubcategoryId');
		$this->db->from('products');
		$this->db->where('Id', $productId);
		$this->db->stop_cache();
		$query = $this->db->get();
		$this->db->flush_cache();
		if ($query->num_rows() == 1){
			return (Object)$query->result()[0];
		}
		else return null;
	}
	
	function getWebstoresInfo(){
		$this->db->start_cache();
		$this->db->select('*');
		$this->db->from('webstores');
		$this->db->stop_cache();
		$query = $this->db->get();
		$this->db->flush_cache();
		$webStores = array();
		if ($query->num_rows()>0){
			foreach($query->result() as $webStore){
				//$map = array($webStore->Name => $webStore);
				$webStores[$webStore->Name] = $webStore;
			}
			return $webStores;
		}
		else return null;
	}
	
	function getSubcategoryPropertyDetailsMetadata($subcategoryId){
		$this->db->start_cache();
		$this->db->select('*');
		$this->db->from('productsubcategories');
		$this->db->where('Id', $subcategoryId);
		$this->db->stop_cache();
		$query = $this->db->get();
		$this->db->flush_cache();
		
		if ($query->num_rows() == 1){
			return $query->result()[0]->MetadataFile;
				
		}
		else return null;
	}
	
	function getSubcategoryCompareMetadata($subcategoryId){
		$this->db->start_cache();
		$this->db->select('*');
		$this->db->from('productsubcategories');
		$this->db->where('Id', $subcategoryId);
		$this->db->stop_cache();
		$query = $this->db->get();
		$this->db->flush_cache();
		
		if ($query->num_rows() == 1){
			return $query->result()[0]->CompareMetadataFile;
				
		}
		else return null;
	}
	
}

?>