<div class="row">
	<div class="col-md-12">
		<div class="card card-primary card-outline">
			<div class="card-header">
				<h3 class="card-title">Withdraw History</h3>
			</div>
			<div class="card-body">
			<!--------------------->
			<table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Tranx ID</th>
                    <th>Amount</th>
                    <th>Fee</th>
                    <th>Method</th>
                    <th>Requested</th>
                    <th>Status</th>
                  </tr>
                  </thead>
                  <tbody>
				  <?php if (count($data)>0){?>
				  <?php foreach ($data as $w){ ?>
                  <tr>
					<td><?php echo modal_anchor(get_uri("member/transaction/".$w['transection_id']), $w['transection_id'], array("class" => "view ico-circle", "title" => 'Transaction Details')); ?></td>
                    <td><?php echo currency($w['withdrawable']);?></td>
                    <td><?php echo currency($w['fees']);?></td>
                    <td><?php echo $w['method'];?><br>(<?php echo $w['details'];?>)</td>
                    <td><?php echo $w['req_date'];?></td>
                    <td>
						<?php if ($w['status'] == 0){?>
						<?php echo 'Pending';?>
						<?php } elseif ($w['status'] == 1) { ?>
						<?php echo 'Approved<br>'.$w['approve_date'];?>
						<?php } else { ?>
						<?php echo 'Rejected';?>
						<?php } ?>
					</td>
                  </tr>
                  <?php } ?>
                  <?php } ?>
                  
                  </tbody>
                  <tfoot>
                  <tr>
                    <th>Tranx ID</th>
                    <th>Amount</th>
                    <th>Fee</th>
                    <th>Method</th>
                    <th>Requested</th>
                    <th>Status</th>
                  </tr>
                  </tfoot>
                </table>
			<!--------------------->
			</div>
		</div>
	</div>
</div>
		