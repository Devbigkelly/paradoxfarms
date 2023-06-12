<div class="row">
	<div class="col-md-6">
		<div class="card card-primary card-outline">
			<div class="card-header">
			<h3 class="card-title">Placement Settings</h3>
		  </div>
		  <form method="post" action="<?php echo base_url('member/placement-settings/update/2x');?>">
		  <div class="card-body">
			<?php $placements = array(
			'Left' => 'Left', 
			'Right' =>'Right'
			);?>
			<?php echo form_hidden($this->security->get_csrf_token_name(), $this->security->get_csrf_hash()); ?>
			<div class="form-group row">
			<label for="" class="col-sm-3 col-form-label">Username</label>
			<div class="col-sm-9">
			  <input type="text" class="form-control" name="username" value="<?php echo $tree_data[0]['binary'];?>" placeholder="Username">
			</div>
		  </div>
		  <div class="form-group row">
			<label for="" class="col-sm-3 col-form-label">Position</label>
			<div class="col-sm-9">
			<?php echo form_dropdown('position', $placements, $tree_data[0]['position'],array('class'=>'form-control')); ?>
			</div>
		  </div>
		  </div>
		  <div class="card-footer" style="text-align: right;">
            <button type="submit" class="btn btn-primary">Update Placement Settings</button>
		  </div>
		  </form>
		</div>
	</div>
	<div class="col-md-6">
		<div class="card card-primary card-outline">
			<div class="card-header">
			<h3 class="card-title">Current Settings</h3>
		  </div>
		  <div class="card-body">
			<div class="callout callout-info">
			  <h5><?php echo $tree_data[0]['binary'];?></h5>
			  <p>Binary Username</p>
			</div>
			<div class="callout callout-info">
			  <h5><?php echo $tree_data[0]['position'];?></h5>
			  <p>Binary Position</p>
			</div>
		  </div>
		</div>
	</div>
</div>

