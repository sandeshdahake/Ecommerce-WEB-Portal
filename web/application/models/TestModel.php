<?php

class TestModel extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get_user_info($user_id) {
		//$this->load->database();
        $query = $this->db->query("SELECT * FROM users WHERE Id = ?", array($user_id));
        return $query->row_array();
    }

}

?>