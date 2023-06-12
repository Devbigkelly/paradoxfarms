<div class="row">
         
          <div class="col-md-12">
            <div class="card card-primary card-outline">
              <form class="form-horizontal" method="post" action="<?php echo base_url('admin/settings/smtp-settings/update');?>">
              <div class="card-header">
				<h3 class="card-title"><?php echo $page_title;?></h3>
			  </div>
			  <div class="card-body">
					
						<?php echo form_hidden($this->security->get_csrf_token_name(), $this->security->get_csrf_hash()); ?>
                      <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">SMTP Host*</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" id="" value="<?php echo $this->general->get_system_var('smtp_host');?>" name="smtp_host" placeholder="SMTP Host">
                        </div>
                      </div>
					  <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">SMTP Port*</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" id="" value="<?php echo $this->general->get_system_var('smtp_port');?>" name="smtp_port" placeholder="SMTP Port">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">SMTP Email*</label>
                        <div class="col-sm-9">
                          <input type="email" class="form-control" id="" value="<?php echo $this->general->get_system_var('smtp_email');?>" name="smtp_email" placeholder="SMTP Email">
                        </div>
                      </div>
					  <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">SMTP Password*</label>
                        <div class="col-sm-9">
                          <div class="input-group" id="">
								<input type="password" class="form-control" name="smtp_password" value="<?php echo $this->general->get_system_var('smtp_password');?>" placeholder="SMTP Password"/>
							</div>
                        </div>
                      </div>
                     
                 
              </div><!-- /.card-body -->
				<div class="card-footer" style="text-align: right;">
                          <button type="submit" class="btn btn-primary">Update SMTP Settings</button>
				</div>
				</form>
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
		