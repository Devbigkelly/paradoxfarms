<div class="row">
         
          <div class="col-md-12">
            <div class="card card-primary card-outline">
              <form class="form-horizontal" method="post" action="<?php echo base_url('member/profile/generate-epin/do');?>">
              <div class="card-header">
				<h3 class="card-title"><?php echo $page_title;?></h3>
			  </div>
			  <div class="card-body">
					
						<?php echo form_hidden($this->security->get_csrf_token_name(), $this->security->get_csrf_hash()); ?>
                      <div class="form-group row">
                        <label for="inputName" class="col-sm-3 col-form-label">E-PIN</label>
                        <div class="col-sm-9">
                          <input type="password" class="form-control" id="inputName" name="epin" placeholder="E-PIN">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputEmail" class="col-sm-3 col-form-label">Confirm E-PIN</label>
                        <div class="col-sm-9">
                          <input type="password" class="form-control" id="inputEmail" name="re_epin" placeholder="Confirm E-PIN">
                        </div>
                      </div>
                     
                      
                      
                    
                 
              </div><!-- /.card-body -->
				<div class="card-footer" style="text-align: right;">
                          <button type="submit" class="btn btn-primary">Generate E-PIN</button>
				</div>
				</form>
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>