<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class product extends CI_Controller{
    
    function __construct(){
        parent::__construct();
        $this->load->database();
        $this->load->model('product_model');
        $this->load->model('login_model');
    }
     /*product validation page */
    public function View_Product(){
        if ($this->session->userdata('user_login_access') != False) {
            $data                  = array();
            $data['settingsvalue'] = $this->product_model->getSettingsValue();
             $data['country']      = $this->product_model->getCountry();
            $data['category']      = $this->product_model->getCategory();
             $data['sub_category']      = $this->product_model->getSubcategory();
            $data['color']         = $this->product_model->getColor();
            $data['size']          = $this->product_model->getSize();
            $data['brand']         = $this->product_model->getBrand();
            $this->load->view('backend/product', $data);
        } else {
            redirect(base_url(), 'refresh');
        }
    }
    public function product_details(){
        if ($this->session->userdata('user_login_access') != False) {
            $proid                  = base64_decode($this->input->get('P'));
            $data                   = array();
            $data['settingsvalue']  = $this->product_model->getSettingsValue();
            $data['productdetails'] = $this->product_model->getproductdetails($proid);
            $data['productsize']    = $this->product_model->getproductsize($proid);
            $data['productcolor']   = $this->product_model->getproductcolor($proid);
            $data['productimage']   = $this->product_model->getproductImage($proid);
            $this->load->view('backend/productdetails', $data);
        } else {
            redirect(base_url(), 'refresh');
        }
    }
    public function addProductData(){
        if ($this->session->userdata('user_login_access') != False) {
            $id          = $this->input->post('pro_id');
            $proid       = 'P' . rand(0, 1000);
            $sku         = $this->input->post('product_sku');
            $name        = $this->input->post('product_name');
            $price       = $this->input->post('product_price');
            $selling     = $this->input->post('selling_price');
            $discount    = $this->input->post('discount');
            $starts      = $this->input->post('discount_starts');
            $ends        = $this->input->post('discount_ends');
            $country_id      = $this->input->post('count_id');
            $cat_id      = $this->input->post('catid');
            $subcatid    = $this->input->post('subcatlist');
            $brandid     = $this->input->post('brand');
            $prosummary  = $this->input->post('summary');
            $prodetails  = $this->input->post('details');
            $proquantity = $this->input->post('quantity');
            $color       = $this->input->post('color[]');
            $size        = $this->input->post('size[]');
            $this->load->library('form_validation');
            // Validating SKU Field
            $this->form_validation->set_rules('product_sku', 'SKU', 'trim|min_length[2]|max_length[40]|xss_clean|required');
            // Validating product Field
            $this->form_validation->set_rules('product_name', 'product Name', 'trim|min_length[2]|max_length[250]|xss_clean|required');
            // Validating summary Field
            $this->form_validation->set_rules('summary', 'summary', 'trim|min_length[15]|max_length[100]|xss_clean|required');
            // Validating details Type Field 
            $this->form_validation->set_rules('details', 'details', 'trim|min_length[100]|max_length[1200]|xss_clean|required');
            //Validating Purchase Price Field
            $this->form_validation->set_rules('product_price', 'Purchase Price', 'trim|xss_clean|required');
            //Validating Selling Price Field
            $this->form_validation->set_rules('selling_price', 'Selling Price', 'trim|xss_clean|required');
            //Validating Discount Field
            $this->form_validation->set_rules('discount', 'Discount', 'trim|xss_clean');
            //Validating Discount Starts Field
            $this->form_validation->set_rules('discount_starts', 'Discount Starts', 'trim|xss_clean');
            //Validating Discount Ends Field
            $this->form_validation->set_rules('discount_ends', 'Discount Ends', 'trim|xss_clean');
            //Validating Category Field
             $this->form_validation->set_rules('count_id', 'Country', 'trim|xss_clean');
            $this->form_validation->set_rules('catid', 'Category', 'trim|xss_clean');
            //Validating SubCategory Field
            $this->form_validation->set_rules('subcatlist', 'SubCategory', 'trim|xss_clean');
            //Validating Brand Field
            $this->form_validation->set_rules('brand', 'Brand Id', 'trim|xss_clean');
            //Validating Quantity Field
            $this->form_validation->set_rules('quantity', 'Quantity', 'trim|xss_clean');
            
            if ($this->form_validation->run() == FALSE) {
                $response['status']  = 'error';
                $response['message'] = validation_errors();
                $this->output->set_output(json_encode($response));
            } else {
                $dataInfo = array();
                $files    = $_FILES;
                $cpt      = count($_FILES['product_image']['name']);
                for ($i = 0; $i < $cpt; $i++) {
                    $_FILES['product_image']['name']     = $files['product_image']['name'][$i];
                    $_FILES['product_image']['type']     = $files['product_image']['type'][$i];
                    $_FILES['product_image']['tmp_name'] = $files['product_image']['tmp_name'][$i];
                    $_FILES['product_image']['error']    = $files['product_image']['error'][$i];
                    $_FILES['product_image']['size']     = $files['product_image']['size'][$i];
                    $uploadPath                          = 'assets/img/product';
                    $config['upload_path']               = $uploadPath;
                    $config['allowed_types']             = 'gif|jpg|png';
                    
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    if ($this->upload->do_upload('product_image')) {
                        $fileData                    = $this->upload->data();
                        $uploadData[$i]['file_name'] = $fileData['file_name'];
                        $data1                       = array();
                        $data1                       = array(
                            'pro_id' => $proid,
                            'img_url' => $uploadData[$i]['file_name']
                        );
                        $success                     = $this->product_model->productImgInsert($data1);
                    }
                }
                if (!empty($uploadData)) {
                    $data                = array();
                    $data                = array(
                        'pro_id' => $proid,
                        'country_id' => $country_id,
                        'cat_id' => $cat_id,
                        'subcat_id' => $subcatid,
                        'brand_id' => $brandid,
                        'pro_sku' => $sku,
                        'pro_name' => $name,
                        'pro_price' => $price,
                        'selling_price' => $selling,
                        'discount' => $discount,
                        'discount_starts' => $starts,
                        'discount_end' => $ends,
                        'pro_summery' => $prosummary,
                        'pro_details' => $prodetails,
                        'quantity' => $proquantity
                    );
                    $success             = $this->product_model->productInsert($data);
                    #$this->session->set_flashdata('feedback','Successfully Updated');
                    $response['status']  = 'success';
                    $response['message'] = "Successfully Added";
                    $this->output->set_output(json_encode($response));
                    $insertid = $this->db->insert_id();
                    if ($insertid) {
                        $color = $this->input->post('color[]');
                        $size  = $this->input->post('size[]');
                        if(!empty($color)){
                        foreach ($color as $colorvalue) {
                            $data        = array();
                            $data        = array(
                                'pro_id' => $proid,
                                'color_id' => $colorvalue
                            );
                            $success     = $this->product_model->productColor($data);
                            $insertidtwo = $this->db->insert_id();
                        }                            
                        }
                        if(!empty($size)){
                        foreach ($size as $sizevalue) {
                            $data          = array();
                            $data          = array(
                                'pro_id' => $proid,
                                'size_id' => $sizevalue
                            );
                            $success       = $this->product_model->productSize($data);
                            $insertidthree = $this->db->insert_id();
                        }
                        }
                    }
                    
                }
            }
        } else {
            redirect(base_url(), 'refresh');
        }
    }
    /*Product update*/
    public function updateProduct(){
        if ($this->session->userdata('user_login_access') != False) {
            $id          = $this->input->post('pro_id');
            $sku         = $this->input->post('product_sku');
            $name        = $this->input->post('product_name');
            $price       = $this->input->post('product_price');
            $selling     = $this->input->post('selling_price');
            $discount    = $this->input->post('discount');
            $starts      = $this->input->post('discount_starts');
            $ends        = $this->input->post('discount_ends');
            $country_id  = $this->input->post('count_id');
            $cat_id      = $this->input->post('catid');
            $subcatid    = $this->input->post('subcatlist');
            $brandid     = $this->input->post('brand');
            $prosummary  = $this->input->post('summary');
            $prodetails  = $this->input->post('details');
            $proquantity = $this->input->post('quantity');
            $color       = $this->input->post('color[]');
            $size        = $this->input->post('size[]');
            $this->load->library('form_validation');
            // Validating SKU Field
            $this->form_validation->set_rules('product_sku', 'SKU', 'trim|min_length[2]|max_length[40]|xss_clean|required');
            // Validating product Field
            $this->form_validation->set_rules('product_name', 'product Name', 'trim|min_length[2]|max_length[250]|xss_clean|required');
            // Validating summary Field
            $this->form_validation->set_rules('summary', 'summary', 'trim|min_length[50]|max_length[512]|xss_clean|required');
            // Validating details Type Field 
            $this->form_validation->set_rules('details', 'details', 'trim|min_length[100]|max_length[1200]|xss_clean|required');
            //Validating Purchase Price Field
            $this->form_validation->set_rules('product_price', 'Purchase Price', 'trim|xss_clean|required');
            //Validating Selling Price Field
            $this->form_validation->set_rules('selling_price', 'Selling Price', 'trim|xss_clean|required');
            //Validating Discount Field
            $this->form_validation->set_rules('discount', 'Discount', 'trim|xss_clean');
            //Validating Discount Starts Field
            $this->form_validation->set_rules('discount_starts', 'Discount Starts', 'trim|xss_clean');
            //Validating Discount Ends Field
            $this->form_validation->set_rules('discount_ends', 'Discount Ends', 'trim|xss_clean');
            //Validating Category Field
             $this->form_validation->set_rules('count_id', 'Country', 'trim|xss_clean');
            $this->form_validation->set_rules('catid', 'Category', 'trim|xss_clean');
            //Validating SubCategory Field
            $this->form_validation->set_rules('subcatlist', 'SubCategory', 'trim|xss_clean');
            //Validating Brand Field
            $this->form_validation->set_rules('brand', 'Brand Id', 'trim|xss_clean');
            //Validating Quantity Field
            $this->form_validation->set_rules('quantity', 'Quantity', 'trim|xss_clean');
            
            if ($this->form_validation->run() == FALSE) {
                $response['status']  = 'error';
                $response['message'] = validation_errors();
                $this->output->set_output(json_encode($response));
            } else {
                $dataInfo = array();
                $files    = $_FILES;
                $cpt      = count($_FILES['product_image']['name']);
                for ($i = 0; $i < $cpt; $i++) {
                    $_FILES['product_image']['name']     = $files['product_image']['name'][$i];
                    $_FILES['product_image']['type']     = $files['product_image']['type'][$i];
                    $_FILES['product_image']['tmp_name'] = $files['product_image']['tmp_name'][$i];
                    $_FILES['product_image']['error']    = $files['product_image']['error'][$i];
                    $_FILES['product_image']['size']     = $files['product_image']['size'][$i];
                    $uploadPath                          = 'assets/img/product';
                    $config['upload_path']               = $uploadPath;
                    $config['allowed_types']             = 'gif|jpg|png';
                    
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    if ($this->upload->do_upload('product_image')) {
                        $fileData                    = $this->upload->data();
                        $uploadData[$i]['file_name'] = $fileData['file_name'];
                        $data1                       = array();
                        $data1                       = array(
                            'pro_id' => $id,
                            'img_url' => $uploadData[$i]['file_name']
                        );
                        $success                     = $this->product_model->ProductImgInsert($data1);
                    }
                }
                if (!empty($id)) {
                    $data       = array();
                    $data       = array(
                        'country_id' => $country_id,
                        'cat_id' => $cat_id,
                        'subcat_id' => $subcatid,
                        'brand_id' => $brandid,
                        'pro_sku' => $sku,
                        'pro_name' => $name,
                        'pro_price' => $price,
                        'selling_price' => $selling,
                        'discount' => $discount,
                        'discount_starts' => $starts,
                        'discount_end' => $ends,
                        'pro_summery' => $prosummary,
                        'pro_details' => $prodetails,
                        'quantity' => $proquantity
                    );
                    $success    = $this->product_model->productUpdateInfo($id, $data);
                    $deletcolor = $this->product_model->delet_Color($id);
                    $deletsize  = $this->product_model->delet_Size($id);
                    $color      = $this->input->post('color[]');
                    $size       = $this->input->post('size[]');
                    foreach ($color as $colorvalue) {
                        $data        = array();
                        $data        = array(
                            'pro_id' => $id,
                            'color_id' => $colorvalue
                        );
                        $success     = $this->product_model->productColor($data);
                        $insertidtwo = $this->db->insert_id();
                    }
                    foreach ($size as $sizevalue) {
                        $data          = array();
                        $data          = array(
                            'pro_id' => $id,
                            'size_id' => $sizevalue
                        );
                        $success       = $this->product_model->productSize($data);
                        $insertidthree = $this->db->insert_id();
                    }
                    #$this->session->set_flashdata('feedback','Successfully Updated');
                    $response['status']  = 'success';
                    $response['message'] = "Successfully Updated";
                    $this->output->set_output(json_encode($response));
                }
            }
        } else {
            redirect(base_url(), 'refresh');
        }
    }
    function set_notification(){
        $data = $_POST["id"];
        $this->load->model('product_model');
        $this->product_model->set_notifiication($data);
    }
    public function getCategoryByID(){
        if ($this->session->userdata('user_login_access') != False) {
            $catid      = $this->input->get('c');
            $subcatlist = $this->product_model->getsubcategoryByID($catid);
            echo '<option value="">Select a Sub-Category</option>';
            foreach ($subcatlist AS $eachSubcat)
                echo "<option value='$eachSubcat->subcat_id'>$eachSubcat->subcat_name</option>";
        } else {
            redirect(base_url(), 'refresh');
        }
    }
    
    public function getSubcategoryByid(){
        if ($this->session->userdata('user_login_access') != False) {
            $id             = $this->input->get('id');
            $data['subcat'] = $this->product_model->getSubCatById($id);
            echo json_encode($data);
        } else {
            redirect(base_url(), 'refresh');
        }
    }
    public function addSubCategoryData(){
        if ($this->session->userdata('user_login_access') != False) {
            $id          = $this->input->post('subcatid');
            $category_id = $this->input->post('cat');
            $subcategory = $this->input->post('subname');
            $status      = $this->input->post('status');
            // Validating details Type Field 
            $this->load->library('form_validation');
            $this->form_validation->set_rules('subcatid', 'SubCategory Id', 'trim|xss_clean');
            $this->form_validation->set_rules('cat', 'Category Id', 'trim|xss_clean|required');
            $this->form_validation->set_rules('subname', 'SubCategory Name', 'trim|min_length[3]|max_length[25]|xss_clean|required');
            $this->form_validation->set_rules('status', 'Status', 'trim|xss_clean|required');
            
            if ($this->form_validation->run() == FALSE) {
                $response['status']  = 'error';
                $response['message'] = validation_errors();
                $this->output->set_output(json_encode($response));
            } else {
                $data = array();
                $data = array(
                    'cat_id' => $category_id,
                    'subcat_name' => $subcategory,
                    'subcat_status' => $status
                );
                if (!empty($id)) {
                    $update              = $this->product_model->updateSubcategory($id, $data);
                    $response['status']  = 'success';
                    $response['message'] = "Successfully Updated";
                    $this->output->set_output(json_encode($response));
                } else {
                    $insert              = $this->product_model->insertSubcategory($data);
                    $response['status']  = 'success';
                    $response['message'] = "Successfully Added";
                    $this->output->set_output(json_encode($response));
                }
            }
        } else {
            redirect(base_url(), 'refresh');
        }
    } 
    
  
}
?>
    
    
    