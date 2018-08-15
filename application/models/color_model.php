<?php

class color_model extends CI_Model {
    
    
    function __consturct() {
        parent::__construct();
        
    }

    public function insertColorValue($data) {
        $this->db->insert('color', $data);
    }
    public function getColor() {
        $color  = $this->db->dbprefix('color');
        $sql    = "SELECT * FROM $color ";
        $query  = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }
     public function getColorById($id) {
        $sql    = "SELECT * FROM `color` WHERE `color_id`='$id'";
        $query  = $this->db->query($sql);
        $result = $query->row();
        return $result;
    }
     public function productColor($data) 
    {
        $this->db->insert('product_color', $data);
    }
    
     public function updateColorValue($id, $data) {
        $this->db->where('color_id', $id);
        $this->db->update('color', $data);
    }
     public function delet_Color($id) {
        $this->db->where('pro_id', $id);
        $this->db->delete('product_color');
    }
    public function getSettingsValue() 
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
