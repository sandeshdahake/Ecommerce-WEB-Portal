<?php

class UserRatingReviewModel extends CI_Model {

    function __construct() {
        parent::__construct();
    }
	
	
	function getProductReviews($productId, $count=5, $start=0){
		$this->db->start_cache();
		$this->db->select('*');
		$this->db->from('userratings');
		$this->db->where('ProductId', $productId);
		$this->db->where('ReviewTitle != ""');
		$this->db->join('users', 'userratings.UserId = users.Id');
		$this->db->limit($count, $start);
		$this->db->stop_cache();
		$query = $this->db->get();
		$this->db->flush_cache();
		$webStores = array();
		$reviewsList = array();
		if ($query->num_rows()>0){
			foreach($query->result() as $review){
				array_push($reviewsList, (Object)$review);
			}
			return $reviewsList;
		}
		else return null;
	}
	
	function createProductReview($review){
		$this->db->insert('userratings', $review);
		$insert_id = $this->db->insert_id();
		return  $insert_id;
	}
}
?>