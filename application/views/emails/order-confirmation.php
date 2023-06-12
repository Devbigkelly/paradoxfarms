
<body>

            <table class="body-wrap" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; background-color: #eaf0f7; margin: 0;" bgcolor="#eaf0f7">
                <tr>
                    <td class="container" width="100%" style="margin:0 auto;  clear: both !important;" valign="top">
                        <div class="content" style="padding: 50px 0;">
                            <table class="main" width="100%" cellpadding="0" cellspacing="0" style="border: 1px solid #e9e9e9;" bgcolor="#fff">
                                <tr>
                                    <td class="alert alert-primary border-0 bg-primary" style="background-color: #5867dd;padding: 20px; border-radius: 0;" align="center" valign="top"><img src="<?php echo base_url($logo_img);?>" alt="image" style="margin-left: auto; margin-right: auto; display:block;height: 60px;"></td>
                                </tr>
								
                                <tr>
                                    <td class="alert alert-dark border-0" style="color:#ffffff; background-color: #949494; padding: 20px; border-radius: 0;" align="center" valign="top"><?php echo $subject;?></td>
                                </tr>
								<tr>
                                    <td class="alert alert-dark border-0" style="color:#525252; background-color: #d4d5d8; padding: 20px; border-radius: 0;" valign="top"><?php echo $message;?></td>
                                </tr>
                                <tr>
                                    <td class="content-wrap" style="padding: 20px;" valign="top">
                                        <?php if (count($data)>0){?>
										<table  cellspacing="0" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; font-size: 14px; padding: 10px 10px 20px;white-space: pre;">
                                          <!-------------------------------------->
										 <?php 
											$p_t = 0;	
											$m_t = 0;
											foreach ($data as $cart){ ?>
													<tr class="tbl-title" style="border: 1px solid #e9e9e9;">
														<td colspan="3"><strong><?php echo $cart['name'];?></strong></td>
														
													</tr>
													
													<?php if (count($cart['options']['modules'])>0){
													 foreach($cart['options']['modules'] as $module){
													?>
													<tr>
														<td style="border: 1px solid #e9e9e9;">
															<img style="width:45px; height:45px;" src="<?php echo base_url('uploads/front/'.$module['thumb']);?>">
														</td>
														<td style="border: 1px solid #e9e9e9;">
															<strong> <?php echo $module['title'];?></strong>
														</td>
														<?php if ($cart['options']['subscription'] == 'Monthly'){
														if ($module['monthly_discount_fee'] > 0){
															$m_p = $module['monthly_discount_fee'];
															$m_t = $m_t + $module['monthly_discount_fee'];
														} else {
															$m_p = $module['monthly_fee'];
															$m_t = $m_t + $module['monthly_fee'];
														}
														
														?>
														<td style="border: 1px solid #e9e9e9;"><strong><?php echo $currency;?><?php echo $m_p;?></strong><?php echo ' '.$currency_name;?></td>
														<?php } else {
														if ($module['annual_discount_fee'] > 0){
															$m_p = $module['annual_discount_fee'];
															$m_t = $m_t + $module['annual_discount_fee'];
														} else {
															$m_p = $module['annual_fee'];
															$m_t = $m_t + $module['annual_fee'];
														}
														
														?>
														<td style="border: 1px solid #e9e9e9;"><strong><?php echo $currency;?><?php echo $module['annual_fee'];?></strong><?php echo ' '.$currency_name;?></td>
														<?php } ?>
														
													</tr>
													<?php } ?>
													<?php } ?>
													
													<?php } 
													$s_total = $m_t;
													if ($cart['options']['subscription'] == 'Monthly'){
														$u_total = $upm * $cart['qty'];
													} else {
														$u_total = $upa * $cart['qty'];
													}
													$total = $s_total + $u_total;
													?>
													<tr class="tbl-title">
														<td> </td>
														<td style="border: 1px solid #e9e9e9;"> Subscription </td>
														<td style="border: 1px solid #e9e9e9;"><strong><?php echo $cart['options']['subscription'];?></strong></td>
													</tr>
													<tr>
														<td> </td>
														<td style="border: 1px solid #e9e9e9;"> Subtotal </td>
														<td style="border: 1px solid #e9e9e9;"><strong><?php echo $currency.$s_total;?></strong><?php echo ' '.$currency_name;?></td>
														
													</tr>
													<tr>
														<td> </td>
														<td style="border: 1px solid #e9e9e9;"><strong><?php echo $cart['qty'];?> x </strong> Users</td>
														<td style="border: 1px solid #e9e9e9;"><strong><?php echo $currency.$u_total;?></strong><?php echo ' '.$currency_name;?></td>
													</tr>
													
													<tr>
														<td> </td>
														<td style="border: 1px solid #e9e9e9;"> Total </td>
														<td style="border: 1px solid #e9e9e9;"><strong><?php echo $currency.$total;?></strong><?php echo ' '.$currency_name;?></td>
													</tr>
                                         <!-------------------------------------->
                                        </table>
										<?php } ?>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </td>
                    <td style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0;" valign="top"></td>
                </tr>
            </table>
            

</body>
