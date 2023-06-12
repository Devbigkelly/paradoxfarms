<div class="row">
	<div class="col-md-12">
		<div class="card card-primary card-outline">
			<div class="card-header">
				<h3 class="card-title"><?php echo $page_title;?></h3>
				<div class="card-tools">
					<a type="button" href="<?php echo base_url('admin/database-backup/create-new');?>" class="btn btn-tool">
						<i class="fas fa-plus"></i> Create New Backup
					</a>
				</div>
			</div>
			
			<div class="card-body">
			<!--------------------->
			<table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>File</th>
                    <th>Dated</th>
					<th>Actions</th>
                  </tr>
                  </thead>
                  <tbody>
				  <?php if (count($data)>0){?>
				  <?php foreach($data as $backup){?>
                  <tr>
					<td><?php echo $backup['backup_file'];?></td>
					<td><?php echo $backup['dated'];?></td>
					<td>
						<div class="btn-group">
							<button type="button" class="btn btn-default btn-flat">Actions</button>
							<button type="button" class="btn btn-default btn-flat dropdown-toggle dropdown-icon" data-toggle="dropdown">
							  <span class="sr-only">Toggle Dropdown</span>
							</button>
							<div class="dropdown-menu" role="menu">
							  <a class="dropdown-item" href="<?php echo base_url('admin/database-backup/download/'.$backup['id']);?>">Download</a>
							  <a class="dropdown-item" href="<?php echo base_url('admin/database-backup/restore/'.$backup['id']);?>">Restore</a>
							  <a class="dropdown-item" href="<?php echo base_url('admin/database-backup/delete/'.$backup['id']);?>">Delete</a>
							</div>
						</div>
					</td>
                  </tr>
				  <?php } ?>
				  <?php } ?>
                 
                  </tbody>
                  <tfoot>
                  <tr>
                   <th>File</th>
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
		