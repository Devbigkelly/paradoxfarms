<div class="row">
         
          <div class="col-md-12">
            <div class="card card-primary card-outline">
              <form class="form-horizontal" method="post" action="<?php echo base_url('admin/settings/sms-settings/update');?>">
              <div class="card-header">
				<h3 class="card-title">SMS Gateway Settings</h3>
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
					  <a class="nav-link active" id="twillo-tab" data-toggle="pill" href="#twillo" role="tab" aria-controls="twillo" aria-selected="false">Twillo</a>
					  <a class="nav-link" id="messente-tab" data-toggle="pill" href="#messente" role="tab" aria-controls="messente" aria-selected="false">Messente</a>
					  <a class="nav-link" id="infobip-tab" data-toggle="pill" href="#infobip" role="tab" aria-controls="infobip" aria-selected="false">Infobip</a>
					</div>
				  </div>
				  <div class="col-7 col-sm-9">
					<div class="tab-content" id="vert-tabs-tabContent">
					  
					 
					  <div class="tab-pane text-left fade show active" id="twillo" role="tabpanel" aria-labelledby="twillo-tab">
							<div class="form-group row">
								<label for="" class="col-sm-3 col-form-label">Twillo Status</label>
								<div class="col-sm-9">
								<?php
									
									$twillo_status = $this->general->get_system_var('twillo_status'); 
								?>
								  <select class="form-control required" name="twillo_status">
										<?php
											foreach($stats as $s){
										?>
										<option value="<?php echo $s['value'];?>" <?php if($s['value'] == $twillo_status){ echo 'selected'; } ?>>
											<?php echo $s['name'];?>
										</option>
										<?php		
											}
										?>
									</select>
								</div>
							  </div>
							  <div class="form-group row">
								<label for="" class="col-sm-3 col-form-label">Twillo Mobile No*</label>
								<div class="col-sm-9">
								  <input type="text" class="form-control" id="" value="<?php echo $this->general->get_system_var('twillo_phone_number');?>" name="twillo_phone_number" placeholder="Twillo Mobile No">
								</div>
							  </div>
							  <div class="form-group row">
								<label for="" class="col-sm-3 col-form-label">Twillo SID*</label>
								<div class="col-sm-9">
								  <input type="text" class="form-control" id="" value="<?php echo $this->general->get_system_var('twillo_sid');?>" name="twillo_sid" placeholder="Twillo SID">
								</div>
							  </div>
							  <div class="form-group row">
								<label for="" class="col-sm-3 col-form-label">Twillo Token*</label>
								<div class="col-sm-9">
								  <input type="text" class="form-control" id="" value="<?php echo $this->general->get_system_var('twillo_token');?>" name="twillo_token" placeholder="Twillo Token">
								</div>
							  </div>
					  </div>
					  <div class="tab-pane fade" id="messente" role="tabpanel" aria-labelledby="messente-tab">
							<div class="form-group row">
							<label for="" class="col-sm-3 col-form-label">Messente Status</label>
							<div class="col-sm-9">
							<?php
								
								$messente_status = $this->general->get_system_var('messente_status'); 
							?>
							  <select class="form-control required" name="messente_status">
									<?php
										foreach($stats as $s){
									?>
									<option value="<?php echo $s['value'];?>" <?php if($s['value'] == $messente_status){ echo 'selected'; } ?>>
										<?php echo $s['name'];?>
									</option>
									<?php		
										}
									?>
								</select>
							</div>
						  </div>
						  <div class="form-group row">
							<label for="" class="col-sm-3 col-form-label">Messente Sender*</label>
							<div class="col-sm-9">
							  <input type="text" class="form-control" id="" value="<?php echo $this->general->get_system_var('messente_phone_number');?>" name="messente_phone_number" placeholder="Sender">
							</div>
						  </div>
						  <div class="form-group row">
							<label for="" class="col-sm-3 col-form-label">Messente Username*</label>
							<div class="col-sm-9">
							  <input type="text" class="form-control" id="" value="<?php echo $this->general->get_system_var('messente_username');?>" name="messente_username" placeholder="Messente Username">
							</div>
						  </div>
						  <div class="form-group row">
							<label for="" class="col-sm-3 col-form-label">Messente Password*</label>
							<div class="col-sm-9">
							  <input type="text" class="form-control" id="" value="<?php echo $this->general->get_system_var('messente_password');?>" name="messente_password" placeholder="Messente Password">
							</div>
						  </div>
					  </div>
					  
					  <div class="tab-pane fade" id="infobip" role="tabpanel" aria-labelledby="infobip-tab">
							<div class="form-group row">
							<label for="" class="col-sm-3 col-form-label">Infobip Status</label>
							<div class="col-sm-9">
							<?php
								
								$infobip_status = $this->general->get_system_var('infobip_status'); 
							?>
							  <select class="form-control required" name="infobip_status">
									<?php
										foreach($stats as $s){
									?>
									<option value="<?php echo $s['value'];?>" <?php if($s['value'] == $infobip_status){ echo 'selected'; } ?>>
										<?php echo $s['name'];?>
									</option>
									<?php		
										}
									?>
								</select>
							</div>
						  </div>
						  <div class="form-group row">
							<label for="" class="col-sm-3 col-form-label">Infobip Mobile No*</label>
							<div class="col-sm-9">
							  <input type="text" class="form-control" id="" value="<?php echo $this->general->get_system_var('infobip_phone_number');?>" name="infobip_phone_number" placeholder="Infobip Mobile No">
							</div>
						  </div>
						  <div class="form-group row">
							<label for="" class="col-sm-3 col-form-label">Infobip Username*</label>
							<div class="col-sm-9">
							  <input type="text" class="form-control" id="" value="<?php echo $this->general->get_system_var('infobip_username');?>" name="infobip_username" placeholder="Infobip Username">
							</div>
						  </div>
						  <div class="form-group row">
							<label for="" class="col-sm-3 col-form-label">Infobip Password*</label>
							<div class="col-sm-9">
							  <input type="text" class="form-control" id="" value="<?php echo $this->general->get_system_var('infobip_password');?>" name="infobip_password" placeholder="Infobip Password">
							</div>
						  </div>
					  </div>
					</div>
				  </div>
				</div>
					
					  
					  
                     
                 
              </div><!-- /.card-body -->
				<div class="card-footer" style="text-align: right;">
                          <button type="submit" class="btn btn-primary">Update SMS Gateways</button>
				</div>
				</form>
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
		