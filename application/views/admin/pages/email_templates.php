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
                    <th>Sr #</th>
                    <th>Subject</th>
                    <th>Type</th>
                    <th>Status</th>
                    <th>Actions</th>
                  </tr>
                  </thead>
                  <tbody>
				  <?php if (count($data)>0){?>
				  <?php foreach ($data as $key => $t){ ?>
                  <tr>
                    <td><?php echo $key + 1;?></td>
                    <td><?php echo $t['subject'];?></td>
                    <td><code><?php echo $t['type'];?></code></td>
					<td><?php if ($t['status'] == '1'){
						echo 'Enabled';
					} else {
						echo 'Disabled';
					}?></td>
                   
					<th>
						<div class="btn-group">
							<button type="button" class="btn btn-default btn-flat">Actions</button>
							<button type="button" class="btn btn-default btn-flat dropdown-toggle dropdown-icon" data-toggle="dropdown">
							  <span class="sr-only">Toggle Dropdown</span>
							</button>
							<div class="dropdown-menu" role="menu">
								<a class="dropdown-item" href="<?php echo base_url('admin/settings/email-templates/edit/'.$t['id']);?>">Edit Template</a>
							  <!---<?php echo modal_anchor(get_uri("admin/settings/email-templates/edit/".$t['id']), 'Edit Template', array("class" => "dropdown-item", "title" => 'Edit Template', "data-post-template_id"=>$t['id']));?>--->
							</div>
						</div>
					</th>
                  </tr>
                  <?php } ?>
                  <?php } ?>
                  
                  </tbody>
                  <tfoot>
                  <tr>
                    <th>Sr #</th>
                    <th>Subject</th>
                    <th>Type</th>
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
		