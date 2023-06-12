<div class="row">
	<div class="col-md-12">
		<div class="card card-primary card-outline">
			<div class="card-header">
				<h3 class="card-title"><?php echo $page_title;?></h3>
			</div>
			<div class="card-body">
			<!--------------------->
			<table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Tranx ID</th>
                    <th>Message</th>
                    <th>Type</th>
                    <th>Amount</th>
                    <th>Total</th>
                    <th>Dated</th>
                  </tr>
                  </thead>
                  <tbody>
				  <?php if (count($data)>0){?>
				  <?php foreach ($data as $d){ ?>
                  <tr>
                    
                    <td><?php echo modal_anchor(get_uri("member/transaction/".$d['tranx_id']), $d['tranx_id'], array("class" => "view ico-circle", "title" => 'Transaction Details')); ?></td>
					<td><?php echo $d['message'];?></td>
					<td><?php echo $d['type'];?></td>
					<td><?php echo currency($d['amount']);?></td>
					<td><?php echo currency($d['total']);?></td>
					<td><?php echo $d['dated'];?></td>
                  </tr>
                  <?php } ?>
                  <?php } ?>
                  
                  </tbody>
                  <tfoot>
                  <tr>
                    <th>Tranx ID</th>
                    <th>Message</th>
                    <th>Type</th>
                    <th>Amount</th>
                    <th>Total</th>
                    <th>Dated</th>
                  </tr>
                  </tfoot>
                </table>
			<!--------------------->
			</div>
		</div>
	</div>
</div>
		