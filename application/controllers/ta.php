<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ta extends CI_Controller
{
    
    function __construct(){
        parent::__construct();
        $this->load->database();
        $this->load->model('ta_model');
        $this->load->model('login_model');
    }
    
    public function addCategoryData(){
        if ($this->session->userdata('user_login_access') != False) {
            $catid    = $this->input->post('transaction_id');
            $category = $this->input->post('amount');
           
            // Validating category Type Field 
            $this->load->library('form_validation');
            $this->form_validation->set_rules('transaction_id', 'Category Id', 'trim|xss_clean');
            $this->form_validation->set_rules('amount', 'Category Name', 'trim|min_length[2]|max_length[25]|xss_clean|required');
           

            if ($this->form_validation->run() == FALSE) {
                $response['status']  = 'error';
                $response['message'] = validation_errors();
                $this->output->set_output(json_encode($response));
            } else {
                $data = array();
                $data = array(
                    'amount' => $category,
                    
                );
                if (!empty($catid)) {
                    $update              = $this->ta_model->updateCategory($catid, $data);
                    $response['status']  = 'success';
                    $response['message'] = "Successfully Updated";
                    $this->output->set_output(json_encode($response));
                } else {
                    $insert              = $this->ta_model->insertcategory($data);
                    $response['status']  = 'success';
                    $response['message'] = "Successfully Added";
                    $this->output->set_output(json_encode($response));
                }
            }
        } else {
            redirect(base_url(), 'refresh');
        }
    }
    public function getCategoryByID()
    {
        if ($this->session->userdata('user_login_access') != False) 
        {
            $catid      = $this->input->get('c');
            $subcatlist = $this->ta_model->getsubcategoryByID($catid);
            echo '<option value="">Select a Sub-Category</option>';
            foreach ($subcatlist AS $eachSubcat)
                echo "<option value='$eachSubcat->subcat_id'>$eachSubcat->subcat_name</option>";
        } else {
            redirect(base_url(), 'refresh');
        }
    }

     public function view_category()
    {
        if ($this->session->userdata('user_login_access') != False) 
        {
            $data             = array();
            $data['ta'] = $this->ta_model->getCategory();
            $this->load->view('backend/ta', $data);
        } 
        else 
        {
            redirect(base_url(), 'refresh');
        }
    }
    public function categoryById()
    {
        if ($this->session->userdata('user_login_access') != False) 
        {
            $id               = $this->input->get('id');
            $data['catvalue'] = $this->ta_model->getCategoryValueById($id);
            echo json_encode($data);
        } 
        else 
        {
            redirect(base_url(), 'refresh');
        }
    }
    // public function View_profile(){
    //     if ($this->session->userdata('user_login_access') != False) {
    //         $userid                = base64_decode($this->input->get('U'));
    //         $data                  = array();
    //         $data['settingsvalue'] = $this->category_model->getSettingsValue();
    //         $data['profile']       = $this->category_model->getProfileValue($userid);
    //         //$data['usernote']      = $this->category_model->getUserNotes($userid);
    //         $this->load->view('backend/profile', $data);
    //     } else {
    //         redirect(base_url(), 'refresh');
    //     }
    // }
    function set_notification(){
        $data = $_POST["id"];
        $this->load->model('ta_model');
        $this->ta_model->set_notifiication($data);
    }
     public function category_delet(){
        if ($this->session->userdata('user_login_access') != False) {
            $id = $this->input->get('id');
            $this->ta_model->categoryTableDelet($id);
            if ($this->db->affected_rows()) {
                $profile    = $this->ta_model->getCategoryValue($id);
                $checkimage = "./assets/img/user/$profile->image";
                if (file_exists($checkimage)) {
                    unlink($checkimage);
                    redirect('ta/ta');
                }
                /*      $this->crud_model->User_Notes_Delet($id);
                $this->crud_model->User_commentid_Delet($id);*/
                
            } else {
                redirect(base_url(), 'refresh');
            }
        }
    }
     public function Delet_CategoryInfo(){
        if ($this->session->userdata('user_login_access') != False) {
            $id    = base64_decode($this->input->get('D'));
            $value = $this->ta_model->getCategoryById($id);
            if (!empty($value)) {
                $deletproduct = $this->ta_model->delet_Category($id);
                $deletcolor   = $this->ta_model->delet_Color($id);
                $deletsize    = $this->ta_model->delet_Size($id);
                $imgvalue     = $this->ta_model->getCatImageById($id);
                if (!empty($imgvalue)) {
                    foreach ($imgvalue as $value) {
                        while (file_exists("./assets/img/product/$value->img_url")) {
                            unlink("./assets/img/product/$value->img_url");
                        }
                    }
                    $delet = $this->ta_model->delet_Cat_Image($id);
                }
                redirect('ta/ta');
            } else {
                $this->session->set_flashdata('feedback', 'Your request do not valid');
                redirect('ta/ta');
            }
        } else {
            redirect(base_url(), 'refresh');
        }
    }
}
?>