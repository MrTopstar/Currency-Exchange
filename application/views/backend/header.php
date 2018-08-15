<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Steller | Madcoderz</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="apple-touch-icon" href="<?php echo base_url() ?>icon.png">
    <!-- Place favicon.ico in the root directory -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500" rel="stylesheet">
    <link rel="icon" type="image/png" href="<?php echo base_url() ?>icon.png">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/normalize.css">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap3.min.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/simple-line-icons/2.4.1/css/simple-line-icons.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/magnific-popup.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/main.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/jquery-jvectormap-2.0.3.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.6.1/fullcalendar.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker.standalone.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.16/datatables.min.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.4.2/css/buttons.dataTables.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.2.0/dropzone.css">
    <script src="<?php echo base_url() ?>assets/js/vendor/jquery-3.2.1.min.js"></script>
    <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js"></script>
    <style type="text/css">
        nav .navbar-nav li > a {
            color: #fff;
        }
        nav.navbar {
            background-color: rgba(123, 31, 162, 0.79);
        }
        .nav .open>a, .nav .open>a:focus, .nav .open>a:hover {
            background-color: rgba(123, 31, 162, 0.79);
            border-color: rgba(123, 31, 162, 0.79);
            border-color: #0288d0;
            color: #fff;
        }
        .navbar-nav>.open>a, .nav>li>a:focus, .nav>li>a:hover {
            background-color: transparent;
            color: #fff;
        }
        
        .left-sidebar {
            background-color: rgb(41, 64, 98);
        }
        .sidebar-nav ul > li a {
            color: #fff;
        }
        .sidebar-nav ul > li.menu-header {
            color: #fff;
        }
        .sidebar-nav>ul>li.active>a {
            background-color: rgba(255, 255, 255, 0.09);
        }
        .sidebar-nav ul li.active a i, .sidebar-nav ul li a:hover i {
            color: #fff;
        }
    </style>
