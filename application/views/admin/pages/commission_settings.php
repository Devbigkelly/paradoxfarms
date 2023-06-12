<div class="row">
         
          <div class="col-md-12">
            <div class="card card-primary card-outline">
              <form class="form-horizontal" method="post" action="<?php echo base_url('admin/settings/commission-settings/update');?>">
              <div class="card-header">
				<h3 class="card-title">Commission Settings</h3>
			  </div>
			  <div class="card-body">
				<div class="callout callout-danger">
				  <ul>
					<li class="text-danger"><b>Up to Level</b> Means up to how many <b>levels deep</b>, commission will be calculated.</li>
					<li class="text-danger">Up to Level and No of Level Values <b>must be same</b>.</li>
					<li class="text-danger">Level Values are <b>percentages</b>, i.e 1,2,3... means 1%, 2%, 3%... respectively.</li>
					<li class="text-danger">Level Values are in <b>Ascending Order</b></li>
					<li class="text-danger"><b>Matching ROI</b> is based on <b>ROI</b>, Means if <b>ROI</b> is disabled, <b>Matching ROI won't work too</b></li>
					<li class="text-danger"><b>Network Binary Bonus</b> is not applicable to  <b>Forced Matrix System</b></li>
				  </ul>
				</div>
				<hr>
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
					<?php 
					$bases = array(
								array(
									'name'=>'Product Bonus Value',
									'value'=>'product_purchase',
								),array(
									'name'=>'Network Binary Bonus Value',
									'value'=>'nbb',
								),
							);
					?>
					<?php 
					$nbb_bases = array(
								array(
									'name'=>'Product Bonus Value',
									'value'=>'product_purchase',
								),array(
									'name'=>'Total Personal Sponsor Bonus',
									'value'=>'psb_total',
								),
							);
					?>
					<?php 
					$nbb_levels = array(
								array(
									'name'=>'Unlimited Levels',
									'value'=>'1',
								),array(
									'name'=>'Defined Number of Levels',
									'value'=>'0',
								),
							);
					?>
					<?php 
					$nbb_pairs = array(
								array(
									'name'=>'All Users',
									'value'=>'0',
								),array(
									'name'=>'Users with Product Purchased',
									'value'=>'1',
								),
							);
					?>
						<?php echo form_hidden($this->security->get_csrf_token_name(), $this->security->get_csrf_hash()); ?>
						
						
				<div class="row">
				  <div class="col-5 col-sm-3">
					<div class="nav flex-column nav-tabs h-100" id="vert-tabs-tab" role="tablist" aria-orientation="vertical">
					  <a class="nav-link active" id="personal-sponsor-bonus-tab" data-toggle="pill" href="#personal-sponsor-bonus" role="tab" aria-controls="personal-sponsor-bonus" aria-selected="true">Personal Sponsor Bonus</a>
					  <a class="nav-link" id="network-binary-bonus-tab" data-toggle="pill" href="#network-binary-bonus" role="tab" aria-controls="network-binary-bonus" aria-selected="false">Network Binary Bonus</a>
					  <a class="nav-link" id="generation-bonus-tab" data-toggle="pill" href="#generation-bonus" role="tab" aria-controls="generation-bonus" aria-selected="false">Generation Bonus</a>
					  <a class="nav-link" id="reverse-generation-bonus-tab" data-toggle="pill" href="#reverse-generation-bonus" role="tab" aria-controls="reverse-generation-bonus" aria-selected="false">Reverse Generation Bonus</a>
					  <a class="nav-link" id="roi-tab" data-toggle="pill" href="#roi" role="tab" aria-controls="roi" aria-selected="false">Return on Investment (ROI)</a>
					  <a class="nav-link" id="matching-roi-tab" data-toggle="pill" href="#matching-roi" role="tab" aria-controls="matching-roi" aria-selected="false">Matching ROI</a>
					</div>
				  </div>
				  <div class="col-7 col-sm-9">
					<div class="tab-content" id="vert-tabs-tabContent">
					  <div class="tab-pane text-left fade show active" id="personal-sponsor-bonus" role="tabpanel" aria-labelledby="personal-sponsor-bonus-tab">
						<div class="form-group row">
							<label for="" class="col-sm-3 col-form-label">Personal Sponsor Bonus Status</label>
							<div class="col-sm-9">
							<?php
								
								$personal_sponsor_bonus_status = $this->general->get_commission_var('personal_sponsor_bonus_status'); 
							?>
							  <select class="form-control required" name="personal_sponsor_bonus_status">
									<?php
										foreach($stats as $s){
									?>
									<option value="<?php echo $s['value'];?>" <?php if($s['value'] == $personal_sponsor_bonus_status){ echo 'selected'; } ?>>
										<?php echo $s['name'];?>
									</option>
									<?php		
										}
									?>
								</select>
							</div>
						  </div>
						  <div class="form-group row">
							<label for="" class="col-sm-3 col-form-label">Australian xUP Status</label>
							<div class="col-sm-9">
							<div class="row">
								<div class="col-sm-6">
								<?php
									
									$xup_status = $this->general->get_commission_var('xup_status'); 
								?>
								  <select class="form-control required" name="xup_status">
										<?php
											foreach($stats as $s){
										?>
										<option value="<?php echo $s['value'];?>" <?php if($s['value'] == $xup_status){ echo 'selected'; } ?>>
											<?php echo $s['name'];?>
										</option>
										<?php		
											}
										?>
									</select>
								</div>
								<div class="col-sm-6">
								  <input type="number" class="form-control" id="" value="<?php echo $this->general->get_commission_var('xup_level');?>" name="xup_level" placeholder="Up to Level" required>
								</div>
							</div>
							</div>
						  </div>
						  <div class="form-group row">
							<label for="" class="col-sm-3 col-form-label">Up to Level*</label>
							<div class="col-sm-9">
							  <input type="number" class="form-control" id="" value="<?php echo $this->general->get_commission_var('personal_sponsor_bonus_levels');?>" name="personal_sponsor_bonus_levels" placeholder="Up to Level" required>
							</div>
						  </div>
						  <div class="form-group row">
							<label for="" class="col-sm-3 col-form-label">Level Values* <small>Each Separated by comma (,)</small></label>
							<div class="col-sm-9">
							  <input type="text" class="form-control" id="" value="<?php echo implode(',',json_decode($this->general->get_commission_var('personal_sponsor_bonus_values')));?>" name="personal_sponsor_bonus_values" placeholder="Level Values (Each separated by comma)">
							</div>
						  </div>
						  <hr>
						  <h3>Elegibility</h3>
						  <hr>
						  <div class="form-group row">
							<label for="" class="col-sm-3 col-form-label">Minimum Direct Referrals*</label>
							<div class="col-sm-9">
							  <input type="number" class="form-control" id="" value="<?php echo $this->general->get_commission_var('psb_min_direct_sponsors');?>" name="psb_min_direct_sponsors" placeholder="Minimum Direct Referrals" required>
							</div>
						  </div>
						  <div class="form-group row">
							<label for="" class="col-sm-3 col-form-label">Minimum Products / Packages Purchase*</label>
							<div class="col-sm-9">
							  <input type="number" class="form-control" id="" value="<?php echo $this->general->get_commission_var('psb_min_purchases');?>" name="psb_min_purchases" placeholder="Minimum Products / Packages Purchase" required>
							</div>
						  </div>
					  </div>
					  <div class="tab-pane fade" id="network-binary-bonus" role="tabpanel" aria-labelledby="network-binary-bonus-tab">
							<div class="form-group row">
								<label for="" class="col-sm-3 col-form-label">Network Binary Bonus Status</label>
								<div class="col-sm-9">
								<?php
									
									$network_binary_bonus_status = $this->general->get_commission_var('network_binary_bonus_status'); 
								?>
								  <select class="form-control required" name="network_binary_bonus_status">
										<?php
											foreach($stats as $s){
										?>
										<option value="<?php echo $s['value'];?>" <?php if($s['value'] == $network_binary_bonus_status){ echo 'selected'; } ?>>
											<?php echo $s['name'];?>
										</option>
										<?php		
											}
										?>
									</select>
								</div>
							</div>
							<div class="form-group row">
								<label for="" class="col-sm-3 col-form-label">Network Binary Bonus Pair Type</label>
								<div class="col-sm-9">
								<?php
									
									$nbb_pair_type = $this->general->get_commission_var('nbb_pair_type'); 
								?>
								  <select class="form-control required" name="nbb_pair_type">
										<?php
											foreach($nbb_pairs as $pait_type){
										?>
										<option value="<?php echo $pait_type['value'];?>" <?php if($pait_type['value'] == $nbb_pair_type){ echo 'selected'; } ?>>
											<?php echo $pait_type['name'];?>
										</option>
										<?php		
											}
										?>
									</select>
								</div>
							</div>
							  <div class="form-group row">
								<label for="" class="col-sm-3 col-form-label">Network Binary Bonus Amount</label>
								<div class="col-sm-9">
								<?php $network_binary_bonus_base = $this->general->get_commission_var('network_binary_bonus_base');  ?>
								  <select class="form-control required" name="network_binary_bonus_base">
										<?php
											foreach($nbb_bases as $nbb_b){
										?>
										<option value="<?php echo $nbb_b['value'];?>" <?php if($nbb_b['value'] == $network_binary_bonus_base){ echo 'selected'; } ?>>
											<?php echo $nbb_b['name'];?>
										</option>
										<?php		
											}
										?>
									</select>
								</div>
							  </div>
							  <div class="form-group row">
								<label for="" class="col-sm-3 col-form-label">Level Setting*</label>
								<div class="col-sm-9">
								<?php $nbb_level_unlimited = $this->general->get_commission_var('nbb_level_unlimited');  ?>
								  <select class="form-control required" name="nbb_level_unlimited" id="nbb_level_unlimited" onchange="levet_setting_box()">
										<?php
											foreach($nbb_levels as $nbb_level){
										?>
										<option value="<?php echo $nbb_level['value'];?>" <?php if($nbb_level['value'] == $nbb_level_unlimited){ echo 'selected'; } ?>>
											<?php echo $nbb_level['name'];?>
										</option>
										<?php		
											}
										?>
									</select>
								</div>
							  </div>
							  <?php if ($this->general->get_commission_var('nbb_level_unlimited') == '1'){
								  $lvl_display = 'style="display:none"';
							  } else {
								  $lvl_display = '';
							  }?>
							  <div class="form-group row" id="network_binary_bonus_levels" <?php echo $lvl_display;?>>
								<label for="" class="col-sm-3 col-form-label">Up to Level*</label>
								<div class="col-sm-9">
								  <input type="number" class="form-control" id="" value="<?php echo $this->general->get_commission_var('network_binary_bonus_levels');?>" name="network_binary_bonus_levels" placeholder="Up to Level" required>
								</div>
							  </div>
							  
							  <div class="form-group row">
								<label for="" class="col-sm-3 col-form-label">Commission Percentage</label>
								<div class="col-sm-9">
								  <input type="number" class="form-control" id="" value="<?php echo $this->general->get_commission_var('network_binary_bonus_percentage');?>" name="network_binary_bonus_percentage" placeholder="Commission Percentage">
								</div>
							  </div>
							  <hr>
						  <h3>Elegibility</h3>
						  <hr>
						  <div class="form-group row">
							<label for="" class="col-sm-3 col-form-label">Minimum Direct Referrals*</label>
							<div class="col-sm-9">
							  <input type="number" class="form-control" id="" value="<?php echo $this->general->get_commission_var('nbs_min_direct_sponsors');?>" name="nbs_min_direct_sponsors" placeholder="Minimum Direct Referrals" required>
							</div>
						  </div>
						  <div class="form-group row">
							<label for="" class="col-sm-3 col-form-label">Minimum Binary Referrals*</label>
							<div class="col-sm-9">
							  <input type="number" class="form-control" id="" value="<?php echo $this->general->get_commission_var('nbs_min_binary_sponsors');?>" name="nbs_min_binary_sponsors" placeholder="Minimum Binary Referrals" required>
							</div>
						  </div>
						  <div class="form-group row">
							<label for="" class="col-sm-3 col-form-label">Minimum Products / Packages Purchase*</label>
							<div class="col-sm-9">
							  <input type="number" class="form-control" id="" value="<?php echo $this->general->get_commission_var('nbs_min_purchases');?>" name="nbs_min_purchases" placeholder="Minimum Products / Packages Purchase" required>
							</div>
						  </div>
					  </div>
					  <div class="tab-pane fade" id="generation-bonus" role="tabpanel" aria-labelledby="generation-bonus">
							<div class="form-group row">
								<label for="" class="col-sm-3 col-form-label">Generation Bonus Status</label>
								<div class="col-sm-9">
								<?php
									
									$generation_bonus_status = $this->general->get_commission_var('generation_bonus_status'); 
								?>
								  <select class="form-control required" name="generation_bonus_status">
										<?php
											foreach($stats as $s){
										?>
										<option value="<?php echo $s['value'];?>" <?php if($s['value'] == $generation_bonus_status){ echo 'selected'; } ?>>
											<?php echo $s['name'];?>
										</option>
										<?php		
											}
										?>
									</select>
								</div>
							  </div>
							  <div class="form-group row">
								<label for="" class="col-sm-3 col-form-label">Generation Bonus Amount</label>
								<div class="col-sm-9">
								<?php
									
									$generation_bonus_base = $this->general->get_commission_var('generation_bonus_base'); 
								?>
								  <select class="form-control required" name="generation_bonus_base">
										<?php
											foreach($bases as $b){
										?>
										<option value="<?php echo $b['value'];?>" <?php if($b['value'] == $generation_bonus_base){ echo 'selected'; } ?>>
											<?php echo $b['name'];?>
										</option>
										<?php		
											}
										?>
									</select>
								</div>
							  </div>
							  <div class="form-group row">
								<label for="" class="col-sm-3 col-form-label">Up to Level*</label>
								<div class="col-sm-9">
								  <input type="number" class="form-control" id="" value="<?php echo $this->general->get_commission_var('generation_bonus_levels');?>" name="generation_bonus_levels" placeholder="Up to Level" required>
								</div>
							  </div>
							  <div class="form-group row">
								<label for="" class="col-sm-3 col-form-label">Level Values* <small>Each Separated by comma (,)</small></label>
								<div class="col-sm-9">
								  <input type="text" class="form-control" id="" value="<?php echo implode(',',json_decode($this->general->get_commission_var('generation_bonus_values')));?>" name="generation_bonus_values" placeholder="Level Values (Each separated by comma)">
								</div>
							  </div>
							  
							  <hr>
						  <h3>Elegibility</h3>
						  <hr>
						  <div class="form-group row">
							<label for="" class="col-sm-3 col-form-label">Minimum Direct Referrals*</label>
							<div class="col-sm-9">
							  <input type="number" class="form-control" id="" value="<?php echo $this->general->get_commission_var('gb_min_direct_sponsors');?>" name="gb_min_direct_sponsors" placeholder="Minimum Direct Referrals" required>
							</div>
						  </div>
						  <div class="form-group row">
							<label for="" class="col-sm-3 col-form-label">Minimum Binary Referrals*</label>
							<div class="col-sm-9">
							  <input type="number" class="form-control" id="" value="<?php echo $this->general->get_commission_var('gb_min_binary_sponsors');?>" name="gb_min_binary_sponsors" placeholder="Minimum Binary Referrals" required>
							</div>
						  </div>
						  <div class="form-group row">
							<label for="" class="col-sm-3 col-form-label">Minimum Direct Sponsor Bonus*</label>
							<div class="col-sm-9">
							  <input type="number" class="form-control" id="" value="<?php echo $this->general->get_commission_var('gb_min_direct_sponsors_bonus');?>" name="gb_min_direct_sponsors_bonus" placeholder="Minimum Direct Sponsor Bonus" required>
							</div>
						  </div>
						  <div class="form-group row">
							<label for="" class="col-sm-3 col-form-label">Minimum Network Binary Bonus*</label>
							<div class="col-sm-9">
							  <input type="number" class="form-control" id="" value="<?php echo $this->general->get_commission_var('gb_min_nbb_bonus');?>" name="gb_min_nbb_bonus" placeholder="Minimum Network Binary Bonus" required>
							</div>
						  </div>
						  <div class="form-group row">
							<label for="" class="col-sm-3 col-form-label">Minimum Products / Packages Purchase*</label>
							<div class="col-sm-9">
							  <input type="number" class="form-control" id="" value="<?php echo $this->general->get_commission_var('gb_min_purchases');?>" name="gb_min_purchases" placeholder="Minimum Products / Packages Purchase" required>
							</div>
						  </div>
					  </div>
					  <div class="tab-pane fade" id="reverse-generation-bonus" role="tabpanel" aria-labelledby="reverse-generation-bonus-tab">
							<div class="form-group row">
								<label for="" class="col-sm-3 col-form-label">Reverse Generation Bonus Status</label>
								<div class="col-sm-9">
								<?php
									
									$reverse_generation_bonus_status = $this->general->get_commission_var('reverse_generation_bonus_status'); 
								?>
								  <select class="form-control required" name="reverse_generation_bonus_status">
										<?php
											foreach($stats as $s){
										?>
										<option value="<?php echo $s['value'];?>" <?php if($s['value'] == $reverse_generation_bonus_status){ echo 'selected'; } ?>>
											<?php echo $s['name'];?>
										</option>
										<?php		
											}
										?>
									</select>
								</div>
							  </div>
							  <div class="form-group row">
								<label for="" class="col-sm-3 col-form-label">Reverse Generation Bonus Amount</label>
								<div class="col-sm-9">
								<?php
									
									$reverse_generation_bonus_base = $this->general->get_commission_var('reverse_generation_bonus_base'); 
								?>
								  <select class="form-control required" name="reverse_generation_bonus_base">
										<?php
											foreach($bases as $b){
										?>
										<option value="<?php echo $b['value'];?>" <?php if($b['value'] == $reverse_generation_bonus_base){ echo 'selected'; } ?>>
											<?php echo $b['name'];?>
										</option>
										<?php		
											}
										?>
									</select>
								</div>
							  </div>
							  <div class="form-group row">
								<label for="" class="col-sm-3 col-form-label">Up to Level*</label>
								<div class="col-sm-9">
								  <input type="number" class="form-control" id="" value="<?php echo $this->general->get_commission_var('reverse_generation_bonus_levels');?>" name="reverse_generation_bonus_levels" placeholder="Up to Level" required>
								</div>
							  </div>
							  <div class="form-group row">
								<label for="" class="col-sm-3 col-form-label">Level Values* <small>Each Separated by comma (,)</small></label>
								<div class="col-sm-9">
								  <input type="text" class="form-control" id="" value="<?php echo implode(',',json_decode($this->general->get_commission_var('reverse_generation_bonus_values')));?>" name="reverse_generation_bonus_values" placeholder="Level Values (Each separated by comma)">
								</div>
							  </div>
							  <hr>
						  <h3>Elegibility</h3>
						  <hr>
						  <div class="form-group row">
							<label for="" class="col-sm-3 col-form-label">Minimum Direct Referrals*</label>
							<div class="col-sm-9">
							  <input type="number" class="form-control" id="" value="<?php echo $this->general->get_commission_var('rgb_min_direct_sponsors');?>" name="rgb_min_direct_sponsors" placeholder="Minimum Direct Referrals" required>
							</div>
						  </div>
						  <div class="form-group row">
							<label for="" class="col-sm-3 col-form-label">Minimum Binary Referrals*</label>
							<div class="col-sm-9">
							  <input type="number" class="form-control" id="" value="<?php echo $this->general->get_commission_var('rgb_min_binary_sponsors');?>" name="rgb_min_binary_sponsors" placeholder="Minimum Binary Referrals" required>
							</div>
						  </div>
						  <div class="form-group row">
							<label for="" class="col-sm-3 col-form-label">Minimum Direct Sponsor Bonus*</label>
							<div class="col-sm-9">
							  <input type="number" class="form-control" id="" value="<?php echo $this->general->get_commission_var('rgb_min_direct_sponsors_bonus');?>" name="rgb_min_direct_sponsors_bonus" placeholder="Minimum Direct Sponsor Bonus" required>
							</div>
						  </div>
						  <div class="form-group row">
							<label for="" class="col-sm-3 col-form-label">Minimum Network Binary Bonus*</label>
							<div class="col-sm-9">
							  <input type="number" class="form-control" id="" value="<?php echo $this->general->get_commission_var('rgb_min_nbb_bonus');?>" name="rgb_min_nbb_bonus" placeholder="Minimum Network Binary Bonus" required>
							</div>
						  </div>
						  <div class="form-group row">
							<label for="" class="col-sm-3 col-form-label">Minimum Products / Packages Purchase*</label>
							<div class="col-sm-9">
							  <input type="number" class="form-control" id="" value="<?php echo $this->general->get_commission_var('rgb_min_purchases');?>" name="rgb_min_purchases" placeholder="Minimum Products / Packages Purchase" required>
							</div>
						  </div>
					  </div>
					  <div class="tab-pane fade" id="roi" role="tabpanel" aria-labelledby="roi-tab">
							<div class="form-group row">
							<label for="" class="col-sm-3 col-form-label">Return on Investment (ROI) Status</label>
							<div class="col-sm-9">
							<?php
								
								$roi_status = $this->general->get_commission_var('roi_status'); 
							?>
							  <select class="form-control required" name="roi_status">
									<?php
										foreach($stats as $s){
									?>
									<option value="<?php echo $s['value'];?>" <?php if($s['value'] == $roi_status){ echo 'selected'; } ?>>
										<?php echo $s['name'];?>
									</option>
									<?php		
										}
									?>
								</select>
							</div>
						  </div>
						  
							  <div class="form-group row">
								<label for="" class="col-sm-3 col-form-label">ROI Percentage</small></label>
								<div class="col-sm-9">
								  <input type="text" class="form-control" id="" value="<?php echo $this->general->get_commission_var('roi_percentage');?>" name="roi_percentage" placeholder="ROI Percentage" required>
								</div>
							  </div>
							   <hr>
						  <h3>Elegibility</h3>
						  <hr>
						  <div class="form-group row">
							<label for="" class="col-sm-3 col-form-label">Minimum Direct Referrals*</label>
							<div class="col-sm-9">
							  <input type="number" class="form-control" id="" value="<?php echo $this->general->get_commission_var('roi_min_direct_sponsors');?>" name="roi_min_direct_sponsors" placeholder="Minimum Direct Referrals" required>
							</div>
						  </div>
						  <div class="form-group row">
							<label for="" class="col-sm-3 col-form-label">Minimum Binary Referrals*</label>
							<div class="col-sm-9">
							  <input type="number" class="form-control" id="" value="<?php echo $this->general->get_commission_var('roi_min_binary_sponsors');?>" name="roi_min_binary_sponsors" placeholder="Minimum Binary Referrals" required>
							</div>
						  </div>
						  <div class="form-group row">
							<label for="" class="col-sm-3 col-form-label">Minimum Direct Sponsor Bonus*</label>
							<div class="col-sm-9">
							  <input type="number" class="form-control" id="" value="<?php echo $this->general->get_commission_var('roi_min_direct_sponsors_bonus');?>" name="roi_min_direct_sponsors_bonus" placeholder="Minimum Direct Sponsor Bonus" required>
							</div>
						  </div>
						  <div class="form-group row">
							<label for="" class="col-sm-3 col-form-label">Minimum Network Binary Bonus*</label>
							<div class="col-sm-9">
							  <input type="number" class="form-control" id="" value="<?php echo $this->general->get_commission_var('roi_min_nbb_bonus');?>" name="roi_min_nbb_bonus" placeholder="Minimum Network Binary Bonus" required>
							</div>
						  </div>
						  <div class="form-group row">
							<label for="" class="col-sm-3 col-form-label">Minimum Products / Packages Purchase*</label>
							<div class="col-sm-9">
							  <input type="number" class="form-control" id="" value="<?php echo $this->general->get_commission_var('roi_min_purchases');?>" name="roi_min_purchases" placeholder="Minimum Products / Packages Purchase" required>
							</div>
						  </div>
					  </div>
					  
					  <div class="tab-pane fade" id="matching-roi" role="tabpanel" aria-labelledby="matching-roi-tab">
							<div class="form-group row">
							<label for="" class="col-sm-3 col-form-label">Matching ROI Status</label>
							<div class="col-sm-9">
							<?php
								
								$matching_roi_status = $this->general->get_commission_var('matching_roi_status'); 
							?>
							  <select class="form-control required" name="matching_roi_status">
									<?php
										foreach($stats as $s){
									?>
									<option value="<?php echo $s['value'];?>" <?php if($s['value'] == $matching_roi_status){ echo 'selected'; } ?>>
										<?php echo $s['name'];?>
									</option>
									<?php		
										}
									?>
								</select>
							</div>
						  </div>
						  <div class="form-group row">
								<label for="" class="col-sm-3 col-form-label">Up to Level*</label>
								<div class="col-sm-9">
								  <input type="number" class="form-control" id="" value="<?php echo $this->general->get_commission_var('matching_roi_levels');?>" name="matching_roi_levels" placeholder="Up to Level" required>
								</div>
							  </div>
							  <div class="form-group row">
								<label for="" class="col-sm-3 col-form-label">Level Values* <small>Each Separated by comma (,)</small></label>
								<div class="col-sm-9">
								  <input type="text" class="form-control" id="" value="<?php echo implode(',',json_decode($this->general->get_commission_var('matching_roi_values')));?>" name="matching_roi_values" placeholder="Level Values (Each separated by comma)">
								</div>
							  </div>
							   <hr>
						  <h3>Elegibility</h3>
						  <hr>
						  <div class="form-group row">
							<label for="" class="col-sm-3 col-form-label">Minimum Direct Referrals*</label>
							<div class="col-sm-9">
							  <input type="number" class="form-control" id="" value="<?php echo $this->general->get_commission_var('matching_roi_min_direct_sponsors');?>" name="matching_roi_min_direct_sponsors" placeholder="Minimum Direct Referrals" required>
							</div>
						  </div>
						  <div class="form-group row">
							<label for="" class="col-sm-3 col-form-label">Minimum Binary Referrals*</label>
							<div class="col-sm-9">
							  <input type="number" class="form-control" id="" value="<?php echo $this->general->get_commission_var('matching_roi_min_binary_sponsors');?>" name="matching_roi_min_binary_sponsors" placeholder="Minimum Binary Referrals" required>
							</div>
						  </div>
						  <div class="form-group row">
							<label for="" class="col-sm-3 col-form-label">Minimum Direct Sponsor Bonus*</label>
							<div class="col-sm-9">
							  <input type="number" class="form-control" id="" value="<?php echo $this->general->get_commission_var('matching_roi_min_direct_sponsors_bonus');?>" name="matching_roi_min_direct_sponsors_bonus" placeholder="Minimum Direct Sponsor Bonus" required>
							</div>
						  </div>
						  <div class="form-group row">
							<label for="" class="col-sm-3 col-form-label">Minimum Network Binary Bonus*</label>
							<div class="col-sm-9">
							  <input type="number" class="form-control" id="" value="<?php echo $this->general->get_commission_var('matching_roi_min_nbb_bonus');?>" name="matching_roi_min_nbb_bonus" placeholder="Minimum Network Binary Bonus" required>
							</div>
						  </div>
						  <div class="form-group row">
							<label for="" class="col-sm-3 col-form-label">Minimum Products / Packages Purchase*</label>
							<div class="col-sm-9">
							  <input type="number" class="form-control" id="" value="<?php echo $this->general->get_commission_var('matching_roi_min_purchases');?>" name="matching_roi_min_purchases" placeholder="Minimum Products / Packages Purchase" required>
							</div>
						  </div>
					  </div>
					</div>
				  </div>
				</div>
					
					  
					  
                     
                 
              </div><!-- /.card-body -->
				<div class="card-footer" style="text-align: right;">
                          <button type="submit" class="btn btn-primary">Update Commission Settings</button>
				</div>
				</form>
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
		<script>
		function levet_setting_box(){
			var nbb_level_unlimited = $('#nbb_level_unlimited option:selected').val();
			if (nbb_level_unlimited == '1'){
				$('#network_binary_bonus_levels').hide();
			} else {
				$('#network_binary_bonus_levels').show();
			}
		}
		</script>