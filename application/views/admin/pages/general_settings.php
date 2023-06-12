<div class="row">
         
          <div class="col-md-12">
            <div class="card card-primary card-outline">
              <form class="form-horizontal" method="post" action="<?php echo base_url('admin/settings/general-settings/update');?>">
              <div class="card-header">
				<h3 class="card-title">General Settings</h3>
			  </div>
			  <div class="card-body">
					
						<?php echo form_hidden($this->security->get_csrf_token_name(), $this->security->get_csrf_hash()); ?>
                      <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">System Name*</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" id="" value="<?php echo $this->general->get_system_var('system_name');?>" name="system_name" placeholder="System Name">
                        </div>
                      </div>
					  <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">Short Name*</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" id="" value="<?php echo $this->general->get_system_var('system_nick');?>" name="system_nick" placeholder="Short Name">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">Google Analytic</label>
                        <div class="col-sm-9">
                          <textarea class="form-control" id=""  name="google_analytic_code" placeholder="Google Analytic"><?php echo $this->general->get_system_var('google_analytic_code');?></textarea>
                        </div>
                      </div>
					  <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">Backend Footer Left</label>
                        <div class="col-sm-9">
                          <textarea class="form-control" id="" name="back_foot_left" placeholder="Backend Footer Left"><?php echo $this->general->get_system_var('back_foot_left');?></textarea>
                        </div>
                      </div>
					  <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">Backend Footer Right</label>
                        <div class="col-sm-9">
                          <div class="input-group" id="">
								<textarea class="form-control" name="back_foot_right" placeholder="Backend Footer Right"><?php echo $this->general->get_system_var('back_foot_right');?></textarea>
							</div>
                        </div>
                      </div>
					  
					  <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label"></label>
                        <div class="col-sm-9">
						<hr>
                          <div class="form-group clearfix">
							  <div class="icheck-primary d-inline">
								<input type="checkbox" id="ranking_system_status" name="ranking_system_status" <?php if ($this->general->get_system_var('ranking_system_status')){echo 'checked';}?>>
								<label for="ranking_system_status">Ranking System</label>
							  </div>
							</div>
							
							<div class="form-group clearfix">
							  <div class="icheck-primary d-inline">
								<input type="checkbox" id="2fa_auth_status" name="2fa_auth_status" <?php if ($this->general->get_system_var('2fa_auth_status')){echo 'checked';}?>>
								<label for="2fa_auth_status">Two Factor Authentication</label>
							  </div>
							</div>
							
							<div class="form-group clearfix">
							  <div class="icheck-primary d-inline">
								<input type="checkbox" id="email_verification_required" name="email_verification_required" <?php if ($this->general->get_system_var('email_verification_required')){echo 'checked';}?>>
								<label for="email_verification_required">Email Verification Required For New User Registration</label>
							  </div>
							</div>
							
							<div class="form-group clearfix">
							  <div class="icheck-primary d-inline">
								<input type="checkbox" id="epin_status" name="epin_status" <?php if ($this->general->get_system_var('epin_status')){echo 'checked';}?>>
								<label for="epin_status">E-PIN Required for Internal Transfer and Withdraw</label>
							  </div>
							</div>
							
							<div class="form-group clearfix">
							  <div class="icheck-primary d-inline">
								<input type="checkbox" id="invitation_status" name="invitation_status" <?php if ($this->general->get_system_var('invitation_status')){echo 'checked';}?>>
								<label for="invitation_status">Allow member to send invitation </label>
							  </div>
							</div>
							
							<div class="form-group clearfix">
							  <div class="icheck-primary d-inline">
								<input type="checkbox" id="register_without_sponsor" name="register_without_sponsor" <?php if ($this->general->get_system_var('register_without_sponsor')){echo 'checked';}?>>
								<label for="register_without_sponsor">Allow user to signup without sponsor</label>
							  </div>
							</div>
							
							<div class="form-group clearfix">
							  <div class="icheck-primary d-inline">
								<input type="checkbox" id="faqs_status" name="faqs_status" <?php if ($this->general->get_system_var('faqs_status')){echo 'checked';}?>>
								<label for="faqs_status">Enable FAQs</label>
							  </div>
							</div>
							
							<div class="form-group clearfix">
							  <div class="icheck-primary d-inline">
								<input type="checkbox" id="sms_notifications_status" name="sms_notifications_status" <?php if ($this->general->get_system_var('sms_notifications_status')){echo 'checked';}?>>
								<label for="sms_notifications_status">Enable SMS Notifications</label>
							  </div>
							</div>
							<div class="form-group clearfix" id="default_sms_gateway" style="<?php if ($this->general->get_system_var('sms_notifications_status') == '0'){echo 'display:none';}?>">
							  <label for="">Default SMS Gateway</label>
							  <?php $gateways = array(
								array(
									'name' => 'Twillo',
									'value' => 'twillo',
									'status' => $this->general->get_system_var('twillo_status'),
								),
								array(
									'name' => 'Messente',
									'value' => 'messente',
									'status' => $this->general->get_system_var('messente_status'),
								),array(
									'name' => 'Infobip',
									'value' => 'infobip',
									'status' => $this->general->get_system_var('infobip_status'),
								),
							  );?>
								<?php 
								$total_sms_active = 0;
								foreach ($gateways as $gw){
								if ($gw['status'] == '1'){
									$total_sms_active = $total_sms_active + 1;
								?>
								<div class="custom-control custom-radio">
								<input type="radio" class="custom-control-input" id="<?php echo $gw['value'];?>" name="default_sms_gateway" value="<?php echo $gw['value'];?>" <?php if ($this->general->get_system_var('default_sms_gateway') == $gw['value']){echo 'checked';}?>>
								<label for="<?php echo $gw['value'];?>" class="custom-control-label"><?php echo $gw['name'];?></label>
								 </div>
								<?php } } 
								if ($total_sms_active == 0){
									echo '<br><a href="'.base_url('admin/settings/sms-settings').'">Enable atlease one SMS Gateway</a>';
								}
								?>
								
							 
							</div>
                        </div>
                      </div>
					  
                   
                 
              </div><!-- /.card-body -->
				<div class="card-footer" style="text-align: right;">
                          <button type="submit" class="btn btn-primary">Update General Settings</button>
				</div>
				</form>
            </div>
			
			
			<div class="card card-primary card-outline">
              <form class="form-horizontal" method="post" action="<?php echo base_url('admin/settings/general-settings/seo-update');?>">
              <div class="card-header">
				<h3 class="card-title">SEO Settings</h3>
			  </div>
			  <div class="card-body">
			  
			  <div class="form-group row">
				<label for="" class="col-sm-3 col-form-label">Meta Tags</label>
				<div class="col-sm-9">
				  <input type="text" class="form-control" id="" value="<?php echo $this->general->get_system_var('meta_tags');?>" name="meta_tags" placeholder="Meta Tags">
				</div>
			  </div>
			  <div class="form-group row">
				<label for="" class="col-sm-3 col-form-label">Meta Description</label>
				<div class="col-sm-9">
				  <textarea class="form-control" id=""  name="meta_description" placeholder="Meta Description"><?php echo $this->general->get_system_var('meta_description');?></textarea>
				</div>
			  </div>
			  </div><!-- /.card-body -->
				<div class="card-footer" style="text-align: right;">
                          <button type="submit" class="btn btn-primary">Update SEO Settings</button>
				</div>
				</form>
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
		  <div class="col-md-6">
			<div class="card card-primary card-outline">
				<div class="card-header">
				<h3 class="card-title">Frontend Logo</h3>
			  </div>
			  <div class="card-body">
				<form method="post" action="<?php echo base_url('admin/settings/general-settings/logo/frontend');?>" enctype="multipart/form-data">
				<?php echo form_hidden($this->security->get_csrf_token_name(), $this->security->get_csrf_hash()); ?>
				<div class="form-group">
					<div class="input-group">
					  <div class="custom-file">
						<input type="file" class="custom-file-input" name="logo" accept="image/*" id="exampleInputFile">
						<label class="custom-file-label" for="exampleInputFile">Choose file</label>
					  </div>
					  <div class="input-group-append">
						<button type="submit" class="input-group-text">Upload</button>
					  </div>
					</div>
				  </div>
				</form>
			  </div>
			</div>
		  </div>
		  <div class="col-md-6">
			<div class="card card-primary card-outline">
				<div class="card-header">
				<h3 class="card-title">Backend Logo</h3>
			  </div>
			  <div class="card-body">
				<form method="post" action="<?php echo base_url('admin/settings/general-settings/logo/backend');?>" enctype="multipart/form-data">
				<?php echo form_hidden($this->security->get_csrf_token_name(), $this->security->get_csrf_hash()); ?>
				<div class="form-group">
					<div class="input-group">
					  <div class="custom-file">
						<input type="file" class="custom-file-input" name="logo" accept="image/*" id="exampleInputFile">
						<label class="custom-file-label" for="exampleInputFile">Choose file</label>
					  </div>
					  <div class="input-group-append">
						<button type="submit" class="input-group-text">Upload</button>
					  </div>
					</div>
				  </div>
				</form>
			  </div>
			</div>
		  </div>
		  <div class="col-md-6">
			<div class="card card-primary card-outline">
				<div class="card-header">
				<h3 class="card-title">Favicon</h3>
			  </div>
			  <div class="card-body">
				<form method="post" action="<?php echo base_url('admin/settings/general-settings/logo/favicon');?>" enctype="multipart/form-data">
				<?php echo form_hidden($this->security->get_csrf_token_name(), $this->security->get_csrf_hash()); ?>
				<div class="form-group">
					<div class="input-group">
					  <div class="custom-file">
						<input type="file" class="custom-file-input" name="logo" accept="image/*" id="exampleInputFile">
						<label class="custom-file-label" for="exampleInputFile">Choose file</label>
					  </div>
					  <div class="input-group-append">
						<button type="submit" class="input-group-text">Upload</button>
					  </div>
					</div>
				</div>
				</form>
			  </div>
			</div>
		  </div>
		  <div class="col-md-6">
			<div class="card card-primary card-outline">
				<div class="card-header">
				<h3 class="card-title">Default Avatar</h3>
			  </div>
			  <div class="card-body">
				<form method="post" action="<?php echo base_url('admin/settings/general-settings/logo/avatar');?>" enctype="multipart/form-data">
				<?php echo form_hidden($this->security->get_csrf_token_name(), $this->security->get_csrf_hash()); ?>
				<div class="form-group">
					<div class="input-group">
					  <div class="custom-file">
						<input type="file" class="custom-file-input" name="logo" accept="image/*" id="exampleInputFile">
						<label class="custom-file-label" for="exampleInputFile">Choose file</label>
					  </div>
					  <div class="input-group-append">
						<button type="submit" class="input-group-text">Upload</button>
					  </div>
					</div>
				</div>
				</form>
			  </div>
			</div>
		  </div>
		  
        </div>
		<script>
		$(document).ready(function(){
        $('#sms_notifications_status').click(function(){
            if($(this).prop("checked") == true){
                $('#default_sms_gateway').show();
            } else if($(this).prop("checked") == false){
                $('#default_sms_gateway').hide();
            }
        });
    });
		</script>
		