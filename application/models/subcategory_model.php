<?php

class subcategory_model extends CI_Model {
    
    
    function __consturct() {
        parent::__construct();
        
    }
    public function insertcategory($data) {
        $this->db->insert('category', $data);
    }
    public function insertSubcategory($data) {
        $this->db->insert('sub_category', $data);
    }
    public function getCategory() {
        $category = $this->db->dbprefix('category');
        $sql      = "SELECT * FROM $category ";
        $query    = $this->db->query($sql);
        $result   = $query->result();
        return $result;
    }
    public function getsubcategoryByID($catid) {
        $subcategory = $this->db->dbprefix('sub_category');
        $sql         = "SELECT * FROM $subcategory
    WHERE `cat_id`='$catid'";
        $query       = $this->db->query($sql);
        $result      = $query->result();
        return $result;
    }
    public function getSubCatById($id) {
        $sql    = "SELECT `sub_category`.*,
      `category`.*
      from `sub_category`
      LEFT JOIN `category` ON `sub_category`.`cat_id`=`category`.`cat_id`
      WHERE `sub_category`.`subcat_id`='$id'";
        $query  = $this->db->query($sql);
        $result = $query->row();
        return $result;
    }
    public function updateSubcategory($id, $data) {
        $this->db->where('subcat_id', $id);
        $this->db->update('sub_category', $data);
    }
    public function getSubCategory() {
        $sql    = "SELECT `category`.*,
      `sub_category`.*
      from `sub_category`
      LEFT JOIN `category` ON `sub_category`.`cat_id`=`category`.`cat_id`";
        $query  = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }
     public function getSettingsValue( ) 
    {
        $settings = $this->db->dbprefix('settings');
        $sql      = "SELECT * FROM $settings";
        $query    = $this->db->query($sql);
        $result   = $query->row();
        return $result;
    }
    public function getProfileValue($userid) {
        $user   = $this->db->dbprefix('users');
        $sql    = "SELECT * FROM $user
    WHERE `user_id`='$userid'";
        $query  = $this->db->query($sql);
        $result = $query->row();
        return $result;
    }
     public function notifications_user($id) {
        $sql = "SELECT `notes`.*,
        `users`.`full_name`, `image`
        FROM `notes` 
        LEFT JOIN `users` ON `notes`.`comment_id` = `users`.`user_id`
        WHERE `notes`.`user_id` = '$id' AND `notification_status` = 'unseen' AND `notes`.`comment_id` != '$id'";
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }
    public function set_notifiication($id) 
    {
        $sql = "UPDATE notes SET notification_status = 'seen' WHERE user_id = '$id' AND notification_status = 'unseen'";
        $this->db->query($sql);
        
    }
     public function delet_Subcategory($id) {
        $this->db->where('pro_id', $id);
        $this->db->delete('product_color');
    }
    public function subcategoryTableDelet($id) {
        $this->db->delete('sub_category', array(
            'subcat_id' => $id
        ));
        $this->db->delete('notes', array(
            'user_id' => $id
        ));
        $this->db->delete('notes', array(
            'comment_id' => $id
        ));
    }
  }
  ?> 