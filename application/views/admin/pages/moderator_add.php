<div class="row">
         
          <div class="col-md-12">
            <div class="card card-primary card-outline">
              <form class="form-horizontal" method="post" action="<?php echo base_url('admin/moderators/add-new/proceed');?>" enctype="multipart/form-data">
              <div class="card-header">
				<h3 class="card-title">Add Moderator</h3>
			  </div>
			  <div class="card-body">
					
						<?php echo form_hidden($this->security->get_csrf_token_name(), $this->security->get_csrf_hash()); ?>
                    <div class="form-group row">
						<label for="" class="col-sm-3 col-form-label">Avatar</label>
                        <div class="col-sm-9">
						<div class="input-group">
					  <div class="custom-file">
						<input type="file" class="custom-file-input" name="logo" accept="image/*" id="exampleInputFile">
						<label class="custom-file-label" for="exampleInputFile">Choose file</label>
					  </div>
					</div>
						</div>
					
				  </div>
					  <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">Username*</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" id="" name="username" value="<?php echo $this->session->userdata('username');?>" placeholder="Username">
                        </div>
                      </div>
					  <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">Name*</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" id="" value="<?php echo $this->session->userdata('name');?>" name="name" placeholder="Name">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">Email*</label>
                        <div class="col-sm-9">
                          <input type="email" class="form-control" id="" value="<?php echo $this->session->userdata('email');?>" name="email" placeholder="Email">
                        </div>
                      </div>
					  <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">Date of Birth*</label>
                        <div class="col-sm-9">
                          <div class="input-group date" id="" data-target-input="nearest">
								<input type="date" class="form-control" name="dob" value="<?php echo $this->session->userdata('dob');?>" placeholder="Date of Birth"/>
							</div>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">Country*</label>
                        <div class="col-sm-9">
                          <select class="form-control" name="country">
							<?php if(count($countries)>0){?>
							<?php foreach ($countries as $c){?>
								<option value="<?php echo $c['name'];?>" <?php if ($c['name'] == $this->session->userdata('country')){echo 'selected';}?>><?php echo $c['name'];?></option>
							<?php } ?>
							<?php } ?>
						  </select>
                        </div>
                      </div>
					  <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">Phone Number*</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" id="" value="<?php echo $this->session->userdata('mobile');?>" name="mobile" placeholder="Phone Number">
                        </div>
                      </div>
                      
                      <hr>
					  <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">Role*</label>
                        <div class="col-sm-9">
                          <select class="form-control" name="role_id">
							<?php if(count($roles)>0){?>
							<?php foreach ($roles as $r){?>
								<option value="<?php echo $r['id'];?>" <?php if ($r['id'] == $this->session->userdata('role_id')){echo 'selected';}?>><?php echo $r['title'];?></option>
							<?php } ?>
							<?php } ?>
						  </select>
                        </div>
                    </div>
                      <hr>
					  <div class="form-group row">
                        <label for="inputName" class="col-sm-3 col-form-label">Password</label>
                        <div class="col-sm-9">
                          <input type="password" class="form-control" id="inputName" name="password" placeholder="New Password">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputEmail" class="col-sm-3 col-form-label">Confirm Password</label>
                        <div class="col-sm-9">
                          <input type="password" class="form-control" id="inputEmail" name="repassword" placeholder="Confirm New Password">
                        </div>
                      </div>
						
					
                 
              </div><!-- /.card-body -->
				<div class="card-footer" style="text-align: right;">
                          <button type="submit" class="btn btn-primary">Add Moderator</button>
				</div>
				</form>
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
		