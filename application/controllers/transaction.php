<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class transaction extends CI_Controller
{
    
    function __construct(){
        parent::__construct();
        $this->load->database();
        $this->load->model('transaction_model');
        $this->load->model('login_model');
    }
    
    public function addCurrencyData(){
        if ($this->session->userdata('user_login_access') != False) {
            $catid    = $this->input->post('currency_id');
            //$pair = $this->input->post('pair');
            $brate = $this->input->post('brate');
            $srate = $this->input->post('srate');
            //$date = $this->input->post('date');
            //$cby   = $this->input->post('cby');
            // Validating category Type Field 
            $this->load->library('form_validation');
            
            
            // Validating SKU Field
            $this->form_validation->set_rules('brate', 'Buy Rate', 'trim|min_length[1]|max_length[40]|xss_clean|required');
            // Validating product Field
            $this->form_validation->set_rules('srate', 'Sell Rate', 'trim|min_length[1]|max_length[250]|xss_clean|required');
            // Validating summary Field
            //$this->form_validation->set_rules('date', 'Date', 'trim|min_length[2]|max_length[100]|xss_clean|required');
            // Validating details Type Field 
            //$this->form_validation->set_rules('cby', 'Created By', 'trim|min_length[2]|max_length[1200]|xss_clean|required');
            //Validating Category Field
             //$this->form_validation->set_rules('pair', 'Currency Pair', 'trim|xss_clean');

            if ($this->form_validation->run() == FALSE) {
                $response['status']  = 'error';
                $response['message'] = validation_errors();
                $this->output->set_output(json_encode($response));
            } else {
                $data = array();
                $data = array(
                     'currency_id' => $catid,
                    //'currency_id' => $pair,
                    'codes' => $brate,
                    'code_name' => $srate
                    //'date' => $date,
                    //'created_by' => $cby
                );
                if (!empty($catid) ){
                    $update              = $this->currencyCode_model->updateCurrency($catid, $data);
                    $response['status']  = 'success';
                    $response['message'] = "Successfully Updated";
                    $this->output->set_output(json_encode($response));
                } else {
                    $insert              = $this->currencyCode_model->insertcurrency($data);
                    $response['status']  = 'success';
                    $response['message'] = "Successfully Added";
                    $this->output->set_output(json_encode($response));
                }
            }
        } else {
            redirect(base_url(), 'refresh');
        }
    }
    public function getCurrencyById(){
        if ($this->session->userdata('user_login_access') != False) {
            $id                 = $this->input->get('id');
            $data['brandvalue'] = $this->currencyCode_model->getCurrencyBYID($id);
            echo json_encode($data);
        } else {
            redirect(base_url(), 'refresh');
        }
    }

        public function getCurrencyrateById(){
        if ($this->session->userdata('user_login_access') != False) {
            $id                 = $this->input->get('id');
            $data['currency'] = $this->currencyCode_model->getCurrencyrateBYID($id);
            echo json_encode($data);
        } else {
            redirect(base_url(), 'refresh');
        }
    }



     public function view_currency()
    {
        if ($this->session->userdata('user_login_access') != False) 
        {
            $data             = array();
            $data['category'] = $this->transaction_model->getCurrency();
            //$data['currency'] = $this->currencyCode_model->getCurrencyRate();
            $this->load->view('backend/transaction', $data);
        } 
        else 
        {
            redirect(base_url(), 'refresh');
        }
    }
    public function currencyById()
    {
        if ($this->session->userdata('user_login_access') != False) 
        {
            $id               = $this->input->get('id');
            $data['catvalue'] = $this->currencyCode_model->getCurrencyValueById($id);
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
        $this->load->model('transaction_model');
        $this->currencyCode_model->set_notifiication($data);
    }
    public function currency_delet(){
        if ($this->session->userdata('user_login_access') != False) {
            $id = $this->input->get('id');
            $this->transaction_model->currencyTableDelet($id);
            if ($this->db->affected_rows()) {
                $profile    = $this->transaction_model->getCurrencyValue($id);
                $checkimage = "./assets/img/user/$profile->image";
                if (file_exists($checkimage)) {
                    unlink($checkimage);
                    redirect('transaction/currency_delet');
                }
                /*      $this->crud_model->User_Notes_Delet($id);
                $this->crud_model->User_commentid_Delet($id);*/
                
            } else {
                redirect(base_url(), 'refresh');
            }
        }
    }

    public function Delet_CurrencyInfo(){
        if ($this->session->userdata('user_login_access') != False) {
            $id    = base64_decode($this->input->get('D'));
            $value = $this->transaction_model->getCurrencyById($id);
            if (!empty($value)) {
                $deletproduct = $this->transaction_model->delet_currency($id);
                
                
                redirect('transaction/view_currency');
            } else {
                $this->session->set_flashdata('feedback', 'Your request do not valid');
                redirect('transaction/view_currency');
            }
        } else {
            redirect(base_url(), 'refresh');
        }
    }
}
?>