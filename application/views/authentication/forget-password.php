<p class="login-box-msg">You forgot your password? Here you can easily retrieve a new password.</p>
<form action="<?php echo base_url('auth/recover-password');?>" method="post">
<?php echo form_hidden($this->security->get_csrf_token_name(), $this->security->get_csrf_hash()); ?>
   <div class="input-group mb-3">
      <input type="email" class="form-control" name="email" placeholder="Email">
      <div class="input-group-append">
         <div class="input-group-text">
            <span class="fas fa-envelope"></span>
         </div>
      </div>
   </div>
   <div class="row">
      <div class="col-12">
         <button type="submit" class="btn btn-primary btn-block">Request new password</button>
      </div>
      <!-- /.col -->
   </div>
</form>
<p class="mt-3 mb-1">
   <a href="<?php echo base_url('auth/login');?>">Login</a>
</p>
      

						