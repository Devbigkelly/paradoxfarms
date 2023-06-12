<div class="row">
         
          <div class="col-md-12">
            <div class="card card-primary card-outline">
              <form class="form-horizontal" method="post" action="<?php echo base_url('admin/settings/transfer-settings/update');?>">
              <div class="card-header">
				<h3 class="card-title">Transfer Settings</h3>
			  </div>
			  <div class="card-body">
					
						<?php echo form_hidden($this->security->get_csrf_token_name(), $this->security->get_csrf_hash()); ?>
                      <?php 
					  $stats = array(
						array(
							'status' => 'Enable',
							'value' => '1',
						), array(
							'status' => 'Disable',
							'value' => '0',
						)
					  );
					  ?>
					  <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">Status*</label>
                        <div class="col-sm-9">
                          <select class="form-control" name="enable_transfer">
							<?php foreach ($stats as $st){?>
							<?php if ($st['value'] == $this->general->get_system_var('enable_transfer')){?>
								<option value="<?php echo $st['value'];?>" selected="selected"><?php echo $st['status'];?></option>
							<?php } else { ?>
								<option value="<?php echo $st['value'];?>"><?php echo $st['status'];?></option>
							<?php }?>
								
							<?php }?>
						  </select>
                        </div>
                      </div>
					  <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">Minimum Transfer*</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" id="" value="<?php echo $this->general->get_system_var('min_transfer');?>" name="min_transfer" placeholder="Minimum Transfer">
                        </div>
                      </div>
					  
					 
                     
                 
              </div><!-- /.card-body -->
				<div class="card-footer" style="text-align: right;">
                          <button type="submit" class="btn btn-primary">Update Transfer Settings</button>
				</div>
				</form>
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
		