<div class="row">
	<div class="col-md-12">
		<div class="card card-primary card-outline">
			<div class="card-header">
				<h3 class="card-title">Users List</h3>
			</div>
			<div class="card-body">
			<!--------------------->
			<table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Username</th>
                    <th>Sponsor</th>
                    <th>Binary Referral</th>
                    <th>Join Date</th>
                    <th>Package</th>
                    <th>Status</th>
                    <th>Actions</th>
                  </tr>
                  </thead>
                  <tbody>
				  <?php if (count($data)>0){
					$users_delete = $this->returns->permission_access('users_delete', $logged_username);
					$users_issue_epin = $this->returns->permission_access('users_issue_epin', $logged_username); 
					$users_email_verify = $this->returns->permission_access('users_email_verify', $logged_username); 
					$users_login_as = $this->returns->permission_access('users_login_as', $logged_username); 
					$users_change_password = $this->returns->permission_access('users_change_password', $logged_username); 
					$users_update_avatar = $this->returns->permission_access('users_update_avatar', $logged_username); 
					$users_edit = $this->returns->permission_access('users_edit', $logged_username); 
					?>
				  <?php foreach ($data as $u){ 
				  ?>
                  <tr>
                    <td><?php echo $u['username'];?></td>
                    <td><?php echo $u['direct_referral'];?></td>
                    <td><?php echo $u['binary_referral'];?></td>
                    <td><?php echo $u['created'];?></td>
                    <td>
					<?php if ($this->commissions->product_purchased($u['username']) == true){
						echo 'Purchased';
					} else {
						echo 'Not Purchased';
					}?>
					</td>
                    <td>
					<?php if ($u['status'] == '1'){
						echo 'Active';
					} else {
						echo 'Inactive';
					}?>
					</td>
					<th>
						<div class="btn-group">
							<button type="button" class="btn btn-default btn-flat">Actions</button>
							<button type="button" class="btn btn-default btn-flat dropdown-toggle dropdown-icon" data-toggle="dropdown">
							  <span class="sr-only">Toggle Dropdown</span>
							</button>
							<div class="dropdown-menu" role="menu">
							  <?php if ($users_edit || $users_update_avatar){?><a class="dropdown-item" href="<?php echo base_url('admin/users/edit-profile/'.$u['username']);?>">Edit Profile</a><?php } ?>
							  <?php if ($users_change_password){?><a class="dropdown-item" href="<?php echo base_url('admin/users/update-password/'.$u['username']);?>">Change Password</a><?php } ?>
							  <?php if ($users_issue_epin){?><a class="dropdown-item" href="<?php echo base_url('admin/users/issue-e-pin/'.$u['username']);?>">Re-Generate E-PIN</a><?php } ?>
							  <?php if (in_array('users_email_verify', $permissions)){?>
								  <?php if ($u['status'] == '0'){?>
									<div class="dropdown-divider"></div>
									<?php if ($users_email_verify){?><a class="dropdown-item" href="<?php echo base_url('admin/users/verify-email/'.$u['username']);?>">Verify Email</a><?php } ?>
								  <?php } ?>
							  <?php } ?>
							  <?php if (in_array('users_delete', $permissions) || in_array('users_login_as', $permissions) || in_array('purchase_product', $permissions)){?>
							  <div class="dropdown-divider"></div>
							  <?php if ($users_delete){?><a class="dropdown-item" href="<?php echo base_url('admin/users/delete/'.$u['username']);?>">Delete User</a><?php } ?>
							  <?php if (in_array('purchase_product', $permissions)){?>
							  <?php echo modal_anchor(get_uri("admin/users/purchase-product/".$u['username']), 'Purchase Product', array("class" => "dropdown-item", "title" => 'Purchase Product')); ?>
							  <?php } ?>
							  <?php if ($users_login_as){?><a class="dropdown-item" href="<?php echo base_url('admin/users/login-as/'.$u['username']);?>">Login as <?php echo $u['username'];?></a><?php } ?>
							  <?php } ?>
							</div>
						</div>
					</th>
                  </tr>
                  <?php } ?>
                  <?php } ?>
                  
                  </tbody>
                  <tfoot>
                  <tr>
                    <th>Username</th>
                    <th>Sponsor</th>
                    <th>Binary Referral</th>
                    <th>Join Date</th>
                    <th>Package</th>
                    <th>Status</th>
                    <th>Actions</th>
                  </tr>
                  </tfoot>
                </table>
			<!--------------------->
			</div>
		</div>
	</div>
</div>
		