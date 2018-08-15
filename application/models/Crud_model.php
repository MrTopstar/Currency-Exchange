<?php

class Crud_model extends CI_Model {
    
    
    function __consturct() {
        parent::__construct();
        
    }
    
    public function UserUpdate($id, $data) {
        $this->db->where('user_id', $id);
        $this->db->update('users', $data);
    }
    public function UpdateTododata($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('to_do_list', $data);
    }
    public function updatePassword($id, $data) {
        $this->db->where('user_id', $id);
        $this->db->update('users', $data);
    }
    public function settingsUpdate($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('settings', $data);
    }
  
   
    
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
    public function addUserInfo($data) {
        $this->db->insert('users', $data);
    }
    public function getAllGroupsUser() {
        $sql    = "SELECT * FROM `users` WHERE `user_type`='User'";
        $query  = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }
    public function getAllGroupsAdmin() {
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
    }
    public function addUserNote($data) {
        $this->db->insert('notes', $data);
    }
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
    public function getProfileValue($userid) {
        $user   = $this->db->dbprefix('users');
        $sql    = "SELECT * FROM $user
    WHERE `user_id`='$userid'";
        $query  = $this->db->query($sql);
        $result = $query->row();
        return $result;
    }
   
    public function getTodoInfo($userid) {
        $sql    = "SELECT * FROM `to_do_list` WHERE `user_id`='$userid' ORDER BY `id` DESC";
        $query  = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }
  
    public function productUpdateInfo($id, $data) {
        $this->db->where('pro_id', $id);
        $this->db->update('product', $data);
    }
    public function insert_tododata($data) {
        return $this->db->insert('to_do_list', $data);
    }
  
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
    ///currency_code



     public function GetproductImage($proid) {
        $sql    = "SELECT * FROM `product_image` WHERE `pro_id`='$proid'";
        $query  = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }



     public function insertcurrencyCode($data) {
        $this->db->insert('currency_code', $data);
    }
    public function getCurrencyCode() {
        $category = $this->db->dbprefix('currency_code');
        $sql      = "SELECT * FROM $category ";
        $query    = $this->db->query($sql);
        $result   = $query->result();
        return $result;
    }
        
        public function getcurrencyCodedetails($proid) {
        $sql    = "SELECT `currency_code`.*
      
      from `currency_code`

      WHERE `currency_code`.`currency_id`='$proid'";
        $query  = $this->db->query($sql);
        $result = $query->row();
        return $result;
    }

        public function getCurrencyCodeValue($id) {
        $user   = $this->db->dbprefix('currency_code');
        $sql    = "SELECT * FROM $user WHERE `currency_id`='$id'";
        $query  = $this->db->query($sql);
        $result = $query->row();
        return $result;
    }

       /*public function getCurrencyRate() {
        $category = $this->db->dbprefix('currency_code');
        $sql      = "SELECT * FROM $category ";
        $query    = $this->db->query($sql);
        $result   = $query->result();
        return $result;
    }*/

