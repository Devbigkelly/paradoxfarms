 <form class="login-form ajax_form" id="ajax_form" method="POST" action="<?php echo base_url('auth/do-register');?>">
		<?php echo form_hidden($this->security->get_csrf_token_name(), $this->security->get_csrf_hash()); ?>
         
		  <div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<input class="form-control" type="text" name="name" value="<?php echo $this->session->flashdata('name');?>" placeholder="Name" autofocus>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<input class="form-control" type="text" name="username" value="<?php echo $this->session->flashdata('username');?>" placeholder="Username" autofocus>
				</div>
			</div>
		  </div>
		  <div class="form-group">
			<input class="form-control" type="email" name="email" value="<?php echo $this->session->flashdata('email');?>" placeholder="Email" autofocus>
		  </div>
		  <?php if (empty($sponsor)){?>
		<!---<input type="hidden" name="sponsor" value="">--->
		<div class="row">
			<div class="col-md-12">
				<div class="form-group">
					<input class="form-control" type="text" value="<?php echo $this->session->flashdata('sponsor');?>" name="sponsor" placeholder="Sponsor's Username">
				</div>
			</div>
		</div>
		<?php } else {?>
		<input type="hidden" name="sponsor" value="<?php echo $sponsor;?>">
		<?php } ?>
		  <div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<select class="form-control" name="country" onchange="populate_country_code(this.value)">
					<option value="">Select Country</option>
					<?php foreach ($countries as $c){
						if ($c['name'] == $this->session->flashdata('country')){?>
							<option value="<?php echo $c['name'].'-'.$c['dial_code'];?>" selected="selected"><?php echo $c['name'];?></option>
						<?php } else { ?>
							<option value="<?php echo $c['name'].'-'.$c['dial_code'];?>"><?php echo $c['name'];?></option>
						<?php } ?>
					
					<?php } ?>
					</select>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<input class="form-control" id="mobile" type="text" name="mobile" value="<?php echo $this->session->flashdata('mobile');?>" placeholder="Mobile Number" autofocus>
				</div>
			</div>
		  </div>
		<!---<?php if($this->general->get_system_var('matrix_type') == 'simple'){?>
			<div class="form-group">
				<select class="form-control" name="position">
					<option value="">Select Position</option>
					<option value="Left">Left</option>
					<?php if ($this->general->get_system_var('matrix') == '3x'){?>
					<option value="Center">Center</option>
					<?php } ?>
					<option value="Right">Right</option>
				</select>
			</div>
		<?php } ?>--->
		
		  <div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<input class="form-control" type="password" name="password" placeholder="Password">
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<input class="form-control" type="password" name="repassword" placeholder="Confirm Password">
				</div>
			</div>
		  </div>
		  
		  
          
		  
          
		  
          <div class="form-group btn-container">
            <button type="submit" class="btn btn-primary btn-block ajax_form_submit"><i class="fa fa-sign-in fa-lg fa-fw"></i>Create Account</button>
          </div>
		  <div class="form-group">
            <div class="utility">
			  <a class="btn btn-primary btn-block" href="<?php echo base_url('auth/login');?>">Already Registered, Login Here</a>
            </div>
          </div>
        </form>
<script>
	var base_url = '<?php echo base_url();?>';
	function populate_country_code(value){
		if (value == ''){
			$('#mobile').val('');
		} else {
			$.ajax({
				url:base_url+'auth/get_country_code',
				method:"POST",
				data:{country:value},
				//dataType: "json",
				success:function(data){
					$('#mobile').val(data);
				}, 
			});
		}
		
	}
</script>

