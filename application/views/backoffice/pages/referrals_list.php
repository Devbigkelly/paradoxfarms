<div class="row">
	<div class="col-md-12">
		<div class="card card-primary card-outline">
			<div class="card-header">
				<h3 class="card-title">Referrals List (<?php echo $username;?>)</h3>
			</div>
			<div class="card-body">
			<!--------------------->
			<table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Name</th>
                    <th>Username</th>
                    <th>Join Date</th>
                    <th>Status</th>
                  </tr>
                  </thead>
                  <tbody>
				  <?php if (count($data)>0){?>
				  <?php foreach ($data as $u){
				  $userdata = $this->general->get_tbl_field('users', '*', 'username', $u['username']);
				  if (count($userdata)> 0){
				  ?>
                  <tr>
                    <td><?php echo $userdata[0]['name'];?></td>
                    <td><?php echo $userdata[0]['username'];?></td>
                    <td><?php echo $userdata[0]['created'];?></td>
                    <td>
					<?php if ($this->commissions->product_purchased($userdata[0]['username']) == true){
						echo 'Active';
					} else {
						echo 'Inactive';
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
                    <th>Username</th>
                    <th>Join Date</th>
                    <th>Status</th>
                  </tr>
                  </tfoot>
                </table>
			<!--------------------->
			</div>
		</div>
	</div>
</div>
		