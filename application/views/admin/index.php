<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
	  <meta name="description" content="<?php echo $this->general->get_system_var('meta_description');?>">
	  <meta name="keywords" content="<?php echo $this->general->get_system_var('meta_tags');?>">
	  <meta name="author" content="<?php echo $system_name;?>">
	  <meta property="og:title" content="<?php echo $system_name;?>">
      <meta property="og:description" content="<?php echo $this->general->get_system_var('meta_description');?>">
      <meta property="og:image" content="<?php echo base_url('assets/preview.png');?>">
      <meta property="og:url" content="<?php echo base_url();?>">
      <meta name="viewport" content="width=device-width, initial-scale=1">
	  <link rel="icon" href="<?php echo base_url($this->general->get_system_var('favicon'));?>">
      <title><?php echo $title;?></title>
      <!-- Google Font: Source Sans Pro -->
      <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
      <!-- Font Awesome -->
      <link rel="stylesheet" href="<?php echo base_url('assets/backend/');?>plugins/fontawesome-free/css/all.min.css">
      <!-- Ionicons -->
      <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
      <!-- Tempusdominus Bootstrap 4 -->
      <link rel="stylesheet" href="<?php echo base_url('assets/backend/');?>plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
	  <!-- DataTables -->
	  <link rel="stylesheet" href="<?php echo base_url('assets/backend/');?>plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
      <link rel="stylesheet" href="<?php echo base_url('assets/backend/');?>plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
      <link rel="stylesheet" href="<?php echo base_url('assets/backend/');?>plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
      <!-- iCheck -->
      <link rel="stylesheet" href="<?php echo base_url('assets/backend/');?>plugins/icheck-bootstrap/icheck-bootstrap.min.css">
      <!-- JQVMap -->
      <link rel="stylesheet" href="<?php echo base_url('assets/backend/');?>plugins/jqvmap/jqvmap.min.css">
      <!-- Theme style -->
      <link rel="stylesheet" href="<?php echo base_url('assets/backend/');?>dist/css/adminlte.min.css">
      <!-- overlayScrollbars -->
      <link rel="stylesheet" href="<?php echo base_url('assets/backend/');?>plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
      <!-- Daterange picker -->
      <link rel="stylesheet" href="<?php echo base_url('assets/backend/');?>plugins/daterangepicker/daterangepicker.css">
      <!-- summernote -->
      <link rel="stylesheet" href="<?php echo base_url('assets/backend/');?>plugins/summernote/summernote-bs4.min.css">
	  <link rel="stylesheet" href="<?php echo base_url('assets/backend/');?>dist/css/custom.css">
	  <link rel="stylesheet" href="<?php echo base_url('assets/backend/plugins/bootstrap-editor');?>/css/wysiwyg.css">
	  <link rel="stylesheet" href="<?php echo base_url('assets/backend/plugins/bootstrap-editor');?>/css/highlight.min.css.css">
	  <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/backend/');?>plugins/toastr/toastr.min.css">
	  
	  <!-- jQuery -->
      <script src="<?php echo base_url('assets/backend/');?>plugins/jquery/jquery.min.js"></script>
	  
		<script>var base_url = '<?php echo base_url();?>'</script>
   </head>
   <body class="hold-transition sidebar-mini layout-fixed">
   <div class="ajax-loading" style="display: none;"></div>
   <?php $this->load->view('modal/index'); ?>
      <div class="wrapper">
         <!-- Navbar -->
         <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
               <li class="nav-item">
                  <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
               </li>
            </ul>
            
            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
               <!-- Messages Dropdown Menu -->
			   <?php $notifications = $this->general->get_all_field_order_limit('notifications', '*', 'DESC', 5);?>
               <li class="nav-item dropdown">
                  <a class="nav-link" data-toggle="dropdown" href="#">
                  <i class="far fa-bell"></i>
                  <?php if (count($notifications)>0){?><span class="badge badge-danger navbar-badge"><?php echo count($notifications);?></span><?php } ?>
                  </a>
				  <?php if (count($notifications)>0){?>
                  <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                     
					 <?php foreach($notifications as $n){?>
					 <div class="dropdown-item">
                        <!-- Message Start -->
                        <div class="media">
							<?php if ($n['msg_from'] == 'Admin'){?>
							<img src="<?php echo base_url($this->general->get_system_var('favicon'));?>" alt="<?php echo $system_name;?>" class="img-size-50 mr-3 img-circle">
							<?php } else { ?>
							<img src="<?php echo $this->user_account->get_small_pic($n['username']);?>" alt="<?php echo $n['username'];?>" class="img-size-50 mr-3 img-circle">
							<?php } ?>
                           
                           <div class="media-body">
                              <h3 class="dropdown-item-title">
                                 <?php 
									if ($n['username'] == 'Admin'){
										echo $system_name;
									} else {
										echo $this->user_account->user_name($n['username']);
									}
								 ?>
                              </h3>
                              <p class="text-sm"><?php echo $n['message'];?></p>
                              <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> <?php echo $this->general->time_ago($n['dated']);?></p>
                           </div>
                        </div>
                        <!-- Message End -->
                     </div>
                     <div class="dropdown-divider"></div>
					 <?php } ?>
					 
                     
                  </div>
				  <?php } ?>
               </li>
               
               <li class="nav-item">
                  <a class="nav-link" href="<?php echo base_url('admin/profile')?>" role="button">
                  <i class="fas fa-user"></i>
                  </a>
               </li>
			   <li class="nav-item">
                  <a class="nav-link" href="<?php echo base_url('auth/logout')?>" role="button">
                  <i class="fas fa-sign-out-alt"></i>
                  </a>
               </li>
            </ul>
         </nav>
         <!-- /.navbar -->
         <!-- Main Sidebar Container -->
         <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="<?php echo base_url('admin/dashboard');?>" class="brand-link d-flex justify-content-center">
            <img src="<?php echo base_url($this->general->get_system_var('logo_backend'));?>" alt="<?php echo $this->general->get_system_var('system_name');?>" class="brand-image">
            </a>
            <!-- Sidebar -->
            <div class="sidebar">
               <!-- Sidebar user panel (optional) -->
               <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                  <div class="image">
                     <img src="<?php echo $this->user_account->get_small_pic($this->session->userdata('user_name'));?>" class="img-circle elevation-2" alt="<?php echo $this->session->userdata('user_name');?>">
                  </div>
                  <div class="info">
                     <a href="<?php echo base_url('admin/profile')?>" class="d-block"><?php echo $this->user_account->user_name($this->session->userdata('user_name'));?></a>
                  </div>
               </div>
               <!-- SidebarSearch Form -->
               <div class="form-inline">
                  <div class="input-group" data-widget="sidebar-search">
                     <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                     <div class="input-group-append">
                        <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                        </button>
                     </div>
                  </div>
               </div>
			   
               <!-- Sidebar Menu -->
               <nav class="mt-2">
                  <ul class="nav nav-pills nav-sidebar flex-column nav-legacy nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">
                     <!-- Add icons to the links using the .nav-icon class
                        with font-awesome or any other icon font library -->
                      <li class="nav-item">
                        <a href="<?php echo base_url('admin/dashboard');?>" class="nav-link <?php if ($file == 'home'){echo 'active';};?>">
                           <i class="nav-icon fas fa-tachometer-alt"></i>
                           <p>
                              Dashboard
                           </p>
                        </a>
                     </li>
					 <?php if (in_array('products_list', $permissions) || in_array('products_add', $permissions)){?>
					 <li class="nav-item <?php if ($file == 'products_list' || $file == 'add_product' || $file == 'edit_product' || $file == 'purchase_history'){echo 'menu-open';};?>">
                        <a href="#" class="nav-link <?php if ($file == 'products_list' || $file == 'add_product' || $file == 'edit_product' || $file == 'purchase_history'){echo 'active';};?>">
                           <i class="nav-icon fas fa-list"></i>
                           <p>
                              Products
                              <i class="right fas fa-angle-left"></i>
                           </p>
                        </a>
                        <ul class="nav nav-treeview">
						<?php if (in_array('products_list', $permissions)){?>
                           <li class="nav-item">
                              <a href="<?php echo base_url('admin/products')?>" class="nav-link <?php if ($file == 'products_list'){echo 'active';};?>">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p>Products List</p>
                              </a>
                           </li>
                        <?php } ?> 
						<?php if (in_array('products_add', $permissions)){?>
                           <li class="nav-item">
                              <a href="<?php echo base_url('admin/products/add-new')?>" class="nav-link <?php if ($file == 'add_product'){echo 'active';};?>">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p>Add New Product</p>
                              </a>
                           </li>
						<?php } ?> 
						<?php if (in_array('products_purchase_history', $permissions)){?>
						   <li class="nav-item">
                              <a href="<?php echo base_url('admin/products/purchase-history')?>" class="nav-link <?php if ($file == 'purchase_history'){echo 'active';};?>">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p>Purchase History</p>
                              </a>
                           </li>
						<?php } ?>
                        </ul>
                     </li>
					 <?php } ?>
					 <?php if (in_array('users_list', $permissions)){?>
					 <li class="nav-item">
                        <a href="<?php echo base_url('admin/users');?>" class="nav-link <?php if ($file == 'users' || $file == 'user_profile' || $file == 'user_password'){echo 'active';};?>">
                           <i class="nav-icon fas fa-user-friends"></i>
                           <p>
                              Users List
                           </p>
                        </a>
                     </li>
					 <?php } ?>
					 <?php if (in_array('manual_payments_pending', $permissions) || in_array('manual_payments_verified', $permissions) || in_array('manual_payments_rejected', $permissions)){?>
					 <li class="nav-item <?php if ($file == 'manual_payment_proof' || $file == 'manual_payments_pending' || $file == 'manual_payments_verified' || $file == 'manual_payments_rejected'){echo 'menu-open';};?>">
                        <a href="#" class="nav-link <?php if ($file == 'manual_payment_proof' || $file == 'manual_payments_pending' || $file == 'manual_payments_verified' || $file == 'manual_payments_rejected'){echo 'active';};?>">
                           <i class="nav-icon fas fa-money-check"></i>
                           <p>
                              Manual Payments
                              <i class="right fas fa-angle-left"></i>
                           </p>
                        </a>
                        <ul class="nav nav-treeview">
                           <?php if (in_array('manual_payments_pending', $permissions)){?>
						   <li class="nav-item">
                              <a href="<?php echo base_url('admin/manual-payments/pending')?>" class="nav-link <?php if ($file == 'manual_payments_pending'){echo 'active';};?>">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p>Pending</p>
                              </a>
                           </li>
                           <?php } ?> 
							<?php if (in_array('manual_payments_verified', $permissions)){?>
                           <li class="nav-item">
                              <a href="<?php echo base_url('admin/manual-payments/verified')?>" class="nav-link <?php if ($file == 'manual_payments_verified'){echo 'active';};?>">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p>Verified</p>
                              </a>
                           </li>
						   <?php } ?> 
						<?php if (in_array('manual_payments_rejected', $permissions)){?>
						   <li class="nav-item">
                              <a href="<?php echo base_url('admin/manual-payments/rejected')?>" class="nav-link <?php if ($file == 'manual_payments_rejected'){echo 'active';};?>">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p>Rejected</p>
                              </a>
                           </li>
						   <?php } ?>
                        </ul>
                     </li>
					 <?php } ?>
					 <?php if (in_array('wallets_list', $permissions)){?>
					 <li class="nav-item">
                        <a href="<?php echo base_url('admin/wallets');?>" class="nav-link <?php if ($file == 'user_wallet_admin_transaction' || $file == 'user_wallets' || $file == 'user_wallet' || $file == 'wallet_statement'){echo 'active';};?>">
                           <i class="nav-icon fas fa-wallet"></i>
                           <p>
                              User Wallets
                           </p>
                        </a>
                     </li>
					 <?php } ?>
					 <?php if (in_array('roi_disperse', $permissions)){?>
					 <li class="nav-item">
                        <a href="<?php echo base_url('admin/disperse-roi');?>" class="nav-link <?php if ($file == 'disperse_roi'){echo 'active';};?>">
                           <i class="nav-icon fas fa-hand-holding-usd"></i>
                           <p>
                              Disperse ROI
                           </p>
                        </a>
                     </li>
					 <?php } ?>
					 <?php if (in_array('transfers_list', $permissions)){?>
					 <li class="nav-item">
                        <a href="<?php echo base_url('admin/transfers');?>" class="nav-link <?php if ($file == 'transfers_list'){echo 'active';};?>">
                           <i class="nav-icon fas fa-exchange-alt"></i>
                           <p>
                              Funds Transfers
                           </p>
                        </a>
                     </li>
					 <?php } ?>
					 <?php if (in_array('calender', $permissions)){?>
					 <li class="nav-item">
                        <a href="<?php echo base_url('admin/calendar');?>" class="nav-link <?php if ($file == 'calendar'){echo 'active';};?>">
                           <i class="nav-icon fas fa-calendar"></i>
                           <p>
                              Calendar
                           </p>
                        </a>
                     </li>
					 <?php } ?>
					 <?php if (in_array('income_personal_sponsor_bonus', $permissions) || 
					 in_array('income_network_binary_bonus', $permissions) ||
					 in_array('income_generation_bonus', $permissions) ||
					 in_array('income_reverse_generation_bonus', $permissions) ||
					 in_array('income_roi', $permissions) ||
					 in_array('income_matching_roi', $permissions)
					 ){?>
					 <li class="nav-item <?php if ($file == 'psb-history' || $file == 'nbb-history' || $file == 'gb-history' || $file == 'rgb-history' || $file == 'roi-history' || $file == 'matching-roi-history'){echo 'menu-open';};?>">
                        <a href="#" class="nav-link <?php if ($file == 'psb-history' || $file == 'nbb-history' || $file == 'gb-history' || $file == 'rgb-history' || $file == 'roi-history' || $file == 'matching-roi-history'){echo 'active';};?>">
                           <i class="nav-icon fas fa-credit-card"></i>
                           <p>
                              Income History
                              <i class="right fas fa-angle-left"></i>
                           </p>
                        </a>
                        <ul class="nav nav-treeview">
							
							<?php if (in_array('income_personal_sponsor_bonus', $permissions)){?>
							<?php if ($this->general->get_commission_var('personal_sponsor_bonus_status') == '1'){?>
                           <li class="nav-item">
                              <a href="<?php echo base_url('admin/income/personal-sponsor-bonus')?>" class="nav-link <?php if ($file == 'psb-history'){echo 'active';};?>">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p>Personal Sponsor Bonus</p>
                              </a>
                           </li>
							<?php } ?>
							<?php } ?>
							<?php if (in_array('income_network_binary_bonus', $permissions)){?>
							<?php if ($this->general->get_commission_var('network_binary_bonus_status') == '1'){?>
                           <li class="nav-item">
                              <a href="<?php echo base_url('admin/income/network-binary-bonus')?>" class="nav-link <?php if ($file == 'nbb-history'){echo 'active';};?>">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p>Network Binary Bonus</p>
                              </a>
                           </li>
						   <?php } ?>
						   <?php } ?>
							<?php if (in_array('income_generation_bonus', $permissions)){?>
							<?php if ($this->general->get_commission_var('generation_bonus_status') == '1'){?>
						   <li class="nav-item">
                              <a href="<?php echo base_url('admin/income/generation-bonus')?>" class="nav-link <?php if ($file == 'gb-history'){echo 'active';};?>">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p>Generation Bonus</p>
                              </a>
                           </li>
						   <?php } ?>
						   <?php } ?>
							<?php if (in_array('income_reverse_generation_bonus', $permissions)){?>
							<?php if ($this->general->get_commission_var('reverse_generation_bonus_status') == '1'){?>
						   <li class="nav-item">
                              <a href="<?php echo base_url('admin/income/reverse-generation-bonus')?>" class="nav-link <?php if ($file == 'rgb-history'){echo 'active';};?>">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p>Reverse Generation Bonus</p>
                              </a>
                           </li>
						   <?php } ?>
						   <?php } ?>
							<?php if (in_array('income_roi', $permissions)){?>
							<?php if ($this->general->get_commission_var('roi_status') == '1'){?>
						   <li class="nav-item">
                              <a href="<?php echo base_url('admin/income/roi')?>" class="nav-link <?php if ($file == 'roi-history'){echo 'active';};?>">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p>ROI</p>
                              </a>
                           </li>
						   <?php } ?>
						   <?php } ?>
							<?php if (in_array('income_matching_roi', $permissions)){?>
						   <?php if ($this->general->get_commission_var('matching_roi_status') == '1'){?>
						   <li class="nav-item">
                              <a href="<?php echo base_url('admin/income/matching-roi')?>" class="nav-link <?php if ($file == 'matching-roi-history'){echo 'active';};?>">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p>Matching ROI</p>
                              </a>
                           </li>
						   <?php } ?>
						   <?php } ?>
                        </ul>
                     </li>
					 <?php } ?>
					 <?php if (in_array('ranking_list', $permissions) || in_array('ranking_add', $permissions)){?>
					 <?php if ($this->general->get_system_var('ranking_system_status') == '1'){?>
					 <li class="nav-item <?php if ($file == 'rankings_list' || $file == 'rankings_add' || $file == 'rankings_edit'){echo 'menu-open';};?>">
                        <a href="#" class="nav-link <?php if ($file == 'rankings_list' || $file == 'rankings_add' || $file == 'rankings_edit'){echo 'active';};?>">
                           <i class="nav-icon fas fa-id-card"></i>
                           <p>
                              Ranking
                              <i class="right fas fa-angle-left"></i>
                           </p>
                        </a>
                        <ul class="nav nav-treeview">
                           <?php if (in_array('ranking_list', $permissions)){?>
						   <li class="nav-item">
                              <a href="<?php echo base_url('admin/ranking')?>" class="nav-link <?php if ($file == 'rankings_list' || $file == 'rankings_edit'){echo 'active';};?>">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p>Ranking List</p>
                              </a>
                           </li>
                           <?php } ?>
						   <?php if (in_array('ranking_add', $permissions)){?>
                           <li class="nav-item">
                              <a href="<?php echo base_url('admin/ranking/add-new')?>" class="nav-link <?php if ($file == 'rankings_add'){echo 'active';};?>">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p>Create New Rank</p>
                              </a>
                           </li>
						   <?php } ?>
                        </ul>
                     </li>
					 <?php } ?>
					 <?php } ?>
					 <?php if (in_array('kyc_list', $permissions)){?>
					 <?php if ($this->general->get_system_var('kyc_status') == '1'){?>
					 <li class="nav-item <?php if ($file == 'kyc_user_docs' || $file == 'kyc_list_pending' || $file == 'kyc_list_verified' || $file == 'kyc_list_rejected'){echo 'menu-open';};?>">
                        <a href="#" class="nav-link <?php if ($file == 'kyc_user_docs' || $file == 'kyc_list_pending' || $file == 'kyc_list_verified' || $file == 'kyc_list_rejected'){echo 'active';};?>">
                           <i class="nav-icon fas fa-file-contract"></i>
                           <p>
                              KYC
                              <i class="right fas fa-angle-left"></i>
                           </p>
                        </a>
                        <ul class="nav nav-treeview">
                           <li class="nav-item">
                              <a href="<?php echo base_url('admin/kyc/pending')?>" class="nav-link <?php if ($file == 'kyc_list_pending'){echo 'active';};?>">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p>Pending</p>
                              </a>
                           </li>
                           
                           <li class="nav-item">
                              <a href="<?php echo base_url('admin/kyc/verified')?>" class="nav-link <?php if ($file == 'kyc_list_verified'){echo 'active';};?>">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p>Verified</p>
                              </a>
                           </li>
						   <li class="nav-item">
                              <a href="<?php echo base_url('admin/kyc/rejected')?>" class="nav-link <?php if ($file == 'kyc_list_rejected'){echo 'active';};?>">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p>Rejected</p>
                              </a>
                           </li>
                        </ul>
                     </li>
					 <?php } ?>
					 <?php } ?>
					 <?php if (in_array('withdraw_list', $permissions)){?>
					 <li class="nav-item">
                        <a href="<?php echo base_url('admin/withdraws');?>" class="nav-link <?php if ($file == 'withdraws_list'){echo 'active';};?>">
                           <i class="nav-icon fas fa-donate"></i>
                           <p>
                              Withdraw
                           </p>
                        </a>
                     </li>
					 <?php } ?>
					 <?php if (in_array('faqs_list', $permissions)){?>
					 <?php if ($this->general->get_system_var('faqs_status') == '1'){?>
					 <li class="nav-item">
                        <a href="<?php echo base_url('admin/faqs');?>" class="nav-link <?php if ($file == 'faqs' || $file == 'edit_faq' || $file == 'add_faq'){echo 'active';};?>">
                           <i class="nav-icon fas fa-info-circle"></i>
                           <p>
                              FAQs
                           </p>
                        </a>
                     </li>
					 <?php } ?>
					 <?php } ?>
					 
					 
					 <?php if (in_array('support_tickets_open', $permissions) || in_array('support_tickets_closed', $permissions)){?>
					 <li class="nav-item <?php if ($file == 'support' || $file == 'ticket' || $file == 'tickets'){echo 'menu-open';};?>">
                        <a href="#" class="nav-link <?php if ($file == 'support' || $file == 'ticket' || $file == 'tickets'){echo 'active';};?>">
                           <i class="nav-icon fas fa-question-circle"></i>
                           <p>
                              Support
                              <i class="right fas fa-angle-left"></i>
                           </p>
                        </a>
                        <ul class="nav nav-treeview">
                           <?php if (in_array('support_tickets_open', $permissions)){?>
						   <li class="nav-item">
                              <a href="<?php echo base_url('admin/support/tickets/open')?>" class="nav-link <?php if ($file == 'open_tickets'){echo 'active';};?>">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p>Open Tickets</p>
                              </a>
                           </li>
                           <?php } ?>
						   <?php if (in_array('support_tickets_closed', $permissions)){?>
                           <li class="nav-item">
                              <a href="<?php echo base_url('admin/support/tickets/closed')?>" class="nav-link <?php if ($file == 'closed_tickets'){echo 'active';};?>">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p>Closed Tickets</p>
                              </a>
                           </li>
						   <?php } ?>
                        </ul>
                     </li>
					 <?php } ?>
					 <li class="nav-item <?php if ($file == 'profile' || $file == 'change_password'){echo 'menu-open';};?>">
                        <a href="#" class="nav-link <?php if ($file == 'profile' || $file == 'change_password'){echo 'active';};?>">
                           <i class="nav-icon fas fa-id-card"></i>
                           <p>
                              Profile
                              <i class="right fas fa-angle-left"></i>
                           </p>
                        </a>
                        <ul class="nav nav-treeview">
                           <li class="nav-item">
                              <a href="<?php echo base_url('admin/profile')?>" class="nav-link <?php if ($file == 'profile'){echo 'active';};?>">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p>Profile</p>
                              </a>
                           </li>
                           
                           <li class="nav-item">
                              <a href="<?php echo base_url('admin/profile/change-password')?>" class="nav-link <?php if ($file == 'change_password'){echo 'active';};?>">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p>Change Password</p>
                              </a>
                           </li>
                        </ul>
                     </li>
					 <?php if (in_array('moderators_list', $permissions) || in_array('moderators_add', $permissions)){?>
					 <li class="nav-item <?php if ($file == 'moderators_list' || $file == 'moderator_add' || $file == 'edit_moderator' || $file == 'moderator_password' || $file == 'moderator_profile'){echo 'menu-open';};?>">
                        <a href="#" class="nav-link <?php if ($file == 'moderators_list' || $file == 'moderator_add' || $file == 'edit_moderator' || $file == 'moderator_password' || $file == 'moderator_profile'){echo 'active';};?>">
                           <i class="nav-icon fas fa-key"></i>
                           <p>
                              Moderators
                              <i class="right fas fa-angle-left"></i>
                           </p>
                        </a>
                        <ul class="nav nav-treeview">
							<?php if (in_array('moderators_list', $permissions)){?>
                           <li class="nav-item">
                              <a href="<?php echo base_url('admin/moderators')?>" class="nav-link <?php if ($file == 'moderators_list'){echo 'active';};?>">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p>Moderators List</p>
                              </a>
                           </li>
							<?php } ?>
							<?php if (in_array('moderators_add', $permissions)){?>
                           <li class="nav-item">
                              <a href="<?php echo base_url('admin/moderators/add-new')?>" class="nav-link <?php if ($file == 'moderator_add'){echo 'active';};?>">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p>Add New</p>
                              </a>
                           </li>
						   <?php } ?>
                        </ul>
                     </li>
					 <?php } ?>
					 <?php if (in_array('roles_list', $permissions) || in_array('roles_add', $permissions)){?>
					 <li class="nav-item <?php if ($file == 'roles' || $file == 'add_role' || $file == 'edit_role'){echo 'menu-open';};?>">
                        <a href="#" class="nav-link <?php if ($file == 'roles' || $file == 'add_role' || $file == 'edit_role'){echo 'active';};?>">
                           <i class="nav-icon fas fa-key"></i>
                           <p>
                              Roles
                              <i class="right fas fa-angle-left"></i>
                           </p>
                        </a>
                        <ul class="nav nav-treeview">
							<?php if (in_array('roles_list', $permissions)){?>
                           <li class="nav-item">
                              <a href="<?php echo base_url('admin/roles')?>" class="nav-link <?php if ($file == 'roles'){echo 'active';};?>">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p>Roles List</p>
                              </a>
                           </li>
                           <?php } ?>
							<?php if (in_array('roles_add', $permissions)){?>
                           <li class="nav-item">
                              <a href="<?php echo base_url('admin/roles/add-new')?>" class="nav-link <?php if ($file == 'add_role'){echo 'active';};?>">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p>Create New Role</p>
                              </a>
                           </li>
							<?php } ?>
                        </ul>
                     </li>
					<?php } ?>
					<?php if (in_array('settings_sms_gateway', $permissions) || 
					in_array('settings_sms_templates', $permissions) ||
					in_array('settings_email_templates', $permissions) ||
					in_array('settings_kyc', $permissions) ||
					in_array('settings_contact', $permissions) ||
					in_array('settings_commission', $permissions) ||
					in_array('settings_general', $permissions) ||
					in_array('settings_smtp', $permissions) ||
					in_array('settings_transfer', $permissions) ||
					in_array('settings_withdraw', $permissions) ||
					in_array('settings_payment_gateway', $permissions) ||
					in_array('settings_currency', $permissions)){?>
					 <li class="nav-item <?php if ($file == 'currency_settings' || $file == 'kyc_settings' || $file == 'contact_settings' || $file == 'commission_settings' || $file == 'currency_list' || $file == 'payment_settings' || $file == 'smtp_settings' || $file == 'transfer_settings' || $file == 'general_settings' || $file == 'withdraw_settings' || $file == 'email_templates' || $file == 'email_template' || $file == 'sms_templates' || $file == 'sms_template' || $file == 'sms_settings'){echo 'menu-open';};?>">
                        <a href="#" class="nav-link <?php if ($file == 'currency_settings' || $file == 'kyc_settings' || $file == 'contact_settings' || $file == 'commission_settings' || $file == 'currency_list' || $file == 'payment_settings' || $file == 'smtp_settings' || $file == 'transfer_settings' || $file == 'general_settings' || $file == 'withdraw_settings' || $file == 'email_templates' || $file == 'email_template' || $file == 'sms_templates' || $file == 'sms_template' || $file == 'sms_settings'){echo 'active';};?>">
                           <i class="nav-icon fas fa-cog"></i>
                           <p>
                              Settings
                              <i class="right fas fa-angle-left"></i>
                           </p>
                        </a>
                        <ul class="nav nav-treeview">
							<?php if (in_array('settings_general', $permissions)){?>
                           <li class="nav-item">
                              <a href="<?php echo base_url('admin/settings/general-settings')?>" class="nav-link <?php if ($file == 'general_settings'){echo 'active';};?>">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p>General Settings</p>
                              </a>
                           </li>
							<?php } ?>
						   <?php if (in_array('settings_currency', $permissions)){?>
						   <li class="nav-item">
                              <a href="<?php echo base_url('admin/settings/currency-settings')?>" class="nav-link <?php if ($file == 'currency_settings' || $file == 'currency_list'){echo 'active';};?>">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p>Currency Settings</p>
                              </a>
                           </li>
						   <?php } ?>
						   <?php if (in_array('settings_payment_gateway', $permissions)){?>
						   <li class="nav-item">
                              <a href="<?php echo base_url('admin/settings/payment-settings')?>" class="nav-link <?php if ($file == 'payment_settings'){echo 'active';};?>">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p>Payment Settings</p>
                              </a>
                           </li>
						   <?php } ?>
						   <?php if (in_array('settings_commission', $permissions)){?>
						   <li class="nav-item">
                              <a href="<?php echo base_url('admin/settings/commission-settings')?>" class="nav-link <?php if ($file == 'commission_settings'){echo 'active';};?>">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p>Commission Settings</p>
                              </a>
                           </li>
						   <?php } ?>
						   <?php if (in_array('settings_transfer', $permissions)){?>
						   <li class="nav-item">
                              <a href="<?php echo base_url('admin/settings/transfer-settings')?>" class="nav-link <?php if ($file == 'transfer_settings'){echo 'active';};?>">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p>Transfer Settings</p>
                              </a>
                           </li>
						   <?php } ?>
						   <?php if (in_array('settings_kyc', $permissions)){?>
						   <li class="nav-item">
                              <a href="<?php echo base_url('admin/settings/kyc-settings')?>" class="nav-link <?php if ($file == 'kyc_settings'){echo 'active';};?>">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p>KYC Settings</p>
                              </a>
                           </li>
						   <?php } ?>
						   <?php if (in_array('settings_withdraw', $permissions)){?>
						   <li class="nav-item">
                              <a href="<?php echo base_url('admin/settings/withdraw-settings')?>" class="nav-link <?php if ($file == 'withdraw_settings'){echo 'active';};?>">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p>Withdraw Settings</p>
                              </a>
                           </li>
						   <?php } ?>
						   <?php if (in_array('settings_email_templates', $permissions)){?>
						   <li class="nav-item">
                              <a href="<?php echo base_url('admin/settings/email-templates')?>" class="nav-link <?php if ($file == 'email_templates' || $file == 'email_template'){echo 'active';};?>">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p>Email Templates</p>
                              </a>
                           </li>
						   <?php } ?>
						   <?php if (in_array('settings_sms_templates', $permissions)){?>
						   <?php if ($this->general->get_system_var('twillo_status') == '1' || $this->general->get_system_var('messente_status') == '1'){?>
						   <li class="nav-item">
                              <a href="<?php echo base_url('admin/settings/sms-templates')?>" class="nav-link <?php if ($file == 'sms_templates' || $file == 'sms_template'){echo 'active';};?>">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p>SMS Templates</p>
                              </a>
                           </li>
						   <?php } ?>
						   <?php } ?>
						   <?php if (in_array('settings_sms_gateway', $permissions)){?>
						   <li class="nav-item">
                              <a href="<?php echo base_url('admin/settings/sms-settings')?>" class="nav-link <?php if ($file == 'sms_settings'){echo 'active';};?>">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p>SMS Gateway Settings</p>
                              </a>
                           </li>
						   <?php } ?>
						   <?php if (in_array('settings_smtp', $permissions)){?>
						   <li class="nav-item">
                              <a href="<?php echo base_url('admin/settings/smtp-settings')?>" class="nav-link <?php if ($file == 'smtp_settings'){echo 'active';};?>">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p>SMTP Settings</p>
                              </a>
                           </li>
						   <?php } ?>
						   <?php if (in_array('settings_contact', $permissions)){?>
						   <li class="nav-item">
                              <a href="<?php echo base_url('admin/settings/contact-settings')?>" class="nav-link <?php if ($file == 'contact_settings'){echo 'active';};?>">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p>Contact Settings</p>
                              </a>
                           </li>
                           <?php } ?>
                        </ul>
                     </li>
					 <?php } ?>
					 <?php if (in_array('cron_jobs_list', $permissions)){?>
					  <li class="nav-item">
                        <a href="<?php echo base_url('admin/cron-jobs');?>" class="nav-link <?php if ($file == 'cron_jobs'){echo 'active';};?>">
                           <i class="nav-icon fas fa-crosshairs"></i>
                           <p>
                              Cron Jobs
                           </p>
                        </a>
                     </li>
					 <?php } ?>
					 <?php if (in_array('database_backup', $permissions)){?>
					 <li class="nav-item">
                        <a href="<?php echo base_url('admin/database-backup');?>" class="nav-link <?php if ($file == 'database_backup'){echo 'active';};?>">
                           <i class="nav-icon fas fa-database"></i>
                           <p>
                              Database Backup
                           </p>
                        </a>
                     </li>
					 <?php } ?>
                     <li class="nav-item">
                        <a href="<?php echo base_url('auth/logout');?>" class="nav-link">
                           <i class="nav-icon fas fa-sign-out-alt"></i>
                           <p>
                              Logout
                           </p>
                        </a>
                     </li>
                  </ul>
               </nav>
               <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
         </aside>
         <!-- Content Wrapper. Contains page content -->
         <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
               <div class="container-fluid">
                  <div class="row mb-2">
                     <div class="col-sm-6">
                        <h1 class="m-0"><?php echo $page_title;?></h1>
                     </div>
                     <!-- /.col -->
                  </div>
                  <!-- /.row -->
               </div>
               <!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->
            <!-- Main content -->
            <section class="content">
               <div class="container-fluid">
                  <!-- Small boxes (Stat box) -->
                  <?php include('pages/'.$file.'.php');?>
               </div>
               <!-- /.container-fluid -->
            </section>
            <!-- /.content -->
         </div>
         <!-- /.content-wrapper -->
         <footer class="main-footer">
            <?php echo $this->general->get_system_var('back_foot_left');?>
            <div class="float-right d-none d-sm-inline-block">
               <?php echo $this->general->get_system_var('back_foot_right');?>
            </div>
         </footer>
         <!-- Control Sidebar -->
         <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
         </aside>
         <!-- /.control-sidebar -->
      </div>
      <!-- ./wrapper -->
      
      <!-- jQuery UI 1.11.4 -->
      <script src="<?php echo base_url('assets/backend/');?>plugins/jquery-ui/jquery-ui.min.js"></script>
      <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
      <script>
         $.widget.bridge('uibutton', $.ui.button)
      </script>
      <!-- Bootstrap 4 -->
      <script src="<?php echo base_url('assets/backend/');?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
	  <!-- DataTables  & Plugins -->
		<script src="<?php echo base_url('assets/backend/');?>plugins/datatables/jquery.dataTables.min.js"></script>
		<script src="<?php echo base_url('assets/backend/');?>plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
		<script src="<?php echo base_url('assets/backend/');?>plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
		<script src="<?php echo base_url('assets/backend/');?>plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
		<script src="<?php echo base_url('assets/backend/');?>plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
		<script src="<?php echo base_url('assets/backend/');?>plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
		<script src="<?php echo base_url('assets/backend/');?>plugins/jszip/jszip.min.js"></script>
		<script src="<?php echo base_url('assets/backend/');?>plugins/pdfmake/pdfmake.min.js"></script>
		<script src="<?php echo base_url('assets/backend/');?>plugins/pdfmake/vfs_fonts.js"></script>
		<script src="<?php echo base_url('assets/backend/');?>plugins/datatables-buttons/js/buttons.html5.min.js"></script>
		<script src="<?php echo base_url('assets/backend/');?>plugins/datatables-buttons/js/buttons.print.min.js"></script>
		<script src="<?php echo base_url('assets/backend/');?>plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
      <!-- ChartJS -->
      <script src="<?php echo base_url('assets/backend/');?>plugins/chart.js/Chart.min.js"></script>
      <!-- Sparkline -->
      <script src="<?php echo base_url('assets/backend/');?>plugins/sparklines/sparkline.js"></script>
      <!-- JQVMap -->
      <script src="<?php echo base_url('assets/backend/');?>plugins/jqvmap/jquery.vmap.min.js"></script>
      <script src="<?php echo base_url('assets/backend/');?>plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
      <!-- jQuery Knob Chart -->
      <script src="<?php echo base_url('assets/backend/');?>plugins/jquery-knob/jquery.knob.min.js"></script>
      <!-- daterangepicker -->
      <script src="<?php echo base_url('assets/backend/');?>plugins/moment/moment.min.js"></script>
      <script src="<?php echo base_url('assets/backend/');?>plugins/daterangepicker/daterangepicker.js"></script>
      <!-- Tempusdominus Bootstrap 4 -->
      <script src="<?php echo base_url('assets/backend/');?>plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
      <!-- Summernote -->
      <script src="<?php echo base_url('assets/backend/');?>plugins/summernote/summernote-bs4.min.js"></script>
      <!-- overlayScrollbars -->
      <script src="<?php echo base_url('assets/backend/');?>plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
      <!-- AdminLTE App -->
      <script src="<?php echo base_url('assets/backend/');?>dist/js/adminlte.js"></script>
	  <script src="<?php echo base_url('assets/backend/');?>plugins/flot/jquery.flot.js"></script>
	  <script src="<?php echo base_url('assets/backend/');?>plugins/chart.js/Chart.min.js"></script>
      <!-- AdminLTE for demo purposes -->
	  <script src="<?php echo base_url('assets/backend/');?>plugins/toastr/toastr.min.js"></script>
      <script src="<?php echo base_url('assets/backend/');?>dist/js/app.js"></script>
      <script src="<?php echo base_url('assets/backend/');?>multi-matrix.js"></script>
      <script src="<?php echo base_url('assets/backend/');?>dist/js/demo.js"></script>
      
	  <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
     
