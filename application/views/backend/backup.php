<?php $this->load->view('backend/header'); ?>
        <div class="wrapper-page">
                
            <div class="page-title">
                <h1><i class="icon-organization"></i> <b>Back Up</b></h1>
                <span style="color:green"><?php echo $this->session->flashdata('feedback'); ?></span>
            </div>
                <div class="page-content">
                <div class="container-fluid">           
                    <div class="row">
                        <div class="col-md-6">
                            <div class="panel no-border">
                                <div class="content_wrapper">

                                    <div class="table_banner clearfix">
                                        <h3><b>Back Up Database</b></h3>
                                    </div>
                                    <div class="table_body">
                                    <a href="<?php echo base_url(); ?>crud/Backup_Database" class="btn btn-custom" role="button">
                                        <i class="icon-cloud-download"></i> &nbsp; <b>Backup</b>
                                    </a>
                                    <a class="" href="<?php echo base_url(); ?>crud/view_dashboard
                                      " aria-expanded="false">
                                         <button type="button" id="back" class="btn btn-custom pull-right">
                                            <b>Back to Home</b>
                                         </button>
                                      </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
        </div>            
        </div>
        </div>
<span class="flashmessage"><?php echo $this->session->flashdata('feedback'); ?></span>		
<?php $this->load->view('backend/footer'); ?>