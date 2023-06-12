<div class="row">
         
          <div class="col-md-12">
            <div class="card card-primary card-outline">
              <form class="form-horizontal" method="post" action="<?php echo base_url('member/invitation/do');?>">
              <div class="card-header">
				<h3 class="card-title"><?php echo $page_title;?></h3>
			  </div>
			  <div class="card-body">
					
						<?php echo form_hidden($this->security->get_csrf_token_name(), $this->security->get_csrf_hash()); ?>
                      
                      <div class="form-group row">
                        <label for="inputEmail" class="col-sm-3 col-form-label">Invitee Name</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" id="inputEmail" name="name" placeholder="Invitee Name" required>
                        </div>
                      </div> 
					  <div class="form-group row">
                        <label for="inputEmail" class="col-sm-3 col-form-label">Invitee Email</label>
                        <div class="col-sm-9">
                          <input type="email" class="form-control" id="inputEmail" name="email" placeholder="Invitee Email" required>
                        </div>
                      </div> 
					  <div class="form-group row">
                        <label for="inputEmail" class="col-sm-3 col-form-label">Invitee Mobile</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" id="inputEmail" name="mobile" placeholder="Invitee Mobile" required>
                        </div>
                      </div> 
					  
					  <div class="form-group row">
                        <label for="inputEmail" class="col-sm-3 col-form-label">Invitation Message</label>
                        <div class="col-sm-9">
                          <textarea class="form-control" id="inputEmail" name="message" placeholder="Invitation Message" required></textarea>
                        </div>
                      </div>
					  
                    
              </div><!-- /.card-body -->
				<div class="card-footer" style="text-align: right;">
                          <button type="submit" class="btn btn-primary">Send Invitation</button>
				</div>
				</form>
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>