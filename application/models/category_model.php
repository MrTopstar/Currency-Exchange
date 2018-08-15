<?php

class category_model extends CI_Model {
    
    
    function __consturct() {
        parent::__construct();
        
    }
    /*All the names are suggestive enough and hence less code commenting*/
    public function insertcategory($data) {
        $this->db->insert('category', $data);
    }
    public function getCategory() {
        $category = $this->db->dbprefix('category');
        $sql      = "SELECT * FROM $category ";
        $query    = $this->db->query($sql);
        $result   = $query->result();
        return $result;
    }
          public function getCategoryValueById($id) {
        $sql    = "SELECT * FROM `category` WHERE `cat_id`='$id'";
        $query  = $this->db->query($sql);
        $result = $query->row();
        return $result;
    }
     public function getSettingsValue() 
    {
        $settings = $this->db->dbprefix('settings');
        $sql      = "SELECT * FROM $settings";
        $query    = $this->db->query($sql);
        $result   = $query->row();
        return $result;
    }
     public function updateCategory($catid, $data) {
        $this->db->where('cat_id', $catid);
        $this->db->update('category', $data);
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
    public function set_notifiication($id) {
        $sql = "UPDATE notes SET notification_status = 'seen' WHERE user_id = '$id' AND notification_status = 'unseen'";
        $this->db->query($sql);
        
    }
      public function delet_Category($id) {
        $this->db->where('pro_id', $id);
        $this->db->delete('product_color');
    }
    public function categoryTableDelet($id) {
        $this->db->delete('category', array(
            'cat_id' => $id
        ));
        $this->db->delete('notes', array(
            'user_id' => $id
        ));
        $this->db->delete('notes', array(
            'comment_id' => $id
        ));
    }
     public function getCategoryBYID($id) {
        $sql    = "SELECT * FROM `category` WHERE `cat_id`='$id'";
        $query  = $this->db->query($sql);
        $result = $query->row();
        return $result;
    }
}
   ?>