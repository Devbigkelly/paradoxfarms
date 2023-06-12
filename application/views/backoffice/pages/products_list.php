<div class="row">
	<?php if (count($data)>0){?>
	<?php foreach ($data as $p){?>
	<div class="col-md-4">
	<div class="card card-widget widget-user product-widget">
	  <div class="widget-user-header text-white"
		   style="background: url('<?php echo base_url($p['thumb']);?>') center center;">
		<h3 class="widget-user-username text-right"><?php echo $p['title'];?></h3>
	  </div>
	  <div class="card-body">
		<h5><?php echo $p['title'];?></h5>
		<span><?php echo currency($p['selling_price']);?></span>
		<hr>
		<div class="row">
		  
		  <div class="col-sm-6 border-right">
			<div class="description-block">
			  <h5 class="description-header"><?php echo $p['psb'];?></h5>
			  <span class="description-text">PERSONAL SPONSOR BONUS</span>
			</div>
		  </div>
		  <div class="col-sm-6">
			<div class="description-block">
			  <h5 class="description-header"><?php echo currency($p['nbb']);?></h5>
			  <span class="description-text">NETWORK BINARY BONUS</span>
			</div>
		  </div>
		</div>
	  </div>
	  
	  <div class="card-footer" style="text-align: right;">
		<?php echo modal_anchor(get_uri("payments/gateways/".$p['id'].""), "Purchase", array("class" => "btn btn-primary w-100", "title" => "Purchase ".$p['title']."", "data-product_id"=>$p['id'])); ?>
		<!---<button data-toggle="modal" data-target="#purchase_modal_<?php //echo $p['id'];?>" class="btn btn-primary w-100">Purchase</button>--->
	  </div>
	</div>
  </div>
  
  
  <div class="modal fade" id="purchase_modal_<?php echo $p['id'];?>">
	<div class="modal-dialog">
	  <div class="modal-content">
		<div class="modal-header">
		  <h4 class="modal-title">Purchase <?php echo $p['title'];?></h4>
		  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		  </button>
		</div>
		<form method="post" action="<?php echo base_url('payments/index');?>">
		<div class="modal-body">
			<?php echo form_hidden($this->security->get_csrf_token_name(), $this->security->get_csrf_hash()); ?>
			<?php echo form_hidden('product_id', $p['id']); ?>
		  <div class="form-group row">
			<label for="" class="col-sm-4 col-form-label">Select Method*</label>
			<div class="col-sm-8">
			  <select class="form-control" name="method">
				<option value="">Select Payment Method</option>
				<?php if (count($payment_gateways)>0){?>
				<?php foreach($payment_gateways as $pg){?>
				<option value="<?php echo $pg;?>"><?php echo $pg;?></option>
				<?php } ?>
				<?php } ?>
			  </select>
			</div>
		  </div>
		</div>
		<div class="modal-footer" style="text-align: right;">
		  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		  <button type="submit" class="btn btn-primary">Save changes</button>
		</div>
		</form>
	  </div>
	  <!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
  </div>
  
  
	<?php } ?>
	<?php } ?>
	
</div>
		