<div class="row">
         
          <div class="col-md-12">
            <div class="card card-primary card-outline">
              <form class="form-horizontal" method="post" action="<?php echo base_url('admin/settings/kyc-settings/update');?>">
              <div class="card-header">
				<h3 class="card-title"><?php echo $page_title;?></h3>
			  </div>
			  <div class="card-body">
					
						<?php echo form_hidden($this->security->get_csrf_token_name(), $this->security->get_csrf_hash()); ?>
                      <?php 
					  $stats = array(
						array(
							'status' => 'Enable',
							'value' => '1',
						), array(
							'status' => 'Disable',
							'value' => '0',
						)
					  );
					  ?>
					  <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">Status*</label>
                        <div class="col-sm-9">
                          <select class="form-control" name="kyc_status">
							<?php foreach ($stats as $st){?>
							<?php if ($st['value'] == $this->general->get_system_var('kyc_status')){?>
								<option value="<?php echo $st['value'];?>" selected="selected"><?php echo $st['status'];?></option>
							<?php } else { ?>
								<option value="<?php echo $st['value'];?>"><?php echo $st['status'];?></option>
							<?php }?>
								
							<?php }?>
						  </select>
                        </div>
                      </div>
					  
					  <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">Required Documents*</label>
                        <div class="col-sm-9">
                        <div id="kyc_docs">
						<?php if (count($data)>0){?>
						<?php foreach($data as $key=>$doc){?>
						<div class="input-group" id="doc_id_<?php echo $key;?>">
							<input type="text" class="form-control" value="<?php echo $doc['document_title'];?>" name="docs[]" placeholder="Document Title" style="margin-bottom:10px;">
							<span class="input-group-btn">
								<a href="#" class="btn btn-danger btn-md" onclick="removeRow(<?php echo $key;?>);" id="del"> <i class="fas fa-minus"></i></a>
							</span>
						</div>
						<?php } ?>
						<?php } ?>
						</div>
						<input type="hidden" id="fields_counter" value="<?php echo count($data);?>">
						<div class="input-group">
                          <input type="text" class="form-control" id="new_field" value="" name="docs[]" placeholder="Document Title">
						  <span class="input-group-btn">
                            <a href="#" class="btn btn-info btn-md" id="add_more"> <i class="fas fa-plus"></i></a>
						  </span>
						</div>
                        </div>
                      </div>
					 
					 
					  <script>
						function removeRow(removeNum) {
							$('#doc_id_'+removeNum).remove();
						}
						$('#add_more').click(function (event) {
							event.preventDefault();
							var counter = $("#fields_counter").val();
							var value = $("#new_field").val();
							if (value.length > 5){
								counter = parseInt(counter) + 1;
								$("#fields_counter").val(counter);
								var fields = $("#kyc_docs > input").length;
								//already_existed(value);
								var this_id = fields + 1;
								var html = '<div class="input-group" id="doc_id_'+counter+'">'+
								'<input type="text" class="form-control" value="'+value+'" name="docs[]" placeholder="Document Title" style="margin-bottom:10px;">'+
								'<span class="input-group-btn">'+
								'<a href="#" class="btn btn-danger" onclick="removeRow('+counter+');" id="del"> <i class="fas fa-minus"></i></a>'+
								'</span>'+
								'</div>';
								
								
								$('#new_field').val('');
								$("#kyc_docs").append(html);
								
								
							}
    
						});
						function already_existed(new_value){
						var inps = document.getElementsByName('docs[]');
							for (var i = 0; i <inps.length; i++) {
								var inp=inps[i];
								if (new_value == inp.value){
									console.log('existed');
								}
								//console.log("pname["+i+"].value="+inp.value);
							}
						}
					  </script>
					  
					 
                     
                 
              </div><!-- /.card-body -->
				<div class="card-footer" style="text-align: right;">
                          <button type="submit" class="btn btn-primary">Update KYC Settings</button>
				</div>
				</form>
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
		