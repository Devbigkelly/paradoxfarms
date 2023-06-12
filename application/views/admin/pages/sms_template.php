<div class="row">
         
          <div class="col-md-12">
            <div class="card card-primary card-outline">
              <form class="form-horizontal" method="post" enctype="multipart/form-data" action="<?php echo base_url('admin/settings/sms-templates/update');?>">
              <div class="card-header">
				<h3 class="card-title"><?php echo $page_title;?></h3>
			  </div>
			  <div class="card-body">
					
						<?php echo form_hidden($this->security->get_csrf_token_name(), $this->security->get_csrf_hash()); ?>
						<?php echo form_hidden('template_id', $data[0]['id']); ?>
                      
					  <?php 
					$stats = array(
								array(
									'name'=>'Enable',
									'value'=>'1',
								),array(
									'name'=>'Disable',
									'value'=>'0',
								),
							);
					?>
					<div class="form-group row">
							
							<div class="col-sm-12">
							<label for="" class="form-label">SMS Status</label>
							<?php
								
								$status = $data[0]['status']; 
							?>
							  <select class="form-control required" name="status">
									<?php
										foreach($stats as $s){
									?>
									<option value="<?php echo $s['value'];?>" <?php if($s['value'] == $status){ echo 'selected'; } ?>>
										<?php echo $s['name'];?>
									</option>
									<?php		
										}
									?>
								</select>
							</div>
						  </div>
	  <div class="form-group row">
		
		<div class="col-sm-12">
		<label for="" class="form-label">Template*</label>
		<textarea class="form-control" name="message" placeholder="Email Body" required><?php echo $data[0]['message'];?></textarea>
		</div>
	  </div>
	  
	<div class="form-group row">
		<div class="col-sm-12" style="color:#C00;">
			**Parameter must be written within [[ ]] as [[parameter]]. Available parameters for this template are given below<br>
			<?php $parameters = explode(',', $data[0]['parameters_list']);
			if (count($parameters)>0){
				echo '<code>';
				foreach ($parameters as $param){
					echo '<span class="template-parameters">';
					echo '[['.$param.']]';
					echo '</span>';
				}
				echo '</code>';
			}
			?>
		</div>
	</div>
					  
                 
              </div><!-- /.card-body -->
				<div class="card-footer" style="text-align: right;">
                          <button type="submit" class="btn btn-primary">Update Template</button>
				</div>
				</form>
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
		
		