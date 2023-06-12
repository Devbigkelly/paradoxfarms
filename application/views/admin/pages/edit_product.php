<div class="row">
         
          <div class="col-md-12">
            <div class="card card-primary card-outline">
              <form class="form-horizontal ajax_form" id="ajax_form" method="post" enctype="multipart/form-data" action="<?php echo base_url('admin/products/edit/proceed');?>">
              <div class="card-header">
				<h3 class="card-title"><?php echo $page_title;?></h3>
			  </div>
			  <div class="card-body">
					
						<?php echo form_hidden($this->security->get_csrf_token_name(), $this->security->get_csrf_hash()); ?>
						<?php echo form_hidden('product_id', $data[0]['id']); ?>
                      <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">Title*</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" id="" value="<?php echo $data[0]['title'];?>" name="title" placeholder="Title">
                        </div>
                      </div>
					  <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">Image <small>Leave Empty if you dont want to change</small></label>
                        <div class="col-sm-9">
                          <input type="file" class="form-control" name="image" accept="image/*" id="exampleInputFile">
                        </div>
                      </div>
					  <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">Price*</label>
                        <div class="col-sm-9">
                          <input type="number" class="form-control" id="" value="<?php echo $data[0]['selling_price'];?>" name="selling_price" placeholder="Price">
                        </div>
                      </div>
					  <?php if ($this->general->get_commission_var('personal_sponsor_bonus_status') == '1'){?>
                      <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">Personal Sponsor Bonus*</label>
                        <div class="col-sm-9">
                          <input type="number" class="form-control" id="" value="<?php echo $data[0]['psb'];?>" name="psb" placeholder="Personal Sponsor Bonus">
                        </div>
                      </div>
					  <?php } ?>
					  <?php if ($this->general->get_commission_var('network_binary_bonus_status') == '1'){?>
					  <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">Network Binary Bonus*</label>
                        <div class="col-sm-9">
                          <div class="input-group" id="">
								<input type="number" class="form-control" value="<?php echo $data[0]['nbb'];?>" name="nbb" placeholder="Network Binary Bonus"/>
							</div>
                        </div>
                      </div>
					  <?php } ?>
					  <?php if ($this->general->get_commission_var('generation_bonus_status') == '1'){?>
					  <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">Generation Bonus*</label>
                        <div class="col-sm-9">
                          <div class="input-group" id="">
								<input type="number" class="form-control" value="<?php echo $data[0]['gb'];?>" name="gb" placeholder="Generation Bonus"/>
							</div>
                        </div>
                      </div>
					  <?php } ?>
					  <?php if ($this->general->get_commission_var('reverse_generation_bonus_status') == '1'){?>
					  <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">Reverse Generation Bonus*</label>
                        <div class="col-sm-9">
                          <div class="input-group" id="">
								<input type="number" class="form-control" value="<?php echo $data[0]['rgb'];?>" name="rgb" placeholder="Reverse Generation Bonus"/>
							</div>
                        </div>
                      </div>
					  <?php } ?>
					  <?php if ($this->general->get_commission_var('roi_status') == '1'){?>
					  <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">Return on Investment (ROI)*</label>
                        <div class="col-sm-9">
                          <div class="input-group" id="">
								<input type="number" class="form-control" value="<?php echo $data[0]['roi'];?>" name="roi" placeholder="Return on Investment (ROI)"/>
							</div>
                        </div>
                      </div>
					  <?php } ?>
                     
                 
              </div><!-- /.card-body -->
				<div class="card-footer" style="text-align: right;">
                          <button type="submit" class="btn btn-primary ajax_form_submit">Edit Product</button>
				</div>
				</form>
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
		