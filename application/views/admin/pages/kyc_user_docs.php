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
                    <th>Document Title</th>
                    <th>View</th>
                  </tr>
                  </thead>
                  <tbody>
				  <?php if (count($data)>0){?>
				  <?php foreach ($data as $k){ ?>
                  <tr>
                    <td><?php echo $k['document'];?></td>
                    <td><a href="<?php echo base_url($k['file']);?>" target="_blank">View Document</a></td>
                   
                  </tr>
                  <?php } ?>
                  <?php } ?>
                  
                  </tbody>
                  <tfoot>
                  <tr>
                    <tr>
                    <th>Document Title</th>
                    <th>View</th>
                  </tr>
                  </tr>
                  </tfoot>
                </table>
			<!--------------------->
			</div>
		</div>
	</div>
</div>
		