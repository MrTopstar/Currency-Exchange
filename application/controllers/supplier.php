<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class supplier extends CI_Controller{
    
    function __construct(){
        parent::__construct();
        $this->load->database();
        $this->load->model('supplier_model');
        $this->load->model('login_model');
    }
    
    
    /*|||||||||||||| UPDATED |||||||||||||||*/
    
    /*Select Group data by id */
    
    /*subcategory validation*/
   
    /*Color data by id*/
    public function getSupplierById() {
        if ($this->session->userdata('user_login_access') != False) {
            $id                 = $this->input->get('id');
            $data['colorvalue'] = $this->supplier_model->getSupplierById($id);
            echo json_encode($data);
        } else {
            redirect(base_url(), 'refresh');
        }
    }
    /*Size data by id*/
    public function addSupplierData(){
        if ($this->session->userdata('user_login_access') != False) {
            $id          = $this->input->post('supplier_id');
            $colorvalue  = $this->input->post('colorname');
            $colorstatus = $this->input->post('status');
            // Validating details Type Field 
            $this->load->library('form_validation');
            $this->form_validation->set_rules('color_id', 'Color Id', 'trim|xss_clean');
            $this->form_validation->set_rules('colorname', 'Color Name', 'trim|min_length[2]|max_length[10]|xss_clean|required');
            $this->form_validation->set_rules('status', 'Color Status', 'trim|xss_clean');
            
            if ($this->form_validation->run() == FALSE) {
                $response['status']  = 'error';
                $response['message'] = validation_errors();
                $this->output->set_output(json_encode($response));
            } else {
                $data = array();
                $data = array(
                    'supplier_name' => $colorvalue,
                    'supplier_status' => $colorstatus
                );
                if (!empty($id)) {
                    $update              = $this->supplier_model->updateSupplierValue($id, $data);
                    $response['status']  = 'success';
                    $response['message'] = "Successfully Updated";
                    $this->output->set_output(json_encode($response));
                } else {
                    $insert              = $this->supplier_model->insertSupplierValue($data);
                    $response['status']  = 'success';
                    $response['message'] = "Successfully Added";
                    $this->output->set_output(json_encode($response));
                }
                
            }
        } else {
            redirect(base_url(), 'refresh');
        }
    }
    /*brand data validation*/
    public function view_supplier(){
        if ($this->session->userdata('user_login_access') != False) 
        {
            $data          = array();
            $data['color'] = $this->supplier_model->getSupplier();
            $this->load->view('backend/supplier', $data);
        } else 
        {
            redirect(base_url(), 'refresh');
        }
    }
}

    ?>
