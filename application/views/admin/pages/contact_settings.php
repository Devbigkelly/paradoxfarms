<div class="row">
         
          <div class="col-md-12">
            <div class="card card-primary card-outline">
              <form class="form-horizontal" method="post" action="<?php echo base_url('admin/settings/contact-settings/update');?>">
              <div class="card-header">
				<h3 class="card-title"><?php echo $page_title;?></h3>
			  </div>
			  <div class="card-body">
					
						<?php echo form_hidden($this->security->get_csrf_token_name(), $this->security->get_csrf_hash()); ?>
                      <h3>Social Media</h3>
					  <hr>
					  <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">Facebook</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" id="" value="<?php echo $this->general->get_system_var('facebook');?>" name="facebook" placeholder="Facebook">
                        </div>
                      </div>
					  <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">Twitter</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" id="" value="<?php echo $this->general->get_system_var('twitter');?>" name="twitter" placeholder="Twitter">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">Google Plus</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" id="" value="<?php echo $this->general->get_system_var('google_plus');?>" name="google_plus" placeholder="Google Plus">
                        </div>
                      </div>
					  <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">Pinterest</label>
                        <div class="col-sm-9">
							<input type="text" class="form-control" name="pinterest" value="<?php echo $this->general->get_system_var('pinterest');?>" placeholder="Pinterest"/>
                        </div>
                      </div>
					  <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">Linkedin</label>
                        <div class="col-sm-9">
							<input type="text" class="form-control" name="linkedin" value="<?php echo $this->general->get_system_var('linkedin');?>" placeholder="Linkedin"/>
                        </div>
                      </div>
					  <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">Youtube</label>
                        <div class="col-sm-9">
							<input type="text" class="form-control" name="youtube" value="<?php echo $this->general->get_system_var('youtube');?>" placeholder="Youtube"/>
                        </div>
                      </div>
					  <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">Instagram</label>
                        <div class="col-sm-9">
							<input type="text" class="form-control" name="instagram" value="<?php echo $this->general->get_system_var('instagram');?>" placeholder="Instagram"/>
                        </div>
                      </div>
					  <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">Delicious</label>
                        <div class="col-sm-9">
							<input type="text" class="form-control" name="delicious" value="<?php echo $this->general->get_system_var('delicious');?>" placeholder="Delicious"/>
                        </div>
                      </div>
					  <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">Dribbble</label>
                        <div class="col-sm-9">
							<input type="text" class="form-control" name="dribbble" value="<?php echo $this->general->get_system_var('dribbble');?>" placeholder="Dribbble"/>
                        </div>
                      </div>
					  <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">Foursquare</label>
                        <div class="col-sm-9">
							<input type="text" class="form-control" name="foursquare" value="<?php echo $this->general->get_system_var('foursquare');?>" placeholder="Foursquare"/>
                        </div>
                        </div>
						<div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">GG-Circle</label>
                        <div class="col-sm-9">
							<input type="text" class="form-control" name="gg-circle" value="<?php echo $this->general->get_system_var('gg-circle');?>" placeholder="GG-Circle"/>
                        </div>
                      </div>
					  <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">Forumbee</label>
                        <div class="col-sm-9">
							<input type="text" class="form-control" name="forumbee" value="<?php echo $this->general->get_system_var('forumbee');?>" placeholder="Forumbee"/>
                        </div>
                      </div>
					  <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">QQ</label>
                        <div class="col-sm-9">
							<input type="text" class="form-control" name="qq" value="<?php echo $this->general->get_system_var('qq');?>" placeholder="QQ"/>
                        </div>
                      </div>
					  <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">Snapchat</label>
                        <div class="col-sm-9">
							<input type="text" class="form-control" name="snapchat" value="<?php echo $this->general->get_system_var('snapchat');?>" placeholder="Snapchat"/>
                        </div>
                      </div>
					  <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">Tumblr</label>
                        <div class="col-sm-9">
							<input type="text" class="form-control" name="tumblr" value="<?php echo $this->general->get_system_var('tumblr');?>" placeholder="Tumblr"/>
                        </div>
                      </div>
					  <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">Twitch</label>
                        <div class="col-sm-9">
							<input type="text" class="form-control" name="twitch" value="<?php echo $this->general->get_system_var('twitch');?>" placeholder="Twitch"/>
                        </div>
                        </div>
						<div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">Vk</label>
                        <div class="col-sm-9">
							<input type="text" class="form-control" name="vk" value="<?php echo $this->general->get_system_var('vk');?>" placeholder="Vk"/>
                        </div>
                      </div>
					  <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">Whatsapp</label>
                        <div class="col-sm-9">
							<input type="text" class="form-control" name="whatsapp" value="<?php echo $this->general->get_system_var('whatsapp');?>" placeholder="Whatsapp"/>
                        </div>
                      </div>
					  <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">Vimeo</label>
                        <div class="col-sm-9">
							<input type="text" class="form-control" name="vimeo" value="<?php echo $this->general->get_system_var('vimeo');?>" placeholder="Vimeo"/>
                        </div>
                      </div>
					  <hr>
					  <h3>Other Info</h3>
					  <hr>
					  <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">Email*</label>
                        <div class="col-sm-9">
							<input type="email" class="form-control" name="email" value="<?php echo $this->general->get_system_var('email');?>" placeholder="Email" required/>
                        </div>
                      </div>
					  <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">Phone No</label>
                        <div class="col-sm-9">
							<input type="text" class="form-control" name="phone" value="<?php echo $this->general->get_system_var('phone');?>" placeholder="Phone No"/>
                        </div>
                      </div>
					  <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">Address</label>
                        <div class="col-sm-9">
							<input type="text" class="form-control" name="address" value="<?php echo $this->general->get_system_var('address');?>" placeholder="Address"/>
                        </div>
                      </div>
					  
                     
                 
              </div><!-- /.card-body -->
				<div class="card-footer" style="text-align: right;">
                          <button type="submit" class="btn btn-primary">Update Contact Settings</button>
				</div>
				</form>
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
		