<div class="row">
	<div class="col-md-12">
		<div class="card card-primary card-outline">
			<div class="card-header">
				<h3 class="card-title">Moderators List</h3>
			</div>
			<div class="card-body">
			<!--------------------->
			<table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Name</th>
                    <th>Username</th>
                    <th>Country</th>
                    <th>Mobile</th>
                    <th>Role</th>
                    <th>Dated</th>
                    <th>Actions</th>
                  </tr>
                  </thead>
                  <tbody>
				  <?php if (count($data)>0){?>
				  <?php foreach ($data as $u){ 
					$moderators_change_password = $this->returns->permission_access('moderators_change_password', $logged_username);
					$moderators_edit = $this->returns->permission_access('moderators_edit', $logged_username); 
					$moderators_update_avatar = $this->returns->permission_access('moderators_update_avatar', $logged_username); 
					$moderators_delete = $this->returns->permission_access('moderators_delete', $logged_username); 
				  ?>
                  <tr>
                    <td><?php echo $u['name'];?></td>
                    <td><?php echo $u['username'];?></td>
                    <td><?php echo $u['country'];?></td>
                    <td><?php echo $u['mobile'];?></td>
                    <td><?php echo $u['title'];?></td>
                    <td><?php echo $u['created'];?></td>
                    
					<th>
						<div class="btn-group">
							<button type="button" class="btn btn-default btn-flat">Actions</button>
							<button type="button" class="btn btn-default btn-flat dropdown-toggle dropdown-icon" data-toggle="dropdown">
							  <span class="sr-only">Toggle Dropdown</span>
							</button>
							<?php if (in_array('moderators_edit', $permissions) || in_array('moderators_edit', $permissions) || in_array('moderators_delete', $permissions)){?>
							<div class="dropdown-menu" role="menu">
							  <?php if ($moderators_edit || $moderators_update_avatar){?><a class="dropdown-item" href="<?php echo base_url('admin/moderators/edit-profile/'.$u['username']);?>">Edit Profile</a><?php } ?>
							  <?php if ($moderators_change_password){?><a class="dropdown-item" href="<?php echo base_url('admin/moderators/update-password/'.$u['username']);?>">Change Password</a><?php } ?>
							  <?php if ($moderators_delete){?><a class="dropdown-item" href="<?php echo base_url('admin/moderators/delete/'.$u['username']);?>">Delete</a><?php } ?>
							</div>
							<?php } ?>
						</div>
					</th>
                  </tr>
                  <?php } ?>
                  <?php } ?>
                  
                  </tbody>
                  <tfoot>
                  <tr>
                    <th>Name</th>
                    <th>Username</th>
                    <th>Country</th>
                    <th>Mobile</th>
                    <th>Role</th>
                    <th>Dated</th>
                    <th>Actions</th>
                  </tr>
                  </tfoot>
                </table>
			<!--------------------->
			</div>
		</div>
	</div>
</div>
		