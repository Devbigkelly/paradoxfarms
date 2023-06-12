<div class="modal-body clearfix">
<?php if (count($tranxs)>0){
	echo '<ul class="tranxs-list">';
	foreach ($tranxs as $tx){
		echo '<li class="tranx-list-item">';
		echo '<span>Date Time: <strong>'.$tx['dated'].'</strong></span><br>';
		echo '<span>Transaction Type: <strong>'.$tx['tranx_type'].'</strong></span><br><br>';
		echo '<span>'.$tx['details'].'</span>';
		echo '</li>';
	}
	echo '<ul>';
}?>
	
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal"><span class="fa fa-close"></span> <?php echo ('Close'); ?></button>
</div>
