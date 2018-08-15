<?php

class userlist_model extends CI_Model {
   
    
    function __consturct() {
        parent::__construct();
        
    }
    public function getProfileValue($userid) {
        $user   = $this->db->dbprefix('users');
        $sql    = "SELECT * FROM $user
    WHERE `user_id`='$userid'";
        $query  = $this->db->query($sql);
        $result = $query->row();
        return $result;
    }
    public function getUserValue($id) {
        $user   = $this->db->dbprefix('users');
        $sql    = "SELECT * FROM $user WHERE `user_id`='$id'";
        $query  = $this->db->query($sql);
        $result = $query->row();
        return $result;
    }
   /* public function UserUpdate($id, $data) {
        $this->db->where('user_id', $id);
        $this->db->update('users', $data);
    }*/
    /*public function UpdateTododata($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('to_do_list', $data);
    }*/
   /* public function updatePassword($id, $data) {
        $this->db->where('user_id', $id);
        $this->db->update('users', $data);
    }*/
    /*public function settingsUpdate($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('settings', $data);
    }*/
    
     public function getSettingsValue() {
        $settings = $this->db->dbprefix('settings');
        $sql      = "SELECT * FROM $settings";
        $query    = $this->db->query($sql);
        $result   = $query->row();
        return $result;
    }
    public function getAllUsers() {
        $user   = $this->db->dbprefix('users');
        $sql    = "SELECT * FROM $user WHERE `status`='ACTIVE'";
        $query  = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }
   /* public function addUserInfo($data) {
        $this->db->insert('users', $data);
    }
    public function getAllGroupsUser() {
        $sql    = "SELECT * FROM `users` WHERE `user_type`='User'";
        $query  = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }*/
   /* public function getAllGroupsAdmin() {
        $sql    = "SELECT * FROM `users` WHERE `user_type`='Admin'";
        $query  = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }
    public function selectgroupdatabyId($id) {
        $sql    = "SELECT * FROM `users` WHERE `user_id`='$id'";
        $query  = $this->db->query($sql);
        $result = $query->row();
        return $result;
    }
    public function updateGroupInfo($id, $data) {
        $this->db->where('user_id', $id);
        $this->db->update('users', $data);
    }*/
  /*  public function addUserNote($data) {
        $this->db->insert('notes', $data);
    }*/
    public function getUserNotes($userid) {
        $sql    = "SELECT `users`.*,
      `notes`.*
      from `notes`
      LEFT JOIN `users` ON `notes`.`comment_id`=`users`.`user_id`
      WHERE `notes`.`user_id`='$userid' ORDER BY `notes`.`datetime`DESC";
        $query  = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }
    /* public function getTodoInfo($userid) {
        $sql    = "SELECT * FROM `to_do_list` WHERE `user_id`='$userid' ORDER BY `id` DESC";
        $query  = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }
    public function insert_tododata($data) {
        return $this->db->insert('to_do_list', $data);
    }*/
    public function userTableDelet($id) {
        $this->db->delete('users', array(
            'user_id' => $id
        ));
        $this->db->delete('notes', array(
            'user_id' => $id
        ));
        $this->db->delete('notes', array(
            'comment_id' => $id
        ));
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
    
}
?>