<?php if ($file !== 'error_404'){?>
<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    
  });
  $(function () {
    $("#example2").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print"]
    }).buttons().container().appendTo('#example2_wrapper .col-md-6:eq(0)');
    
  });
</script>
	  <script>
		$('#reservationdate').datetimepicker({
        format: 'L'
    });
    //Date range picker
    $('#reservation').daterangepicker()
		</script>
<?php } ?>
	  
	  <?php $error=$this->session->flashdata('error');
	if ($error == TRUE){?>
	<script>
	$(document).ready(function(){
		toastr.error("<?php echo $error;?>");
	});
	</script>
	<?php }?>
	<?php $success=$this->session->flashdata('success');
	if ($success == TRUE){?>
	<script>
	$(document).ready(function(){
		toastr.success("<?php echo $success;?>");
	});
	</script>
	<?php }?>
	<?php $info=$this->session->flashdata('info');
	if ($info == TRUE){?>
	<script>
	$(document).ready(function(){
		toastr.info("<?php echo $info;?>");
	});
	</script>
	<?php }?>
	<?php $warning=$this->session->flashdata('warning');
	if ($warning == TRUE){?>
	<script>
	$(document).ready(function(){
		toastr.warning("<?php echo $warning;?>");
	});
	</script>
	<?php }?>
   </body>
</html>