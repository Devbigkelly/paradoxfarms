<div class="row">
	<div class="col-md-12">
		<div class="card card-primary card-outline">
			<div class="card-header">
				<h3 class="card-title"><?php echo $page_title;?></h3>
				<?php if ($this->returns->permission_access('faqs_add', $logged_username)){?>
				<div class="card-tools">
					<a type="button" href="<?php echo base_url('admin/faqs/add-new');?>" class="btn btn-tool">
						<i class="fas fa-plus"></i> Add New FAQ
					</a>
				</div>
				<?php } ?>
			</div>
			<div class="card-body">
			<!--------------------->
			<table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Sr.#</th>
                    <th>Question</th>
                    <th>Actions</th>
                  </tr>
                  </thead>
                  <tbody>
				  <?php if (count($data)>0){
					$faqs_edit = $this->returns->permission_access('faqs_edit', $logged_username);
					$faqs_delete = $this->returns->permission_access('faqs_delete', $logged_username);  
					?>
				  <?php foreach ($data as $key=>$faq){ ?>
                  <tr>
                    
                    <td><?php echo $key + 1; ?></td>
					<td><?php echo $faq['question'];?></td>
					<td>
						<div class="btn-group">
							<button type="button" class="btn btn-default btn-flat">Actions</button>
							<button type="button" class="btn btn-default btn-flat dropdown-toggle dropdown-icon" data-toggle="dropdown">
							  <span class="sr-only">Toggle Dropdown</span>
							</button>
							<div class="dropdown-menu" role="menu">
							  <?php if ($faqs_edit){?><a class="dropdown-item" href="<?php echo base_url('admin/faqs/edit/'.$faq['id']);?>">Edit</a><?php } ?>
							  <?php if ($faqs_delete){?><a class="dropdown-item" href="<?php echo base_url('admin/faqs/delete/'.$faq['id']);?>">Delete</a><?php } ?>
							</div>
						</div>
					</td>
                  </tr>
                  <?php } ?>
                  <?php } ?>
                  
                  </tbody>
                  <tfoot>
                  <tr>
                    <th>Sr.#</th>
                    <th>Question</th>
                    <th>Actions</th>
                  </tr>
                  </tfoot>
                </table>
			<!--------------------->
			</div>
		</div>
	</div>
</div>
		