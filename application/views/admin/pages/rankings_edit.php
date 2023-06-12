<div class="row">
         
          <div class="col-md-12">
            <div class="card card-primary card-outline">
              <form class="form-horizontal" method="post" action="<?php echo base_url('admin/ranking/do-edit');?>">
              <div class="card-header">
				<h3 class="card-title"><?php echo $page_title;?></h3>
			  </div>
			  <div class="card-body">
					<div class="callout callout-danger">
					  <ul>
						<li class="text-danger"><b>Maximum Value</b> must be <b>999999999</b>, if you are adding Final Rank.</li>
						<li class="text-danger"><b>Rank Order with heigher value means heigher Rank</b></li>
						<li class="text-danger">Put <b>0</b> to the Parameters <b>except the ones you want rank system based on</b></li>
						<li class="text-danger">Rank Values <b>must not overlap</b> with other ranks</li>
					  </ul>
					</div>
						<?php echo form_hidden($this->security->get_csrf_token_name(), $this->security->get_csrf_hash()); ?>
						<?php echo form_hidden('rank_id', $data[0]['id']); ?>
                      <div class="form-group row">
                        <label for="inputEmail" class="col-sm-3 col-form-label">Rank Title</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" id="inputEmail" name="title" value="<?php echo $data[0]['title'];?>" placeholder="Rank Title" required>
                        </div>
                      </div>
					  <div class="form-group row">
                        <label for="inputEmail" class="col-sm-3 col-form-label">Rank Order</label>
						<div class="col-sm-9">
							<div class="row">
								<div class="col-sm-6">
								<input type="number" class="form-control" id="inputEmail" name="rank_order" value="<?php echo $data[0]['rank_order'];?>" placeholder="Rank Order" required>
								</div>
								<?php $colors = array(
									array(
										'name' => 'White',
										'value' => 'navbar-light navbar-white'
									),array(
										'name' => 'Light Blue',
										'value' => 'navbar-dark navbar-primary'
									),array(
										'name' => 'Dark Gray',
										'value' => 'navbar-dark navbar-secondary'
									),array(
										'name' => 'Green',
										'value' => 'navbar-dark navbar-success'
									),array(
										'name' => 'Light Green',
										'value' => 'navbar-dark navbar-teal'
									),array(
										'name' => 'Cyan',
										'value' => 'navbar-dark navbar-cyan'
									),array(
										'name' => 'Red',
										'value' => 'navbar-dark navbar-danger'
									),array(
										'name' => 'Black',
										'value' => 'navbar-dark'
									),array(
										'name' => 'Gray',
										'value' => 'navbar-light'
									),
									
								);?>
								<div class="col-sm-6">
								<select class="form-control" name="rank_color">
									<?php foreach ($colors as $clr){?>
									<option value="<?php echo $clr['value'];?>" <?php if ($clr['value'] == $data[0]['rank_color']){echo 'selected="selected"';}?>><?php echo $clr['name'];?></option>
									<?php } ?>
								</select>
								</div>
							</div>
                        </div>
                      </div>
					  <div class="form-group row">
                        <label for="inputName" class="col-sm-3 col-form-label">Personal Sponsor Bonus</label>
                        <div class="col-sm-9">
							<div class="row">
								<div class="col-sm-6">
								<input type="number" class="form-control" id="inputName" name="psb_min" value="<?php echo $data[0]['psb_min'];?>" placeholder="Minimum Value" required>
								</div>
								<div class="col-sm-6">
								<input type="number" class="form-control" id="inputName" name="psb_max" value="<?php echo $data[0]['psb_max'];?>" placeholder="Maximum Value" required>
								</div>
							</div>
                        </div>
                      </div>
					  <div class="form-group row">
                        <label for="inputName" class="col-sm-3 col-form-label">Network Binary Bonus</label>
                        <div class="col-sm-9">
							<div class="row">
								<div class="col-sm-6">
								<input type="number" class="form-control" id="inputName" name="nbb_min" value="<?php echo $data[0]['nbb_min'];?>" placeholder="Minimum Value" required>
								</div>
								<div class="col-sm-6">
								<input type="number" class="form-control" id="inputName" name="nbb_max" value="<?php echo $data[0]['nbb_max'];?>" placeholder="Maximum Value" required>
								</div>
							</div>
                        </div>
                      </div>
					  <div class="form-group row">
                        <label for="inputName" class="col-sm-3 col-form-label">Generation Bonus</label>
                        <div class="col-sm-9">
							<div class="row">
								<div class="col-sm-6">
								<input type="number" class="form-control" id="inputName" name="gb_min" value="<?php echo $data[0]['gb_min'];?>" placeholder="Minimum Value" required>
								</div>
								<div class="col-sm-6">
								<input type="number" class="form-control" id="inputName" name="gb_max" value="<?php echo $data[0]['gb_max'];?>" placeholder="Maximum Value" required>
								</div>
							</div>
                        </div>
                      </div>
					  <div class="form-group row">
                        <label for="inputName" class="col-sm-3 col-form-label">Reverse Generation Bonus</label>
                        <div class="col-sm-9">
							<div class="row">
								<div class="col-sm-6">
								<input type="number" class="form-control" id="inputName" name="rgb_min" value="<?php echo $data[0]['rgb_min'];?>" placeholder="Minimum Value" required>
								</div>
								<div class="col-sm-6">
								<input type="number" class="form-control" id="inputName" name="rgb_max" value="<?php echo $data[0]['rgb_max'];?>" placeholder="Maximum Value" required>
								</div>
							</div>
                        </div>
                      </div>
					  <div class="form-group row">
                        <label for="inputName" class="col-sm-3 col-form-label">Return on Investment (ROI)</label>
                        <div class="col-sm-9">
							<div class="row">
								<div class="col-sm-6">
								<input type="number" class="form-control" id="inputName" name="roi_min" value="<?php echo $data[0]['roi_min'];?>" placeholder="Minimum Value" required>
								</div>
								<div class="col-sm-6">
								<input type="number" class="form-control" id="inputName" name="roi_max" value="<?php echo $data[0]['roi_max'];?>" placeholder="Maximum Value" required>
								</div>
							</div>
                        </div>
                      </div>
					  <div class="form-group row">
                        <label for="inputName" class="col-sm-3 col-form-label">Matching ROI</label>
                        <div class="col-sm-9">
							<div class="row">
								<div class="col-sm-6">
								<input type="number" class="form-control" id="inputName" name="m_roi_min" value="<?php echo $data[0]['m_roi_min'];?>" placeholder="Minimum Value" required>
								</div>
								<div class="col-sm-6">
								<input type="number" class="form-control" id="inputName" name="m_roi_max" value="<?php echo $data[0]['m_roi_max'];?>" placeholder="Maximum Value" required>
								</div>
							</div>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputEmail" class="col-sm-3 col-form-label">Personal Business</label>
                        <div class="col-sm-9">
                          <input type="number" class="form-control" id="inputEmail" name="min_direct_business" value="<?php echo $data[0]['min_direct_business'];?>" placeholder="Total Personal Business" required>
                        </div>
                      </div>
					  <div class="form-group row">
                        <label for="inputEmail" class="col-sm-3 col-form-label">Team Business</label>
                        <div class="col-sm-9">
                          <input type="number" class="form-control" id="inputEmail" name="min_team_business" value="<?php echo $data[0]['min_team_business'];?>" placeholder="Total Team Business" required>
                        </div>
                      </div>
                      
                      
                    
                 
              </div><!-- /.card-body -->
				<div class="card-footer" style="text-align: right;">
                          <button type="submit" class="btn btn-primary">Update Rank</button>
				</div>
				</form>
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>