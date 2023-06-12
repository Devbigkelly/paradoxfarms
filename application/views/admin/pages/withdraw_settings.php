<div class="row">
         
          <div class="col-md-12">
            <div class="card card-primary card-outline">
              <form class="form-horizontal" method="post" action="<?php echo base_url('admin/settings/withdraw-settings/update');?>">
              <div class="card-header">
				<h3 class="card-title">Withdraw Settings</h3>
			  </div>
			  <div class="card-body">
					
						<?php echo form_hidden($this->security->get_csrf_token_name(), $this->security->get_csrf_hash()); ?>
                      <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">Minimum Withdraw*</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" id="" value="<?php echo $this->general->get_system_var('min_withdraw');?>" name="min_withdraw" placeholder="Minimum Withdraw">
                        </div>
                      </div>
					  <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">Withdtaw Fee (%)*</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" id="" value="<?php echo $this->general->get_system_var('withdraw_fee');?>" name="withdraw_fee" placeholder="Withdtaw Fee (%)">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">Withdraw Methods* <small>each separated by comma(,)</small></label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" id="" value="<?php echo $methods;?>" name="withdraw_methods" placeholder="Withdraw Methods, Separated by comma(,)">
                        </div>
                      </div>
					 
                     
                 
              </div><!-- /.card-body -->
				<div class="card-footer" style="text-align: right;">
                          <button type="submit" class="btn btn-primary">Update Withdraw Settings</button>
				</div>
				</form>
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
		