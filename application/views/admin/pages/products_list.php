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
                    <th>Title</th>
                    <th>Price</th>
                    <th>Sponsor Bonus</th>
                    <th>Network Binary Bonus</th>
                    <th>Generation Bonus</th>
                    <th>Reverse Generation Bonus</th>
                    <th>ROI</th>
                    <th>Actions</th>
                  </tr>
                  </thead>
                  <tbody>
				  <?php if (count($data)>0){
					$products_edit = $this->returns->permission_access('products_edit', $logged_username);
					$products_delete = $this->returns->permission_access('products_delete', $logged_username);
					?>
				  <?php foreach ($data as $p){ ?>
                  <tr>
                    <td><?php echo $p['title'];?></td>
                    <td><?php echo currency($p['selling_price']);?></td>
                    <td><?php echo currency($p['psb']);?></td>
                    <td><?php echo currency($p['nbb']);?></td>
                    <td><?php echo currency($p['gb']);?></td>
                    <td><?php echo currency($p['rgb']);?></td>
                    <td><?php echo currency($p['roi']);?></td>
                    <td>
						<div class="btn-group">
							<button type="button" class="btn btn-default btn-flat">Actions</button>
							<button type="button" class="btn btn-default btn-flat dropdown-toggle dropdown-icon" data-toggle="dropdown">
							  <span class="sr-only">Toggle Dropdown</span>
							</button>
							<div class="dropdown-menu" role="menu">
							  <?php if ($products_edit){?><a class="dropdown-item" href="<?php echo base_url('admin/products/edit/'.$p['id']);?>">Edit</a><?php } ?>
							  <?php if ($products_delete){?><a class="dropdown-item" href="<?php echo base_url('admin/products/delete/'.$p['id']);?>">Delete</a><?php } ?>
							</div>
						</div>
					</td>
                  </tr>
                  <?php } ?>
                  <?php } ?>
                  
                  </tbody>
                  <tfoot>
                  <tr>
                    <th>Title</th>
                    <th>Price</th>
                    <th>Sponsor Bonus</th>
                    <th>Network Binary Bonus</th>
                    <th>Generation Bonus</th>
                    <th>Reverse Generation Bonus</th>
                    <th>ROI</th>
                    <th>Actions</th>
                  </tr>
                  </tfoot>
                </table>
			<!--------------------->
			</div>
		</div>
	</div>
</div>
		