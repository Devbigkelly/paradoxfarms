<div class="row">
	<div class="col-md-12">
		
		<nav class="navbar navbar-expand-lg navbar-light bg-light sub-nav">
 
			<div class="collapse navbar-collapse" id="navbarNav">
				<ul class="nav navbar-nav">
					<li class="nav-item <?php if ($sub == 'guide'){echo 'active';}?>">
						<a class="nav-link" href="<?php echo base_url('site/marketplace/guide');?>">Guide</a>
					</li>
					<li class="nav-item <?php if ($sub == 'catalog'){echo 'active';}?>">
						<a class="nav-link" href="<?php echo base_url('site/marketplace/catalog');?>">Catalog</a>
					</li>
					<li class="nav-item <?php if ($sub == 'portfolio'){echo 'active';}?>">
						<a class="nav-link" href="<?php echo base_url('site/marketplace/portfolio');?>">Portfolio</a>
					</li>
					<li class="nav-item <?php if ($sub == 'orders'){echo 'active';}?>">
						<a class="nav-link" href="<?php echo base_url('site/marketplace/orders');?>">Orders</a>
					</li>
					<li class="nav-item <?php if ($sub == 'reports'){echo 'active';}?>">
						<a class="nav-link" href="<?php echo base_url('site/marketplace/reports');?>">Reports</a>
					</li>
				</ul>
				
			</div>
		</nav>
		
		<?php include($main.'/'.$sub.'.php');?>
	</div>
</div>