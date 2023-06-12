<form method="post" enctype="multipart/form-data" action="<?php echo base_url('payments/index');?>">
<div class="modal-body clearfix">
	<?php echo form_hidden($this->security->get_csrf_token_name(), $this->security->get_csrf_hash()); ?>
	<?php echo form_hidden('product_id', $product_id); ?>
  <div class="form-group row">
	<label for="" class="col-sm-4 col-form-label">Select Method*</label>
	<div class="col-sm-8">
	  <select class="form-control" name="method" id="method" onchange="js_perform()">
		<option value="">Select Payment Method</option>
		<?php if (count($payment_gateways)>0){?>
		<?php foreach($payment_gateways as $pg){?>
		<option value="<?php echo $pg;?>"><?php echo $pg;?></option>
		<?php } ?>
		<?php } ?>
	  </select>
	</div>
  </div>
   <div class="form-group row" id="proof_field" style="display:none">
	<label for="" class="col-sm-4 col-form-label">Payment Proof*</label>
	<div class="col-sm-8">
	  <input type="file" class="form-control" name="image" accept="image/*" id="exampleInputFile">
	</div>
  </div>
</div>
<div class="modal-footer" style="text-align: right;">
  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
  <button type="submit" class="btn btn-primary">Proceed</button>
</div>
</form>


<script>
function js_perform(){
	var method = $('#method option:selected').val();
	if (method == 'Manual-Payment'){
		$('#proof_field').show();
	} else {
		$('#proof_field').hide();
	}
}
</script>