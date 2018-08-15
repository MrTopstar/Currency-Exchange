<?php

class currencyCode_model extends CI_Model {
    
    
    function __consturct() {
        parent::__construct();
        
    }
    /*All the names are suggestive enough and hence less code commenting*/
    public function insertcurrency($data) {
        $this->db->insert('currency_code', $data);
    }
    public function getCurrency() {
        $category = $this->db->dbprefix('currency_code');
        $sql      = "SELECT * FROM $category ";
        $query    = $this->db->query($sql);
        $result   = $query->result();
        return $result;
    }
        
        public function getcurrencydetails($proid) {
        $sql    = "SELECT `currency_code`.*
      
      from `currency_code`

      WHERE `currency_code`.`currency_id`='$proid'";
        $query  = $this->db->query($sql);
        $result = $query->row();
        return $result;
    }

        public function getCurrencyValue($id) {
        $user   = $this->db->dbprefix('currency_code');
        $sql    = "SELECT * FROM $user WHERE `currency_id`='$id'";
        $query  = $this->db->query($sql);
        $result = $query->row();
        return $result;
    }

       public function getCurrencyRate() {
        $category = $this->db->dbprefix('currency_code');
        $sql      = "SELECT * FROM $category ";
        $query    = $this->db->query($sql);
        $result   = $query->result();
        return $result;
    }

        public function currencyTableDelet($id) {
        $this->db->delete('currency_code', array(
            'currency_id' => $id
        ));
        $this->db->delete('notes', array(
            'user_id' => $id
        ));
        $this->db->delete('notes', array(
            'comment_id' => $id
        ));
    }
          public function getCurrencyValueById($id) {
        $sql    = "SELECT * FROM `currency_code` WHERE `currency_id`='$id'";
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
     public function updateCurrency($catid, $data) {
        $this->db->where('currency_id', $catid);
        $this->db->update('currency_code', $data);
    }
    public function getProfileValue($userid) {
        $user   = $this->db->dbprefix('users');
        $sql    = "SELECT * FROM $user
    WHERE `user_id`='$userid'";
        $query  = $this->db->query($sql);
        $result = $query->row();
        return $result;
    }

        public function getCurrencyById($id) {
        $sql    = "SELECT * FROM `currency_code` WHERE `currency_id`='$id'";
        $query  = $this->db->query($sql);
        $result = $query->row();
        return $result;
    }

        public function delet_Currency($id) {
        $this->db->where('currency_id', $id);
        $this->db->delete('currency_code');
    }

        public function getCurrencyrateBYID($id) {
        $sql    = "SELECT * FROM `currency_code` WHERE `currency_id`='$id'";
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
}
   ?>