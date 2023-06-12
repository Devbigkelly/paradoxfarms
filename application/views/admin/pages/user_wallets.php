<div class="row">
	<div class="col-md-12">
		<div class="card card-primary card-outline">
			<div class="card-header">
				<h3 class="card-title">User Wallets</h3>
			</div>
			<div class="card-body">
			<!--------------------->
			<table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Username</th>
                    <th>Amount</th>
                    <th>Type</th>
                    <th>Updated</th>
                    <th>Actions</th>
                  </tr>
                  </thead>
                  <tbody>
				  <?php if (count($data)>0){
					$wallets_admin_transactions = $this->returns->permission_access('wallets_admin_transactions', $logged_username);
					$wallets_history = $this->returns->permission_access('wallets_history', $logged_username); 
					$wallets_options = $this->returns->permission_access('wallets_options', $logged_username);   
					?>
				  <?php foreach ($data as $w){ ?>
                  <tr>
                    <td><?php echo $w['username'];?></td>
                    <td><?php echo currency($w['amount']);?></td>
                    <td><?php echo $w['type'];?></td>
                    <td><?php echo $w['dated'];?></td>
                    
					<td>
						<div class="btn-group">
							<button type="button" class="btn btn-default btn-flat">Actions</button>
							<button type="button" class="btn btn-default btn-flat dropdown-toggle dropdown-icon" data-toggle="dropdown">
							  <span class="sr-only">Toggle Dropdown</span>
							</button>
							<div class="dropdown-menu" role="menu">
							  <?php if ($wallets_history){?><a class="dropdown-item" href="<?php echo base_url('admin/wallets/history/'.$w['username']);?>">History</a><?php } ?>
							  <?php if ($wallets_options){?><a class="dropdown-item" href="<?php echo base_url('admin/wallets/user/'.$w['username']);?>">Wallet Options</a><?php } ?>
							  <?php if ($wallets_admin_transactions){?><a class="dropdown-item" href="<?php echo base_url('admin/wallets/admin-transactions/'.$w['username']);?>">Admin Transactions</a><?php } ?>
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
                    <th>Amount</th>
                    <th>Type</th>
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
		