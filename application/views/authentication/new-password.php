<p class="login-box-msg">You are only one step a way from your new password, recover your password now.</p>
<form action="<?php echo base_url('auth/set-new-password');?>" method="post">
<?php echo form_hidden($this->security->get_csrf_token_name(), $this->security->get_csrf_hash()); ?>
   <div class="input-group mb-3">
      <input type="password" class="form-control" name="password" placeholder="Password">
      <div class="input-group-append">
         <div class="input-group-text">
            <span class="fas fa-lock"></span>
         </div>
      </div>
   </div>
   <div class="input-group mb-3">
      <input type="password" class="form-control" name="repassword" placeholder="Confirm Password">
      <div class="input-group-append">
         <div class="input-group-text">
            <span class="fas fa-lock"></span>
         </div>
      </div>
   </div>
   <div class="row">
      <div class="col-12">
         <button type="submit" class="btn btn-primary btn-block">Change password</button>
      </div>
      <!-- /.col -->
   </div>
   <input type="hidden" name="key" value="<?php echo $key;?>">
</form>
<p class="mt-3 mb-1">
   <a href="<?php echo base_url('auth/login');?>">Login</a>
</p>



        <form class="login-form" method="POST" action="<?php echo base_url('auth/set-new-password');?>">
		
          <h3 class="login-head"><i class="fa fa-lg fa-fw fa-user"></i>CREATE NEW PASSWORD</h3>
          <div class="form-group">
            <label class="control-label">PASSWORD</label>
            <input class="form-control" type="password" name="password" placeholder="Password">
          </div>
		  <div class="form-group">
            <label class="control-label">CONFIRM PASSWORD</label>
            <input class="form-control" type="password" name="repassword" placeholder="Password">
          </div>
          <input type="hidden" name="key" value="<?php echo $key;?>">
		 
          <div class="form-group btn-container">
            <button type="submit" class="btn btn-primary btn-block"><i class="fa fa-sign-in fa-lg fa-fw"></i>Create new Password</button>
            
          </div>
        </form>
        
      
								
