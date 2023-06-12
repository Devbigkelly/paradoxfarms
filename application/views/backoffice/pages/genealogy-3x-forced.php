<div class="row">
         
          <div class="col-md-12">
            <div class="card card-primary card-outline">
              
              <div class="card-header">
				<h3 class="card-title"><?php echo $page_title;?></h3>
			  </div>
			  <div class="card-body">
					<!-------------------------------->
					<?php $top_parent_data = $this->user_account->get_user_data($username); ?>
					<div class="tree" style="width:100%">
						
						<div class="row">
							<div class="col-md-5 c_m_5 p_widg">
								
							</div>
							<div class="col-md-2 c_m_2 text-center">
								​<a href="#" title="<?php echo $username;//$top_parent_data[0]['name'];?>">
									<img class="img-circle <?php echo $this->matrix3x->gen_color($username);?>" width="60%" src="<?php echo $this->user_account->get_pic($username, 'small');?>"><br>
								</a>
								
							</div>
							<div class="col-md-5 c_m_5 p_widg">
								
							</div>
						</div>
						
						<?php 
						$row1 = $this->matrix3x->get_binary_childs($username, $table);
						if(count($row1)>0){?>
						<div class="row child_ref" style="position:relative;">
							<div class="genealogy-border"><div class="g-up"></div><div class="g-down-3x"><div class="g-center"></div></div></div>
							<?php foreach ($row1 as $r1){?>
								<div class="col-md-4 box-border text-center">
									<img class="img-circle <?php echo $this->matrix3x->gen_color($r1['username']);?>" title="<?php echo $r1['username'];?>" width="25%" src="<?php echo $this->user_account->get_pic($r1['username'], 'small');?>">
									<?php 
									$row2 = $this->matrix3x->get_binary_childs($r1['username'], $table);
									if(count($row2)>0){?>
									<div class="row child_ref" style="position:relative;">
										<div class="genealogy-border"><div class="g-up"></div><div class="g-down-3x"><div class="g-center"></div></div></div>
										<?php foreach ($row2 as $r2){?>
											<div class="col-md-4 box-border text-center">
												<img class="img-circle <?php echo $this->matrix3x->gen_color($r2['username']);?>" title="<?php echo $r2['username'];?>" width="50%" src="<?php echo $this->user_account->get_pic($r2['username'], 'small');?>">
												<!---------3RD LEVEL--------->
												<?php 
												$row3 = $this->matrix3x->get_binary_childs($r2['username'], $table);
												if(count($row3)>0){?>
												<!---<div class="row child_ref" style="position:relative;">
													<div class="genealogy-border"><div class="g-up"></div><div class="g-down-3x"><div class="g-center"></div></div></div>
													<?php foreach ($row3 as $r3){?>
														<div class="col-md-4 box-border text-center" style="padding:0px">
															<img class="img-circle <?php echo $this->matrix3x->gen_color($r3['username']);?>" title="<?php echo $r3['username'];?>" width="50%" src="<?php echo $this->user_account->get_pic($r3['username'], 'small');?>">
														</div>
													<?php } ?>
												</div>--->
												<?php } ?>
												<!---------3RD LEVEL--------->
											</div>
										<?php } ?>
									</div>
									<?php } ?>
								</div>
							<?php } ?>
						</div>
						<?php } ?>
					</div>
              </div>
			
            </div>
          </div>
        </div>


