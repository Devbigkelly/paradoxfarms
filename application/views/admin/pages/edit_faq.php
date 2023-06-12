<div class="row">
         
          <div class="col-md-12">
            <div class="card card-primary card-outline">
              <form class="form-horizontal" method="post" enctype="multipart/form-data" action="<?php echo base_url('admin/faqs/do-edit');?>">
              <div class="card-header">
				<h3 class="card-title"><?php echo $page_title;?></h3>
			  </div>
			  <div class="card-body">
					
						<?php echo form_hidden($this->security->get_csrf_token_name(), $this->security->get_csrf_hash()); ?>
						<?php echo form_hidden('faq_id', $data[0]['id']); ?>
                      <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">Question*</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" id="" name="question" value="<?php echo $data[0]['question'];?>" placeholder="Question" required>
                        </div>
                      </div>
					  
					  <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">Answer</label>
                        <div class="col-sm-9">
                          <textarea class="form-control" id=""  name="answer" placeholder="Answer" required><?php echo $data[0]['answer'];?></textarea>
                        </div>
                      </div>
					 
                     
                 
              </div><!-- /.card-body -->
				<div class="card-footer" style="text-align: right;">
                          <button type="submit" class="btn btn-primary">Edit FAQ</button>
				</div>
				</form>
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
		