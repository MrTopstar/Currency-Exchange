<?php

class brand_model extends CI_Model {
    
    
    function __consturct() {
        parent::__construct();
        
    }
     public function insertBrandValue($data) {
        $this->db->insert('brand', $data);
    }
    public function getBrand() {
        $brand  = $this->db->dbprefix('brand');
        $sql    = "SELECT * FROM $brand";
        $query  = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }
    public function getBrandBYID($id) {
        $sql    = "SELECT * FROM `brand` WHERE `brand_id`='$id'";
        $query  = $this->db->query($sql);
        $result = $query->row();
        return $result;
    }
    public function updateBrandValue($id, $data) {
        $this->db->where('brand_id', $id);
        $this->db->update('brand', $data);
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