<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class dashboard extends CI_Controller
{
    public $q=0;

    function __construct(){
        parent::__construct();
        $this->load->database();
        $this->load->model('dashboard_model');
        $this->load->model('login_model');
    }

 
    
    public function addCurrencyData(){
        if ($this->session->userdata('user_login_access') != False) {
            
             
             //$lastId = $this->db->insert_id();
            //$q=$_GET["q"];
            //$sql="SELECT * FROM transcation WHERE transaction_id = '".$q."'";
            
            //$result = mysql_query($sql);

            $catid    = $this->db->insert_id();
            $cid    = $this->input->post('detail_id');
            //$pair = $this->input->post('pair');
            $amount = $this->input->post('Aamount');
            //$AT = $this->input->post('AT');
            $AF = $this->input->post('AF');
            $AT=$this->input->post('AT');
            $cur=split(',',$AT);
            //$b=t.options[t.selectedIndex].value.split(",")[1];
            //$Ato=split(",", $AT);
            //$ATT=$this->input->post('AT');

            $action="Buy";
            //$cby   = $this->input->post('cby');
            // Validating category Type Field 
            $this->load->library('form_validation');
            
            
            // Validating SKU Field
            $this->form_validation->set_rules('Aamount', 'amount', 'trim|min_length[1]|max_length[40]|xss_clean|required');
            // Validating product Field
            $this->form_validation->set_rules('AT', 'To  Currency', 'trim|min_length[1]|max_length[250]|xss_clean|required');

            // Validating summary Field
            $this->form_validation->set_rules('AF', 'From Currency', 'trim|min_length[2]|max_length[100]|xss_clean|required');
            // Validating details Type Field 
            //$this->form_validation->set_rules('cby', 'Created By', 'trim|min_length[2]|max_length[1200]|xss_clean|required');
            //Validating Category Field
             //$this->form_validation->set_rules('pair', 'Currency Pair', 'trim|xss_clean');

            if ($this->form_validation->run() == FALSE) 
            {
                $response['status']  = 'error';
                $response['message'] = validation_errors();
                $this->output->set_output(json_encode($response));
            } 
            else 
            {
                $data = array();
                $userid = $this->session->userdata('user_login_id');
                //$user = $this->dashboard_model->GetProfileValue($userid);
                //$datas = array();
                $data = array(
                     'transaction_id' => $catid,
                    //'currency_id' => $pair,
                    //'amount' => $amount,
                    //'rate' => $AT
                    //'date' => $date,
                    'created_by' => "mama"
                );
               /* $datas = array(
                     'detail_id' => $cid,
                    'transaction_id' =>$catid,
                    'currency_in'=>$AF,
                    'currency_out' =>$cur[0],
                    'action' => $action,
                    'amount' => $amount,
                    'rate' => $cur[1]
                    //'date' => $date,
                    //'created_by' => $cby
                );*/
                 $this->db->trans_begin(); 
                if (!empty($catid) ){
                    $update              = $this->dashboard_model->updateCurrency($catid, $data);
                    $updates              = $this->dashboard_model->updateCurrencys($cid, $datas);
                    $response['status']  = 'success';
                    $response['message'] = "Successfully Updated";
                    $this->output->set_output(json_encode($response));
                }
                else 
                {
                    $insert              = $this->dashboard_model->insertcurrency($data);
                    $datas = array();
                    $datas = array(
                     'detail_id' => $cid,
                    'transaction_id' =>$insert,
                    'currency_in'=>$AF,
                    'currency_out' =>$cur[0],
                    'action' => $action,
                    'amount' => $amount,
                    'rate' => $cur[1]
                    //'date' => $date,
                    //'created_by' => $cby
                );
                    $inserts              = $this->dashboard_model->insertcurrencys($datas);
                    $response['status']  = 'success';
                    $response['message'] = "Successfully Added";
                    $this->output->set_output(json_encode($response));
                }

            }
            $this->db->trans_complete();
        } else {
            redirect(base_url(), 'refresh');
        }
    }

     public function addCurrencyDatas(){
        if ($this->session->userdata('user_login_access') != False) {
            
             //$lastId = $this->db->insert_id();
            //$q=$_GET["q"];
            //$sql="SELECT * FROM transcation WHERE transaction_id = '".$q."'";
            
            //$result = mysql_query($sql);

            $catid    = $this->input->post('transaction_id');
            $cid    = $this->input->post('detail_id');
            //$pair = $this->input->post('pair');
            $amount = $this->input->post('Bamount');
            //$AT = $this->input->post('AT');
            $AF = $this->input->post('BF');
            $BT=$this->input->post('BT');
            //$AT=$this->input->post('AT');
            $cur=split(',',$BT);
            $action="Sell";
            //$cby   = $this->input->post('cby');
            // Validating category Type Field 
            $this->load->library('form_validation');
            
            
            // Validating SKU Field
            $this->form_validation->set_rules('Bamount', 'amount', 'trim|min_length[1]|max_length[40]|xss_clean|required');
            // Validating product Field
            //$this->form_validation->set_rules('AT', 'To  Currency', 'trim|min_length[1]|max_length[250]|xss_clean|required');

            // Validating summary Field
           // $this->form_validation->set_rules('AF', 'From Currency', 'trim|min_length[2]|max_length[100]|xss_clean|required');
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
                     'transaction_id' => $catid,
                    //'currency_id' => $pair,
                    //'amount' => $amount,
                    //'rate' => $rate
                    //'date' => $date,
                    'created_by' => "susu"

                );
                
                if (!empty($catid) ){
                    $update              = $this->dashboard_model->updateCurrency($catid, $data);
                    $updates              = $this->dashboard_model->updateCurrencys($cid, $datas);
                    $response['status']  = 'success';
                    $response['message'] = "Successfully Updated";
                    $this->output->set_output(json_encode($response));
                } else {
                    $insert              = $this->dashboard_model->insertcurrency($data);
                    $datas = array();
                    $datas = array(
                     'detail_id' => $cid,
                    'transaction_id' =>$insert,
                    'currency_in'=>$cur[0],
                    'currency_out' =>$AF,
                    'action' => $action,
                    'amount' => $amount,
                    'rate' => $cur[1]
                    //'date' => $date,
                    //'created_by' => $cby
                );

                    $inserts              = $this->dashboard_model->insertcurrencys($datas);
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
            $data['brandvalue'] = $this->dashboard_model->getCurrencyBYID($id);
            echo json_encode($data);
        } else {
            redirect(base_url(), 'refresh');
        }
    }

        public function getCurrencyrateById(){
        if ($this->session->userdata('user_login_access') != False) {
            $id                 = $this->input->get('id');
            $data['currency'] = $this->dashboard_model->getCurrencyrateBYID($id);
            echo json_encode($data);
        } else {
            redirect(base_url(), 'refresh');
        }
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


     public function view_currency()
    {
        if ($this->session->userdata('user_login_access') != False) 
        {
            $data             = array();
            $data['category'] = $this->dashboard_model->getCurrency();
            $data['currency'] = $this->dashboard_model->getCurrencyRate();
            //echo $lastId = $this->db->insert_id();
             //$lastId = $this->db->insert_id();
            //$data['value']=$this->dashboard_model->getValue();
            $this->load->view('backend/dashboard', $data);
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
            $data['catvalue'] = $this->dashboard_model->getCurrencyValueById($id);
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
        $this->load->model('dashboard_model');
        $this->dashboard_model->set_notifiication($data);
    }
    public function currency_delet(){
        if ($this->session->userdata('user_login_access') != False) {
            $id = $this->input->get('id');
            $this->dashboard_model->currencyTableDelet($id);
            if ($this->db->affected_rows()) {
                $profile    = $this->dashboard_model->getCurrencyValue($id);
                $checkimage = "./assets/img/user/$profile->image";
                if (file_exists($checkimage)) {
                    unlink($checkimage);
                    redirect('dashboard/currency_delet');
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
            $value = $this->dashboard_model->getCurrencyById($id);
            if (!empty($value)) {
                $deletproduct = $this->dashboard_model->delet_currency($id);
                
                
                redirect('dashboard/view_currency');
            } else {
                $this->session->set_flashdata('feedback', 'Your request do not valid');
                redirect('dashboard/view_currency');
            }
        } else {
            redirect(base_url(), 'refresh');
        }
    }
}
?>