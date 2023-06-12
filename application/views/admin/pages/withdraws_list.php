<div class="row">
	<div class="col-md-12">
		<div class="card card-primary card-outline">
			<div class="card-header">
				<h3 class="card-title">Withdraw</h3>
			</div>
			<div class="card-body">
			<!--------------------->
			<table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Tranx ID</th>
                    <th>Username</th>
                    <th>Amount</th>
                    <th>Fee</th>
                    <th>Method</th>
                    <th>Requested</th>
                    <th>Status</th>
                    <th>Actions</th>
                  </tr>
                  </thead>
                  <tbody>
				  <?php if (count($data)>0){
					$withdraw_approve = $this->returns->permission_access('withdraw_approve', $logged_username); 
					$withdraw_reject = $this->returns->permission_access('withdraw_reject', $logged_username);   
					?>
				  <?php foreach ($data as $w){ ?>
                  <tr>
                    <td><?php echo modal_anchor(get_uri("admin/transaction/".$w['transection_id']), $w['transection_id'], array("class" => "view ico-circle", "title" => 'Transaction Details')); ?></td>
                    <td><?php echo $w['username'];?></td>
                    <td><?php echo currency($w['withdrawable']);?></td>
                    <td><?php echo currency($w['fees']);?></td>
                    <td><?php echo $w['method'];?><br>(<?php echo $w['details'];?>)</td>
                    <td><?php echo $w['req_date'];?></td>
                    <td>
						<?php if ($w['status'] == 0){?>
						<?php echo 'Pending';?>
						<?php } elseif ($w['status'] == 1) { ?>
						<?php echo 'Approved<br>'.$w['approve_date'];?>
						<?php } else { ?>
						<?php echo 'Rejected';?>
						<?php } ?>
					</td>
					<td>
						<?php if ($w['status'] == 0){?>
						<div class="btn-group">
							<button type="button" class="btn btn-default btn-flat">Actions</button>
							<button type="button" class="btn btn-default btn-flat dropdown-toggle dropdown-icon" data-toggle="dropdown">
							  <span class="sr-only">Toggle Dropdown</span>
							</button>
							<div class="dropdown-menu" role="menu">
							  <?php if ($withdraw_approve){?><a class="dropdown-item" href="<?php echo base_url('admin/withdraws/approve/'.$w['id']);?>">Approve</a><?php } ?>
							  <?php if ($withdraw_reject){?><a class="dropdown-item" href="<?php echo base_url('admin/withdraws/reject/'.$w['id']);?>">Reject</a><?php } ?>
							</div>
						</div>
						<?php } else { ?>
							<button type="button" class="btn btn-default btn-flat">No Action Required</button>
						<?php } ?>
					</td>
                  </tr>
                  <?php } ?>
                  <?php } ?>
                  
                  </tbody>
                  <tfoot>
                  <tr>
                    <th>Tranx ID</th>
                    <th>Username</th>
                    <th>Amount</th>
                    <th>Fee</th>
                    <th>Method</th>
                    <th>Requested</th>
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
		