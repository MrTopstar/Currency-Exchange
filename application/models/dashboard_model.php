<?php

class dashboard_model extends CI_Model {
    
    
    function __consturct() {
        parent::__construct();
        
    }
     public function getTransaction()
      {
        $transaction = $this->db->dbprefix('transaction');
        $sql      = "SELECT MAX(transaction_id) FROM transaction ";
        $query    = $this->db->query($sql);
        $result   = $query->result();
        return $result;
       
       }


    /*All the names are suggestive enough and hence less code commenting*/
    public function insertcurrency($data) {
       
        $this->db->insert('transaction', $data);
        return $this->db->insert_id();
       

    }
     public function insertcurrencys($data) {
        $this->db->insert('transaction_details', $data);
    }

    public function getCurrency() {
        $category = $this->db->dbprefix('currency_code');
        $sql      = "SELECT * FROM $category ";
        $query    = $this->db->query($sql);
        $result   = $query->result();
        return $result;
    }
        
        public function getcurrencydetails($proid) {
        $sql    = "SELECT `transaction`.*
      
      from `transaction`

      WHERE `transaction`.`transaction_id`='$proid'";
        $query  = $this->db->query($sql);
        $result = $query->row();
        return $result;
    }

        public function getCurrencyValue($id) {
        $user   = $this->db->dbprefix('transaction');
        $sql    = "SELECT * FROM $user WHERE `transaction_id`='$id'";
        $query  = $this->db->query($sql);
        $result = $query->row();
        return $result;
    }
     
    public function getValue()
    {
            $amount    = $this->input->post('amount');
            $value = $this->input->post('tcur.getValue');
            //$brate = $this->input->post('amount');
            $query=$amount+$value;
            //$result   = $query->result();
            return $query;
    }
       public function getCurrencyRate() {

        $sql="SELECT DISTINCT `currency_code`.`codes` , `currency_rate`. `buy_rate`, `currency_rate`. `sell_rate` FROM `currency_code` 
            LEFT JOIN `currency_rate`  
            ON `currency_rate`.`currency_id` = `currency_code`.`currency_id`
            AND `currency_rate`.`rate_id` IN (
            SELECT MAX(`rate_id`)
            FROM `currency_rate`
            GROUP BY `currency_id`) 
            WHERE`currency_code`.`codes`<>'MMK'
             " ;

         
            //$category = $this->db->dbprefix('currency_code');
            //$sql      = "SELECT * FROM $cat ";
            $query    = $this->db->query($sql);
            $result   = $query->result();
            return $result;
    }

        public function currencyTableDelet($id) {
        $this->db->delete('transaction', array(
            'transaction_id' => $id
        ));
        $this->db->delete('notes', array(
            'user_id' => $id
        ));
        $this->db->delete('notes', array(
            'comment_id' => $id
        ));
    }
          public function getCurrencyValueById($id) {
        $sql    = "SELECT * FROM `transaction` WHERE `transaction_id`='$id'";
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
        $this->db->where('transaction_id', $catid);
        $this->db->update('transaction', $data);
    }

     public function updateCurrencys($catid, $data) {
        $this->db->where('detail_id', $catid);
        $this->db->update('transaction_details', $data);
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
        $sql    = "SELECT * FROM `transaction` WHERE `transaction_id`='$id'";
        $query  = $this->db->query($sql);
        $result = $query->row();
        return $result;
    }

        public function delet_Currency($id) {
        $this->db->where('transaction_id', $id);
        $this->db->delete('transaction');
    }

        public function getCurrencyrateBYID($id) {
        $sql    = "SELECT * FROM `transaction` WHERE `transaction_id`='$id'";
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