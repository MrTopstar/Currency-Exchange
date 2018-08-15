<?php

class adduser_model extends CI_Model {
    
    
    function __consturct() {
        parent::__construct();
        
    }
    public function getSettingsValue() {
        $settings = $this->db->dbprefix('settings');
        $sql      = "SELECT * FROM $settings";
        $query    = $this->db->query($sql);
        $result   = $query->row();
        return $result;
    }
     public function addUserInfo($data) {
        $this->db->insert('users', $data);
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
     
    public function getUserValue($id) {
        $user   = $this->db->dbprefix('users');
        $sql    = "SELECT * FROM $user WHERE `user_id`='$id'";
        $query  = $this->db->query($sql);
        $result = $query->row();
        return $result;
    }
     public function UserUpdate($id, $data) {
        $this->db->where('user_id', $id);
        $this->db->update('users', $data);
    }
     public function getAllUsers() {
        $user   = $this->db->dbprefix('users');
        $sql    = "SELECT * FROM $user WHERE `status`='ACTIVE'";
        $query  = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }
     public function addUserNote($data) {
        $this->db->insert('notes', $data);
    }
     public function getProfileValue($userid) {
        $user   = $this->db->dbprefix('users');
        $sql    = "SELECT * FROM $user
    WHERE `user_id`='$userid'";
        $query  = $this->db->query($sql);
        $result = $query->row();
        return $result;
    }

}
?>