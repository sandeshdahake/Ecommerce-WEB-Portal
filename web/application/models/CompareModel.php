<?php

class CompareModel extends CI_Model {

    function __construct() {
        parent::__construct();
    }

	function getProductsForCompare($productsList){
		if(count($productsList) > 0){
			// get product subcategory record
			$subcategoryRecord = $this->getProductSubcategoryRecord($productsList[0]->Id);
			$productIdsList = array();
			if(count($productsList) > 0){
				foreach($productsList as $product){
					array_push($productIdsList, $product->Id);
				}
			}
			
			$this->load->helper('Object');
			if($subcategoryRecord != NULL){
				$this->db->start_cache();
				$this->db->select('*');
				$this->db->from('products');
				$this->db->where_in('products.Id', $productIdsList);
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
					
					//die(json_encode($productsList));
					return $productsList;
				}
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
}

?>