<div class="row">
          <div class="col-md-12 col-12">
            <div class="card">
            <div class="card-body" style="padding:7px;">
             <a class="btn btn-primary" href="<?php echo base_url('admin/settings/currency/list');?>"><i class="fa fa-list"></i> Currencies List</a>
              
            </div>
            </div>
            
          </div>
         
        </div>

<div class="row">
         
          <div class="col-md-12">
            <div class="card card-primary card-outline">
              <form class="form-horizontal" method="post" action="<?php echo base_url('admin/settings/currency-settings/update');?>">
              <div class="card-header">
				<h3 class="card-title">Currency Settings</h3>
			  </div>
              <div class="card-body">
					
						<?php echo form_hidden($this->security->get_csrf_token_name(), $this->security->get_csrf_hash()); ?>
                      <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">Currency Status</label>
                        <div class="col-sm-9">
						<?php
							$currency_stats = array(
								array(
									'name'=>'Enable',
									'value'=>'1',
								),array(
									'name'=>'Disable',
									'value'=>'0',
								),
							);
							$currency_status = $this->general->get_system_var('currency_status'); 
						?>
                          <select class="form-control required" name="currency_status">
								<?php
									foreach($currency_stats as $c_s){
								?>
								<option value="<?php echo $c_s['value'];?>" <?php if($c_s['value'] == $currency_status){ echo 'selected'; } ?>>
									<?php echo $c_s['name'];?>
								</option>
								<?php		
									}
								?>
							</select>
                        </div>
                      </div>
					  <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">Default Currency</label>
                        <div class="col-sm-9">
							<?php $def_currency = $this->general->get_system_var('def_currency');?>
                          <select class="form-control required" name="def_currency">
								<?php
								if (count($currencies)>0){
									foreach($currencies as $cur){
								?>
								<option value="<?php echo $cur['currency_settings_id'];?>" <?php if($cur['currency_settings_id'] == $def_currency){ echo 'selected'; } ?>>
									<?php echo $cur['name'];?>
								</option>
								<?php		
									}}
								?>
							</select>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">Currency Format</label>
                        <div class="col-sm-9">
							<?php
							$currency_formats = array('us' => 'US Format - 1,234,567.89',
											'german' => 'German Format - 1.234.567,89',
											'french' => 'French Format - 1 234 567,89'
							);
							$currency_format = $this->general->get_system_var('currency_format'); 
						?>
                          <select class="form-control required" name="currency_format">
								<?php
									foreach($currency_formats as $n => $row){
								?>
								<option value="<?php echo $n;?>" <?php if($n == $currency_format){ echo 'selected'; } ?>>
									<?php echo $row;?>
								</option>
								<?php		
									}
								?>
							</select>
                        </div>
                      </div>
					  <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">Symbol Format</label>
                        <div class="col-sm-9">
							<?php
							$symbol_formats = array('s_amount' => '{{ Symbol }} {{ Amount }}',
									'amount_s' => '{{ Amount }} {{ Symbol }}'
								);
							$symbol_format = $this->general->get_system_var('symbol_format'); 
						?>
                          <select class="form-control required" name="symbol_format">
								<?php
									foreach($symbol_formats as $n => $row){
								?>
								<option value="<?php echo $n;?>" <?php if($n == $symbol_format){ echo 'selected'; } ?>>
									<?php echo $row;?>
								</option>
								<?php		
									}
								?>
							</select>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">No of Decimals</label>
                        <div class="col-sm-9">
                          <?php
							$formats = array('0' => '12345',
														'1' => '1234.5',
														'2' => '123.45',
														'3' => '12.345'
									);
							$no_of_decimal = $this->general->get_system_var('no_of_decimals'); 
						?>
						<select class="form-control required" name="no_of_decimals">
								<?php
									foreach($formats as $n => $row){
								?>
								<option value="<?php echo $n;?>" <?php if($n == $no_of_decimal){ echo 'selected'; } ?>>
									<?php echo $row;?>
								</option>
								<?php		
									}
								?>
							</select>
                        </div>
                      </div>
					  
                      
                    
                 
              </div><!-- /.card-body -->
				<div class="card-footer" style="text-align: right;">
                          <button type="submit" class="btn btn-primary">Update Settings</button>
				</div>
				</form>
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
		