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
      <link rel="stylesheet" href="<?php echo base_url('assets/backend/');?>plugins/orgchart/css/jquery.orgchart.css">
	  
	  <link rel="stylesheet" href="<?php echo base_url('assets/backend/');?>dist/css/custom.css">
	  <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/backend/');?>plugins/toastr/toastr.min.css">
	  
	  <!-- jQuery -->
      <script src="<?php echo base_url('assets/backend/');?>plugins/jquery/jquery.min.js"></script>
	  <script src="<?php echo base_url('assets/backend/');?>plugins/orgchart/js/jquery.orgchart.js"></script>
	  <script>var base_url = '<?php echo base_url();?>'</script>
   </head>
   <body class="hold-transition sidebar-mini layout-fixed">
   <div class="ajax-loading" style="display: none;"></div>
   <?php $this->load->view('modal/index'); ?>
      <div class="wrapper">
         <!-- Navbar <?php //echo $this->ranking_model->rank_clr($this->session->userdata('user_name'));?>-->
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
			   <?php $notifications = $this->general->get_tbl_field_order_limit('notifications', '*', 'username', $this->session->userdata('user_name'), 'DESC', 5);?>
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
							<img src="<?php echo $this->user_account->get_small_pic($n['msg_from']);?>" alt="<?php echo $n['msg_from'];?>" class="img-size-50 mr-3 img-circle">
							<?php } ?>
                           
                           <div class="media-body">
                              <h3 class="dropdown-item-title">
                                 <?php 
									if ($n['msg_from'] == 'Admin'){
										echo $system_name;
									} else {
										echo $this->user_account->user_name($n['msg_from']);
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
			   <?php if ($this->general->get_system_var('currency_status') == '1'){
				$currency_id = $this->returns->default_currency($this->session->userdata('user_name'));
				$symbol = $this->db->get_where('currency_settings',array('currency_settings_id'=>$currency_id))->row()->symbol;
				$c_name = $this->db->get_where('currency_settings',array('currency_settings_id'=>$currency_id))->row()->name;
				$currencies = $this->db->get_where('currency_settings',array('status'=>'ok'))->result_array();
				if (count($currencies)>0){
				?>
               <li class="nav-item dropdown">
				<a class="nav-link" data-toggle="dropdown" href="#">
				  <i class="fas fa-list-ul"></i> <?php echo $c_name; ?><span> (<?php echo $symbol; ?>)</span>
				</a>
				<div class="dropdown-menu dropdown-menu-md dropdown-menu-right dropdown-select-list">
				<?php foreach ($currencies as $c){?>
				<?php if ($c['currency_settings_id'] == $currency_id){?>
					<a href="#" class="dropdown-item list-selected" onclick="window.location.href='<?php echo base_url('member/set_currency/'.$c['currency_settings_id']);?>'">
						<?php echo $c['name'];?>
					</a>
				<?php } else {?>
					<a href="#" class="dropdown-item" onclick="window.location.href='<?php echo base_url('member/set_currency/'.$c['currency_settings_id']);?>'">
						<?php echo $c['name'];?>
					</a>
				<?php } ?>
					
				<?php }?>
				</div>
			  </li>
			   <?php } }?>
               <li class="nav-item">
                  <a class="nav-link" href="<?php echo base_url('member/profile')?>" role="button">
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
            <a href="<?php echo base_url('member/dashboard');?>" class="brand-link d-flex justify-content-center">
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
                     <a href="<?php echo base_url('member/profile')?>" class="d-block"><?php echo $this->user_account->user_name($this->session->userdata('user_name'));?></a>
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
                        <a href="<?php echo base_url('member/dashboard');?>" class="nav-link <?php if ($file == 'home'){echo 'active';};?>">
                           <i class="nav-icon fas fa-tachometer-alt"></i>
                           <p>
                              Dashboard
                           </p>
                        </a>
                     </li>
					 <li class="nav-item <?php if ($file == 'profile' || $file == 'change_password' || $file == 'generate_epin' || $file == 'notification_settings'){echo 'menu-open';};?>">
                        <a href="#" class="nav-link <?php if ($file == 'profile' || $file == 'change_password' || $file == 'generate_epin' || $file == 'notification_settings'){echo 'active';};?>">
                           <i class="nav-icon fas fa-id-card"></i>
                           <p>
                              Profile
                              <i class="right fas fa-angle-left"></i>
                           </p>
                        </a>
                        <ul class="nav nav-treeview">
                           <li class="nav-item">
                              <a href="<?php echo base_url('member/profile')?>" class="nav-link <?php if ($file == 'profile'){echo 'active';};?>">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p>Profile</p>
                              </a>
                           </li>
                           
                           <li class="nav-item">
                              <a href="<?php echo base_url('member/profile/change-password')?>" class="nav-link <?php if ($file == 'change_password'){echo 'active';};?>">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p>Change Password</p>
                              </a>
                           </li>
						   <?php 
						   if ($this->general->get_system_var('epin_status') == '1'){
						   if ($this->user_account->epin_exists($this->session->userdata('user_name')) == false){?>
						   <li class="nav-item">
                              <a href="<?php echo base_url('member/profile/generate-epin')?>" class="nav-link <?php if ($file == 'generate_epin'){echo 'active';};?>">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p>Generate E-PIN</p>
                              </a>
                           </li>
						   <?php } 
						   }?>
						   
						   <li class="nav-item">
                              <a href="<?php echo base_url('member/profile/notification-settings')?>" class="nav-link <?php if ($file == 'notification_settings'){echo 'active';};?>">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p>Notification Settings</p>
                              </a>
                           </li>
                        </ul>
                     </li>
					 <li class="nav-item <?php if ($file == 'products_list' || $file == 'purchase_history'){echo 'menu-open';};?>">
                        <a href="#" class="nav-link <?php if ($file == 'products_list' || $file == 'purchase_history'){echo 'active';};?>">
                           <i class="nav-icon fas fa-list"></i>
                           <p>
                              Products
                              <i class="right fas fa-angle-left"></i>
                           </p>
                        </a>
                        <ul class="nav nav-treeview">
                           <li class="nav-item">
                              <a href="<?php echo base_url('member/products')?>" class="nav-link <?php if ($file == 'products_list'){echo 'active';};?>">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p>Products List</p>
                              </a>
                           </li>
                           
                           <li class="nav-item">
                              <a href="<?php echo base_url('member/products/purchase-history')?>" class="nav-link <?php if ($file == 'purchase_history'){echo 'active';};?>">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p>Purchase History</p>
                              </a>
                           </li>
                        </ul>
                     </li>
					
					 <li class="nav-item <?php if ($file == 'referrals_card' || $file == 'referrals_list' || $file == 'referrals_genealogy'){echo 'menu-open';};?>">
                        <a href="#" class="nav-link <?php if ($file == 'referrals_card' || $file == 'referrals_list' || $file == 'referrals_genealogy'){echo 'active';};?>">
                           <i class="nav-icon fas fa-sitemap"></i>
                           <p>
                              Direct Referrals
                              <i class="right fas fa-angle-left"></i>
                           </p>
                        </a>
                        <ul class="nav nav-treeview">
                           
						  
                           <li class="nav-item">
                              <a href="<?php echo base_url('member/referrals/list-view')?>" class="nav-link <?php if ($file == 'referrals_list'){echo 'active';};?>">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p>List View</p>
                              </a>
                           </li>
						   <li class="nav-item">
                              <a href="<?php echo base_url('member/referrals/card-view')?>" class="nav-link <?php if ($file == 'referrals_card'){echo 'active';};?>">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p>Card View</p>
                              </a>
                           </li>
						   <li class="nav-item">
                              <a href="<?php echo base_url('member/referrals/genealogy')?>" class="nav-link <?php if ($file == 'referrals_genealogy'){echo 'active';};?>">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p>Tree View</p>
                              </a>
                           </li>
						  
                        </ul>
                     </li>
					 <li class="nav-item <?php if ($file == 'tree_right_childs' || $file == 'tree_left_childs' || $file == 'tree_childs' || $file == 'tree_parents' || $file == 'genealogy-3x-forced' || $file == 'genealogy-3x' || $file == 'genealogy-2x-forced' || $file == 'genealogy-2x' || $file == 'tree_3x_settings' || $file == 'tree_2x_settings'){echo 'menu-open';};?>">
                        <a href="#" class="nav-link <?php if ($file == 'tree_right_childs' || $file == 'tree_left_childs' || $file == 'tree_childs' || $file == 'tree_parents' || $file == 'genealogy-3x-forced' || $file == 'genealogy-3x' || $file == 'genealogy-2x-forced' || $file == 'genealogy-2x' || $file == 'tree_3x_settings' || $file == 'tree_2x_settings'){echo 'active';};?>">
                           <i class="nav-icon fas fa-sitemap"></i>
                           <p>
                              Genealogy Referrals
                              <i class="right fas fa-angle-left"></i>
                           </p>
                        </a>
                        <ul class="nav nav-treeview">
                           
						   <li class="nav-item">
                              <a href="<?php echo base_url('member/genealogy')?>" class="nav-link <?php if ($file == 'genealogy-3x-forced' || $file == 'genealogy-3x' || $file == 'genealogy-2x-forced' || $file == 'genealogy-2x'){echo 'active';};?>">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p>Genealogy View</p>
                              </a>
                           </li>
                           
                           <li class="nav-item">
                              <a href="<?php echo base_url('member/genealogy-referrals/left')?>" class="nav-link <?php if ($file == 'tree_left_childs'){echo 'active';};?>">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p>Left in Tree</p>
                              </a>
                           </li>
						   <li class="nav-item">
                              <a href="<?php echo base_url('member/genealogy-referrals/right')?>" class="nav-link <?php if ($file == 'tree_right_childs'){echo 'active';};?>">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p>Right in Tree</p>
                              </a>
                           </li>
						   <li class="nav-item">
                              <a href="<?php echo base_url('member/genealogy-referrals/parents')?>" class="nav-link <?php if ($file == 'tree_parents'){echo 'active';};?>">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p>Parents in Tree</p>
                              </a>
                           </li>
						   <li class="nav-item">
                              <a href="<?php echo base_url('member/genealogy-referrals/children')?>" class="nav-link <?php if ($file == 'tree_childs'){echo 'active';};?>">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p>Children in Tree</p>
                              </a>
                           </li>
						   <?php if ($this->general->get_system_var('matrix_type') == 'simple'){?>
						   <li class="nav-item">
                              <a href="<?php echo base_url('member/placement-settings')?>" class="nav-link <?php if ($file == 'tree_3x_settings' || $file == 'tree_2x_settings'){echo 'active';};?>">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p>Placement Settings</p>
                              </a>
                           </li>
						   <?php } ?>
                        </ul>
                     </li>
					 <li class="nav-item">
                        <a href="<?php echo base_url('member/wallet-history');?>" class="nav-link <?php if ($file == 'wallet_statement'){echo 'active';};?>">
                           <i class="nav-icon fas fa-wallet"></i>
                           <p>
                              Wallet History
                           </p>
                        </a>
                     </li>
					 <?php if ($this->general->get_system_var('invitation_status') == '1'){?>
					 <li class="nav-item">
                        <a href="<?php echo base_url('member/invitation');?>" class="nav-link <?php if ($file == 'invitation_form'){echo 'active';};?>">
                           <i class="nav-icon fas fa-gifts"></i>
                           <p>
                              Invite New User
                           </p>
                        </a>
                     </li>
					 <?php } ?>
					 <li class="nav-item <?php if ($file == 'psb-history' || $file == 'nbb-history' || $file == 'gb-history' || $file == 'rgb-history' || $file == 'roi-history' || $file == 'matching-roi-history'){echo 'menu-open';};?>">
                        <a href="#" class="nav-link <?php if ($file == 'psb-history' || $file == 'nbb-history' || $file == 'gb-history' || $file == 'rgb-history' || $file == 'roi-history' || $file == 'matching-roi-history'){echo 'active';};?>">
                           <i class="nav-icon fas fa-credit-card"></i>
                           <p>
                              Income History
                              <i class="right fas fa-angle-left"></i>
                           </p>
                        </a>
                        <ul class="nav nav-treeview">
							<?php if ($this->general->get_commission_var('personal_sponsor_bonus_status') == '1'){?>
                           <li class="nav-item">
                              <a href="<?php echo base_url('member/income/personal-sponsor-bonus')?>" class="nav-link <?php if ($file == 'psb-history'){echo 'active';};?>">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p>Personal Sponsor Bonus</p>
                              </a>
                           </li>
							<?php } ?>
							<?php if ($this->general->get_commission_var('network_binary_bonus_status') == '1'){?>
                           <li class="nav-item">
                              <a href="<?php echo base_url('member/income/network-binary-bonus')?>" class="nav-link <?php if ($file == 'nbb-history'){echo 'active';};?>">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p>Network Binary Bonus</p>
                              </a>
                           </li>
						   <?php } ?>
							<?php if ($this->general->get_commission_var('generation_bonus_status') == '1'){?>
						   <li class="nav-item">
                              <a href="<?php echo base_url('member/income/generation-bonus')?>" class="nav-link <?php if ($file == 'gb-history'){echo 'active';};?>">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p>Generation Bonus</p>
                              </a>
                           </li>
						   <?php } ?>
							<?php if ($this->general->get_commission_var('reverse_generation_bonus_status') == '1'){?>
						   <li class="nav-item">
                              <a href="<?php echo base_url('member/income/reverse-generation-bonus')?>" class="nav-link <?php if ($file == 'rgb-history'){echo 'active';};?>">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p>Reverse Generation Bonus</p>
                              </a>
                           </li>
						   <?php } ?>
							<?php if ($this->general->get_commission_var('roi_status') == '1'){?>
						   <li class="nav-item">
                              <a href="<?php echo base_url('member/income/roi')?>" class="nav-link <?php if ($file == 'roi-history'){echo 'active';};?>">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p>ROI</p>
                              </a>
                           </li>
						   <?php } ?>
						   <?php if ($this->general->get_commission_var('matching_roi_status') == '1'){?>
						   <li class="nav-item">
                              <a href="<?php echo base_url('member/income/matching-roi')?>" class="nav-link <?php if ($file == 'matching-roi-history'){echo 'active';};?>">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p>Matching ROI</p>
                              </a>
                           </li>
						   <?php } ?>
                        </ul>
                     </li>
					 <?php if ($this->general->get_system_var('kyc_status') == '1'){?>
					 <li class="nav-item">
                        <a href="<?php echo base_url('member/kyc');?>" class="nav-link <?php if ($file == 'kyc_form' || $file == 'kyc_confirmation'){echo 'active';};?>">
                           <i class="nav-icon fas fa-file-contract"></i>
                           <p>
                              KYC
                           </p>
                        </a>
                     </li>
					 <?php } ?>
					 <?php if ($this->general->get_system_var('enable_transfer') == '1'){?>
					 <li class="nav-item <?php if ($file == 'transfer_history' || $file == 'transfer_form'){echo 'menu-open';};?>">
                        <a href="#" class="nav-link <?php if ($file == 'transfer_history' || $file == 'transfer_form'){echo 'active';};?>">
                           <i class="nav-icon fas fa-exchange-alt"></i>
                           <p>
                              Funds Transfer
                              <i class="right fas fa-angle-left"></i>
                           </p>
                        </a>
                        <ul class="nav nav-treeview">
                           <li class="nav-item">
                              <a href="<?php echo base_url('member/transfer/form')?>" class="nav-link <?php if ($file == 'transfer_form'){echo 'active';};?>">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p>Transfer Funds</p>
                              </a>
                           </li>
						   <li class="nav-item">
                              <a href="<?php echo base_url('member/transfer/history')?>" class="nav-link <?php if ($file == 'transfer_history'){echo 'active';};?>">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p>History</p>
                              </a>
                           </li>
                        </ul>
                     </li>
					 <?php } ?>
					 <li class="nav-item <?php if ($file == 'withdraw_history' || $file == 'withdraw_form'){echo 'menu-open';};?>">
                        <a href="#" class="nav-link <?php if ($file == 'withdraw_history' || $file == 'withdraw_form'){echo 'active';};?>">
                           <i class="nav-icon fas fa-donate"></i>
                           <p>
                              Withdraw
                              <i class="right fas fa-angle-left"></i>
                           </p>
                        </a>
                        <ul class="nav nav-treeview">
                           <li class="nav-item">
                              <a href="<?php echo base_url('member/withdraw/form')?>" class="nav-link <?php if ($file == 'withdraw_form'){echo 'active';};?>">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p>Withdraw Funds</p>
                              </a>
                           </li>
						   <li class="nav-item">
                              <a href="<?php echo base_url('member/withdraw/history')?>" class="nav-link <?php if ($file == 'withdraw_history'){echo 'active';};?>">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p>History</p>
                              </a>
                           </li>
                         </ul>
                     </li>
					 <?php if ($this->general->get_system_var('faqs_status') == '1'){?>
					 <li class="nav-item">
                        <a href="<?php echo base_url('member/faqs');?>" class="nav-link <?php if ($file == 'faqs'){echo 'active';};?>">
                           <i class="nav-icon fas fa-info-circle"></i>
                           <p>
                              FAQs
                           </p>
                        </a>
                     </li>
					 <?php } ?>
                     <li class="nav-item">
                        <a href="<?php echo base_url('member/support');?>" class="nav-link <?php if ($file == 'support' || $file == 'ticket' || $file == 'tickets'){echo 'active';};?>">
                           <i class="nav-icon fas fa-question-circle"></i>
                           <p>
                              Support
                           </p>
                        </a>
                     </li>
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
     
	  <script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
  
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