<form class="ajax_form" id="ajax_form" method="POST" action="<?php echo base_url('admin/users/do-purchase-product');?>">
<?php echo form_hidden($this->security->get_csrf_token_name(), $this->security->get_csrf_hash()); ?>
<div class="modal-body clearfix">
<?php if (count($data)>0){
	echo '<table class="table table-bordered">';
	foreach ($data as $product){
		echo '<tr>';
		echo '<td><input type="radio" name="product_id" value="'.$product['id'].'"></td>';
		echo '<td><img style="width:50px" src="'.base_url($product['thumb']).'"></td>';
		echo '<td>';
		echo '<strong>'.$product['title'].'</strong>';
		echo '</td>';
		echo '</tr>';
	}
	echo '</table>';
}?>
<input type="hidden" name="username" value="<?php echo $username;?>">
	<table class="table table-bordered">
		<tr>
			<td>Deduct From User Wallet</td>
			<td><label><input type="radio" name="payment" value="unpaid"> No</label></td>
			<td><label><input type="radio" name="payment" value="paid" checked="checked"> Yes</label></td>
		</tr>
	</table>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal"><span class="fa fa-close"></span> <?php echo ('Close'); ?></button>
	<button type="submit" class="btn btn-primary ajax_form_submit"><span class="fa fa-close"></span> Purchase</button>
</div>
</form>