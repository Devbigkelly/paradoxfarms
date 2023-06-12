<div class="row">
         
          <div class="col-md-12">
            <div class="card card-primary card-outline">
              <form class="form-horizontal ajax_form" id="ajax_form" method="post" enctype="multipart/form-data" action="<?php echo base_url('admin/products/add-new/proceed');?>">
              <div class="card-header">
				<h3 class="card-title"><?php echo $page_title;?></h3>
			  </div>
			  <div class="card-body">
					
						<?php echo form_hidden($this->security->get_csrf_token_name(), $this->security->get_csrf_hash()); ?>
                      <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">Title*</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" id="" name="title" placeholder="Title">
                        </div>
                      </div>
					  <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">Image*</label>
                        <div class="col-sm-9">
                          <input type="file" class="form-control" name="image" accept="image/*" id="exampleInputFile">
                        </div>
                      </div>
					  <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">Price*</label>
                        <div class="col-sm-9">
                          <input type="number" class="form-control" id="" name="selling_price" placeholder="Price">
                        </div>
                      </div>
					  <?php if ($this->general->get_commission_var('personal_sponsor_bonus_status') == '1'){?>
                      <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">Personal Sponsor Bonus*</label>
                        <div class="col-sm-9">
                          <input type="number" class="form-control" id="" name="psb" placeholder="Personal Sponsor Bonus">
                        </div>
                      </div>
					  <?php } ?>
					  <?php if ($this->general->get_commission_var('network_binary_bonus_status') == '1'){?>
					  <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">Network Binary Bonus*</label>
                        <div class="col-sm-9">
                          <div class="input-group" id="">
								<input type="number" class="form-control" name="nbb" placeholder="Network Binary Bonus"/>
							</div>
                        </div>
                      </div>
					   <?php } ?>
					  <?php if ($this->general->get_commission_var('generation_bonus_status') == '1'){?>
					  <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">Generation Bonus*</label>
                        <div class="col-sm-9">
                          <div class="input-group" id="">
								<input type="number" class="form-control" name="gb" placeholder="Generation Bonus"/>
							</div>
                        </div>
                      </div>
					   <?php } ?>
					  <?php if ($this->general->get_commission_var('reverse_generation_bonus_status') == '1'){?>
					  <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">Reverse Generation Bonus*</label>
                        <div class="col-sm-9">
                          <div class="input-group" id="">
								<input type="number" class="form-control" name="rgb" placeholder="Reverse Generation Bonus"/>
							</div>
                        </div>
                      </div>
					   <?php } ?>
					  <?php if ($this->general->get_commission_var('roi_status') == '1'){?>
					  <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">Return on Investment (ROI)*</label>
                        <div class="col-sm-9">
                          <div class="input-group" id="">
								<input type="number" class="form-control" name="roi" placeholder="Return on Investment (ROI)"/>
							</div>
                        </div>
                      </div>
					   <?php } ?>
                     
                 
              </div><!-- /.card-body -->
				<div class="card-footer" style="text-align: right;">
                    <button type="submit" class="btn btn-primary ajax_form_submit">Add Product</button>
				</div>
				</form>
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
		