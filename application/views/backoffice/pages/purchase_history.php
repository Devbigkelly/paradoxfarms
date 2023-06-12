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
                    <th>Product</th>
                    <th>Price</th>
                    <th>Sponsor Bonus</th>
                    <th>Network Binary Bonus</th>
                    <th>ROI</th>
                    <th>Method</th>
                    <th>Dated</th>
                  </tr>
                  </thead>
                  <tbody>
				  <?php if (count($data)>0){?>
				  <?php foreach ($data as $p){ ?>
                  <tr>
                    
                    <td><?php echo modal_anchor(get_uri("member/transaction/".$p['tranx_id']), $p['tranx_id'], array("class" => "view ico-circle", "title" => 'Transaction Details')); ?></td>
                    <td><?php echo $this->commissions->product_name($p['product_id']);?></td>
					<td><?php echo currency($p['selling_price']);?></td>
					<td><?php echo currency($p['psb']);?></td>
					<td><?php echo currency($p['nbb']);?></td>
					<td><?php echo currency($p['roi']);?></td>
					<td><?php echo $p['payment_method'];?></td>
					<td><?php echo $p['dated'];?></td>
                  </tr>
                  <?php } ?>
                  <?php } ?>
                  
                  </tbody>
                  <tfoot>
                  <tr>
                    <th>Tranx ID</th>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Sponsor Bonus</th>
                    <th>Network Binary Bonus</th>
                    <th>ROI</th>
                    <th>Method</th>
                    <th>Dated</th>
                  </tr>
                  </tfoot>
                </table>
			<!--------------------->
			</div>
		</div>
	</div>
</div>
		