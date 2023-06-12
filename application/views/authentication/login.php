<p class="login-box-msg">Sign in to start your session</p>
<form action="<?php echo base_url('auth/do_login');?>" method="post">
<?php echo form_hidden($this->security->get_csrf_token_name(), $this->security->get_csrf_hash()); ?>
   <div class="input-group mb-3">
      <input type="text" class="form-control" name="email" placeholder="Username / Email">
      <div class="input-group-append">
         <div class="input-group-text">
            <span class="fas fa-envelope"></span>
         </div>
      </div>
   </div>
   <div class="input-group mb-3">
      <input type="password" class="form-control" name="password" placeholder="Password">
      <div class="input-group-append">
         <div class="input-group-text">
            <span class="fas fa-lock"></span>
         </div>
      </div>
   </div>
   <div class="row">
      <div class="col-8">
         <div class="icheck-primary">
            <input type="checkbox" id="remember">
            <label for="remember">
            Remember Me
            </label>
         </div>
      </div>
      <!-- /.col -->
      <div class="col-4">
         <button type="submit" class="btn btn-primary btn-block">Sign In</button>
      </div>
      <!-- /.col -->
   </div>
</form>
<hr>
<!-- /.social-auth-links -->
<p class="mb-1">
   <a href="<?php echo base_url('auth/forget-password');?>">I forgot my password</a>
</p>
<p class="mb-0">
   <a href="<?php echo base_url('auth/register');?>" class="text-center">Register a new membership</a>
</p>
