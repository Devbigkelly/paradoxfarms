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
                    <th>Product</th>
                    <th>Tranx ID</th>
                    <th>Amount</th>
                    <th>Updated</th>
                    <th>Actions</th>
                  </tr>
                  </thead>
                  <tbody>
				  <?php if (count($data)>0){
					$manual_payments_proof = $this->returns->permission_access('manual_payments_proof', $logged_username);
					$manual_payments_approve = $this->returns->permission_access('manual_payments_approve', $logged_username);
					$manual_payments_reject = $this->returns->permission_access('manual_payments_reject', $logged_username);
					?>
				  <?php foreach ($data as $p){ ?>
                  <tr>
                    <td><?php echo $p['username'];?></td>
                    <td><?php echo $p['title'];?></td>
                    <td><?php echo $p['tranx_id'];?></td>
                    <td><?php echo currency($p['payment_gross']);?></td>
                    <td><?php echo $p['dated'];?></td>
                    
					<td>
						<div class="btn-group">
							<button type="button" class="btn btn-default btn-flat">Actions</button>
							<button type="button" class="btn btn-default btn-flat dropdown-toggle dropdown-icon" data-toggle="dropdown">
							  <span class="sr-only">Toggle Dropdown</span>
							</button>
							<div class="dropdown-menu" role="menu">
							<?php if ($manual_payments_proof){?><a class="dropdown-item" target="_blank" href="<?php echo base_url('admin/manual-payments/proof/'.$p['id']);?>">View Proof</a><?php } ?>
							<?php if ($p['status'] == '0'){?>
							<div class="dropdown-divider"></div>
							  <?php if ($manual_payments_approve){?><a class="dropdown-item" href="<?php echo base_url('admin/manual-payments/approve/'.$p['id']);?>">Approve</a><?php } ?>
							  <?php if ($manual_payments_reject){?><a class="dropdown-item" href="<?php echo base_url('admin/manual-payments/reject/'.$p['id']);?>">Reject</a><?php } ?>
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
                    <th>Product</th>
                    <th>Tranx ID</th>
                    <th>Amount</th>
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
		