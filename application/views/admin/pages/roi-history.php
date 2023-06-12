<div class="row">
	<div class="col-md-12">
		<div class="card card-primary card-outline">
			<div class="card-header">
				<h3 class="card-title"><?php echo $page_title;?></h3>
			</div>
			<div class="card-body">
			<!--------------------->
			<table id="exampledt" class="table table-bordered table-striped">
                  <thead>
                  <tr>
					<th>#</th>
                    <th>Tranx ID</th>
                    <th>Username</th>
                    <th>Amount</th>
                    <th>Dated</th>
                  </tr>
                  </thead>
                  <tbody>
				  
                  </tbody>
                  <tfoot>
                  <tr>
					<th>#</th>
                    <th>Tranx ID</th>
					<th>Username</th>
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
<script>

$( document ).ready(function() {
	$('#exampledt').DataTable({
		'processing': true,
		'serverSide': true,
		'serverMethod': 'post',
		'ajax': {
			'url':base_url + "admin/income_ajax/roi"
		},
		'columns': [
			{ data: 'id' },
			{ data: 'tranx_id' },
			{ data: 'username' },
			{ data: 'amount' },
			{ data: 'dated' },
        
		]
   });
});
</script>		