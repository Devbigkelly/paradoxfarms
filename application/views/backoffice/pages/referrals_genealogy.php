<div class="row">
	<div class="col-md-12">
		<div class="card card-primary card-outline">
			<div class="card-header">
				<h3 class="card-title"><?php echo $page_title;?></h3>
			</div>
			<div class="card-body" style="overflow-x: scroll;">
				<div id="main" class="direct_gen"></div>
			</div>
			
		</div>
	</div>
</div>
<div  style="display: none">
<?php echo $data;?>
</div>




<script type="text/javascript">
 $(function() {
		$("#direct_genealogy").orgChart({container: $("#main"), interactive: true, fade: true, speed: 'slow'});
	});
</script>
