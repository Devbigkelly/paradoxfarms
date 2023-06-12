<p class="login-box-msg">Please enter verification code. you received in your provided email.</p>
<form action="<?php echo base_url('auth/two-factor-authentication/verify');?>" method="post">
<?php echo form_hidden($this->security->get_csrf_token_name(), $this->security->get_csrf_hash()); ?>
   <div class="input-group mb-3">
      <input type="text" class="form-control" name="two_factor_auth_code" placeholder="Two Factor Authentication Code" value="">
      <div class="input-group-append">
         <div class="input-group-text">
            <span class="fas fa-lock"></span>
         </div>
      </div>
   </div>
   <div class="row">
      <div class="col-12">
         <button type="submit" class="btn btn-primary btn-block">Verify Code</button>
      </div>
      <!-- /.col -->
   </div>
</form>
<p class="mt-3 mb-1">
   <a href="<?php echo base_url('auth/two-factor-authentication/resend');?>">Resend Code again</a>
</p>
      

						