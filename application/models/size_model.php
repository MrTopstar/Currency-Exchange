<?php

class size_model extends CI_Model {
    
    
    function __consturct() {
        parent::__construct();
        
    }
    /*All the names are suggestive enough and hence less code commenting*/
    public function insertSizeValue($data) {
        $this->db->insert('size', $data);
    }
    public function getSize() {
        $size   = $this->db->dbprefix('size');
        $sql    = "SELECT * FROM $size";
        $query  = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }
    public function getSizeBYId($id) {
        $sql    = "SELECT * FROM `size` WHERE `size_id`='$id'";
        $query  = $this->db->query($sql);
        $result = $query->row();
        return $result;
    }
    public function updateSizeValue($id, $data) {
        $this->db->where('size_id', $id);
        $this->db->update('size', $data);
    }
    public function delet_Size($id) {
        $this->db->where('pro_id', $id);
        $this->db->delete('product_size');
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
  }
  ?> 
