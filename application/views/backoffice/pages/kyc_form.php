<div class="row">
         
          <div class="col-md-12">
            <div class="card card-primary card-outline">
              <form class="form-horizontal" method="post" enctype="multipart/form-data" action="<?php echo base_url('member/kyc/upload');?>">
              <div class="card-header">
				<h3 class="card-title">KYC Verification</h3>
			  </div>
			  <div class="card-body">
					
						<?php echo form_hidden($this->security->get_csrf_token_name(), $this->security->get_csrf_hash()); ?>
                      
                      
					  <div class="form-group row">
                        <label for="inputEmail" class="col-sm-3 col-form-label">Document Title*</label>
                        <div class="col-sm-9">
                          <select class="form-control" name="kyc_requirement_id">
							<option value="">Select Document Title</option>
							<?php if (count($data)>0){
								foreach ($data as $d){
									if ($this->kyc_model->is_doc_provided($this->session->userdata('user_name'), $d['id']) == false){
										echo '<option value="'.$d['id'].'">'.$d['document_title'].'</option>';
									}
								}
							}?>
						  </select>
                        </div>
                      </div>
					  <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">File*</label>
                        <div class="col-sm-9">
                          <input type="file" class="form-control" name="file" accept="" id="exampleInputFile">
                        </div>
                      </div>
					  
                    
              </div><!-- /.card-body -->
				<div class="card-footer" style="text-align: right;">
                          <button type="submit" class="btn btn-primary">Submit</button>
				</div>
				</form>
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>