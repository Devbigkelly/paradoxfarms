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
                    <th>Title</th>
                    <th>Value</th>
                  </tr>
                  </thead>
                  <tbody>
				  
                  <tr>
					<td>ROI</td>
					<td><code>wget <?php echo base_url('cron/disperse-roi');?></code></td>
                  </tr>
				  <tr>
					<td>Database Backup</td>
					<td><code>wget <?php echo base_url('cron/database-backup');?></code></td>
                  </tr>
                 
                  </tbody>
                  <tfoot>
                  <tr>
                    <th>Title</th>
                    <th>Value</th>
                  </tr>
                  </tfoot>
                </table>
			<!--------------------->
			</div>
		</div>
	</div>
</div>
		