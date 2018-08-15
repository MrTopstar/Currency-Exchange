<?php

class i_model extends CI_Model {
    
    
    function __consturct() {
        parent::__construct();
        
    }

public function getProImage() {
        $sql    = "SELECT * FROM `product_image`";
        $query  = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }

 ?>