        public function currencyCodeTableDelet($id) {
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
          public function getCurrencyCodeValueById($id) 
    {
        $sql    = "SELECT * FROM `currency_code` WHERE `currency_id`='$id'";
        $query  = $this->db->query($sql);
        $result = $query->row();
        return $result;
    }
      public function updateCurrencyCode($catid, $data) {
        $this->db->where('currency_id', $catid);
        $this->db->update('currency_code', $data);
    }

        public function getCurrencyCodeById($id) {
        $sql    = "SELECT * FROM `currency_code` WHERE `currency_id`='$id'";
        $query  = $this->db->query($sql);
        $result = $query->row();
        return $result;
    }

        public function delet_currencyCode($id) {
        $this->db->where('currency_id', $id);
        $this->db->delete('currency_code');
    }


     public function getSingleProImageById($id) {
        $image  = $this->db->dbprefix('product_image');
        $sql    = "SELECT * FROM $image
        WHERE `id`='$id'";
        $query  = $this->db->query($sql);
        $result = $query->row();
        return $result;
    }

     public function getProImageById($id) {
        $image  = $this->db->dbprefix('product_image');
        $sql    = "SELECT * FROM $image
        WHERE `pro_id`='$id'";
        $query  = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }

     public function getProImage() {
        $sql    = "SELECT * FROM `product_image`";
        $query  = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }

     public function getproductImages($proid) {
        $sql    = "SELECT * FROM `product_image` WHERE `pro_id`='$proid'";
        $query  = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }




     public function productImgInsert($data1) {
        $this->db->insert('product_image', $data1);
    }

     public function deelet_Img($id) {
        $this->db->where('id', $id);
        $this->db->delete('product_image');
    }

     public function deelet_Pro_Imgage($id) {
        $this->db->where('pro_id', $id);
        $this->db->delete('product_image');
    }



       /* public function getCurrencyCodeBYID($id) {
        $sql    = "SELECT * FROM `currency_code` WHERE `currency_id`='$id'";
        $query  = $this->db->query($sql);
        $result = $query->row();
        return $result;
    }*///end currency_code


    //currency_rate
     public function insertcurrencyRate($data) {
        $this->db->insert('currency_rate', $data);
    }
    public function getCurrencyRate() {
        
        $sql="SELECT `currency_rate`.*,`currency_code`.`codes`
      
             from `currency_rate`,`currency_code`

             WHERE `currency_rate`.`currency_id`=`currency_code`.`currency_id`";
        $query    = $this->db->query($sql);
        $result   = $query->result();
        return $result;
    }
        
        public function getcurrencyratedetails($proid) {
        $sql    = "SELECT `currency_rate`.*
      
      from `currency_rate`

      WHERE `currency_rate`.`rate_id`='$proid'";
        $query  = $this->db->query($sql);
        $result = $query->row();
        return $result;
    }

        public function getCurrencyRateValue($id) {
        $user   = $this->db->dbprefix('currency_rate');
        $sql    = "SELECT * FROM $user WHERE `rate_id`='$id'";
        $query  = $this->db->query($sql);
        $result = $query->row();
        return $result;
    }

       public function getCurrencyC() {
        $category = $this->db->dbprefix('currency_code');
        $sql      = "SELECT DISTINCT codes,currency_id  FROM $category ";
        $query    = $this->db->query($sql);
        $result   = $query->result();
        return $result;
    }

        public function currencyRateTableDelet($id) {
        $this->db->delete('currency_rate', array(
            'rate_id' => $id
        ));
        $this->db->delete('notes', array(
            'user_id' => $id
        ));
        $this->db->delete('notes', array(
            'comment_id' => $id
        ));
    }
          public function getCurrencyRateValueById($id) {
        $sql    = "SELECT * FROM `currency_rate` WHERE `rate_id`='$id'";
        $query  = $this->db->query($sql);
        $result = $query->row();
        return $result;
    }
         public function updateCurrencyRate($catid, $data) {
        $this->db->where('rate_id', $catid);
        $this->db->update('currency_rate', $data);
    }

        public function getCurrencyRateById($id) {
        $sql    = "SELECT * FROM `currency_rate` WHERE `rate_id`='$id'";
        $query  = $this->db->query($sql);
        $result = $query->row();
        return $result;
    }

        public function delet_currencyRate($id) {
        $this->db->where('rate_id', $id);
        $this->db->delete('currency_rate');
    }

       /* public function getCurrencyRateBYID($id) {
        $sql    = "SELECT * FROM `currency_rate` WHERE `currency_id`='$id'";
        $query  = $this->db->query($sql);
        $result = $query->row();
        return $result;
    }*///end currency_rate



    //dashboard
     /*public function getTransaction()
      {
        $transaction = $this->db->dbprefix('transaction');
        $sql      = "SELECT MAX(transaction_id) FROM transaction ";
        $query    = $this->db->query($sql);
        $result   = $query->result();
        return $result;
       
       }*/


    /*All the names are suggestive enough and hence less code commenting*/
    public function insertcurrencyDash($data) {
       
        $this->db->insert('transaction', $data);
        return $this->db->insert_id();
       

    }
     public function insertcurrencysDash($data) {
        $this->db->insert('transaction_details', $data);
    }

   /* public function getCCurrency() {
        $category = $this->db->dbprefix('currency_code');
        $sql      = "SELECT * FROM $category ";
        $query    = $this->db->query($sql);
        $result   = $query->result();
        return $result;
    }
        
        public function getcurrencytrandetails($proid) {
        $sql    = "SELECT `transaction`.*
      
      from `transaction`

      WHERE `transaction`.`transaction_id`='$proid'";
        $query  = $this->db->query($sql);
        $result = $query->row();
        return $result;
    }

        public function getCurrencytranValue($id) {
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
    }*/
        public function getCurrencyDash() {

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


      /*  public function currencytranTableDelet($id) {
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
          public function getCurrencytranValueById($id) {
        $sql    = "SELECT * FROM `transaction` WHERE `transaction_id`='$id'";
        $query  = $this->db->query($sql);
        $result = $query->row();
        return $result;
    }*/
    public function updateCurrencyDash($catid, $data) {
        $this->db->where('transaction_id', $catid);
        $this->db->update('transaction', $data);
    }

     public function updateCurrencysDash($catid, $data) {
        $this->db->where('detail_id', $catid);
        $this->db->update('transaction_details', $data);
    }
    /* public function getCurrencytranById($id) {
        $sql    = "SELECT * FROM `transaction` WHERE `transaction_id`='$id'";
        $query  = $this->db->query($sql);
        $result = $query->row();
        return $result;
    }

        public function delettran_Currency($id) {
        $this->db->where('transaction_id', $id);
        $this->db->delete('transaction');
    }

        public function getCurrencytransacBYID($id) {
        $sql    = "SELECT * FROM `transaction` WHERE `transaction_id`='$id'";
        $query  = $this->db->query($sql);
        $result = $query->row();
        return $result;
    }*///dashboard



    //transaction
     /*public function inserttrandcurrency($data) {
        $this->db->insert('transaction_details', $data);
    }*/
    public function getCurrencyTran() {
        $category = $this->db->dbprefix('transaction_details','transaction');
        $sql      = "SELECT * FROM $category LEFT JOIN `transaction` ON `transaction`.`transaction_id` = `transaction_details`.`transaction_id`";
        $query    = $this->db->query($sql);
        $result   = $query->result();
        return $result;
    }
        
       /* public function getcurrencytranddetails() {
        $sql    = "SELECT `transaction_details`.*,`transaction`.*
      
      from `transaction_details`
      LEFT JOIN `transaction` ON `transaction`.`transaction_id` = `transaction_details`.`transaction_id`";
     
        $query  = $this->db->query($sql);
        $result = $query->row();
        return $result;
    }*/

        public function getCurrencyTranValue($id) {
        $user   = $this->db->dbprefix('transaction_details');
        $sql    = "SELECT * FROM $user WHERE `detail_id`='$id'";
        $query  = $this->db->query($sql);
        $result = $query->row();
        return $result;
    }

      /* public function getCurrencyCo() {
        $category = $this->db->dbprefix('currency_code');
        $sql      = "SELECT * FROM $category ";
        $query    = $this->db->query($sql);
        $result   = $query->result();
        return $result;
    }*/

        public function currencyTranTableDelet($id) {
        $this->db->delete('transaction_details', array(
            'detail_id' => $id
        ));
        $this->db->delete('notes', array(
            'user_id' => $id
        ));
        $this->db->delete('notes', array(
            'comment_id' => $id
        ));
    }

        public function getCurrencyTranById($id) {
        $sql    = "SELECT * FROM `transaction_details` WHERE `detail_id`='$id'";
        $query  = $this->db->query($sql);
        $result = $query->row();
        return $result;
    }


      public function updatetrandCurrency($catid, $data) {
        $this->db->where('detail_id', $catid);
        $this->db->update('transaction_details', $data);
    }

   

        public function delet_currencyTran($id) {
        $this->db->where('detail_id', $id);
        $this->db->delete('transaction_details');
    }

        
    }//end transaction

?>