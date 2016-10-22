<?php

class HomePageModel extends CI_Model {

    function __construct() {
        parent::__construct();
    }
	
	/*
	 *@Description		: Returns Products list depending on key, from additional details table
	 *@Valid key		: PopularProduct, FeaturedProduct
	 */
    function getProducts($key){
		$this->db->start_cache();
		$this->db->select('products.Id, Name, Key, Value, Image, Price, IsBestSeller, AVG(NULLIF(userratings.Rating, 0)) as Rating');
		$this->db->from('additionalstuff');
		$this->db->join('products', 'CAST(additionalstuff.Value AS SIGNED INTEGER) = products.Id');
		$this->db->join('userratings', 'products.Id = userratings.ProductId');
		$this->db->where('additionalstuff.Type', $key);
		$this->db->group_by('products.Id');
		$this->db->order_by('additionalstuff.Priority', 'ASC');
		$this->db->stop_cache();
		$query = $this->db->get();
		$this->db->flush_cache();
		if ( $query->num_rows() > 0 ){
			$featuredProductsList = array();
			foreach($query->result() as $row){
				array_push($featuredProductsList, (Object)$row);
			}
			return $featuredProductsList;
		}
		return null;
	}
	
	public function getBanners(){
		$this->db->start_cache();
		$this->db->select('Key, Value, Priority, ExtraParam');
		$this->db->from('additionalstuff');
		$this->db->order_by('Priority', 'ASC');
		$this->db->where('Type', 'HomePageBanner');
		$this->db->where('IsActive', 1);
		$this->db->order_by('Priority', 'ASC');
		$this->db->stop_cache();
		$query = $this->db->get();
		$this->db->flush_cache();
		if ( $query->num_rows() > 0 ){
			$featuredProductsList = array();
			foreach($query->result() as $row){
				array_push($featuredProductsList, (Object)$row);
			}
			return $featuredProductsList;
		}
		return null;
	}
	
	public function addToSubscribe($email){
		$this->db->start_cache();
		$this->db->select('Email');
		$this->db->from('subscriptions');
		$this->db->where('Email', $email);
		$this->db->stop_cache();
		$query = $this->db->get();
		$this->db->flush_cache();
		if ( $query->num_rows() > 0 ){
			return "Email already exists";
		}
		else{
			$data = array('Email' => $email);
			$res = $this->db->insert('subscriptions', $data);
			if($res){
				return "Thanks for subscribing to Compare Dunia";
			}
			else{
				return "Somethingwent wrong please try again";
			}
		}
	}
}

?>