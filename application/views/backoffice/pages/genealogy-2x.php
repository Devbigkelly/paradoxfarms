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
									<img class="img-circle <?php echo $this->matrix2x->gen_color($username);?>" width="60%" src="<?php echo $this->user_account->get_pic($username, 'small');?>"><br>
								</a>
								
							</div>
							<div class="col-md-5 c_m_5 p_widg">
								
							</div>
						</div>
						
						<?php $row1 = $this->matrix2x->get_binary_childs_forced($username, $table);?>
						<div class="row child_ref" style="position:relative;">
							<div class="genealogy-border"><div class="g-up"></div><div class="g-down"></div></div>
							
								<div class="col-md-6 box-border text-center">
									<?php if (!empty($row1['left']['username'])){?>
									<a href="<?php echo base_url('member/genealogy/'.$row1['left']['username']);?>"><img class="img-circle <?php echo $this->matrix2x->gen_color($row1['left']['username']);?>" title="<?php echo $row1['left']['username'];?>" width="18%" src="<?php echo $this->user_account->get_pic($row1['left']['username'], 'small');?>"></a>
										<?php $row2_l = $this->matrix2x->get_binary_childs_forced($row1['left']['username'], $table);?>
										<div class="row child_ref" style="position:relative;">
											<div class="genealogy-border"><div class="g-up"></div><div class="g-down"></div></div>
											<div class="col-md-6 box-border text-center">
												<?php if (!empty($row2_l['left']['username'])){?>
												<a href="<?php echo base_url('member/genealogy/'.$row2_l['left']['username']);?>"><img class="img-circle <?php echo $this->matrix2x->gen_color($row2_l['left']['username']);?>" title="<?php echo $row2_l['left']['username'];?>" width="35%" src="<?php echo $this->user_account->get_pic($row2_l['left']['username'], 'small');?>"></a>
													<?php $row3_l_l = $this->matrix2x->get_binary_childs_forced($row2_l['left']['username'], $table);?>
													<div class="row child_ref" style="position:relative;">
														<div class="genealogy-border"><div class="g-up"></div><div class="g-down"></div></div>
														<div class="col-md-6 box-border text-center">
															<?php if (!empty($row3_l_l['left']['username'])){?>
															<a href="<?php echo base_url('member/genealogy/'.$row3_l_l['left']['username']);?>"><img class="img-circle <?php echo $this->matrix2x->gen_color($row3_l_l['left']['username']);?>" title="<?php echo $row3_l_l['left']['username'];?>" width="50%" src="<?php echo $this->user_account->get_pic($row3_l_l['left']['username'], 'small');?>"></a>
															<?php } else { ?>
															<?php echo modal_anchor(get_uri("member/add-referral/".$row2_l['left']['username']."/left"), '<img width="50%" class="img-circle '.$this->matrix2x->gen_color($row3_l_l['left']['username']).'" src="'.$this->user_account->get_pic_blank('small').'">', array("class" => "view ico-circle", "title" => 'Add New Referral')); ?>
															
															<?php } ?>
														</div>
														
														<div class="col-md-6 box-border text-center">
															<?php if (!empty($row3_l_l['right']['username'])){?>
															<a href="<?php echo base_url('member/genealogy/'.$row3_l_l['right']['username']);?>"><img class="img-circle <?php echo $this->matrix2x->gen_color($row3_l_l['right']['username']);?>" title="<?php echo $row3_l_l['right']['username'];?>" width="50%" src="<?php echo $this->user_account->get_pic($row3_l_l['right']['username'], 'small');?>"></a>
															<?php } else { ?>
															<?php echo modal_anchor(get_uri("member/add-referral/".$row2_l['left']['username']."/right"), '<img width="50%" class="img-circle '.$this->matrix2x->gen_color($row3_l_l['right']['username']).'" src="'.$this->user_account->get_pic_blank('small').'">', array("class" => "view ico-circle", "title" => 'Add New Referral')); ?>
															
															<?php } ?>
														</div>
													</div>
												
												<?php } else { ?>
												
												<?php echo modal_anchor(get_uri("member/add-referral/".$row1['left']['username']."/left"), '<img width="35%" class="img-circle '.$this->matrix2x->gen_color($row2_l['left']['username']).'" src="'.$this->user_account->get_pic_blank('small').'">', array("class" => "view ico-circle", "title" => 'Add New Referral')); ?>
												<?php } ?>
											</div>
											
											<div class="col-md-6 box-border text-center">
												<?php if (!empty($row2_l['right']['username'])){?>
												<a href="<?php echo base_url('member/genealogy/'.$row2_l['right']['username']);?>"><img class="img-circle <?php echo $this->matrix2x->gen_color($row2_l['right']['username']);?>" title="<?php echo $row2_l['right']['username'];?>" width="35%" src="<?php echo $this->user_account->get_pic($row2_l['right']['username'], 'small');?>"></a>
													<?php $row3_l_r = $this->matrix2x->get_binary_childs_forced($row2_l['right']['username'], $table);?>
													<div class="row child_ref" style="position:relative;">
														<div class="genealogy-border"><div class="g-up"></div><div class="g-down"></div></div>
														<div class="col-md-6 box-border text-center">
															<?php if (!empty($row3_l_r['left']['username'])){?>
															<a href="<?php echo base_url('member/genealogy/'.$row3_l_r['left']['username']);?>"><img class="img-circle <?php echo $this->matrix2x->gen_color($row3_l_r['left']['username']);?>" title="<?php echo $row3_l_r['left']['username'];?>" width="50%" src="<?php echo $this->user_account->get_pic($row3_l_r['left']['username'], 'small');?>"></a>
															<?php } else { ?>
															<?php echo modal_anchor(get_uri("member/add-referral/".$row2_l['right']['username']."/left"), '<img width="50%" class="img-circle '.$this->matrix2x->gen_color($row3_l_r['left']['username']).'" src="'.$this->user_account->get_pic_blank('small').'">', array("class" => "view ico-circle", "title" => 'Add New Referral')); ?>
															
															<?php } ?>
														</div>
														<div class="col-md-6 box-border text-center">
															<?php if (!empty($row3_l_r['right']['username'])){?>
															<a href="<?php echo base_url('member/genealogy/'.$row3_l_r['right']['username']);?>"><img class="img-circle <?php echo $this->matrix2x->gen_color($row3_l_r['right']['username']);?>" title="<?php echo $row3_l_r['right']['username'];?>" width="50%" src="<?php echo $this->user_account->get_pic($row3_l_r['right']['username'], 'small');?>"></a>
															<?php } else { ?>
															<?php echo modal_anchor(get_uri("member/add-referral/".$row2_l['right']['username']."/right"), '<img width="50%" class="img-circle '.$this->matrix2x->gen_color($row3_l_r['right']['username']).'" src="'.$this->user_account->get_pic_blank('small').'">', array("class" => "view ico-circle", "title" => 'Add New Referral')); ?>
															
															<?php } ?>
														</div>
													</div>
												<?php } else { ?>
												<?php echo modal_anchor(get_uri("member/add-referral/".$row1['left']['username']."/right"), '<img width="35%" class="img-circle '.$this->matrix2x->gen_color($row2_l['right']['username']).'" src="'.$this->user_account->get_pic_blank('small').'">', array("class" => "view ico-circle", "title" => 'Add New Referral')); ?>
												
												<?php } ?>
											</div>
										</div>
									<?php } else { ?>
									<?php echo modal_anchor(get_uri("member/add-referral/".$username."/left"), '<img width="18%" class="img-circle '.$this->matrix2x->gen_color($row1['left']['username']).'" src="'.$this->user_account->get_pic_blank('small').'">', array("class" => "view ico-circle", "title" => 'Add New Referral')); ?>
									
									<?php } ?>
								</div>
								
								<div class="col-md-6 box-border text-center">
									<?php if (!empty($row1['right']['username'])){?>
									<a href="<?php echo base_url('member/genealogy/'.$row1['right']['username']);?>"><img class="img-circle <?php echo $this->matrix2x->gen_color($row1['right']['username']);?>" title="<?php echo $row1['right']['username'];?>" width="18%" src="<?php echo $this->user_account->get_pic($row1['right']['username'], 'small');?>"></a>
										<?php $row2_r = $this->matrix2x->get_binary_childs_forced($row1['right']['username'], $table);?>
										<div class="row child_ref" style="position:relative;">
											<div class="genealogy-border"><div class="g-up"></div><div class="g-down"></div></div>
											<div class="col-md-6 box-border text-center">
												<?php if (!empty($row2_r['left']['username'])){?>
												<a href="<?php echo base_url('member/genealogy/'.$row2_r['left']['username']);?>"><img class="img-circle <?php echo $this->matrix2x->gen_color($row2_r['left']['username']);?>" title="<?php echo $row2_r['left']['username'];?>" width="35%" src="<?php echo $this->user_account->get_pic($row2_r['left']['username'], 'small');?>"></a>
													<?php $row3_r_l = $this->matrix2x->get_binary_childs_forced($row2_r['left']['username'], $table);?>
													<div class="row child_ref" style="position:relative;">
														<div class="genealogy-border"><div class="g-up"></div><div class="g-down"></div></div>
														<div class="col-md-6 box-border text-center">
															<?php if (!empty($row3_r_l['left']['username'])){?>
															<a href="<?php echo base_url('member/genealogy/'.$row3_r_l['left']['username']);?>"><img class="img-circle <?php echo $this->matrix2x->gen_color($row3_r_l['left']['username']);?>" title="<?php echo $row3_r_l['left']['username'];?>" width="50%" src="<?php echo $this->user_account->get_pic($row3_r_l['left']['username'], 'small');?>"></a>
															<?php } else { ?>
															<?php echo modal_anchor(get_uri("member/add-referral/".$row2_r['left']['username']."/left"), '<img width="50%" class="img-circle '.$this->matrix2x->gen_color($row3_r_l['left']['username']).'" src="'.$this->user_account->get_pic_blank('small').'">', array("class" => "view ico-circle", "title" => 'Add New Referral')); ?>
															
															<?php } ?>
														</div>
														
														<div class="col-md-6 box-border text-center">
															<?php if (!empty($row3_r_l['right']['username'])){?>
															<a href="<?php echo base_url('member/genealogy/'.$row3_r_l['right']['username']);?>"><img class="img-circle <?php echo $this->matrix2x->gen_color($row3_r_l['right']['username']);?>" title="<?php echo $row3_r_l['right']['username'];?>" width="50%" src="<?php echo $this->user_account->get_pic($row3_r_l['right']['username'], 'small');?>"></a>
															<?php } else { ?>
															<?php echo modal_anchor(get_uri("member/add-referral/".$row2_r['left']['username']."/right"), '<img width="50%" class="img-circle '.$this->matrix2x->gen_color($row3_r_l['right']['username']).'" src="'.$this->user_account->get_pic_blank('small').'">', array("class" => "view ico-circle", "title" => 'Add New Referral')); ?>
															
															<?php } ?>
														</div>
													</div>
												<?php } else { ?>
												<?php echo modal_anchor(get_uri("member/add-referral/".$row1['right']['username']."/left"), '<img width="35%" class="img-circle '.$this->matrix2x->gen_color($row2_r['left']['username']).'" src="'.$this->user_account->get_pic_blank('small').'">', array("class" => "view ico-circle", "title" => 'Add New Referral')); ?>
												
												<?php } ?>
											</div>
											
											<div class="col-md-6 box-border text-center">
												<?php if (!empty($row2_r['right']['username'])){?>
												<a href="<?php echo base_url('member/genealogy/'.$row2_r['right']['username']);?>"><img class="img-circle <?php echo $this->matrix2x->gen_color($row2_r['right']['username']);?>" title="<?php echo $row2_r['right']['username'];?>" width="35%" src="<?php echo $this->user_account->get_pic($row2_r['right']['username'], 'small');?>"></a>
													<?php $row3_r_r = $this->matrix2x->get_binary_childs_forced($row2_r['right']['username'], $table);?>
													<div class="row child_ref" style="position:relative;">
														<div class="genealogy-border"><div class="g-up"></div><div class="g-down"></div></div>
														<div class="col-md-6 box-border text-center">
															<?php if (!empty($row3_r_r['left']['username'])){?>
															<a href="<?php echo base_url('member/genealogy/'.$row3_r_r['left']['username']);?>"><img class="img-circle <?php echo $this->matrix2x->gen_color($row3_r_r['left']['username']);?>" title="<?php echo $row3_r_r['left']['username'];?>" width="50%" src="<?php echo $this->user_account->get_pic($row3_r_r['left']['username'], 'small');?>"></a>
															<?php } else { ?>
															<?php echo modal_anchor(get_uri("member/add-referral/".$row2_r['right']['username']."/left"), '<img width="50%" class="img-circle '.$this->matrix2x->gen_color($row3_r_r['left']['username']).'" src="'.$this->user_account->get_pic_blank('small').'">', array("class" => "view ico-circle", "title" => 'Add New Referral')); ?>
															
															<?php } ?>
														</div>
														
														<div class="col-md-6 box-border text-center">
															<?php if (!empty($row3_r_r['right']['username'])){?>
															<a href="<?php echo base_url('member/genealogy/'.$row3_r_r['right']['username']);?>"><img class="img-circle <?php echo $this->matrix2x->gen_color($row3_r_r['right']['username']);?>" title="<?php echo $row3_r_r['right']['username'];?>" width="50%" src="<?php echo $this->user_account->get_pic($row3_r_r['right']['username'], 'small');?>"></a>
															<?php } else { ?>
															<?php echo modal_anchor(get_uri("member/add-referral/".$row2_r['right']['username']."/right"), '<img width="50%" class="img-circle '.$this->matrix2x->gen_color($row3_r_r['right']['username']).'" src="'.$this->user_account->get_pic_blank('small').'">', array("class" => "view ico-circle", "title" => 'Add New Referral')); ?>
															
															<?php } ?>
														</div>
													</div>
												<?php } else { ?>
												<?php echo modal_anchor(get_uri("member/add-referral/".$row1['right']['username']."/right"), '<img width="35%" class="img-circle '.$this->matrix2x->gen_color($row2_r['right']['username']).'" src="'.$this->user_account->get_pic_blank('small').'">', array("class" => "view ico-circle", "title" => 'Add New Referral')); ?>
												
												<?php } ?>
											</div>
										</div>
									<?php } else { ?>
									<?php echo modal_anchor(get_uri("member/add-referral/".$username."/right"), '<img width="18%" class="img-circle '.$this->matrix2x->gen_color($row1['right']['username']).'" src="'.$this->user_account->get_pic_blank('small').'">', array("class" => "view ico-circle", "title" => 'Add New Referral')); ?>
									
									<?php } ?>
								</div>
								
							
						</div>
						
					</div>
              </div>
			
            </div>
          </div>
        </div>


