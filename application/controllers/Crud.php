<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Crud extends CI_Controller{
    
    function __construct(){
        parent::__construct();
        $this->load->database();
        $this->load->model('crud_model');
        $this->load->model('login_model');
    }
    
    public function index(){
        if ($this->session->userdata('user_login_access') != 1)
            redirect(base_url() . 'login', 'refresh');
        if ($this->session->userdata('user_login_access') == 1)
            $data = array();
        redirect('crud/dashboard');
    }
    /*Dashboard section*/
    public function dashboard(){
        if ($this->session->userdata('user_login_access') != False) {
            $data             = array();
            $userid           = $this->session->userdata('user_login_id');
            $data['todolist'] = $this->crud_model->getTodoInfo($userid);
            //$this->load->view('backend/dashboard', $data);
            redirect('crud/view_dashboard', $data);
        } else {
            redirect(base_url(), 'refresh');
        }
    }


    /*List all user*/
    public function List_user(){
        if ($this->session->userdata('user_login_access') != False) {
            $data                  = array();
            $data['userlist']      = $this->crud_model->getAllUsers();
            $data['settingsvalue'] = $this->crud_model->getSettingsValue();
            $this->load->view('backend/userlist', $data);
        } else {
            redirect(base_url(), 'refresh');
        }
    }
    /*|||||||||||||| UPDATED |||||||||||||||*/
    public function List_user_updated(){
        if ($this->session->userdata('user_login_access') != False) {
            $data                  = array();
            $data['userlist']      = $this->crud_model->getAllUsers();
            $data['settingsvalue'] = $this->crud_model->getSettingsValue();
            $this->load->view('backend/userlist-updated', $data);
        } else {
            redirect(base_url(), 'refresh');
        }
    }
    /*|||||||||||||| UPDATED |||||||||||||||*/
    
    
    /*Add user Form View*/
    public function Add_User(){
        if ($this->session->userdata('user_login_access') != False) {
            $data['settingsvalue'] = $this->crud_model->getSettingsValue();
            $this->load->view('backend/adduser', $data);
        } else {
            redirect(base_url(), 'refresh');
        }
    }
    # user delect
    public function user_delet(){
        if ($this->session->userdata('user_login_access') != False) {
            $id = $this->input->get('id');
            $this->crud_model->userTableDelet($id);
            if ($this->db->affected_rows()) {
                $profile    = $this->crud_model->getUserValue($id);
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

        /*user profile*/
    public function View_profile(){
        if ($this->session->userdata('user_login_access') != False) {
            $userid                = base64_decode($this->input->get('U'));
            $data                  = array();
            $data['settingsvalue'] = $this->crud_model->getSettingsValue();
            $data['profile']       = $this->crud_model->getProfileValue($userid);
            $data['usernote']      = $this->crud_model->getUserNotes($userid);
            $this->load->view('backend/profile', $data);
        } else {
            redirect(base_url(), 'refresh');
        }
    }
   
    /*Note validation*/
    public function noteValidation(){
        if ($this->session->userdata('user_login_access') != False) {
            $userid      = $this->input->post('userid');
            $commentid   = $this->input->post('commentid');
            $description = $this->input->post('description');
            $date        = date("Y-m-d h:i:sa");
            $this->load->library('form_validation');
            // Validating group name Field
            $this->form_validation->set_rules('userid', 'User Id', 'required|xss_clean');
            $this->form_validation->set_rules('commentid', 'Comment ID', 'required|trim|xss_clean');
            $this->form_validation->set_rules('description', 'description', 'required|trim|min_length[10]|max_length[1024]|xss_clean');
            if ($this->form_validation->run() == FALSE) {
                $response['status']  = 'error';
                $response['message'] = validation_errors();
                $this->output->set_output(json_encode($response));
            } else {
                if ($_FILES['note_file']['name']) {
                    $file_name = $_FILES['note_file']['name'];
                    $fileSize  = $_FILES["note_file"]["size"] / 1024;
                    $fileType  = $_FILES["note_file"]["type"];
                    
                    $config = array(
                        'upload_path' => "./assets/img/note",
                        'allowed_types' => "gif|jpg|png|jpeg|pdf",
                        'overwrite' => False,
                        'max_size' => "40480000", // Can be set to particular file size , here it is 4 MB(2048 Kb)
                        'max_height' => "2100",
                        'max_width' => "2100"
                    );
                    
                    $this->load->library('Upload', $config);
                    $this->upload->initialize($config);
                    if (!$this->upload->do_upload('note_file')) {
                        $response['status']  = 'success';
                        $response['message'] = $this->upload->display_errors();
                        $this->output->set_output(json_encode($response));
                    } else {
                        $path                = $this->upload->data();
                        $img_url             = $path['file_name'];
                        $data                = array();
                        $data                = array(
                            'user_id' => $userid,
                            'comment_id' => $commentid,
                            'description' => $description,
                            'note_image' => $img_url,
                            'datetime' => $date
                        );
                        $success             = $this->crud_model->addUserNote($data);
                        $response['status']  = 'success';
                        $response['message'] = "Successfully Added";

                        $this->output->set_output(json_encode($response));
                    }
                } else {
                    $data                = array();
                    $data                = array(
                        'user_id' => $userid,
                        'comment_id' => $commentid,
                        'description' => $description,
                        'datetime' => $date
                    );
                    $success             = $this->crud_model->addUserNote($data);
                    $response['status']  = 'success';
                    $response['message'] = "Successfully Added";
                    $this->output->set_output(json_encode($response));
                }
            }
        } else {
            redirect(base_url(), 'refresh');
        }
    }
    /*Group list for admin*/
    public function ListGroup(){
        if ($this->session->userdata('user_login_access') != False && $this->session->userdata('user_type') == 'Admin') {
            $data                  = array();
            $data['settingsvalue'] = $this->crud_model->getSettingsValue();
            $data['userrole']      = $this->crud_model->getAllGroupsUser();
            $data['adminrole']     = $this->crud_model->getAllGroupsAdmin();
            $this->load->view('backend/listgroup', $data);
        } else {
            redirect(base_url(), 'refresh');
        }
    }
    /*Select Group data by id */
    public function groupDataByID(){
        if ($this->session->userdata('user_login_access') != False && $this->session->userdata('user_type') == 'Admin') {
            $id            = $this->input->get('id');
            $data['value'] = $this->crud_model->selectgroupdatabyId($id);
            echo json_encode($data);
        } else {
            redirect(base_url(), 'refresh');
        }
    }
    /*group information update*/
    public function Update_Group(){
        if ($this->session->userdata('user_login_access') != False && $this->session->userdata('user_type') == 'Admin') {
            
            $id   = $this->input->post('groupid');
            $name = $this->input->post('role');
            
            $this->load->library('form_validation');
            
            // Validating group name Field
            $this->form_validation->set_rules('groupname', 'Group name', 'trim|min_length[2]|max_length[25]|xss_clean');
            
            if ($this->form_validation->run() == FALSE) {
                
                $response['status']  = 'error';
                $response['message'] = validation_errors();
                $this->output->set_output(json_encode($response));
                
            } else {
                
                $data = array();
                $data = array(
                    'user_type' => $name
                );
                
                $success = $this->crud_model->updateGroupInfo($id, $data);
                
                if ($this->db->affected_rows()) {
                    
                    $response['status']  = 'success';
                    $response['message'] = "Successfully Updated";
                    $this->output->set_output(json_encode($response));
                }
            }
        } else {
            redirect(base_url(), 'refresh');
        }
    }
  
    /*single product information*/

  
    /*Reset password validation*/
    public function Add_Reset_password(){
        if ($this->session->userdata('user_login_access') != False) {
            $id          = $this->session->userdata('user_login_id');
            $oldpass     = sha1($this->input->post('oldpass'));
            $newpass     = $this->input->post('newpass');
            $confirmpass = $this->input->post('confirmpass');
            $userdata    = $this->crud_model->getUserValue($id);
            if ($userdata->password == $oldpass && $newpass == $confirmpass) {
                $data = array();
                $data = array(
                    'password' => sha1($newpass)
                );
                if (!empty($id)) {
                    $update              = $this->crud_model->updatePassword($id, $data);
                    $inserted            = $this->db->affected_rows();
                    $response['status']  = 'success';
                    $response['message'] = "Successfully Updated Your  password";
                    $this->output->set_output(json_encode($response));
                }
            } else {
                $response['status']  = 'error';
                $response['message'] = "Please enter Valid password";
                $this->output->set_output(json_encode($response));
            }
        } else {
            redirect(base_url(), 'refresh');
        }
    }
    /*to-do note validation*/
    public function addTodoData(){
        if ($this->session->userdata('user_login_access') != False) {
            
            $userid   = $this->input->post('userid');
            $tododata = $this->input->post('todo_data');
            $date     = date("Y-m-d h:i:sa");
            
            $this->load->library('form_validation');
            
            //validating to do list data
            $this->form_validation->set_rules('userid', 'user Id', 'trim|xss_clean');
            $this->form_validation->set_rules('todo_data', 'To-do Data', 'trim|required|min_length[3]|max_length[150]|xss_clean');
            
            if ($this->form_validation->run() == FALSE) {
                $response['status']  = 'error';
                $response['message'] = validation_errors();
                $this->output->set_output(json_encode($response));
            } else {
                $data = array();
                $data = array(
                    'user_id' => $userid,
                    'to_dodata' => $tododata,
                    'value' => '1',
                    'date' => $date
                );
                
                $success    = $this->crud_model->insert_tododata($data);
                $todoLastId = $this->db->insert_id();
                
                if ($success) {
                    
                    $todoHtml = "<li class='todo-item'>";
                    $todoHtml .= "<div class='checkbox checkbox-default'>";
                    $todoHtml .= "<input class='to-do' data-id='" . $todoLastId . "' data-value='0' type='checkbox' id='" . $todoLastId . "'>";
                    $todoHtml .= "<label for='" . $todoLastId . "'>" . $tododata . "</label>";
                    $todoHtml .= "</div>";
                    $todoHtml .= "</li>";
                    $todoHtml .= "<li><hr class='light-grey-hr'></li>";
                    
                    $response['status']   = 'success';
                    $response['todoHtml'] = $todoHtml;
                    $response['message']  = "Successfully Added";
                    $this->output->set_output(json_encode($response));
                }
            }
        } else {
            redirect(base_url(), 'refresh');
        }
    }
    /*Todo Data Update*/
    public function updateTododata(){
        
        if ($this->session->userdata('user_login_access') != False) {
            $id    = $this->input->post('toid');
            $value = $this->input->post('tovalue'); // initially 0 when not completed
            
            $data   = array();
            $data   = array(
                'value' => $value
            );
            $update = $this->crud_model->UpdateTododata($id, $data);
            
            $response['status']  = 'success';
            $response['value']   = $value;
            $response['message'] = "Successfully updated";
            $this->output->set_output(json_encode($response));
        }
        
        else {
            redirect(base_url(), 'refresh');
        }
    }

    /*Select user information By user ID*/
    public function viewUserDataBYID(){
        if ($this->session->userdata('user_login_access') != False) {
            $id                = $this->input->get('id');
            $data['uservalue'] = $this->crud_model->getUserValue($id);
            echo json_encode($data);
        } else {
            redirect(base_url(), 'refresh');
        }
    }
    /*user information validation*/
    public function addUserInfo(){
        if ($this->session->userdata('user_login_access') != False) {
            /*Custom Random password generator*/
            function rand_password($length) {
                $str   = "";
                $chars = "abcdefghijklmanopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
                $size  = strlen($chars);
                for ($i = 0; $i < $length; $i++) {
                    $str .= $chars[rand(0, $size - 1)];
                }
                return $str;
            }
            /*Set password length*/
            $pass_hash = sha1(rand_password(7));
            /*password length 7 & convert to Secure Hash Algorithm 1(SHA1)*/
            /*custom user id generator*/
            $userid    = 'U' . rand(500, 1000);
            /*generate random user ID from 500 to 1000*/
            $username  = $this->input->post('name');
            $email     = $this->input->post('email');
            $contact   = $this->input->post('contact');
            $address   = $this->input->post('address');
            $dob       = $this->input->post('dob');
            $country   = $this->input->post('country');
            $role      = $this->input->post('role');
            $gender    = $this->input->post('gender');
            $date      = date('Y-m-d');
            $this->load->library('form_validation');
            $this->form_validation->set_error_delimiters();
            // Validating Name Field
            $this->form_validation->set_rules('name', 'Name', 'trim|required|min_length[3]|max_length[60]|xss_clean');
            /*validating email field*/
            $this->form_validation->set_rules('email', 'Email', 'trim|required|min_length[7]|max_length[100]|xss_clean');
            /*Validating address field*/
            $this->form_validation->set_rules('address', 'address', 'trim|required|min_length[5]|max_length[150]|xss_clean');
            /*validating contact field*/
            $this->form_validation->set_rules('contact', 'Contact', 'trim|xss_clean');
            /*validating Date Of Birth field*/
            $this->form_validation->set_rules('dob', 'Date Of Birth', 'trim|xss_clean');
            /*validating country field*/
            $this->form_validation->set_rules('country', 'Country', 'trim|xss_clean');
            /*validating role field*/
            $this->form_validation->set_rules('role', 'Role', 'trim|xss_clean');
            /*validating gender field*/
            $this->form_validation->set_rules('gender', 'Gender', 'trim|xss_clean');
            
            if ($this->form_validation->run() == FALSE) {
                $response['status']  = 'error';
                $response['message'] = validation_errors();
                $this->output->set_output(json_encode($response));
            } else {
                if ($this->login_model->Does_email_exists($email)) {
                    $response['status']  = 'error';
                    $response['message'] = 'Email already exits';
                    $this->output->set_output(json_encode($response));
                } else {
                    if ($_FILES['user_image']['name']) {
                        $file_name     = $_FILES['user_image']['name'];
                        $fileSize      = $_FILES["user_image"]["size"] / 1024;
                        $fileType      = $_FILES["user_image"]["type"];
                        $new_file_name = '';
                        $new_file_name .= $userid;
                        
                        $config = array(
                            'file_name' => $new_file_name,
                            'upload_path' => "./assets/img/user",
                            'allowed_types' => "gif|jpg|png|jpeg",
                            'overwrite' => False,
                            'max_size' => "20240000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
                            'max_height' => "600",
                            'max_width' => "600"
                        );
                        
                        $this->load->library('Upload', $config);
                        $this->upload->initialize($config);
                        if (!$this->upload->do_upload('user_image')) {
                            $response['status']  = 'error';
                            $response['message'] = $this->upload->display_errors();
                            $this->output->set_output(json_encode($response));
                        } else {
                            $path                = $this->upload->data();
                            $img_url             = $path['file_name'];
                            $data                = array();
                            $data                = array(
                                'user_id' => $userid,
                                'full_name' => $username,
                                'email' => $email,
                                'password' => $pass_hash,
                                'address' => $address,
                                'dob' => $dob,
                                'image' => $img_url,
                                'contact' => $contact,
                                'gender' => $gender,
                                'country' => $country,
                                'status' => 'ACTIVE',
                                'user_type' => $role,
                                'created_on' => $date
                            );
                            $success             = $this->crud_model->addUserInfo($data);
                            $response['status']  = 'success';
                            $response['message'] = "Successfully Added";
                            $this->output->set_output(json_encode($response));
                            #$this->session->set_flashdata('feedback','Successfully Created');
                        }
                    } else {
                        $data                = array();
                        $data                = array(
                            'user_id' => $userid,
                            'full_name' => $username,
                            'email' => $email,
                            'password' => $pass_hash,
                            'address' => $address,
                            'dob' => $dob,
                            'contact' => $contact,
                            'gender' => $gender,
                            'country' => $country,
                            'status' => 'ACTIVE',
                            'user_type' => $role,
                            'created_on' => $date
                        );
                        $success             = $this->crud_model->addUserInfo($data);
                        $response['status']  = 'success';
                        $response['message'] = "Successfully Created";
                        $this->output->set_output(json_encode($response));
                        #$this->session->set_flashdata('feedback','Successfully Created');    
                    }
                }
            }
        } else {
            redirect(base_url(), 'refresh');
        }
    }
    /*user information update validation*/
    public function updateValue(){
        if ($this->session->userdata('user_login_access') != False) {
            $id       = $this->input->post('userid');
            $username = $this->input->post('name');
            $email    = $this->input->post('email');
            $contact  = $this->input->post('contact');
            $address  = $this->input->post('address');
            $dob      = $this->input->post('dob');
            $country  = $this->input->post('country');
            $gender   = $this->input->post('gender');
            $role     = $this->input->post('role');
            $this->load->library('form_validation');
            $this->form_validation->set_error_delimiters();
            // Validating Name Field
            $this->form_validation->set_rules('name', 'Name', 'trim|required|min_length[2]|max_length[60]|xss_clean');
            /*validating email field*/
            $this->form_validation->set_rules('email', 'Email', 'trim|required|min_length[7]|max_length[100]|xss_clean');
            /*Validating address field*/
            $this->form_validation->set_rules('address', 'address', 'trim|required|min_length[5]|max_length[150]|xss_clean');
            /*validating contact field*/
            $this->form_validation->set_rules('contact', 'Contact', 'trim|xss_clean');
            /*validating Date Of Birth field*/
            $this->form_validation->set_rules('dob', 'Date Of Birth', 'trim|xss_clean');
            /*validating country field*/
            $this->form_validation->set_rules('country', 'Country', 'trim|xss_clean');
            /*validating role field*/
            $this->form_validation->set_rules('role', 'Role', 'trim|xss_clean');
            /*validating gender field*/
            $this->form_validation->set_rules('gender', 'Gender', 'trim|xss_clean');
            
            if ($this->form_validation->run() == FALSE) {
                $response['status']  = 'error';
                $response['message'] = validation_errors();
                $this->output->set_output(json_encode($response));
            } else {
                if ($_FILES['user_image']['name']) {
                    $profile       = $this->crud_model->getUserValue($id);
                    $file_name     = $_FILES['user_image']['name'];
                    $fileSize      = $_FILES["user_image"]["size"] / 1024;
                    $fileType      = $_FILES["user_image"]["type"];
                    $new_file_name = '';
                    $new_file_name .= $id;
                    $checkimage = "./assets/img/user/$profile->image";
                    
                    $config = array(
                        'file_name' => $new_file_name,
                        'upload_path' => "./assets/img/user",
                        'allowed_types' => "gif|jpg|png|jpeg",
                        'overwrite' => False,
                        'max_size' => "20240000",
                        // Can be set to particular file size , here it is 2 MB(2048 Kb)
                        'max_height' => "600",
                        'max_width' => "600"
                    );
                    
                    $this->load->library('Upload', $config);
                    $this->upload->initialize($config);
                    if (!$this->upload->do_upload('user_image')) {
                        
                        $response['status']  = 'error';
                        $response['message'] = $this->upload->display_errors();
                        $this->output->set_output(json_encode($response));
                    } else {
                        if (file_exists($checkimage)) {
                            unlink($checkimage);
                        }
                        $path                = $this->upload->data();
                        $img_url             = $path['file_name'];
                        $data                = array();
                        $data                = array(
                            'full_name' => $username,
                            'email' => $email,
                            'address' => $address,
                            'dob' => $dob,
                            'image' => $img_url,
                            'contact' => $contact,
                            'gender' => $gender,
                            'user_type' => $role,
                            'country' => $country
                        );
                        $success             = $this->crud_model->UserUpdate($id, $data);
                        $response['id']      = $id;
                        $data['image']       = base_url() . 'assets/img/user/' . $data['image'];
                        $response['data']    = $data;
                        $response['status']  = 'success';
                        $response['message'] = "Successfully Updated";
                        $this->output->set_output(json_encode($response));
                        #$this->session->set_flashdata('feedback','Successfully Updated');    
                    }
                } else {
                    $data                = array();
                    $data                = array(
                        'full_name' => $username,
                        'email' => $email,
                        'address' => $address,
                        'dob' => $dob,
                        'contact' => $contact,
                        'gender' => $gender,
                        'user_type' => $role,
                        'country' => $country
                    );
                    $success             = $this->crud_model->UserUpdate($id, $data);
                    $response['id']      = $id;
                    $response['data']    = $data;
                    $response['status']  = 'success';
                    $response['message'] = "Successfully Updated";
                    $this->output->set_output(json_encode($response));
                }
                
            }
        } else {
            redirect(base_url(), 'refresh');
        }
    }
    public function Site_Settings(){
        if ($this->session->userdata('user_login_access') != False && $this->session->userdata('user_type') == 'Admin') {
            $data['settingsvalue'] = $this->crud_model->getSettingsValue();
            $this->load->view('backend/settings', $data);
        } else {
            redirect(base_url(), 'refresh');
        }
    }
 
    /*Product image delete controller*/
    public function unlinkImage(){
        if ($this->session->userdata('user_login_access') != False) {
            $id       = $this->input->get('UN');
            $imgvalue = $this->crud_model->getSingleProImageById($id);
            if (!empty($imgvalue->id)) {
                unlink("./assets/img/product/$imgvalue->img_url");
                $delet               = $this->crud_model->deelet_Img($id);
                $response['status']  = 'success';
                $response['message'] = "Successfully Deleted";
                $this->output->set_output(json_encode($response));
            }
            
        } else {
            redirect(base_url(), 'refresh');
        }
    }

    /*Product image delet controller*/
   
    public function addSettings(){
        if ($this->session->userdata('user_login_access') != False && $this->session->userdata('user_type') == 'Admin') {
            $id          = $this->input->post('id');
            $title       = $this->input->post('title');
            $description = $this->input->post('description');
            $copyright   = $this->input->post('copyright');
            $contact     = $this->input->post('contact');
            $currency    = $this->input->post('currency');
            $symbol      = $this->input->post('symbol');
            $email       = $this->input->post('email');
            $address     = $this->input->post('address');
            $this->load->library('form_validation');
            $this->form_validation->set_error_delimiters();
            // Validating Title Field
            $this->form_validation->set_rules('title', 'Title', 'trim|required|min_length[5]|max_length[60]|xss_clean');
            // Validating description Field
            $this->form_validation->set_rules('description', 'Description', 'trim|required|min_length[20]|max_length[180]|xss_clean');
            // Validating copyright Field
            $this->form_validation->set_rules('copyright', 'Copyright', 'trim|xss_clean');
            // Validating contact Field
            $this->form_validation->set_rules('contact', 'Contact', 'trim|xss_clean');
            // Validating currency Field
            $this->form_validation->set_rules('currency', 'Currency', 'trim|xss_clean');
            // Validating symbol Field
            $this->form_validation->set_rules('symbol', 'Symbol', 'trim|xss_clean');
            // Validating email Field
            $this->form_validation->set_rules('email', 'Email', 'trim|xss_clean');
            // Validating address Field
            $this->form_validation->set_rules('address', 'Address', 'trim|min_length[5]|max_length[60]|xss_clean');
            
            if ($this->form_validation->run() == FALSE) {
                $response['status']  = 'error';
                $response['message'] = validation_errors();
                $this->output->set_output(json_encode($response));
            } else {
                
                if ($_FILES['img_url']['name']) {
                    $settings   = $this->crud_model->getSettingsValue();
                    $file_name  = $_FILES['img_url']['name'];
                    $fileSize   = $_FILES["img_url"]["size"] / 1024;
                    $fileType   = $_FILES["img_url"]["type"];
                    /*          $new_file_name='';
                    $new_file_name .= $title;*/
                    $checkimage = "./assets/img/$settings->sitelogo";
                    
                    $config = array(
                        'file_name' => $file_name,
                        'upload_path' => "./assets/img",
                        'allowed_types' => "gif|jpg|png|jpeg|svg",
                        'overwrite' => False,
                        'max_size' => "13038", // Can be set to particular file size , here it is 220KB(220 Kb)
                        'max_height' => "850",
                        'max_width' => "850"
                    );
                    
                    $this->load->library('Upload', $config);
                    $this->upload->initialize($config);
                    if (!$this->upload->do_upload('img_url')) {
                        $response['status']  = 'success';
                        $response['message'] = $this->upload->display_errors();
                        $this->output->set_output(json_encode($response));
                    } else {
                        if (file_exists($checkimage)) {
                            unlink($checkimage);
                        }
                        $path                = $this->upload->data();
                        $img_url             = $path['file_name'];
                        $data                = array();
                        $data                = array(
                            'sitelogo' => $img_url,
                            'sitetitle' => $title,
                            'description' => $description,
                            'copyright' => $copyright,
                            'contact' => $contact,
                            'currency' => $currency,
                            'symbol' => $symbol,
                            'system_email' => $email,
                            'address' => $address
                        );
                        $success             = $this->crud_model->settingsUpdate($id, $data);
                        $response['status']  = 'success';
                        $response['message'] = "Successfully Updated";
                        $this->output->set_output(json_encode($response));
                        #$this->session->set_flashdata('feedback','Successfully Updated');    
                    }
                } else {
                    $data                = array();
                    $data                = array(
                        'sitetitle' => $title,
                        'description' => $description,
                        'copyright' => $copyright,
                        'contact' => $contact,
                        'currency' => $currency,
                        'symbol' => $symbol,
                        'system_email' => $email,
                        'address' => $address
                    );
                    $success             = $this->crud_model->settingsUpdate($id, $data);
                    $response['status']  = 'success';
                    $response['message'] = "Successfully Updated";
                    $this->output->set_output(json_encode($response));
                }
            }
        } else {
            redirect(base_url(), 'refresh');
        }
    }
    //Similarly, you can force download other files formats like word doc, pdf files, etc.
   
    public function Backup_page(){
        if ($this->session->userdata('user_login_access') != False) {
            $this->load->view('backend/backup');
        } else {
            redirect(base_url(), 'refresh');
        }
    }
    public function Backup_Database(){
        $database = 'crud';
        $username = 'root';
        $password = '';
        $hostname = 'localhost';
        $path     = 'assets/dbbackup.sql';
        if ($this->Backup_sql($database, $username, $password, $hostname, $path)) {
            $this->session->set_flashdata('feedback', 'Successfully Downloaded');
            redirect(base_url() . 'crud/Backup_page');
        } else {
            $this->session->set_flashdata('feedback', 'Successfully Downloaded');
            redirect(base_url() . 'crud/Backup_page');
        }
    }
    public function Backup_sql($database, $username, $password, $hostname, $path){

        //ENTER THE RELEVANT INFO BELOW
        $mysqlDatabaseName = $database;
        $mysqlUserName     = $username;
        $mysqlPassword     = $password;
        $mysqlHostName     = $hostname;
        $mysqlExportPath   = $path;
        
        //DO NOT EDIT BELOW THIS LINE
        //Export the database and output the status to the page
        $command = 'mysqldump --opt -h' . $mysqlHostName . ' -u' . $mysqlUserName . ' -p' . $mysqlPassword . ' ' . $mysqlDatabaseName . ' > ' . $mysqlExportPath;
        exec($command, $output = array(), $worked);
        switch ($worked) {
            case 0:
                echo 'Database <b>' . $mysqlDatabaseName . '</b> successfully exported to <b>' . getcwd() . '/' . $mysqlExportPath . '</b>';
                break;
            case 1:
                echo 'There was a warning during the export of <b>' . $mysqlDatabaseName . '</b> to <b>' . getcwd() . '/' . $mysqlExportPath . '</b>';
                break;
            case 2:
                echo 'There was an error during export. Please check your values:<br/><br/><table><tr><td>MySQL Database Name:</td><td><b>' . $mysqlDatabaseName . '</b></td></tr><tr><td>MySQL User Name:</td><td><b>' . $mysqlUserName . '</b></td></tr><tr><td>MySQL Password:</td><td><b>NOTSHOWN</b></td></tr><tr><td>MySQL Host Name:</td><td><b>' . $mysqlHostName . '</b></td></tr></table>';
                break;
                
        }
    }
    
    
    /*Notification*/
    function set_notification(){
        $data = $_POST["id"];
        $this->load->model('Crud_model');
        $this->Crud_model->set_notifiication($data);
    }
    /*End crud controller*/

    //currency_code

    
    public function currency_list(){
        if ($this->session->userdata('user_login_access') != False) {
            $data                  = array();
            $data['settingsvalue'] = $this->crud_model->getSettingsValue();
            $data['proimage']      = $this->crud_model->getProImage();
            //$data['productlist']   = $this->crud_model->getProductData();   
            $this->load->view('backend/currencyCode', $data);
        } else {
            redirect(base_url(), 'refresh');
        }
    }



    public function addCurrencyCodesData()
    {
        if ($this->session->userdata('user_login_access') != False) 
        {
            //$id          = $this->input->post('pro_id');
            $proid       = 'P' . rand(0, 1000);
            $catid    = $this->input->post('currency_id');
            //$pair = $this->input->post('pair');
            $brate = $this->input->post('brate');
            $srate = $this->input->post('srate');
            //$date = $this->input->post('date');
            //$cby   = $this->input->post('cby');
            // Validating category Type Field 
            $this->load->library('form_validation');
           
           
            $this->form_validation->set_rules('brate', 'Buy Rate', 'trim|min_length[1]|max_length[40]|xss_clean|required');
            // Validating product Field
            $this->form_validation->set_rules('srate', 'Sell Rate', 'trim|min_length[1]|max_length[250]|xss_clean|required');

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
                    $uploadPath                          = 'assets/img/currency_code';
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
                        $success                     = $this->crud_model->productImgInsert($data1);
                    }
                }
                 if (!empty($uploadData)) {
                    $data                = array();
                    $data                = array(
                         'currency_id' => $catid,
                         //'currency_id' => $pair,
                         'codes' => $brate,
                         'code_name' => $srate);
                 
                    $update              = $this->crud_model->updateCurrencyCode($catid, $data);
                    $response['status']  = 'success';
                    $response['message'] = "Successfully Updated";
                    $this->output->set_output(json_encode($response));
                }else {
                    $data                = array();
                    $data                = array(
                         'currency_id' => $catid,
                         //'currency_id' => $pair,
                         'codes' => $brate,
                         'code_name' => $srate);
                    $insert              = $this->crud_model->insertcurrencyCode($data);
                    $response['status']  = 'success';
                    $response['message'] = "Successfully Added";
                    $this->output->set_output(json_encode($response));
                }
                     
                    
              }
                    
       } 
   }
        
    public function Download_image(){
        // Get parameters
        $file     = $this->input->get('product_image');
        $filepath = "./assets/img/user/" . $file;
        // Process download
        if (file_exists($filepath)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . basename($filepath) . '"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($filepath));
            flush(); // Flush system output buffer
            readfile($filepath);
            exit();
        }
    }


     public function addCurrencyCodeData(){
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
                    $update              = $this->crud_model->updateCurrencyCode($catid, $data);
                    $response['status']  = 'success';
                    $response['message'] = "Successfully Updated";
                    $this->output->set_output(json_encode($response));
                } else {
                    $insert              = $this->crud_model->insertcurrencyCode($data);
                    $response['status']  = 'success';
                    $response['message'] = "Successfully Added";
                    $this->output->set_output(json_encode($response));
                }
            }
        }
    }
    


        
    
    public function getCurrencyCodeById(){
        if ($this->session->userdata('user_login_access') != False) {
            $id                 = $this->input->get('id');
            $data['brandvalue'] = $this->crud_model->getCurrencyCodeBYID($id);
            echo json_encode($data);
        } else {
            redirect(base_url(), 'refresh');
        }
    }

        /*public function getCurrencyrateById(){
        if ($this->session->userdata('user_login_access') != False) {
            $id                 = $this->input->get('id');
            $data['currency'] = $this->crud_model->getCurrencyrateBYID($id);
            echo json_encode($data);
        } else {
            redirect(base_url(), 'refresh');
        }
    }*/





     public function view_code()
    {
        if ($this->session->userdata('user_login_access') != False) 
        {
            $data             = array();
            $data['settingsvalue'] = $this->crud_model->getSettingsValue();
            $data['category'] = $this->crud_model->getCurrencyCode();
            //$data['currency'] = $this->currencyCode_model->getCurrencyRate();
            $this->load->view('backend/currencyCode', $data);
        } 
        else 
        {
            redirect(base_url(), 'refresh');
        }
    }
    public function currencyCodeById()
    {
        if ($this->session->userdata('user_login_access') != False) 
        {
            $id               = $this->input->get('id');
            $data['catvalues'] = $this->crud_model->getCurrencyCodeValueById($id);
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
  
    public function currencyCode_delet(){
        if ($this->session->userdata('user_login_access') != False) {
            $id = $this->input->get('id');
            $this->crud_model->currencyCodeTableDelet($id);
            if ($this->db->affected_rows()) {
                $profile    = $this->crud_model->getCurrencyCodeValue($id);
                $checkimage = "./assets/img/user/$profile->image";
                if (file_exists($checkimage)) {
                    unlink($checkimage);
                    redirect('crud/currencyCode_delet');
                }
                /*      $this->crud_model->User_Notes_Delet($id);
                $this->crud_model->User_commentid_Delet($id);*/
                
            } else {
                redirect(base_url(), 'refresh');
            }
        }
    }

    
     public function Delet_CurrencyCodeInfo(){
        if ($this->session->userdata('user_login_access') != False) {
            $id    = base64_decode($this->input->get('D'));
            $value = $this->crud_model->getCurrencyCodeById($id);
            if (!empty($value)) {
                $deletproduct = $this->crud_model->delet_currencyCode($id);
                //$deletcolor   = $this->crud_model->delet_Color($id);
                //$deletsize    = $this->crud_model->delet_Size($id);
                //$imgvalue     = $this->crud_model->getProImageById($id);
                /*if (!empty($imgvalue)) {
                    foreach ($imgvalue as $value) {
                        while (file_exists("./assets/img/product/$value->img_url")) {
                            unlink("./assets/img/product/$value->img_url");
                        }
                    }
                    $delet = $this->crud_model->deelet_Pro_Imgage($id);
                }*/
                redirect('crud/view_code');
            } else {
                $this->session->set_flashdata('feedback', 'Your request do not valid');
                redirect('crud/view_code');
            }
        } else {
            redirect(base_url(), 'refresh');
        }
    }
  


    public function Delet_CurrencyCodesInfo(){
        if ($this->session->userdata('user_login_access') != False) {
            $id    = base64_decode($this->input->get('D'));
            $value = $this->crud_model->getCurrencyCodeById($id);
            if (!empty($value)) {
                $deletproduct = $this->crud_model->delet_currencyCode($id);
                
                
                redirect('crud/view_code');
            } else {
                $this->session->set_flashdata('feedback', 'Your request do not valid');
                redirect('crud/view_code');
            }
        } else {
            redirect(base_url(), 'refresh');
        }
    }//end currency_code



    //currency_rate
     
    public function addCurrencyRateData(){
        if ($this->session->userdata('user_login_access') != False) {
            $catid    = $this->input->post('rate_id');
            $pair = $this->input->post('pair');
            $brate = $this->input->post('brate');
            $srate = $this->input->post('srate');
            //$date = $this->input->post('date');
            $cby   = $this->input->post('cby');
            // Validating category Type Field 
            $this->load->library('form_validation');
            
            
            // Validating SKU Field
            $this->form_validation->set_rules('brate', 'Buy Rate', 'trim|min_length[1]|max_length[40]|xss_clean|required');
            // Validating product Field
            $this->form_validation->set_rules('srate', 'Sell Rate', 'trim|min_length[1]|max_length[250]|xss_clean|required');
            // Validating summary Field
            //$this->form_validation->set_rules('date', 'Date', 'trim|min_length[2]|max_length[100]|xss_clean|required');
            // Validating details Type Field 
            $this->form_validation->set_rules('cby', 'Created By', 'trim|min_length[2]|max_length[1200]|xss_clean|required');
            //Validating Category Field
             $this->form_validation->set_rules('pair', 'Currency Pair', 'trim|xss_clean');

            if ($this->form_validation->run() == FALSE) {
                $response['status']  = 'error';
                $response['message'] = validation_errors();
                $this->output->set_output(json_encode($response));
            } else {
                $data = array();
                $data = array(
                     'rate_id' => $catid,
                    'currency_id' => $pair,
                    'buy_rate' => $brate,
                    'sell_rate' => $srate,
                    //'date' => $date,
                    'created_by' => $cby
                );
                if (!empty($catid)) {
                    $update              = $this->crud_model->updateCurrencyRate($catid, $data);
                    $response['status']  = 'success';
                    $response['message'] = "Successfully Updated";
                    $this->output->set_output(json_encode($response));
                } else {
                    $insert              = $this->crud_model->insertcurrencyRate($data);
                    $response['status']  = 'success';
                    $response['message'] = "Successfully Added";
                    $this->output->set_output(json_encode($response));
                }
            }
        } else {
            redirect(base_url(), 'refresh');
        }
    }
    public function getCurrencyRateById(){
        if ($this->session->userdata('user_login_access') != False) {
            $id                 = $this->input->get('id');
            $data['brandvalue'] = $this->crud_model->getCurrencyRateBYID($id);
            echo json_encode($data);
        } else {
            redirect(base_url(), 'refresh');
        }
    }

       /* public function getCurrencyraById(){
        if ($this->session->userdata('user_login_access') != False) {
            $id                 = $this->input->get('id');
            $data['currency'] = $this->crud_model->getCurrencyrateBYID($id);
            echo json_encode($data);
        } else {
            redirect(base_url(), 'refresh');
        }
    }*/



     public function view_rate()
    {
        if ($this->session->userdata('user_login_access') != False) 
        {
            $data             = array();
            $data['category'] = $this->crud_model->getCurrencyRate();
            $data['currency'] = $this->crud_model->getCurrencyC();
            $this->load->view('backend/cuex', $data);
        } 
        else 
        {
            redirect(base_url(), 'refresh');
        }
    }
    public function currencyRateById()
    {
        if ($this->session->userdata('user_login_access') != False) 
        {
            $id               = $this->input->get('id');
            $data['catvalue'] = $this->crud_model->getCurrencyRateValueById($id);
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
   
    public function rate_delet(){
        if ($this->session->userdata('user_login_access') != False) {
            $id = $this->input->get('id');
            $this->crud_model->currencyRateTableDelet($id);
            if ($this->db->affected_rows()) {
                $profile    = $this->crud_model->getCurrencyRateValue($id);
                $checkimage = "./assets/img/user/$profile->image";
                if (file_exists($checkimage)) {
                    unlink($checkimage);
                    redirect('crud/rate_delet');
                }
                /*      $this->crud_model->User_Notes_Delet($id);
                $this->crud_model->User_commentid_Delet($id);*/
                
            } else {
                redirect(base_url(), 'refresh');
            }
        }
    }

    public function Delet_CurrencyRateInfo(){
        if ($this->session->userdata('user_login_access') != False) {
            $id    = base64_decode($this->input->get('D'));
            $value = $this->crud_model->getCurrencyRateById($id);
            if (!empty($value)) {
                $deletproduct = $this->crud_model->delet_currencyRate($id);
                
                
                redirect('crud/view_rate');
            } else {
                $this->session->set_flashdata('feedback', 'Your request do not valid');
                redirect('crud/view_rate');
            }
        } else {
            redirect(base_url(), 'refresh');
        }
    }//end currency_rate


    //dashboard

    public function addCurrencyDashData(){
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
                    $update              = $this->crud_model->updateCurrencyDash($catid, $data);
                    $updates              = $this->crud_model->updateCurrencysDash($cid, $datas);
                    $response['status']  = 'success';
                    $response['message'] = "Successfully Updated";
                    $this->output->set_output(json_encode($response));
                }
                else 
                {
                    $insert              = $this->crud_model->insertcurrencyDash($data);
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
                    $inserts              = $this->crud_model->insertcurrencysDash($datas);
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

     public function addCurrencyDashDatas(){
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
                    $update              = $this->crud_model->updateCurrencyDash($catid, $data);
                    $updates              = $this->crud_model->updateCurrencysDash($cid, $datas);
                    $response['status']  = 'success';
                    $response['message'] = "Successfully Updated";
                    $this->output->set_output(json_encode($response));
                } else {
                    $insert              = $this->crud_model->insertcurrencyDash($data);
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

                    $inserts              = $this->crud_model->insertcurrencysDash($datas);
                    $response['status']  = 'success';
                    $response['message'] = "Successfully Added";
                    $this->output->set_output(json_encode($response));
                }
            }
        } else {
            redirect(base_url(), 'refresh');
        }
    }


    /*public function getDashById(){
        if ($this->session->userdata('user_login_access') != False) {
            $id                 = $this->input->get('id');
            $data['brandvalue'] = $this->crud_model->getCurrencyBYID($id);
            echo json_encode($data);
        } else {
            redirect(base_url(), 'refresh');
        }
    }*/

      /*  public function getdashboardById(){
        if ($this->session->userdata('user_login_access') != False) {
            $id                 = $this->input->get('id');
            $data['currency'] = $this->crud_model->getCurrencyrateBYID($id);
            echo json_encode($data);
        } else {
            redirect(base_url(), 'refresh');
        }
    }*/
     
    /*public function getValue()
    {
            $amount    = $this->input->post('amount');
            $value = $this->input->post('tcur.getValue');
            //$brate = $this->input->post('amount');
            $query=$amount+$value;
            //$result   = $query->result();
            return $query;
    }*/


     public function view_dashboard()
    {
        if ($this->session->userdata('user_login_access') != False) 
        {
            $data             = array();
            //$data['category'] = $this->dashboard_model->getCurrency();
            $data['currency'] = $this->crud_model->getCurrencyDash();
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
    /*public function dashboardById()
    {
        if ($this->session->userdata('user_login_access') != False) 
        {
            $id               = $this->input->get('id');
            $data['catvalue'] = $this->crud_model->getCurrencyValueById($id);
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
    // }*/
  
    /*public function dash_delet(){
        if ($this->session->userdata('user_login_access') != False) {
            $id = $this->input->get('id');
            $this->crud_model->currencyTableDelet($id);
            if ($this->db->affected_rows()) {
                $profile    = $this->crud_model->getCurrencyValue($id);
                $checkimage = "./assets/img/user/$profile->image";
                if (file_exists($checkimage)) {
                    unlink($checkimage);
                    redirect('crud/dash_delet');
                }
                /*      $this->crud_model->User_Notes_Delet($id);
                $this->crud_model->User_commentid_Delet($id);
                
            } else {
                redirect(base_url(), 'refresh');
            }
        }
    }*/

    /*public function Delet_dashInfo(){
        if ($this->session->userdata('user_login_access') != False) {
            $id    = base64_decode($this->input->get('D'));
            $value = $this->crud_model->getCurrencyById($id);
            if (!empty($value)) {
                $deletproduct = $this->crud_model->delet_currency($id);
                
                
                redirect('crud/view_dashboard');
            } else {
                $this->session->set_flashdata('feedback', 'Your request do not valid');
                redirect('crud/view_dashboard');
            }
        } else {
            redirect(base_url(), 'refresh');
        }
    }*///end dashboard

     
     //transaction
     /*public function addTransactionData(){
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
                    $update              = $this->crud_model->updateCurrency($catid, $data);
                    $response['status']  = 'success';
                    $response['message'] = "Successfully Updated";
                    $this->output->set_output(json_encode($response));
                } else {
                    $insert              = $this->crud_model->insertcurrency($data);
                    $response['status']  = 'success';
                    $response['message'] = "Successfully Added";
                    $this->output->set_output(json_encode($response));
                }
            }
        } else {
            redirect(base_url(), 'refresh');
        }
    }
    public function gettranById(){
        if ($this->session->userdata('user_login_access') != False) {
            $id                 = $this->input->get('id');
            $data['brandvalue'] = $this->crud_model->getCurrencyBYID($id);
            echo json_encode($data);
        } else {
            redirect(base_url(), 'refresh');
        }
    }

        public function gettranrateById(){
        if ($this->session->userdata('user_login_access') != False) {
            $id                 = $this->input->get('id');
            $data['currency'] = $this->crud_model->getCurrencyTranBYID($id);
            echo json_encode($data);
        } else {
            redirect(base_url(), 'refresh');
        }
    }

*/

     public function view_transaction()
    {
        if ($this->session->userdata('user_login_access') != False) 
        {
            $data             = array();
            $data['category'] = $this->crud_model->getCurrencyTran();
            //$data['currency'] = $this->currencyCode_model->getCurrencyRate();
            $this->load->view('backend/transaction', $data);
        } 
        else 
        {
            redirect(base_url(), 'refresh');
        }
    }
    /*public function tranById()
    {
        if ($this->session->userdata('user_login_access') != False) 
        {
            $id               = $this->input->get('id');
            $data['catvalue'] = $this->crud_model->getCurrencyTranValueById($id);
            echo json_encode($data);
        } 
        else 
        {
            redirect(base_url(), 'refresh');
        }
    }
     public function View_profile(){
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
    // }*/

    public function tran_delet(){
        if ($this->session->userdata('user_login_access') != False) {
            $id = $this->input->get('id');
            $this->crud_model->currencyTranTableDelet($id);
            if ($this->db->affected_rows()) {
                $profile    = $this->crud_model->getCurrencyTranValue($id);
                $checkimage = "./assets/img/user/$profile->image";
                if (file_exists($checkimage)) {
                    unlink($checkimage);
                    redirect('crud/tran_delet');
                }
                /*      $this->crud_model->User_Notes_Delet($id);
                $this->crud_model->User_commentid_Delet($id);*/
                
            } else {
                redirect(base_url(), 'refresh');
            }
        }
    }

    public function Delet_CurrencyTranInfo(){
        if ($this->session->userdata('user_login_access') != False) {
            $id    = base64_decode($this->input->get('D'));
            $value = $this->crud_model->getCurrencyTranById($id);
            if (!empty($value)) {
                $deletproduct = $this->crud_model->delet_currencyTran($id);
                
                
                redirect('crud/view_transaction');
            } else {
                $this->session->set_flashdata('feedback', 'Your request do not valid');
                redirect('crud/view_transaction');
            }
        } else {
            redirect(base_url(), 'refresh');
        }
    }//end transaction
}
?>  
