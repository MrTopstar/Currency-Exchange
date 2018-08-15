<?php

class product_list_model extends CI_Model {
    
    
    function __consturct() {
        parent::__construct();
        }

        public function getSettingsValue() 
    {
        $settings = $this->db->dbprefix('settings');
        $sql      = "SELECT * FROM $settings";
        $query    = $this->db->query($sql);
        $result   = $query->row();
        return $result;
    }
   
    public function getCategory() {
        $category = $this->db->dbprefix('category');
        $sql      = "SELECT * FROM $category ";
        $query    = $this->db->query($sql);
        $result   = $query->result();
        return $result;
    }
    public function getColor() {
        $color  = $this->db->dbprefix('color');
        $sql    = "SELECT * FROM $color ";
        $query  = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }
     public function getSize() {
        $size   = $this->db->dbprefix('size');
        $sql    = "SELECT * FROM $size";
        $query  = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }
    public function getBrand() {
        $brand  = $this->db->dbprefix('brand');
        $sql    = "SELECT * FROM $brand";
        $query  = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }
    public function getCountry() {
        $country  = $this->db->dbprefix('country');
        $sql    = "SELECT * FROM $country";
        $query  = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }

    public function getSubcategory() {
        $sub  = $this->db->dbprefix('sub_category');
        $sql    = "SELECT * FROM $sub";
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
     public function getProductData() {
        $sql    = "SELECT `product`.*,
      `country`.*,
      `category`.*,
      `sub_category`.*
      from `product`
      LEFT JOIN `country` ON `product`.`country_id`=`country`.`country_id` 
      LEFT JOIN `category` ON `product`.`cat_id`=`category`.`cat_id`  
      LEFT JOIN `sub_category` ON `product`.`subcat_id`=`sub_category`.`subcat_id`  
      LEFT JOIN `brand` ON `product`.`brand_id`=`brand`.`brand_id`";
        $query  = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }
    public function getProductById($id) {
        $sql    = "SELECT `product`.*,
      `country`.*,
      `category`.*,
      `sub_category`.*,
      `brand`.*
      from `product`
      LEFT JOIN `country` ON `product`.`country_id`=`country`.`country_id` 
      LEFT JOIN `category` ON `product`.`cat_id`=`category`.`cat_id`  
      LEFT JOIN `sub_category` ON `product`.`subcat_id`=`sub_category`.`subcat_id`  
      LEFT JOIN `brand` ON `product`.`brand_id`=`brand`.`brand_id`
      WHERE `product`.`pro_id`='$id'";
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
    public function getProfileValue($userid) {
        $user   = $this->db->dbprefix('users');
        $sql    = "SELECT * FROM $user
    WHERE `user_id`='$userid'";
        $query  = $this->db->query($sql);
        $result = $query->row();
        return $result;
    }
    public function set_notifiication($id) {
        $sql = "UPDATE notes SET notification_status = 'seen' WHERE user_id = '$id' AND notification_status = 'unseen'";
        $this->db->query($sql);
        
    }

    public function delet_Color($id) {
        $this->db->where('pro_id', $id);
        $this->db->delete('product_color');
    }
    public function delet_Size($id) {
        $this->db->where('pro_id', $id);
        $this->db->delete('product_size');
    }
    public function delet_Product($id) {
        $this->db->where('pro_id', $id);
        $this->db->delete('product');
    }

    public function getProImageById($id) {
        $image  = $this->db->dbprefix('product_image');
        $sql    = "SELECT * FROM $image
    WHERE `pro_id`='$id'";
        $query  = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }
     
     public function deelet_Pro_Imgage($id) {
        $this->db->where('pro_id', $id);
        $this->db->delete('product_image');
    }

     public function GetproductImage($proid) {
        $sql    = "SELECT * FROM `product_image` WHERE `pro_id`='$proid'";
        $query  = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }

    public function getproductdetails($proid) {
        $sql    = "SELECT `product`.*,
      `country`.*,
      `category`.*,
      `sub_category`.*,
      `brand`.*
      from `product`
      LEFT JOIN `country` ON `product`.`country_id`=`country`.`country_id` 
      LEFT JOIN `category` ON `product`.`cat_id`=`category`.`cat_id`  
      LEFT JOIN `sub_category` ON `product`.`subcat_id`=`sub_category`.`subcat_id`  
      LEFT JOIN `brand` ON `product`.`brand_id`=`brand`.`brand_id`
      WHERE `product`.`pro_id`='$proid'";
        $query  = $this->db->query($sql);
        $result = $query->row();
        return $result;
    }

    public function getproductsize($proid) {
        $sql    = "SELECT `product_size`.*,
      `size`.*
      from `product_size`
      LEFT JOIN `size` ON `product_size`.`size_id`=`size`.`size_id`  
      WHERE `product_size`.`pro_id`='$proid'";
        $query  = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }
    public function getproductcolor($proid) {
        $sql    = "SELECT `product_color`.*,
      `color`.*
      from `product_color`
      LEFT JOIN `color` ON `product_color`.`color_id`=`color`.`color_id`  
      WHERE `product_color`.`pro_id`='$proid'";
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
    public function getProductColors($proid) {
        $sql    = "SELECT `product_color`.*,
      `color`.*
      from `product_color`
      LEFT JOIN `color` ON `product_color`.`color_id`=`color`.`color_id`
      WHERE `product_color`.`pro_id`='$proid'";
        $query  = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }
    public function getProductSizes($proid) {
        $sql    = "SELECT `product_size`.*,
      `size`.*
      from `product_size`
      LEFT JOIN `size` ON `product_size`.`size_id`=`size`.`size_id`
      WHERE `product_size`.`pro_id`='$proid'";
        $query  = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }


    public function GetRelatedproduct($catid,$proid) {
        $sql    = "SELECT * FROM `product` WHERE `product`.`cat_id`='$catid' AND `product`.`pro_id` != '$proid' LIMIT 4";
        $query  = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }

    public function productColor($data) {
        $this->db->insert('product_color', $data);
    }

    public function productSize($data) {
        $this->db->insert('product_size', $data);
    }

    public function productUpdateInfo($id, $data) {
        $this->db->where('pro_id', $id);
        $this->db->update('product', $data);
    }

    public function productInsert($data) {
        $this->db->insert('product', $data);
    }

    public function productImgInsert($data1) {
        $this->db->insert('product_image', $data1);
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

    public function insertSubcategory($data) {
        $this->db->insert('sub_category', $data);
    }

    public function getsubcategoryByID($catid) {
        $subcategory = $this->db->dbprefix('sub_category');
        $sql         = "SELECT * FROM $subcategory
    WHERE `cat_id`='$catid'";
        $query       = $this->db->query($sql);
        $result      = $query->result();
        return $result;
    }
}
    ?>