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
                    <th>Ticket ID</th>
                    <th>Username</th>
                    <th>Title</th>
                    <th>Created</th>
                    <th>Last Message</th>
                    <th>Actions</th>
                  </tr>
                  </thead>
                  <tbody>
				  <?php if (count($data)>0){
					$support_ticket_change_status = $this->returns->permission_access('support_ticket_change_status', $logged_username);
					$support_ticket_detail = $this->returns->permission_access('support_ticket_detail', $logged_username); 
					?>
				  <?php foreach ($data as $t){ ?>
                  <tr>
                    <td><?php echo $t['ticket_id'];?></td>
					<td><?php echo $t['username'];?></td>
                    <td><?php echo $t['title'];?></td>
                    <td><?php echo $t['updated'];?></td>
					<td><?php echo $this->support->last_message($t['id']);?></td>
                    <td>
						<div class="btn-group">
							<button type="button" class="btn btn-default btn-flat">Actions</button>
							<button type="button" class="btn btn-default btn-flat dropdown-toggle dropdown-icon" data-toggle="dropdown">
							  <span class="sr-only">Toggle Dropdown</span>
							</button>
							<div class="dropdown-menu" role="menu">
							  <?php if ($support_ticket_detail){?><a class="dropdown-item" href="<?php echo base_url('admin/support/ticket/'.$t['ticket_id']);?>">View Ticket</a><?php } ?>
							  <?php if ($support_ticket_change_status){?><a class="dropdown-item" href="<?php echo base_url('admin/support/close-ticket/'.$t['id']);?>">Close Ticket</a><?php } ?>
							</div>
						</div>
					</td>
                  </tr>
                  <?php } ?>
                  <?php } ?>
                  
                  </tbody>
                  <tfoot>
                  <tr>
                    <th>Ticket ID</th>
					<th>Username</th>
                    <th>Title</th>
                    <th>Created</th>
					<th>Last Message</th>
					<th>Actions</th>
                  </tr>
                  </tfoot>
                </table>
			<!--------------------->
			</div>
		</div>
	</div>
</div>
		