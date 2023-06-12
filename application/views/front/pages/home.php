<div class="row">
	<div class="col-md-8">
		<div class="shadow-wrapper">
			<div class="tag-box tag-box-v1 box-shadow shadow-effect-2">
				<?php $this->load->view('front/includes/home_slider_main');?>
			</div>
		</div>
		<nav class="navbar navbar-expand-lg navbar-light bg-light sub-nav">
 
			<div class="collapse navbar-collapse" id="navbarNav">
				<ul class="nav navbar-nav">
					<li class="nav-item active">
						<a class="nav-link" href="#">The Blend</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="#">Office Posts</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="#">Associate Posts</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="#">Community Posts</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="#">Add a Post</a>
					</li>
				</ul>
				<form class="form-inline">
					<input class="form-control" type="search" placeholder="Search" aria-label="Search" style="max-width:125px;">
					<button class="btn btn-outline-success" type="submit">Search</button>
				</form>
			</div>
		</nav>
		<!------------------------POSTS START------------------->
		<div class="row margin-bottom-20">
			<div class="col-sm-3 sm-margin-bottom-20">
				<img class="img-responsive" src="<?php echo base_url('assets/front/');?>img/main/img12.jpg" alt="">
			</div>
			<div class="col-sm-9 news-v3">
				<div class="news-v3-in-sm no-padding">
					<!---<ul class="list-inline posted-info">
						<li>By Alexander Jenni</li>
						<li>In <a href="#">Design</a></li>
						<li>Posted January 24, 2015</li>
					</ul>--->
					<h2><a href="#">Incredible standard post “IMAGE”</a></h2>
					<p>Nullam elementum tincidunt massa, a pulvinar leo ultricies ut. Ut fringilla lectus tellus, imperdiet molestie est volutpat at. Sed viverra cursus nibh, sed consectetur ipsum sollicitudin non metus inmi efficitur...</p>
					<ul class="post-shares">
						<li>
							<a href="#">
								<i class="icon-speech"></i>
								<span>5</span>
							</a>
						</li>
						<li><a href="#"><i class="fa fa-eye"></i></a></li>
						<li><a href="#"><i class="fa fa-pencil"></i></a></li>
					</ul>
				</div>
			</div>
		</div>
		<div class="clearfix margin-bottom-20"><hr></div>
		<div class="row margin-bottom-20">
			<div class="col-sm-3 sm-margin-bottom-20">
				<img class="img-responsive" src="<?php echo base_url('assets/front/');?>img/main/img12.jpg" alt="">
			</div>
			<div class="col-sm-9 news-v3">
				<div class="news-v3-in-sm no-padding">
					<!---<ul class="list-inline posted-info">
						<li>By Alexander Jenni</li>
						<li>In <a href="#">Design</a></li>
						<li>Posted January 24, 2015</li>
					</ul>--->
					<h2><a href="#">Incredible standard post “IMAGE”</a></h2>
					<p>Nullam elementum tincidunt massa, a pulvinar leo ultricies ut. Ut fringilla lectus tellus, imperdiet molestie est volutpat at. Sed viverra cursus nibh, sed consectetur ipsum sollicitudin non metus inmi efficitur...</p>
					<ul class="post-shares">
						<li>
							<a href="#">
								<i class="icon-speech"></i>
								<span>5</span>
							</a>
						</li>
						<li><a href="#"><i class="fa fa-eye"></i></a></li>
						<li><a href="#"><i class="fa fa-pencil"></i></a></li>
					</ul>
				</div>
			</div>
		</div>
		<div class="clearfix margin-bottom-20"><hr></div>
		<!------------------------POSTS END------------------->
	</div>
	<div class="col-md-4">
	
		<form action="#" id="sky-form2" class="sky-form">
			<div id="inline-start"></div>
		</form>
		<div class="margin-bottom-30"></div>
		<div class="panel panel-grey equal-height-column">
			<div class="panel-heading">
				<h3 class="panel-title"><i class="fa fa-tasks"></i> Featured Videos</h3>
			</div>
			<div class="panel-body padding-0">
				<?php $this->load->view('front/includes/home_slider_side');?>
			</div>
		</div>
	</div>
</div>