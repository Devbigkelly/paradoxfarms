<div class="row">
	<div class="col-md-12">
		<div class="card card-primary card-outline">
			<div class="card-header">
				<h3 class="card-title">Admin Transactions</h3>
			</div>
			<div class="card-body">
			<!--------------------->
			<table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Tranx ID</th>
                    <th>Type</th>
                    <th>To</th>
                    <th>Amount</th>
                    <th>Dated</th>
                  </tr>
                  </thead>
                  <tbody>
				  <?php if (count($data)>0){?>
				  <?php foreach ($data as $t){ ?>
                  <tr>
                    <td><?php echo modal_anchor(get_uri("admin/transaction/".$t['tranx_id']), $t['tranx_id'], array("class" => "view ico-circle", "title" => 'Transaction Details')); ?></td>
                    <td><?php echo $t['transfer_type'];?></td>
                    <td><?php echo $t['transfer_to'];?></td>
                    <td><?php echo currency($t['amount']);?></td>
                    <td><?php echo $t['dated'];?></td>
                  </tr>
                  <?php } ?>
                  <?php } ?>
                  
                  </tbody>
                  <tfoot>
                  <tr>
                    <th>Tranx ID</th>
                    <th>Type</th>
                    <th>To</th>
                    <th>Amount</th>
                    <th>Dated</th>
                  </tr>
                  </tfoot>
                </table>
			<!--------------------->
			</div>
		</div>
	</div>
</div>
		