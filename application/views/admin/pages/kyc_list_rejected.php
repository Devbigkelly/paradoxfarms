<div class="row">
	<div class="col-md-12">
		<div class="card card-primary card-outline">
			<div class="card-header">
				<h3 class="card-title"><?php echo $page_title;?></h3>
			</div>
			<div class="card-body">
			<!--------------------->
			<table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Username</th>
                    <th>Updated</th>
                    <th>Actions</th>
                  </tr>
                  </thead>
                  <tbody>
				  <?php if (count($data)>0){
					$kyc_approve = $this->returns->permission_access('kyc_approve', $logged_username);
					$kyc_reject = $this->returns->permission_access('kyc_reject', $logged_username);
					$kyc_documents = $this->returns->permission_access('kyc_documents', $logged_username);
				?>
				  <?php foreach ($data as $k){ ?>
                  <tr>
                    <td><?php echo $k['username'];?></td>
                    <td><?php echo $k['dated'];?></td>
                    
					<td>
						<div class="btn-group">
							<button type="button" class="btn btn-default btn-flat">Actions</button>
							<button type="button" class="btn btn-default btn-flat dropdown-toggle dropdown-icon" data-toggle="dropdown">
							  <span class="sr-only">Toggle Dropdown</span>
							</button>
							<div class="dropdown-menu" role="menu">
							<?php if ($kyc_documents){?><a class="dropdown-item" href="<?php echo base_url('admin/kyc/documents/'.$k['username']);?>">Documents</a><?php } ?>
							<?php if ($k['status'] == '0'){?>
							<div class="dropdown-divider"></div>
							  <?php if ($kyc_approve){?><a class="dropdown-item" href="<?php echo base_url('admin/kyc/approve/'.$k['username']);?>">Approve</a><?php } ?>
							  <?php if ($kyc_reject){?><a class="dropdown-item" href="<?php echo base_url('admin/kyc/reject/'.$k['username']);?>">Reject</a><?php } ?>
							<?php } ?>
							</div>
						</div>
					</td>
                  </tr>
                  <?php } ?>
                  <?php } ?>
                  
                  </tbody>
                  <tfoot>
                  <tr>
                    <th>Username</th>
                    <th>Updated</th>
                    <th>Actions</th>
                  </tr>
                  </tfoot>
                </table>
			<!--------------------->
			</div>
		</div>
	</div>
</div>
		