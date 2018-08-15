<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class category extends CI_Controller
{
    
    function __construct(){
        parent::__construct();
        $this->load->database();
        $this->load->model('category_model');
        $this->load->model('login_model');
    }
    
    public function addCategoryData(){
        if ($this->session->userdata('user_login_access') != False) {
            $catid    = $this->input->post('cat_id');
            $category = $this->input->post('catname');
            $status   = $this->input->post('catstatus');
            // Validating category Type Field 
            $this->load->library('form_validation');
            $this->form_validation->set_rules('cat_id', 'Category Id', 'trim|xss_clean');
            $this->form_validation->set_rules('catname', 'Category Name', 'trim|min_length[2]|max_length[25]|xss_clean|required');
            $this->form_validation->set_rules('catstatus', 'Category Status', 'trim|xss_clean');

            if ($this->form_validation->run() == FALSE) {
                $response['status']  = 'error';
                $response['message'] = validation_errors();
                $this->output->set_output(json_encode($response));
            } else {
                $data = array();
                $data = array(
                    'cat_name' => $category,
                    'cat_status' => $status
                );
                if (!empty($catid)) {
                    $update              = $this->category_model->updateCategory($catid, $data);
                    $response['status']  = 'success';
                    $response['message'] = "Successfully Updated";
                    $this->output->set_output(json_encode($response));
                } else {
                    $insert              = $this->category_model->insertcategory($data);
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
            $subcatlist = $this->category_model->getsubcategoryByID($catid);
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
            $data['category'] = $this->category_model->getCategory();
            $this->load->view('backend/category', $data);
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
            $data['catvalue'] = $this->category_model->getCategoryValueById($id);
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
        $this->load->model('category_model');
        $this->category_model->set_notifiication($data);
    }
     public function category_delet(){
        if ($this->session->userdata('user_login_access') != False) {
            $id = $this->input->get('id');
            $this->category_model->categoryTableDelet($id);
            if ($this->db->affected_rows()) {
                $profile    = $this->category_model->getCategoryValue($id);
                $checkimage = "./assets/img/user/$profile->image";
                if (file_exists($checkimage)) {
                    unlink($checkimage);
                    redirect('category/category');
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
            $value = $this->category_model->getCategoryById($id);
            if (!empty($value)) {
                $deletproduct = $this->category_model->delet_Category($id);
                $deletcolor   = $this->category_model->delet_Color($id);
                $deletsize    = $this->category_model->delet_Size($id);
                $imgvalue     = $this->category_model->getCatImageById($id);
                if (!empty($imgvalue)) {
                    foreach ($imgvalue as $value) {
                        while (file_exists("./assets/img/product/$value->img_url")) {
                            unlink("./assets/img/product/$value->img_url");
                        }
                    }
                    $delet = $this->category_model->delet_Cat_Image($id);
                }
                redirect('category/category');
            } else {
                $this->session->set_flashdata('feedback', 'Your request do not valid');
                redirect('category/category');
            }
        } else {
            redirect(base_url(), 'refresh');
        }
    }
}
?>