<div class="row">
	<div class="col-md-3">
			<div class="btn-group-vertical support-side-menu">
				<a href="<?php echo base_url('member/support');?>" class="btn btn-default">Generate New Ticket</a>
				<a href="<?php echo base_url('member/support/tickets/open');?>" class="btn btn-default <?php if ($type == 'open'){echo 'active';};?>">Open Tickets</a>
				<a href="<?php echo base_url('member/support/tickets/closed');?>" class="btn btn-default <?php if ($type == 'closed'){echo 'active';};?>">Closed Tickets</a>
			</div>
		  </div>
	<div class="col-md-9">
		<div class="card card-primary card-outline">
			<div class="card-header">
				<h3 class="card-title"><?php echo $page_title;?></h3>
			</div>
			<div class="card-body">
			<!--------------------->
			<table id="example2" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Ticket ID</th>
                    <th>Title</th>
                    <th>Created</th>
                    <th>Actions</th>
                  </tr>
                  </thead>
                  <tbody>
				  <?php if (count($data)>0){?>
				  <?php foreach ($data as $t){ ?>
                  <tr>
                    <td><?php echo $t['ticket_id'];?></td>
                    <td><?php echo $t['title'];?></td>
                    <td><?php echo $t['updated'];?></td>
                    <td><a href="<?php echo base_url('member/support/ticket/'.$t['ticket_id']);?>" class="btn btn-default btn-flat">View Ticket</a></td>
                  </tr>
                  <?php } ?>
                  <?php } ?>
                  
                  </tbody>
                  <tfoot>
                  <tr>
                    <th>Ticket ID</th>
                    <th>Title</th>
                    <th>Created</th>
					<th>Actions</th>
                  </tr>
                  </tfoot>
                </table>
			<!--------------------->
			</div>
		</div>
	</div>
</div>
		