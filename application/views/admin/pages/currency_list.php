<div class="row">
         
          <div class="col-md-12">
            <div class="card card-primary card-outline">
              <div class="card-header">
				<h3 class="card-title">Currencies</h3>
			  </div>
			  <div class="card-body">
					
					<table class="table table-striped table-bordered table-list" style="margin-bottom:0px !important">
							<thead>
                                <tr>
                                    <th><center>Currency Name</center></th>
                                    <th><center>Currency Symbol</center></th>
                                    <th><center> 1 U.S Dollar ($) =  </center></th>
                                    <?php
										$currency_id = $this->general->get_system_var('def_currency');
                                    	$system_def_curr_name = $this->db->get_where('currency_settings',array('currency_settings_id'=>$currency_id))->row()->name;
										$system_def_curr_symbol = $this->db->get_where('currency_settings',array('currency_settings_id'=>$currency_id))->row()->symbol;
										$system_def_curr_code = $this->db->get_where('currency_settings',array('currency_settings_id'=>$currency_id))->row()->code;
									?>
                                    <!--<th><center>1 <?php echo $system_def_curr_name; ?> (<?php echo $system_def_curr_symbol; ?>) =  ) </center></th>--->
                                    <th><center>Status</center></th>
                                    <th><center>Options</center></th>
                                </tr> 
                              </thead>
							  <tbody>
                                  <?php
								  //print_r($currencies);
                                     foreach($currencies as $row){
                                  ?>
										
                                      <tr>
                                      <?php
                                            echo form_open(base_url('admin/settings/currency/update'), 
                                            array(
                                                'class' => 'form-horizontal',
                                                'method' => 'post',
                                                'id' => 'test_'.$row['currency_settings_id'],
                                                'enctype' => 'multipart/form-data'
                                            ));
                                       ?>
                                        <td align="center">
										<input type="hidden" name="currency_settings_id" value="<?php echo $row['currency_settings_id']?>">
                                            <?php 
                                                if($row['currency_settings_id'] == '1'){
                                                	echo $row['name'];
                                                } else {
											?>		
												<input type="text" name="name" value="<?php echo $row['name']?>"  class="form-control required">
                                            <?php
												}
                                                if($row['currency_settings_id'] == $currency_id){
                                            ?>
                                                (Default)
                                            <?php
												}
                                            ?>
                                        </td>
                                        <td align="center">                                        
                                            <?php                        	
                                                if($row['currency_settings_id'] == '1'){
													echo $row['symbol'];
												} else {
											?>	
												<input type="text" name="symbol" value="<?php echo $row['symbol']?>"  class="form-control required">
                                            <?php
												}
											?>
                                        </td>
                                        <td>
                                            <?php                                             	
                                                if($row['currency_settings_id'] !== '1'){
                                            ?>
                                            <div class="col-sm-12">
                                                <div class="col-sm-5 col-sm-offset-2">
                                                    <input type="number" name="exchange_rate" value="<?php echo $row['exchange_rate']?>"  class="form-control required valto">
                                                </div>
                                                <div class="col-sm-3" style="padding-left: 0px !important;padding-right: 0px !important">
                                                    
												
                                            </div>	
                                            <?php 
												}
											?>			
                                        </td>
                                       
                                        <td align="center">
                                            <?php if($row['currency_settings_id'] !== '1'){ ?>
                                            <input class="form-control" type="checkbox" name="status" value="ok" <?php if ($row['status'] == 'ok'){echo 'checked="checked"';};?>>
                                            <?php } ?>	
                                        </td>
                                        <td align="center">
											<?php if($row['currency_settings_id'] !== '1'){ ?>
                                            <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i> Save</button>
											<?php } ?>	
                                        </td>
                                        </form>
									  <?php 
                                          }
                                      ?>
                              	</tr>
                              </tbody>
						</table>
                 
              </div><!-- /.card-body -->
				<div class="card-footer">
					<div class="offset-sm-10 col-sm-2">
                          <button type="submit" class="btn btn-primary">Update Password</button>
                        </div>
				</div>
				
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>