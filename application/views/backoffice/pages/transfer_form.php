<div class="row">
         
          <div class="col-md-12">
            <div class="card card-primary card-outline">
              <form class="form-horizontal" method="post" action="<?php echo base_url('member/transfer/form/do');?>">
              <div class="card-header">
				<h3 class="card-title">Funds Transfer <small>(Min Transfer: <?php echo currency($this->general->get_system_var('min_transfer'));?>)</small></h3>
			  </div>
			  <div class="card-body">
					<?php if ($transfer_disabled == true){?>
					<div class="callout callout-danger">
						<p>Transfer Disabled, Please contact support for more information.</p>
					</div>
					<?php } ?>
						<?php echo form_hidden($this->security->get_csrf_token_name(), $this->security->get_csrf_hash()); ?>
                      <div class="form-group row">
                        <label for="inputName" class="col-sm-3 col-form-label">Beneficiary Username</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" id="inputName" name="username" placeholder="Beneficiary Username">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputEmail" class="col-sm-3 col-form-label">Amount <small>(Current Balance: <?php echo currency($amount)?>)</small></label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" id="inputEmail" name="amount" placeholder="Amount">
                        </div>
                      </div>
					  <?php if ($this->general->get_system_var('epin_status') == '1'){?>
					  <div class="form-group row">
                        <label for="inputEmail" class="col-sm-3 col-form-label">E-PIN</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" id="inputEmail" name="epin" placeholder="E-PIN">
                        </div>
                      </div>
					  <?php } ?>
                    
              </div><!-- /.card-body -->
				<div class="card-footer" style="text-align: right;">
                          <button type="submit" class="btn btn-primary"<?php if ($transfer_disabled == true){echo 'disabled';}?>>Transfer</button>
				</div>
				</form>
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>