<div class="row">
         
          <div class="col-md-12">
            <div class="card card-primary card-outline">
              <form class="form-horizontal" method="post" action="<?php echo base_url('admin/roles/editing');?>">
              <div class="card-header">
				<h3 class="card-title"><?php echo $page_title;?></h3>
			  </div>
			  <div class="card-body">
					
						<?php echo form_hidden($this->security->get_csrf_token_name(), $this->security->get_csrf_hash()); ?>
						<?php echo form_hidden('role_id', $role[0]['id']); ?>
                      <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">Title*</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" id="" name="title" value="<?php echo $role[0]['title'];?>" placeholder="Role Title" required>
                        </div>
                      </div>
					  
					  <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">Permissions*</label>
                        <div class="col-sm-9">
							<div class="role-permissions" id="checkboxes">
							<table class="table" border="1">
								<?php if (count($data)>0){
									$role_permissions = json_decode($role[0]['permissions'], true);
									foreach($data as $p){
								?>
								<tr>
									<td style="border:1px solid #000; background: #ddd; font-weight: bold;" colspan="2"><?php echo $p['title'];?></td>
								</tr>
								<?php $group_permissions = $this->general->get_tbl_field('permissions', '*', 'parent_id', $p['id']);?>
								<?php if (count($group_permissions)){?>
								<?php foreach ($group_permissions as $gp){?>
								<tr>
									<td>
										<input type="checkbox" id="chk_<?php echo $gp['id'];?>" name="permissions[]" value="<?php echo $gp['id'];?>" <?php if (in_array($gp['id'], $role_permissions)){echo 'checked="checked"';}?>>
									</td>
									<td colspan=""><?php echo $gp['title'];?></td>
								</tr>
								<?php } ?>
								<?php } ?>
								
								<?php } } ?>
							</table>
							</div>
                        </div>
                      </div>
					 
                     
                 
              </div><!-- /.card-body -->
				<div class="card-footer" style="text-align: right;">
                          <button type="submit" class="btn btn-primary">Update Role</button>
				</div>
				</form>
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
		