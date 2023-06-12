<form class="login-form ajax_form" id="ajax_form" method="POST" action="<?php echo base_url('member/save-referral');?>">
		<?php echo form_hidden($this->security->get_csrf_token_name(), $this->security->get_csrf_hash()); ?>
<div class="modal-body clearfix">
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
	<input type="hidden" name="direct_referral" value="<?php echo $direct_referral;?>">
	<input type="hidden" name="binary_referral" value="<?php echo $binary_referral;?>">
	<input type="hidden" name="position" value="<?php echo $position;?>">
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

	
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal"><span class="fa fa-close"></span> Close</button>
    <button type="submit" class="btn btn-primary ajax_form_submit"><span class="fa fa-close"></span> Save</button>
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