</head>
<?php $settingsvalue = $this->crud_model->getSettingsValue(); ?>
<?php if(!empty($this->session->userdata('user_login_id'))){
    $userid = $this->session->userdata('user_login_id');
    $profilevalue = $this->crud_model->GetProfileValue($userid);
    $query_user = $this->crud_model->notifications_user($userid);     
}
?>
<body>
    <div class="wrapper-main">
        <header class="topbar clearfix">
            <nav class="navbar navbar-fixed-top bg-white">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                            <span class="icon-options-vertical"></span>
                        </button>
                        <button id="sidebar-toggle" type="button" class="navbar-toggle toggle-sidebar-bars" data-target="#sidebar">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-menu"></span>
                        </button>
                        <a class="navbar-brand text-center" href="<?php echo base_url(); ?>">
                            <img src="<?php echo base_url(); ?>assets/img/<?php echo $settingsvalue->sitelogo; ?>" alt="C">
                            </a>
                    </div>
                    <?php /*echo $this->session->flashdata('feedback');*/ ?>
                    <div class="collapse navbar-collapse" id="myNavbar">
                        <ul class="nav navbar-nav">
                            <li class="hidden-xs">
                                <a href="#" class="sidebar-toggle">
                                    <i class="icon-menu"></i>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav navbar-nav navbar-right">
                            <li class="dropdown notification-parent">
                                <style>
                                    .notification-count i:after {
                                        content: attr(data-badge);
                                        position: absolute;
                                        top: -8px;
                                        right: -8px;
                                        font-size: 8px;
                                        background: #F44336;
                                        color: white;
                                        width: 15px;
                                        height: 15px;
                                        text-align: center;
                                        line-height: 14px;
                                        border-radius: 50%;
                                    }
                                    .notification-count-changed i:after {
                                        content: '0' !IMPORTANT;
                                    }
                                </style>
                                <a href="" data-toggle="dropdown" aria-expanded="false" class="dropdown-toggle notification-count">
                                    <i class="icon-bubbles notification-icon" data-badge="<?php echo count($query_user); ?>" style="position: relative;"></i> <span class="hidden-sm hidden-md hidden-lg notification-text">Comments</span>
                                </a>
                                <ul class="dropdown-menu dropdown-box">
                                    <li class="dropdown-head">
                                        Recent Comments
                                    </li>
                                    <?php if(count($query_user)) { ?>
                                    <li class="box-list">
                                    <?php foreach ($query_user as $value): ?>
                                        <a href="<?php echo base_url(); ?>crud/View_profile?U=<?php echo base64_encode($value->user_id) ?>">
                                            <div class="media">
                                                <div class="media-left box-img">
                                                    <img src="<?php echo base_url(); ?>assets/img/user/<?php echo $value->image; ?>">
                                                </div>
                                                <div class="media-body box-text">
                                                    <h6><?php echo $value->full_name; ?></h6>
                                                    <p><?php echo mb_strimwidth($value->description, 0, 35, '...'); ?></p>
                                                </div>
                                            </div>
                                        </a>
                                    <?php endforeach; ?>
                                    </li>
                                    <?php } else { ?>
                                    <li class="box-list" style="padding: 15px 0 15px 25px;">All caught up!</li>
                                    <?php } ?>
                                    <li class="dropdown-foot">
                                        View all
                                    </li>
                                </ul>
                            </li>
                            <li class="dropdown notification-parent">
                                <a href="" data-toggle="dropdown" aria-expanded="false" class="dropdown-toggle">
                                    <i class="icon-bell notification-icon"></i> <span class="hidden-sm hidden-md hidden-lg notification-text">Notification</span>
                                </a>
                                <ul class="dropdown-menu dropdown-box">
                                    <li class="dropdown-head">
                                        Notifications
                                    </li>
                                    <li class="box-list">
                                        <a href="">
                                            <div class="media">
                                                <div class="media-left box-img">
                                                    <img src="<?php echo base_url(); ?>assets/img/clients-thumb/six.png">
                                                </div>
                                                <div class="media-body box-text">
                                                    <h6>Tom Baier</h6>
                                                    <p>Lorem ipsum dolor sit amet amra</p>
                                                </div>
                                            </div>
                                        </a>
                                        <a href="">
                                            <div class="media">
                                                <div class="media-left box-img">
                                                    <img src="<?php echo base_url(); ?>assets/img/clients-thumb/three.png">
                                                </div>
                                                <div class="media-body box-text">
                                                    <h6>John Doe</h6>
                                                    <p>Ipsum, quam, corporis.</p>
                                                </div>
                                            </div>
                                        </a>
                                        <a href="">
                                            <div class="media">
                                                <div class="media-left box-img">
                                                    <img src="<?php echo base_url(); ?>assets/img/clients-thumb/two.png">
                                                </div>
                                                <div class="media-body box-text">
                                                    <h6>Bella Bose</h6>
                                                    <p>This text is not supposed to be here.</p>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="dropdown-foot">
                                        View all
                                    </li>
                                </ul>
                            </li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    <span class="user-img pull-left">
                                        <img alt="Dotdev" src="<?php echo base_url(); ?>assets/img/user/<?php echo $profilevalue->image; ?>">
                                    </span><?php echo $profilevalue->full_name; ?> <span class="caret"></span>
                                </a>
                                <div class="dropdown-menu topbar-dropdown-wrapper" role="menu">
                                    <ul class="dropdown-user-inner">
                                        <li>
                                            <div class="dd-userbox">
                                                <div class="dd-img">
                                                    <img alt="product management" src="<?php echo base_url(); ?>assets/img/user/<?php echo $profilevalue->image; ?>">
                                                </div>
                                                <div class="dd-info">
                                                    <h4>
                                                        <?php echo $profilevalue->full_name; ?>
                                                    </h4>
                                                    <p>
                                                        <?php echo $profilevalue->email; ?>
                                                    </p>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="divider"></li> 
                                        <li data-id="users" class="main"><a href="<?php echo base_url();?>crud/View_profile?U=<?php echo base64_encode($this->session->userdata('user_login_id')); ?>"><i class="icon-user mr10"></i> Profile</a></li>
                                        <li><a id="resetmodal" href=""><i class="icon-key mr10"></i> Change Password</a></li>
                                        <li class="divider"></li>
                       
                                        <?php if($this->session->userdata('user_type') == 'Admin'){ ?>
                                            <li data-id="configuration" class="main"><a href="<?php echo base_url()?>crud/Site_Settings"><i class="icon-settings mr10"></i> Configuration</a></li>
                                        <?php } ?>
                                        <li data-id="dashboard" class="main"><a href="<?php echo base_url();?>login/logout"><i class="icon-logout mr10"></i> Sign Out</a></li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
      
        </header>
        <aside class="left-sidebar">
            <div class="slimscroll-left-sidebar">
                <nav class="sidebar-nav">
                    <ul>
                        <li data-id="dashboard" id="dashboard" class="main">
                            <a class="" href="<?php echo base_url(); ?>crud/view_dashboard
                                " aria-expanded="false">
                                <i class="fa fa-exchange"></i>
                                <span class="">
                                    Currency Exchange
                                </span>
                            </a>
                        </li>

                        <br>
                        <br>
                        

                        <li data-id="cexchange" id="cexchange" class="main">
                            <a class="" href="<?php echo base_url(); ?>crud/view_code" aria-expanded="false">
                               <i class="fa fa-dollar" aria-hidden="true"></i>
                                <span class="">
                                    Currency Code
                                </span>
                            </a>
                        </li>

                        <br>
                        <br>

                      <li data-id="cexchange" id="cexchange" class="main">
                            <a class="" href="<?php echo base_url(); ?>crud/view_rate" aria-expanded="false">
                               <i class="fa fa-star" aria-hidden="true"></i>
                                <span class="">
                                    Currency Rate
                                </span>
                            </a>
                     </li>

                     <br>
                     <br>

                     <li data-id="cexchange" id="cexchange" class="main">
                            <a class="" href="<?php echo base_url(); ?>crud/view_transaction" aria-expanded="false">
                               <i class="fa fa-star" aria-hidden="true"></i>
                                <span class="">
                                    Transaction List
                                </span>
                            </a>
                     </li>
                         
                         <br>
                         <br>

                        <li data-id="backup" id="backup" class="main">
                            <a class="" href="<?php echo base_url(); ?>crud/Backup_page" aria-expanded="false">
                               <i class="fa fa-star" aria-hidden="true"></i>
                                <span class="">
                                    Backup
                                </span>
                            </a>
                        </li>
                        
                        <br>
                        <br>

                        <li>
                         <a class="" href="<?php echo base_url();?>Static_html/Login"  aria-expanded="false">
                            <i class="fa fa-star" aria-hidden="true"></i>
                            <span class="">
                                  Login

                            </span>
                        </a>
                        </li>       
                </nav>
            </div>
        </aside>        	