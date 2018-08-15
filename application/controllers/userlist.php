<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class userlist extends CI_Controller{
    
    function __construct(){
        parent::__construct();
        $this->load->database();
        $this->load->model('userlist_model');
        $this->load->model('login_model');
    }

    public function List_user(){
        if ($this->session->userdata('user_login_access') != False) {
            $data                  = array();
            $data['userlist']      = $this->userlist_model->getAllUsers();
            $data['settingsvalue'] = $this->userlist_model->getSettingsValue();
            $this->load->view('backend/userlist', $data);
        } else {
            redirect(base_url(), 'refresh');
        }
    }
     
  public function List_user_updated(){
        if ($this->session->userdata('user_login_access') != False) {
            $data                  = array();
            $data['userlist']      = $this->userlist_model->getAllUsers();
            $data['settingsvalue'] = $this->userlist_model->getSettingsValue();
            $this->load->view('backend/userlist-updated', $data);
        } else {
            redirect(base_url(), 'refresh');
        }
    }
    public function user_delet(){
        if ($this->session->userdata('user_login_access') != False) {
            $id = $this->input->get('id');
            $this->userlist_model->userTableDelet($id);
            if ($this->db->affected_rows()) {
                $profile    = $this->userlist_model->getUserValue($id);
                $checkimage = "./assets/img/user/$profile->image";
                if (file_exists($checkimage)) {
                    unlink($checkimage);
                    redirect('crud/List_user');
                }
                /*      $this->crud_model->User_Notes_Delet($id);
                $this->crud_model->User_commentid_Delet($id);*/
                
            } else {
                redirect(base_url(), 'refresh');
            }
        }
    }
    public function viewUserDataBYID(){
        if ($this->session->userdata('user_login_access') != False) {
            $id                = $this->input->get('id');
            $data['uservalue'] = $this->userlist_model->getUserValue($id);
            echo json_encode($data);
        } else {
            redirect(base_url(), 'refresh');
        }
    }
public function View_profile(){
        if ($this->session->userdata('user_login_access') != False) {
            $userid                = base64_decode($this->input->get('U'));
            $data                  = array();
            $data['settingsvalue'] = $this->userlist_model->getSettingsValue();
            $data['profile']       = $this->userlist_model->getProfileValue($userid);
            $data['usernote']      = $this->userlist_model->getUserNotes($userid);
            $this->load->view('backend/profile', $data);
        } else {
            redirect(base_url(), 'refresh');
        }
    }
}

?>