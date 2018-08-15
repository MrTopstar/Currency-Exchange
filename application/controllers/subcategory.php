<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class subcategory extends CI_Controller
{
    
    function __construct(){
        parent::__construct();
        $this->load->database();
        $this->load->model('subcategory_model');
        $this->load->model('login_model');
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
                    $update              = $this->subcategory_model->updateSubcategory($id, $data);
                    $response['status']  = 'success';
                    $response['message'] = "Successfully Updated";
                    $this->output->set_output(json_encode($response));
                } else {
                    $insert              = $this->subcategory_model->insertSubcategory($data);
                    $response['status']  = 'success';
                    $response['message'] = "Successfully Added";
                    $this->output->set_output(json_encode($response));
                }
            }
        } else {
            redirect(base_url(), 'refresh');
        }
    }
    public function view_subcategory(){
        if ($this->session->userdata('user_login_access') != False) {
            $data                = array();
            $data['category']    = $this->subcategory_model->getCategory();
            $data['subcategory'] = $this->subcategory_model->getSubCategory();
            $this->load->view('backend/subcategory', $data);
        } else {
            redirect(base_url(), 'refresh');
        }
    }
    public function getSubcategoryByid(){
        if ($this->session->userdata('user_login_access') != False) {
            $id             = $this->input->get('id');
            $data['subcat'] = $this->subcategory_model->getSubCatById($id);
            echo json_encode($data);
        } else {
            redirect(base_url(), 'refresh');
        }
    }
     public function subcategory_delet(){
        if ($this->session->userdata('user_login_access') != False) {
            $id = $this->input->get('id');
            $this->subcategory_model->subcategoryTableDelet($id);
            if ($this->db->affected_rows()) {
                $profile    = $this->subcategory_model->getSubcategoryValue($id);
                $checkimage = "./assets/img/user/$profile->image";
                if (file_exists($checkimage)) {
                    unlink($checkimage);
                    redirect('subcategory/subcategory_delet');
                }
                /*      $this->crud_model->User_Notes_Delet($id);
                $this->crud_model->User_commentid_Delet($id);*/
                
            } else {
                redirect(base_url(), 'refresh');
            }
        }
    }
    
}
?>