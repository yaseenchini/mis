<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
	<meta charset="utf-8" />
	<title><?php echo $title." - ".$site_name; ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no" />
	<meta name="description" content="" />
	<meta name="author" content="" />
	<link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/css/cloud-admin.css"); ?>" />
	<link rel="stylesheet" type="text/css"  href="<?php echo site_url("assets/css/themes/default.css"); ?>" id="skin-switcher" />
	<link rel="stylesheet" type="text/css"  href="<?php echo site_url("assets/css/responsive.css"); ?>" />
	<!-- STYLESHEETS --><!--[if lt IE 9]><script src="js/flot/excanvas.min.js"></script><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script><![endif]-->

	<!-- DATA TABLES -->
	<link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/datatables/media/css/jquery.dataTables.min.css");?>" />
	<link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/datatables/media/assets/css/datatables.min.css");?>" />
	<link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/datatables/extras/TableTools/media/css/TableTools.min.css");?>" />

	<link href="<?php echo site_url("assets/font-awesome/css/font-awesome.min.css"); ?>" rel="stylesheet" />
	<!-- ANIMATE -->
	<link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/css/animatecss/animate.min.css"); ?>" />
	<!-- DATE RANGE PICKER -->
	<link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/js/bootstrap-daterangepicker/daterangepicker-bs3.css"); ?>" />
	<!-- TODO -->
	<link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/js/jquery-todo/css/styles.css"); ?>" />
	<!-- FULL CALENDAR -->
	<link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/js/fullcalendar/fullcalendar.min.css"); ?>" />
	<!-- GRITTER -->
	<link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/js/gritter/css/jquery.gritter.css"); ?>" />
	<!-- FONTS 
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700' rel='stylesheet' type='text/css' />-->
    <!-- JQUERY -->
	<script src="<?php echo site_url("assets/js/jquery/jquery-2.0.3.min.js"); ?>"></script>

    
    
    <!-- jstree resources -->
	<script src="<?php echo site_url("assets/jstree-dist/jstree.min.js"); ?>"></script>
	<link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/jstree-dist/themes/default/style.min.css"); ?>" >
    
    
    
	<link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/css/my_fucking_style.css"); ?>" >
    <script src="<?php echo site_url("assets/js/script.js"); ?>"></script>
    <script src="<?php echo site_url("assets/js/print_this.js"); ?>"></script>
    
    <!-- HUBSPOT MESSENGER -->
    <link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/js/hubspot-messenger/css/messenger.min.css"); ?>" />
	<link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/js/hubspot-messenger/css/messenger-theme-flat.min.css"); ?>" />
	<script type="text/javascript" src="<?php echo site_url("assets/js/hubspot-messenger/js/messenger.min.js"); ?>"></script>
	<script type="text/javascript" src="<?php echo site_url("assets/js/hubspot-messenger/js/messenger-theme-flat.js"); ?>"></script>
    <!-- HUBSPOT MESSENGER -->

    <!-- Bootstrap Timepicker-->
   <link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/bootstrap-dist/css/bootstrap-timepicker.min.css"); ?>" />
    <link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/css/chosen.css");?>"/>
    <script type="text/javascript" src="<?php echo site_url("assets/css/chosen.js");?>"></script>
    
    <link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/bootstrap-dist/css/bootstrap-clockpicker.min.css"); ?>" />
    <script type="text/javascript" src="<?php echo site_url();?>assets/bootstrap-dist/js/bootstrap-clockpicker.min.js"></script>

    
       
            
                   
