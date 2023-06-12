<div class="row">
	<div class="col-md-12">
		<div class="card card-primary card-outline">
			<div class="card-header">
				<h3 class="card-title"><?php echo $page_title;?></h3>
				<?php if ($this->returns->permission_access('roles_add', $logged_username)){?>
				<div class="card-tools">
					<a type="button" href="<?php echo base_url('admin/roles/add-new');?>" class="btn btn-tool">
						<i class="fas fa-plus"></i> Create New Role
					</a>
				</div>
				<?php } ?>
			</div>
			<div class="card-body">
			<!--------------------->
			<table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Title</th>
                    <th>Slug</th>
                    <th>Permissions</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
				  <?php if (count($data)>0){
					$roles_edit = $this->returns->permission_access('roles_edit', $logged_username);
					$roles_delete = $this->returns->permission_access('roles_delete', $logged_username);
				?>
				  <?php foreach ($data as $row){ 
				  if ($row['id'] > 1) {
				  ?>
                  <tr>
                    <td><?php echo $row['title'];?></td>
					<td><?php echo $row['slug'];?></td>
					<td>
					<?php $permissions = json_decode($row['permissions'], true);
					if (count($permissions)>0){
						echo '<ul>';
						foreach($permissions as $permission){
							echo '<li>'.$this->returns->permission_slug_by_id($permission).'</li>';
						}
						echo '</ul>';
					} else {
						echo 'No permission Granted';
					}
					?>
					</td>
                    
					<td>
						<div class="btn-group">
							<button type="button" class="btn btn-default btn-flat">Actions</button>
							<button type="button" class="btn btn-default btn-flat dropdown-toggle dropdown-icon" data-toggle="dropdown">
							  <span class="sr-only">Toggle Dropdown</span>
							</button>
							<div class="dropdown-menu" role="menu">
								<?php if ($roles_edit){?><a class="dropdown-item" href="<?php echo base_url('admin/roles/edit/'.$row['id']);?>">Edit</a><?php } ?>
								<?php if ($roles_delete){?><a class="dropdown-item" href="<?php echo base_url('admin/roles/delete/'.$row['id']);?>">Delete</a><?php } ?>
							</div>
						</div>
					</td>
                  </tr>
                  <?php } ?>
                  <?php } ?>
                  <?php } ?>
                  
                  </tbody>
                  <tfoot>
                  <tr>
                    <th>Title</th>
                    <th>Slug</th>
                    <th>Permissions</th>
                    <th>Action</th>
                  </tr>
                  </tfoot>
                </table>
			<!--------------------->
			</div>
		</div>
	</div>
</div>
		