<div class="col-md-3 md-margin-bottom-40">
					<img class="img-responsive profile-img margin-bottom-20" src="<?php echo $this->user_account->get_avatar($this->session->userdata('user_id'));?>" alt="">

					<ul class="list-group sidebar-nav-v1 margin-bottom-40" id="sidebar-nav-1">
						
						<li class="list-group-item <?php if ($file == 'profile'){echo 'active';}?>">
							<a href="<?php echo base_url('site/account')?>"><i class="fa fa-user"></i> Profile</a>
						</li>
						<li class="list-group-item <?php if ($file == 'my_matches'){echo 'active';}?>">
							<a href="<?php echo base_url('site/account/matches')?>"><i class="fa fa-group"></i> Matches</a>
						</li>
						<li class="list-group-item" <?php if ($file == 'my_media'){echo 'active';}?>>
							<a href="<?php echo base_url('site/account/media')?>"><i class="fa fa-cubes"></i> Media</a>
						</li>
						<li class="list-group-item">
							<a href="page_profile_settings.html"><i class="fa fa-cog"></i> Settings</a>
						</li>
					</ul>

					

					<!--Notification
					<div class="panel-heading-v2 overflow-h">
						<h2 class="heading-xs pull-left"><i class="fa fa-bell-o"></i> Notification</h2>
						<a href="#"><i class="fa fa-cog pull-right"></i></a>
					</div>
					<ul class="list-unstyled mCustomScrollbar margin-bottom-20" data-mcs-theme="minimal-dark">
						<li class="notification">
							<i class="icon-custom icon-sm rounded-x icon-bg-red icon-line icon-envelope"></i>
							<div class="overflow-h">
								<span><strong>Albert Heller</strong> has sent you email.</span>
								<small>Two minutes ago</small>
							</div>
						</li>
						<li class="notification">
							<img class="rounded-x" src="<?php echo base_url('assets/front/');?>img/testimonials/img6.jpg" alt="">
							<div class="overflow-h">
								<span><strong>Taylor Lee</strong> started following you.</span>
								<small>Today 18:25 pm</small>
							</div>
						</li>
						<li class="notification">
							<i class="icon-custom icon-sm rounded-x icon-bg-yellow icon-line fa fa-bolt"></i>
							<div class="overflow-h">
								<span><strong>Natasha Kolnikova</strong> accepted your invitation.</span>
								<small>Yesterday 1:07 pm</small>
							</div>
						</li>
						<li class="notification">
							<img class="rounded-x" src="<?php echo base_url('assets/front/');?>img/testimonials/img1.jpg" alt="">
							<div class="overflow-h">
								<span><strong>Mikel Andrews</strong> commented on your Timeline.</span>
								<small>23/12 11:01 am</small>
							</div>
						</li>
						<li class="notification">
							<i class="icon-custom icon-sm rounded-x icon-bg-blue icon-line fa fa-comments"></i>
							<div class="overflow-h">
								<span><strong>Bruno Js.</strong> added you to group chating.</span>
								<small>Yesterday 1:07 pm</small>
							</div>
						</li>
						<li class="notification">
							<img class="rounded-x" src="<?php echo base_url('assets/front/');?>img/testimonials/img6.jpg" alt="">
							<div class="overflow-h">
								<span><strong>Taylor Lee</strong> changed profile picture.</span>
								<small>23/12 15:15 pm</small>
							</div>
						</li>
					</ul>
					<button type="button" class="btn-u btn-u-default btn-u-sm btn-block">Load More</button>
					<!--End Notification-->

					<div class="margin-bottom-50"></div>

					<!--Datepicker-->
					<form action="#" id="sky-form2" class="sky-form">
						<div id="inline-start"></div>
					</form>
					<!--End Datepicker-->
				</div>