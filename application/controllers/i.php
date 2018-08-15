<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class product extends CI_Controller{
    
    function __construct(){
        parent::__construct();
        $this->load->database();
        $this->load->model('product_model');
        $this->load->model('login_model');
    }

    function view_image()
    {
    	$data=array();
    	$data['image']=$this->i_model->getProImage();
    	$this->load->view('backend/i', $data);
    }
}
    ?>