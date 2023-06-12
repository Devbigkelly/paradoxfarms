<div class="row">
         
          <div class="col-md-12">
            <div class="card card-primary card-outline">
              <form class="form-horizontal" method="post" action="<?php echo base_url('admin/settings/payment-settings/update');?>">
              <div class="card-header">
				<h3 class="card-title">Payment Settings</h3>
			  </div>
			  <div class="card-body">
					<?php 
					$stats = array(
								array(
									'name'=>'Enable',
									'value'=>'1',
								),array(
									'name'=>'Disable',
									'value'=>'0',
								),
							);
					?>
						<?php echo form_hidden($this->security->get_csrf_token_name(), $this->security->get_csrf_hash()); ?>
						
						
				<div class="row">
				  <div class="col-5 col-sm-3">
					<div class="nav flex-column nav-tabs h-100" id="vert-tabs-tab" role="tablist" aria-orientation="vertical">
					  <a class="nav-link active" id="internal-wallet-tab" data-toggle="pill" href="#internal-wallet" role="tab" aria-controls="internal-wallet" aria-selected="true">Internal Wallet</a>
					  <a class="nav-link" id="manual-tab" data-toggle="pill" href="#manual" role="tab" aria-controls="manual" aria-selected="false">Manual Payment</a>
					  <a class="nav-link" id="paypal-tab" data-toggle="pill" href="#paypal" role="tab" aria-controls="paypal" aria-selected="false">Paypal</a>
					  <a class="nav-link" id="perfect-money-tab" data-toggle="pill" href="#perfect-money" role="tab" aria-controls="perfect-money" aria-selected="false">Perfect Money</a>
					  <a class="nav-link" id="Ipay88-tab" data-toggle="pill" href="#Ipay88" role="tab" aria-controls="Ipay88" aria-selected="false">Ipay88</a>
					  <a class="nav-link" id="stripe-tab" data-toggle="pill" href="#stripe" role="tab" aria-controls="stripe" aria-selected="false">Stripe</a>
					</div>
				  </div>
				  <div class="col-7 col-sm-9">
					<div class="tab-content" id="vert-tabs-tabContent">
					  <div class="tab-pane text-left fade show active" id="internal-wallet" role="tabpanel" aria-labelledby="internal-wallet-tab">
						<div class="form-group row">
							<label for="" class="col-sm-3 col-form-label">Internal Wallet Status</label>
							<div class="col-sm-9">
							<?php
								
								$wallet_status = $this->general->get_system_var('wallet_status'); 
							?>
							  <select class="form-control required" name="wallet_status">
									<?php
										foreach($stats as $s){
									?>
									<option value="<?php echo $s['value'];?>" <?php if($s['value'] == $wallet_status){ echo 'selected'; } ?>>
										<?php echo $s['name'];?>
									</option>
									<?php		
										}
									?>
								</select>
							</div>
						  </div>
					  </div>
					  <div class="tab-pane fade" id="manual" role="tabpanel" aria-labelledby="manual-tab">
						<div class="form-group row">
							<label for="" class="col-sm-3 col-form-label">Manual Payment Status</label>
							<div class="col-sm-9">
							<?php
								
								$manual_status = $this->general->get_system_var('manual_status'); 
							?>
							  <select class="form-control required" name="manual_status">
									<?php
										foreach($stats as $s){
									?>
									<option value="<?php echo $s['value'];?>" <?php if($s['value'] == $manual_status){ echo 'selected'; } ?>>
										<?php echo $s['name'];?>
									</option>
									<?php		
										}
									?>
								</select>
							</div>
						  </div>
					  </div>
					  <div class="tab-pane fade" id="paypal" role="tabpanel" aria-labelledby="paypal-tab">
							<div class="form-group row">
								<label for="" class="col-sm-3 col-form-label">Paypal Status</label>
								<div class="col-sm-9">
								<?php
									
									$paypal_status = $this->general->get_system_var('paypal_status'); 
								?>
								  <select class="form-control required" name="paypal_status">
										<?php
											foreach($stats as $s){
										?>
										<option value="<?php echo $s['value'];?>" <?php if($s['value'] == $paypal_status){ echo 'selected'; } ?>>
											<?php echo $s['name'];?>
										</option>
										<?php		
											}
										?>
									</select>
								</div>
							  </div>
							  <div class="form-group row">
								<label for="" class="col-sm-3 col-form-label">Paypal Account*</label>
								<div class="col-sm-9">
								  <input type="text" class="form-control" id="" value="<?php echo $this->general->get_system_var('paypal_email');?>" name="paypal_email" placeholder="Paypal Account">
								</div>
							  </div>
					  </div>
					  <div class="tab-pane fade" id="perfect-money" role="tabpanel" aria-labelledby="perfect-money-tab">
							<div class="form-group row">
								<label for="" class="col-sm-3 col-form-label">Perfect Money Status</label>
								<div class="col-sm-9">
								<?php
									
									$perfect_money_status = $this->general->get_system_var('perfect_money_status'); 
								?>
								  <select class="form-control required" name="perfect_money_status">
										<?php
											foreach($stats as $s){
										?>
										<option value="<?php echo $s['value'];?>" <?php if($s['value'] == $perfect_money_status){ echo 'selected'; } ?>>
											<?php echo $s['name'];?>
										</option>
										<?php		
											}
										?>
									</select>
								</div>
							  </div>
							  <div class="form-group row">
								<label for="" class="col-sm-3 col-form-label">Perfect Money Account*</label>
								<div class="col-sm-9">
								  <input type="text" class="form-control" id="" value="<?php echo $this->general->get_system_var('perfect_money_account');?>" name="perfect_money_account" placeholder="Perfect Money Account">
								</div>
							  </div>
					  </div>
					  <div class="tab-pane fade" id="Ipay88" role="tabpanel" aria-labelledby="Ipay88-tab">
							<div class="form-group row">
								<label for="" class="col-sm-3 col-form-label">Ipay88 Status</label>
								<div class="col-sm-9">
								<?php
									
									$ipay88_status = $this->general->get_system_var('ipay88_status'); 
								?>
								  <select class="form-control required" name="ipay88_status">
										<?php
											foreach($stats as $s){
										?>
										<option value="<?php echo $s['value'];?>" <?php if($s['value'] == $ipay88_status){ echo 'selected'; } ?>>
											<?php echo $s['name'];?>
										</option>
										<?php		
											}
										?>
									</select>
								</div>
							  </div>
							  <div class="form-group row">
								<label for="" class="col-sm-3 col-form-label">Ipay88 Merchant Code*</label>
								<div class="col-sm-9">
								  <input type="text" class="form-control" id="" value="<?php echo $this->general->get_system_var('ipay88_merchant_code');?>" name="ipay88_merchant_code" placeholder="Ipay88 Merchant Code">
								</div>
							  </div>
							  <div class="form-group row">
								<label for="" class="col-sm-3 col-form-label">Ipay88 Merchant Key*</label>
								<div class="col-sm-9">
								  <input type="text" class="form-control" id="" value="<?php echo $this->general->get_system_var('ipay88_merchant_key');?>" name="ipay88_merchant_key" placeholder="Ipay88 Merchant Key">
								</div>
							  </div>
					  </div>
					  <div class="tab-pane fade" id="stripe" role="tabpanel" aria-labelledby="stripe-tab">
							<div class="form-group row">
							<label for="" class="col-sm-3 col-form-label">Stripe Status</label>
							<div class="col-sm-9">
							<?php
								
								$stripe_status = $this->general->get_system_var('stripe_status'); 
							?>
							  <select class="form-control required" name="stripe_status">
									<?php
										foreach($stats as $s){
									?>
									<option value="<?php echo $s['value'];?>" <?php if($s['value'] == $stripe_status){ echo 'selected'; } ?>>
										<?php echo $s['name'];?>
									</option>
									<?php		
										}
									?>
								</select>
							</div>
						  </div>
						  <div class="form-group row">
							<label for="" class="col-sm-3 col-form-label">Stripe Key*</label>
							<div class="col-sm-9">
							  <input type="text" class="form-control" id="" value="<?php echo $this->general->get_system_var('stripe_key');?>" name="stripe_key" placeholder="Stripe Key">
							</div>
						  </div>
						  <div class="form-group row">
							<label for="" class="col-sm-3 col-form-label">Stripe Secret*</label>
							<div class="col-sm-9">
							  <input type="text" class="form-control" id="" value="<?php echo $this->general->get_system_var('stripe_secret');?>" name="stripe_secret" placeholder="Stripe Secret">
							</div>
						  </div>
					  </div>
					</div>
				  </div>
				</div>
					
					  
					  
                     
                 
              </div><!-- /.card-body -->
				<div class="card-footer" style="text-align: right;">
                          <button type="submit" class="btn btn-primary">Update Payment Settings</button>
				</div>
				</form>
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
		