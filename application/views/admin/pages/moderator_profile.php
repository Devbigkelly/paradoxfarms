<div class="row">
		<?php if ($this->returns->permission_access('moderators_update_avatar', $logged_username)){?>
         <div class="col-md-12">
			<div class="card card-primary card-outline">
				<div class="card-header">
				<h3 class="card-title">Avatar</h3>
			  </div>
			  <div class="card-body">
				<form method="post" action="<?php echo base_url('admin/moderators/do-update-avatar/'.$data[0]['username']);?>" enctype="multipart/form-data">
				<?php echo form_hidden($this->security->get_csrf_token_name(), $this->security->get_csrf_hash()); ?>
				<?php echo form_hidden('username', $data[0]['username']); ?>
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
		<?php } ?>
		<?php if ($this->returns->permission_access('moderators_edit', $logged_username)){?>
          <div class="col-md-12">
            <div class="card card-primary card-outline">
              <form class="form-horizontal" method="post" action="<?php echo base_url('admin/moderators/do-update-profile/'.$data[0]['username']);?>">
              <div class="card-header">
				<h3 class="card-title">Update Profile</h3>
			  </div>
			  <div class="card-body">
					
						<?php echo form_hidden($this->security->get_csrf_token_name(), $this->security->get_csrf_hash()); ?>
						<?php echo form_hidden('username', $data[0]['username']); ?>
                      <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">Username</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" id="" value="<?php echo $data[0]['username'];?>" placeholder="Username" disabled>
                        </div>
                      </div>
					  <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">Name*</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" id="" value="<?php echo $data[0]['name'];?>" name="name" placeholder="Name">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">Email*</label>
                        <div class="col-sm-9">
                          <input type="email" class="form-control" id="" value="<?php echo $data[0]['email'];?>" name="email" placeholder="Email">
                        </div>
                      </div>
					  <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">Date of Birth*</label>
                        <div class="col-sm-9">
                          <div class="input-group date" id="" data-target-input="nearest">
								<input type="date" class="form-control" name="dob" value="<?php echo $data[0]['dob'];?>" placeholder="Date of Birth"/>
							</div>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">Country*</label>
                        <div class="col-sm-9">
                          <select class="form-control" name="country">
							<?php if(count($countries)>0){?>
							<?php foreach ($countries as $c){
							if ($c['name'] == $data[0]['country']){?>
								<option value="<?php echo $c['name'];?>" selected="selected"><?php echo $c['name'];?></option>
							<?php } else {?>
								<option value="<?php echo $c['name'];?>"><?php echo $c['name'];?></option>
							<?php } ?> 
							<?php } ?>
							<?php } ?>
						  </select>
                        </div>
                      </div>
					  <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">Phone Number*</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" id="" value="<?php echo $data[0]['mobile'];?>" name="mobile" placeholder="Phone Number">
                        </div>
                      </div>
                      <hr>
					  <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">Role*</label>
                        <div class="col-sm-9">
                          <select class="form-control" name="role_id">
							<?php if(count($roles)>0){?>
							<?php foreach ($roles as $r){?>
								<option value="<?php echo $r['id'];?>" <?php if ($r['id'] == $data[0]['role_id']){echo 'selected';}?>><?php echo $r['title'];?></option>
							<?php } ?>
							<?php } ?>
						  </select>
                        </div>
                    </div>
                      
                    
                 
              </div><!-- /.card-body -->
				<div class="card-footer" style="text-align: right;">
                          <button type="submit" class="btn btn-primary">Update Profile</button>
				</div>
				</form>
            </div>
            <!-- /.card -->
          </div>
		<?php } ?>
          <!-- /.col -->
        </div>
		