<div class="row">
	<div class="col-md-12">
		<div class="card card-primary card-outline">
			<div class="card-header">
				<h3 class="card-title"><?php echo $page_title;?></h3>
				<?php if ($this->returns->permission_access('ranking_add', $logged_username)){?>
				<div class="card-tools">
					<a href="<?php echo base_url('admin/ranking/add-new');?>" class="btn btn-tool">
						<i class="fas fa-plus"></i> Create New Rank
					</a>
				</div>
				<?php } ?>
			</div>
			<div class="card-body">
			<!--------------------->
			<table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Sr #</th>
                    <th>Rank</th>
                    <th>Personal Sponsor Bonus</th>
                    <th>Network Binary Bonus</th>
                    <th>Generation Bonus</th>
                    <th>Reverse Generation Bonus</th>
                    <th>ROI</th>
                    <th>Matching ROI</th>
                    <th>Direct Business</th>
                    <th>Team Business</th>
                    <th>Actions</th>
                  </tr>
                  </thead>
                  <tbody>
				  <?php if (count($data)>0){
					$ranking_edit = $this->returns->permission_access('ranking_edit', $logged_username); 
					$ranking_delete = $this->returns->permission_access('ranking_delete', $logged_username);    
					?>
				  <?php foreach ($data as $key => $r){ ?>
                  <tr>
                    <td><?php echo $r['rank_order'];?></td>
                    <td><?php echo $r['title'];?></td>
                    <td><?php echo $r['psb_min'].' - to - '.$r['psb_max'];?></td>
                    <td><?php echo $r['nbb_min'].' - to - '.$r['nbb_max'];?></td>
                    <td><?php echo $r['gb_min'].' - to - '.$r['gb_max'];?></td>
                    <td><?php echo $r['rgb_min'].' - to - '.$r['rgb_max'];?></td>
                    <td><?php echo $r['roi_min'].' - to - '.$r['roi_max'];?></td>
                    <td><?php echo $r['m_roi_min'].' - to - '.$r['m_roi_max'];?></td>
                   <td><?php echo $r['min_direct_business'];?></td>
                   <td><?php echo $r['min_team_business'];?></td>
                   
					<th>
						<div class="btn-group">
							<button type="button" class="btn btn-default btn-flat">Actions</button>
							<button type="button" class="btn btn-default btn-flat dropdown-toggle dropdown-icon" data-toggle="dropdown">
							  <span class="sr-only">Toggle Dropdown</span>
							</button>
							<?php if (in_array('ranking_edit', $permissions) || in_array('ranking_delete', $permissions)){?>
							<div class="dropdown-menu" role="menu">
								<?php if ($ranking_edit){?><a class="dropdown-item" href="<?php echo base_url('admin/ranking/edit/'.$r['id']);?>">Edit Rank</a><?php } ?>
								<?php if ($ranking_delete){?><a class="dropdown-item" href="<?php echo base_url('admin/ranking/delete/'.$r['id']);?>">Delete</a><?php } ?>
							</div>
							<?php } ?>
						</div>
					</th>
                  </tr>
                  <?php } ?>
                  <?php } ?>
                  
                  </tbody>
                  <tfoot>
                  <tr>
                    <th>Sr #</th>
                    <th>Rank</th>
                    <th>Personal Sponsor Bonus</th>
                    <th>Network Binary Bonus</th>
                    <th>Generation Bonus</th>
                    <th>Reverse Generation Bonus</th>
                    <th>ROI</th>
                    <th>Matching ROI</th>
                    <th>Direct Business</th>
                    <th>Team Business</th>
                    <th>Actions</th>
                  </tr>
                  </tfoot>
                </table>
			<!--------------------->
			</div>
		</div>
	</div>
</div>
		