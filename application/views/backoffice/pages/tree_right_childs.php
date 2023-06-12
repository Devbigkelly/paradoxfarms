<div class="row">
	<div class="col-md-12">
		<div class="card card-primary card-outline">
			<div class="card-header">
				<h3 class="card-title"><?php echo $page_title?></h3>
			</div>
			<div class="card-body">
			<!--------------------->
			<table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Name</th>
                    <th>Contact</th>
                    <th>Sponsor</th>
                    <th>Binary Referral</th>
                    <th>Join Date</th>
                    <th>Package</th>
                  </tr>
                  </thead>
                  <tbody>
				  <?php if (count($data)>0){?>
				  <?php foreach ($data as $u){ 
				  $userinfo =  $this->user_account->user_info($u['username']);
				  if (count($userinfo)>0){
				  ?>
                  <tr>
                    <td><?php echo $userinfo[0]['name'];?><br>(<?php echo $u['username'];?>)</td>
                    <td><?php echo $userinfo[0]['email'];?><br><?php echo $userinfo[0]['mobile'];?></td>
                    <td><?php echo $userinfo[0]['direct_referral'];?></td>
                    <td><?php echo $userinfo[0]['binary_referral'];?></td>
                    <td><?php echo $userinfo[0]['created'];?></td>
                    <td>
					<?php if ($this->commissions->product_purchased($u['username']) == true){
						echo 'Purchased';
					} else {
						echo 'Not Purchased';
					}?>
					</td>
                    
                  </tr>
                  <?php } ?>
                  <?php } ?>
                  <?php } ?>
                  
                  </tbody>
                  <tfoot>
                  <tr>
                    <th>Name</th>
                    <th>Contact</th>
                    <th>Sponsor</th>
                    <th>Binary Referral</th>
                    <th>Join Date</th>
                    <th>Package</th>
                  </tr>
                  </tfoot>
                </table>
			<!--------------------->
			</div>
		</div>
	</div>
</div>
		