</head>
<body>
	<!-- HEADER -->
	<header class="navbar clearfix" id="header">
		<div class="container">
				<div class="navbar-brand">
					<!-- COMPANY LOGO -->
					<a href="index.html">
						<img src="<?php echo site_url("assets/img/logo/logo.png"); ?>" alt="Cloud Admin Logo" class="img-responsive" height="30" width="120">
					</a>
					<!-- /COMPANY LOGO -->
					<!-- TEAM STATUS FOR MOBILE -->
					<div class="visible-xs">
						<a href="#" class="team-status-toggle switcher btn dropdown-toggle">
							<i class="fa fa-users"></i>
						</a>
					</div>
					<!-- /TEAM STATUS FOR MOBILE -->
					<!-- SIDEBAR COLLAPSE -->
					<div id="sidebar-collapse" class="sidebar-collapse btn">
						<i class="fa fa-bars" 
							data-icon1="fa fa-bars" 
							data-icon2="fa fa-bars" ></i>
					</div>
					<!-- /SIDEBAR COLLAPSE -->
				</div>
				
                
                
                
                
				<!-- BEGIN TOP NAVIGATION MENU -->					
				<ul class="nav navbar-nav pull-right">
					<!-- BEGIN NOTIFICATION DROPDOWN -->	
					<li class="dropdown" id="header-notification">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							<i class="fa fa-bell"></i>
							<span class="badge">7</span>						
						</a>
						<ul class="dropdown-menu notification">
							<li class="dropdown-title">
								<span><i class="fa fa-bell"></i> 7 Notifications</span>
							</li>
							<li>
								<a href="#">
									<span class="label label-success"><i class="fa fa-user"></i></span>
									<span class="body">
										<span class="message">5 users online. </span>
										<span class="time">
											<i class="fa fa-clock-o"></i>
											<span>Just now</span>
										</span>
									</span>
								</a>
							</li>
							<li>
								<a href="#">
									<span class="label label-primary"><i class="fa fa-comment"></i></span>
									<span class="body">
										<span class="message">Martin commented.</span>
										<span class="time">
											<i class="fa fa-clock-o"></i>
											<span>19 mins</span>
										</span>
									</span>
								</a>
							</li>
							<li>
								<a href="#">
									<span class="label label-warning"><i class="fa fa-lock"></i></span>
									<span class="body">
										<span class="message">DW1 server locked.</span>
										<span class="time">
											<i class="fa fa-clock-o"></i>
											<span>32 mins</span>
										</span>
									</span>
								</a>
							</li>
							<li>
								<a href="#">
									<span class="label label-info"><i class="fa fa-twitter"></i></span>
									<span class="body">
										<span class="message">Twitter connected.</span>
										<span class="time">
											<i class="fa fa-clock-o"></i>
											<span>55 mins</span>
										</span>
									</span>
								</a>
							</li>
							<li>
								<a href="#">
									<span class="label label-danger"><i class="fa fa-heart"></i></span>
									<span class="body">
										<span class="message">Jane liked. </span>
										<span class="time">
											<i class="fa fa-clock-o"></i>
											<span>2 hrs</span>
										</span>
									</span>
								</a>
							</li>
							<li>
								<a href="#">
									<span class="label label-warning"><i class="fa fa-exclamation-triangle"></i></span>
									<span class="body">
										<span class="message">Database overload.</span>
										<span class="time">
											<i class="fa fa-clock-o"></i>
											<span>6 hrs</span>
										</span>
									</span>
								</a>
							</li>
							<li class="footer">
								<a href="#">See all notifications <i class="fa fa-arrow-circle-right"></i></a>
							</li>
						</ul>
					</li>
					<!-- END NOTIFICATION DROPDOWN -->
					<!-- BEGIN INBOX DROPDOWN -->
					<li class="dropdown" id="header-message">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<i class="fa fa-envelope"></i>
						<span class="badge">3</span>
						</a>
						<ul class="dropdown-menu inbox">
							<li class="dropdown-title">
								<span><i class="fa fa-envelope-o"></i> 3 Messages</span>
								<span class="compose pull-right tip-right" title="Compose message"><i class="fa fa-pencil-square-o"></i></span>
							</li>
							<li>
								<a href="#">
									<img src="img/avatars/avatar2.jpg" alt="" />
									<span class="body">
										<span class="from">Jane Doe</span>
										<span class="message">
										Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse mole ...
										</span> 
										<span class="time">
											<i class="fa fa-clock-o"></i>
											<span>Just Now</span>
										</span>
									</span>
									 
								</a>
							</li>
							<li>
								<a href="#">
									<img src="img/avatars/avatar1.jpg" alt="" />
									<span class="body">
										<span class="from">Vince Pelt</span>
										<span class="message">
										Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse mole ...
										</span> 
										<span class="time">
											<i class="fa fa-clock-o"></i>
											<span>15 min ago</span>
										</span>
									</span>
									 
								</a>
							</li>
							<li>
								<a href="#">
									<img src="img/avatars/avatar8.jpg" alt="" />
									<span class="body">
										<span class="from">Debby Doe</span>
										<span class="message">
										Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse mole ...
										</span> 
										<span class="time">
											<i class="fa fa-clock-o"></i>
											<span>2 hours ago</span>
										</span>
									</span>
									 
								</a>
							</li>
							<li class="footer">
								<a href="#">See all messages <i class="fa fa-arrow-circle-right"></i></a>
							</li>
						</ul>
					</li>
					<!-- END INBOX DROPDOWN -->
					<!-- BEGIN TODO DROPDOWN -->
					<li class="dropdown" id="header-tasks">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<i class="fa fa-tasks"></i>
						<span class="badge">3</span>
						</a>
						<ul class="dropdown-menu tasks">
							<li class="dropdown-title">
								<span><i class="fa fa-check"></i> 6 tasks in progress</span>
							</li>
							<li>
								<a href="#">
									<span class="header clearfix">
										<span class="pull-left">Software Update</span>
										<span class="pull-right">60%</span>
									</span>
									<div class="progress">
									  <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%;">
										<span class="sr-only">60% Complete</span>
									  </div>
									</div>
								</a>
							</li>
							<li>
								<a href="#">
									<span class="header clearfix">
										<span class="pull-left">Software Update</span>
										<span class="pull-right">25%</span>
									</span>
									<div class="progress">
									  <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="width: 25%;">
										<span class="sr-only">25% Complete</span>
									  </div>
									</div>
								</a>
							</li>
							<li>
								<a href="#">
									<span class="header clearfix">
										<span class="pull-left">Software Update</span>
										<span class="pull-right">40%</span>
									</span>
									<div class="progress progress-striped">
									  <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%;">
										<span class="sr-only">40% Complete</span>
									  </div>
									</div>
								</a>
							</li>
							<li>
								<a href="#">
									<span class="header clearfix">
										<span class="pull-left">Software Update</span>
										<span class="pull-right">70%</span>
									</span>
									<div class="progress progress-striped active">
									  <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width: 70%;">
										<span class="sr-only">70% Complete</span>
									  </div>
									</div>
								</a>
							</li>
							<li>
								<a href="#">
									<span class="header clearfix">
										<span class="pull-left">Software Update</span>
										<span class="pull-right">65%</span>
									</span>
									<div class="progress">
									  <div class="progress-bar progress-bar-success" style="width: 35%">
										<span class="sr-only">35% Complete (success)</span>
									  </div>
									  <div class="progress-bar progress-bar-warning" style="width: 20%">
										<span class="sr-only">20% Complete (warning)</span>
									  </div>
									  <div class="progress-bar progress-bar-danger" style="width: 10%">
										<span class="sr-only">10% Complete (danger)</span>
									  </div>
									</div>
								</a>
							</li>
							<li class="footer">
								<a href="#">See all tasks <i class="fa fa-arrow-circle-right"></i></a>
							</li>
						</ul>
					</li>
					<!-- END TODO DROPDOWN -->
					<!-- BEGIN USER LOGIN DROPDOWN -->
					<li class="dropdown user" id="header-user">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							<img alt="" src="<?php echo site_url("assets/img/avatars/avatar3.jpg"); ?>" />
							<span class="username"><?php echo $this->session->userdata("user_title"); ?></span>
							<i class="fa fa-angle-down"></i>
						</a>
						<ul class="dropdown-menu">
							<li><a href="#"><i class="fa fa-user"></i> My Profile</a></li>
							<li><a href="#"><i class="fa fa-cog"></i> Account Settings</a></li>
							<li><a href="#"><i class="fa fa-eye"></i> Privacy Settings</a></li>
							<li><a href="<?php echo site_url("users/logout"); ?>"><i class="fa fa-power-off"></i> Log Out</a></li>
						</ul>
					</li>
					<!-- END USER LOGIN DROPDOWN -->
				</ul>
				<!-- END TOP NAVIGATION MENU -->
		</div>
		
	</header>
	<!--/HEADER -->
	
	<!-- PAGE -->
	<section id="page">
				<?php $this->load->view("components/nav.php"); ?>
		<div id="main-content">
			
			<div class="container">
            
                <div class="row">
    	           <div id="content" class="col-lg-12">
                   
                   <?php
                        if($this->session->flashdata("msg") || $this->session->flashdata("msg_error") || $this->session->flashdata("msg_success")){ 
                        
                        $type = "";
                        if($this->session->flashdata("msg_success")){
                            $type = "success";
                            $msg = $this->session->flashdata("msg_success");
                        }elseif($this->session->flashdata("msg_error")){
                            $type = "error";
                            $msg = $this->session->flashdata("msg_error");
                        }else{
                            $type = "info";
                            $msg = $this->session->flashdata("msg");
                        }
                    ?>
                       <script type="text/javascript">
                            $(document).ready(function(){
                                    //Set theme
                        			Messenger.options = {
  			                            extraClasses: 'messenger-fixed messenger-on-top messenger-on-right',
                        				theme: "flat"
                        			}
                                    Messenger().post({
                                        message: '<?php echo $msg; ?>',
                                        type: '<?php echo $type; ?>',
                                        showCloseButton: true
                                    })
                                })
                                
                       </script>
                   <?php } ?>
                   
                   
        
    
		