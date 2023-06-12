<div class="row">
	<div class="col-md-12">
		<div class="card card-primary card-outline">
			<form class="form-horizontal" method="post" action="<?php echo base_url('admin/disperse-roi/proceed');?>" onSubmit="return confirm('Are you sure you wish to proceed?');">>
			<div class="card-header">
				<h3 class="card-title"><?php echo $page_title;?></h3>
			</div>
			<div class="card-body">
			<?php echo form_hidden($this->security->get_csrf_token_name(), $this->security->get_csrf_hash()); ?>
			<!--------------------->
			<table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Select</th>
                    <th>#</th>
                    <th>Username</th>
                    <th>Total Personal Sponsor Bonus</th>
                    <th>ROI</th>
                  </tr>
                  </thead>
                  <tbody>
				  <?php if (count($data)>0){?>
				  <?php $x = 1;?>
				  <?php foreach ($data as $user){ ?>
                  <tr>
                    
                    <td><input type="checkbox" name="users[]" value="<?php echo $user['username'];?>"></td>
					<td><?php echo $x;?></td>
					<td><?php echo $user['username'];?></td>
					<td><?php echo currency($this->commissions->total_type_income($user['username'], 'personal-sponsor-bonus'));?></td>
					<td><?php echo currency($this->commissions->total_type_income($user['username'], 'roi'));?></td>
                  </tr>
                  <?php $x = $x+1; ?>
                  <?php } ?>
                  <?php } ?>
                  
                  </tbody>
                  <tfoot>
                  <tr>
                    <th>Select</th>
                    <th>#</th>
                    <th>Username</th>
                    <th>Total Personal Sponsor Bonus</th>
					<th>ROI</th>
                  </tr>
                  </tfoot>
                </table>
			<!--------------------->
			</div>
			<div class="card-footer" style="text-align: right;">
                <button type="submit" class="btn btn-primary">Disperse</button>
			</div>
			</form>
		</div>
	</div>
</div>
		