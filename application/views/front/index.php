<!doctype html>
<html class="no-js" lang="en">

<head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1" />
        <!-- title -->
        <title><?php echo $title;?></title>
		<meta name="description" content="<?php echo $this->general->get_system_var('meta_description');?>">
		<meta name="keywords" content="<?php echo $this->general->get_system_var('meta_tags');?>">
		<meta name="author" content="<?php echo $system_name;?>">
		<meta property="og:title" content="<?php echo $system_name;?>">
		<meta property="og:description" content="<?php echo $this->general->get_system_var('meta_description');?>">
		<meta property="og:image" content="<?php echo base_url('assets/preview.png');?>">
		<meta property="og:url" content="<?php echo base_url();?>">
        
        <!-- favicon -->
        <link rel="shortcut icon" href="<?php echo base_url($this->general->get_system_var('favicon'));?>">
        <!-- animation -->
        <link rel="stylesheet" href="<?php echo base_url('assets/frontend/');?>css/animate.css" />
        <!-- bootstrap -->
        <link rel="stylesheet" href="<?php echo base_url('assets/frontend/');?>css/bootstrap.min.css" />
        <!-- font-awesome icon -->
        <link rel="stylesheet" href="<?php echo base_url('assets/frontend/');?>css/font-awesome.min.css" />
        <!-- themify-icons -->
        <link rel="stylesheet" href="<?php echo base_url('assets/frontend/');?>css/themify-icons.css" />
        <!-- owl carousel -->
        <link rel="stylesheet" href="<?php echo base_url('assets/frontend/');?>css/owl.transitions.css" />
        <link rel="stylesheet" href="<?php echo base_url('assets/frontend/');?>css/owl.carousel.css" /> 
        <!-- magnific popup -->
        <link rel="stylesheet" href="<?php echo base_url('assets/frontend/');?>css/magnific-popup.css" /> 
        <!-- base -->
        <link rel="stylesheet" href="<?php echo base_url('assets/frontend/');?>css/base.css" /> 
        <!-- elements -->
        <link rel="stylesheet" href="<?php echo base_url('assets/frontend/');?>css/elements.css" />
        <!-- responsive -->
        <link rel="stylesheet" href="<?php echo base_url('assets/frontend/');?>css/responsive.css" />
        <!--[if IE 9]>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/frontend/');?>css/ie.css" />
        <![endif]-->
        <!--[if IE]>
            <script src="<?php echo base_url('assets/frontend/');?>js/html5shiv.min.js"></script>
        <![endif]-->
        <style>
            .title-style6 .progress-bar-style1 .progress-bar {background-color: #374a8a;}
        </style>

    </head>
    <body>
        <header class="header-style4" id="header-section9">
            <!-- nav -->
            <nav class="navbar bg-white white-header alt-font no-margin no-padding shrink-medium-header light-header">
                <div class="header-top bg-light-gray tz-header-bg">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
								<?php if (!empty($email)){?>
                                <div class="mail">GET SUPPORT: <a href="mailto:<?php echo $email;?>" class="text-light-gray tz-text"><?php echo $email;?></a></div>
								<?php } ?>
                                <!-- social elements -->
                                <div class="social float-right">
									<?php echo $this->general->get_social_media('facebook', 'fa fa-facebook tz-icon-color');?>
									<?php echo $this->general->get_social_media('twitter', 'fa fa-twitter tz-icon-color');?>
									<?php echo $this->general->get_social_media('google_plus', 'fa fa-google-plus tz-icon-color');?>
									<?php echo $this->general->get_social_media('pinterest', 'fa fa-pinterest tz-icon-color');?>
									<?php echo $this->general->get_social_media('linkedin', 'fa fa-linkedin tz-icon-color');?>
									<?php echo $this->general->get_social_media('youtube', 'fa fa-youtube tz-icon-color');?>
									<?php echo $this->general->get_social_media('instagram', 'fa fa-instagram tz-icon-color');?>
									<?php echo $this->general->get_social_media('delicious', 'fa fa-delicious tz-icon-color');?>
									<?php echo $this->general->get_social_media('dribbble', 'fa fa-dribbble tz-icon-color');?>
									<?php echo $this->general->get_social_media('foursquare', 'fa fa-foursquare tz-icon-color');?>
									<?php echo $this->general->get_social_media('gg-circle', 'fa fa-gg-circle tz-icon-color');?>
									<?php echo $this->general->get_social_media('forumbee', 'fa fa-forumbee tz-icon-color');?>
									<?php echo $this->general->get_social_media('qq', 'fa fa-qq tz-icon-color');?>
									<?php echo $this->general->get_social_media('snapchat', 'fa fa-snapchat tz-icon-color');?>
									<?php echo $this->general->get_social_media('tumblr', 'fa fa-tumblr tz-icon-color');?>
									<?php echo $this->general->get_social_media('twitch', 'fa fa-twitch tz-icon-color');?>
									<?php echo $this->general->get_social_media('vk', 'fa fa-vk tz-icon-color');?>
									<?php echo $this->general->get_social_media('whatsapp', 'fa fa-whatsapp tz-icon-color');?>
									<?php echo $this->general->get_social_media('vimeo', 'fa fa-vimeo tz-icon-color');?>
                                    <?php if ($this->session->userdata('isLogin') == true){?>
									<a href="<?php echo base_url($this->session->userdata('user_group').'/dashboard');?>" title="Dashboard"><i class="fa fa-dashboard tz-icon-color"></i> Dashboard</a>
									<a href="<?php echo base_url('auth/logout');?>" title="Sign Out"><i class="fa fa-sign-out tz-icon-color"></i></a>
									<?php } else { ?>
									<a href="<?php echo base_url('auth/login');?>"><i class="fa fa-sign-in tz-icon-color"></i> Login</a>
                                    <a href="<?php echo base_url('auth/register');?>"><i class="fa fa-user-plus tz-icon-color"></i> Register</a>
									<?php } ?>
                                    
                                </div>
                                <!-- end social elements -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="header-bottom bg-white tz-header-bg">
                    <div class="container navigation-menu">
                        <div class="row">
                            <!-- logo -->
                            <div class="col-md-3 col-sm-4 col-xs-9">
                                <a href="#home" class="inner-link"><img alt="" src="<?php echo base_url($this->general->get_system_var('logo'));?>" data-img-size="(W)163px X (H)39px"></a>
                            </div>
                            <!-- end logo -->
                            <div class="col-md-9 col-sm-8 col-xs-3 position-inherit">
                                <button data-target="#bs-example-navbar-collapse-1" data-toggle="collapse" class="navbar-toggle collapsed" type="button">
                                    <span class="sr-only">Toggle navigation</span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                </button>
                                <div id="bs-example-navbar-collapse-1" class="collapse navbar-collapse pull-right">
                                    <ul class="nav navbar-nav font-weight-600">
                                        <li class="propClone"><a class="inner-link" href="#content-section13">ABOUT</a></li>
                                        <li class="propClone"><a class="inner-link" href="#content-section36">OUR PROCESS</a></li>
                                        <li class="propClone"><a class="inner-link" href="#feature-section4">SERVICES</a></li>
                                        <li class="propClone"><a class="inner-link" href="#team-section9">PEOPLE</a></li>
                                        <li class="propClone"><a class="inner-link" href="#testimonials-section14">TESTIMONIALS</a></li>
                                        <li class="propClone"><a class="inner-link" href="#contact-section9">CONTACT</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </nav> 
            <!-- end nav -->
        </header>             
        <section id="home" class="no-padding slider-style1 border-none">
            <div class="owl-slider-full owl-carousel owl-dark-pagination owl-without-next-pre-arrow">
                <!-- slider item -->
                <div class="item owl-bg-img tz-builder-bg-image cover-background bg-img-one" id="tz-bg-1" data-img-size="(W)1920px X (H)994px" style="background: linear-gradient(rgba(15, 15, 15, 0.0), rgba(15, 15, 15, 0.0)) repeat scroll 0% 0%, transparent url('<?php echo base_url('assets/frontend/');?>images/bg-image/agency-slider-01.jpg') repeat scroll 0% 0%;">
                    <div class="container one-third-screen xs-one-second-screen position-relative">
                        <div class="col-md-12 col-sm-12 col-xs-12 slider-typography text-left sm-position-inherit">
                            <div class="slider-text-middle-main">
                                <div class="slider-text-middle"> 
                                    <div class="col-md-7 col-sm-10 col-xs-12 no-padding alt-font slider-content sm-no-margin-top">
                                        <div class="title-extra-large-6 line-height-75 font-weight-700 text-light-purple-blue slider-title margin-seven-bottom tz-text letter-spacing-minus-1" id="tz-slider-text1">PLANNING FOR THE FUTURE</div>
                                        <div class="text-extra-large text-light-gray2 main-font font-weight-600 slider-text margin-ten-bottom tz-text width-80 xs-width-100" id="tz-slider-text2">Lorem Ipsum is simply dummy text of printing and industry. Lorem Ipsum the industry's dummy text ever since.</div>
                                        <div class="btn-dual">
                                            <a class="btn btn-medium propClone btn-circle bg-middle-light-gray text-white inner-link" href="#feature-section31"><span class="tz-text" id="tz-slider-text6">READ MORE</span><i class="fa fa-angle-right icon-extra-small tz-icon-color" id="tz-icon-5"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end slider item -->
                <!-- slider item -->
                <div class="item owl-bg-img tz-builder-bg-image cover-background bg-img-two" id="tz-bg-2" data-img-size="(W)1920px X (H)994px" style="background: linear-gradient(rgba(15, 15, 15, 0.0), rgba(15, 15, 15, 0.0)) repeat scroll 0% 0%, transparent url('<?php echo base_url('assets/frontend/');?>images/bg-image/agency-slider-02.jpg') repeat scroll 0% 0%;">
                    <div class="container one-third-screen xs-one-second-screen position-relative">
                        <div class="col-md-12 col-sm-10 col-xs-12 slider-typography text-left sm-position-inherit">
                            <div class="slider-text-middle-main">
                                <div class="slider-text-middle">
                                    <div class="col-md-7 col-sm-12 col-xs-12 no-padding alt-font slider-content sm-no-margin-top">
                                        <div class="title-extra-large-6 line-height-75 font-weight-700 text-light-purple-blue slider-title margin-seven-bottom tz-text letter-spacing-minus-1">BOLD, SMART, INNOVATIVE</div>
                                        <div class="text-light-gray2 text-extra-large main-font font-weight-600 slider-text margin-ten-bottom tz-text width-80 xs-width-100" id="tz-slider-text7">Lorem Ipsum is simply dummy text of printing and industry. Lorem Ipsum the industry's dummy text ever since.</div>
                                        <div class="btn-dual">
                                            <a class="btn btn-medium propClone btn-circle bg-middle-light-gray text-white inner-link" href="#feature-section31"><span class="tz-text" id="tz-slider-text4">READ MORE</span><i class="fa fa-angle-right icon-extra-small tz-icon-color" id="tz-icon-6"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end slider item -->
                <!-- slider item -->
                <div class="item owl-bg-img tz-builder-bg-image cover-background bg-img-three" id="tz-bg-3" data-img-size="(W)1920px X (H)994px" style="background: linear-gradient(rgba(15, 15, 15, 0.0), rgba(15, 15, 15, 0.0)) repeat scroll 0% 0%, transparent url('<?php echo base_url('assets/frontend/');?>images/bg-image/agency-slider-03.jpg') repeat scroll 0% 0%;">
                    <div class="container one-third-screen xs-one-second-screen position-relative">
                        <div class="col-md-12 col-sm-12 col-xs-12 slider-typography text-left sm-position-inherit">
                            <div class="slider-text-middle-main">
                                <div class="slider-text-middle"> 
                                    <div class="col-md-7 col-sm-12 col-xs-12 no-padding alt-font slider-content sm-no-margin-top">
                                        <div class="title-extra-large-6 line-height-75 font-weight-700 text-light-purple-blue slider-title margin-seven-bottom tz-text letter-spacing-minus-1" id="tz-slider-text9">POWERFUL OPTIONS</div>
                                        <div class="text-light-gray2 text-extra-large main-font font-weight-600 slider-text margin-ten-bottom tz-text width-80 xs-width-100" id="tz-slider-text10">Lorem Ipsum is simply dummy text of printing and industry. Lorem Ipsum the industry's dummy text ever since.</div>
                                        <div class="btn-dual">
                                            <a class="btn btn-medium propClone btn-circle bg-middle-light-gray text-white inner-link" href="#feature-section31"><span class="tz-text" id="tz-slider-text5">READ MORE</span><i class="fa fa-angle-right icon-extra-small tz-icon-color" id="tz-icon-7"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end slider item -->
            </div>
        </section> 
        <section class="padding-110px-tb bg-white builder-bg xs-padding-60px-tb feature-style-31 border-none" id="feature-section31">
            <div class="container">
                <div class="row">
                    <!-- feature box -->
                    <div class="col-md-4 col-sm-4 col-xs-12 xs-margin-fifteen-bottom">
                        <div class=" display-table margin-five-bottom width-100">
                            <div class="text-greenish-blue icon-style margin-seven-right display-table-cell-vertical-middle floal-none"><span class="fa ti-bar-chart title-extra-large-2 tz-icon-color"></span></div>
                            <div class="display-table-cell-vertical-middle ">
                                <span class="text-medium text-medium-gray tz-text">Business Planning</span>
                                <h3 class="text-large alt-font text-dark-gray position-relative top-minus3 tz-text">Strategy and Execution</h3>
                            </div>
                        </div>
                        <div class="text-medium width-95 xs-width-100 xs-margin-five-top tz-text"><p class="no-margin-bottom">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been he industry's standard dummy text ever since.</p></div>
                    </div>
                    <!-- end feature box -->
                    <!-- feature box -->
                    <div class="col-md-4 col-sm-4 col-xs-12 xs-margin-fifteen-bottom">
                        <div class=" display-table margin-five-bottom width-100">
                            <div class="text-greenish-blue icon-style margin-seven-right display-table-cell-vertical-middle floal-none"><span class="fa ti-stats-up title-extra-large-2 tz-icon-color"></span></div>
                            <div class="display-table-cell-vertical-middle ">
                                <span class="text-medium text-medium-gray tz-text">Extremely Analysis</span>
                                <h3 class="text-large alt-font text-dark-gray position-relative top-minus3 tz-text">Financial Projections</h3>
                            </div>
                        </div>
                        <div class="text-medium width-95 xs-width-100 xs-margin-five-top tz-text"><p class="no-margin-bottom">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been he industry's standard dummy text ever since.</p></div>
                    </div>
                    <!-- end feature box -->
                    <!-- feature box -->
                    <div class="col-md-4 col-sm-4 col-xs-12 xs-margin-fifteen-bottom">
                        <div class=" display-table margin-five-bottom width-100">
                            <div class="text-greenish-blue icon-style margin-seven-right display-table-cell-vertical-middle floal-none"><span class="fa ti-world title-extra-large-2 tz-icon-color"></span></div>
                            <div class="display-table-cell-vertical-middle ">
                                <span class="text-medium text-medium-gray tz-text">Excellent Opportunities</span>
                                <h3 class="text-large alt-font text-dark-gray position-relative top-minus3 tz-text">International Business</h3>
                            </div>
                        </div>
                        <div class="text-medium width-95 xs-width-100 xs-margin-five-top tz-text"><p class="no-margin-bottom">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been he industry's standard dummy text ever since.</p></div>
                    </div>
                    <!-- end feature box -->
                </div>
            </div>
        </section>
        <section class="padding-110px-tb xs-padding-60px-tb bg-light-gray builder-bg border-none" id="content-section13">
            <div class="container">
                <div class="row equalize xs-equalize-auto equalize-display-inherit">
                    <!-- content details -->
                    <div class="col-md-6 col-sm-6 xs-12 xs-text-center xs-margin-nineteen-bottom display-table" style="">
                        <div class="display-table-cell-vertical-middle">
                            <div class="margin-five-bottom sm-margin-ten-bottom"><span class="line-height-0 small-titel-text builder-bg font-weight-700 bg-greenish-blue alt-font text-white text-extra-medium tz-text">GET START NOW</span></div>
                            <h2 class="alt-font title-extra-large sm-title-large xs-section-title-large text-light-purple-blue line-height-40 width-90 sm-width-100 margin-eight-bottom tz-text sm-margin-ten-bottom">The world's most powerful website build now.</h2>
                            <div class="text-medium tz-text width-90 sm-width-100"><p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</p></div>
                            <div class="text-medium tz-text width-90 sm-width-100 margin-ten-bottom"><p>Lorem Ipsum has been the industry's standard dummy text ever since the when an unknown printer took a galley of type scrambled it to make a type specimen book.</p></div>
                            <a class="btn btn-medium propClone btn-circle bg-middle-light-gray text-white inner-link" href="#content-section36"><span class="tz-text">READ MORE</span></a>
                        </div>
                    </div>
                    <!-- end content details -->                        
                    <div class="col-md-6 col-sm-6 xs-12 xs-text-center display-table" style="">
                        <div class="display-table-cell-vertical-middle">
                            <img alt="" src="<?php echo base_url('assets/frontend/');?>images/content-14.png" data-img-size="(W)800px X (H)681px">
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- feature box section -->
        <section class="padding-60px-tb bg-light-purple-blue builder-bg border-none" id="callto-action2">
            <div class="container">
                <div class="row equalize">
                    <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                        <div class="display-inline-block sm-display-block vertical-align-middle margin-five-right sm-no-margin-right sm-margin-ten-bottom tz-text alt-font text-white title-medium sm-title-medium">Looking for a first-class business plan consultant?</div>
                        <a class="btn-large btn text-white highlight-button-white-border btn-circle" href="#contact-section9"><span class="tz-text">REGISTER TODAY</span><i class="fa fa-long-arrow-right icon-extra-small tz-icon-color"></i></a>
                    </div>
                </div>
            </div>
        </section>
        <section class="padding-110px-tb xs-padding-60px-tb bg-white builder-bg" id="content-section36">
            <div class="container-fluid">
                <div class="row four-column">
                    <!-- feature box -->
                    <div class="col-md-3 col-sm-6 col-xs-12 padding-six no-padding-tb sm-margin-nine-bottom xs-margin-fifteen-bottom">
                        <div class="margin-seven-bottom xs-margin-five-bottom title-extra-large-4 alt-font text-very-light-gray tz-text font-weight-600">01.</div>
                        <h3 class="text-dark-gray text-extra-large alt-font display-block tz-text">Technological innovation</h3>
                        <div class="text-medium text-dark-gray margin-six-bottom tz-text">Lorem Ipsum is simply dummy text printing.</div>
                        <div class="text-medium tz-text"><p>Lorem Ipsum is simply dummy text of the printing &amp; typesetting industry. Lorem Ipsum has been the industry's standard dummy.</p></div>
                        <div class="separator-line2 bg-greenish-blue margin-twenty-top tz-background-color"></div>
                    </div>
                    <!-- end feature box -->
                    <!-- feature box -->
                    <div class="col-md-3 col-sm-6 col-xs-12 padding-six no-padding-tb sm-margin-nine-bottom xs-margin-fifteen-bottom">
                        <div class="margin-seven-bottom xs-margin-five-bottom title-extra-large-4 alt-font text-very-light-gray tz-text font-weight-600">02.</div>
                        <h3 class="text-dark-gray text-extra-large alt-font display-block tz-text">Creativity designs</h3>
                        <div class="text-medium text-dark-gray margin-six-bottom tz-text">Lorem Ipsum is simply dummy text printing.</div>
                        <div class="text-medium tz-text"><p>Lorem Ipsum is simply dummy text of the printing &amp; typesetting industry. Lorem Ipsum has been the industry's standard dummy.</p></div>
                        <div class="separator-line2 bg-greenish-blue margin-twenty-top tz-background-color"></div>
                    </div>
                    <!-- end feature box -->
                    <!-- feature box -->
                    <div class="col-md-3 col-sm-6 col-xs-12 padding-six no-padding-tb sm-margin-nine-bottom xs-margin-fifteen-bottom">
                        <div class="margin-seven-bottom xs-margin-five-bottom title-extra-large-4 alt-font text-very-light-gray tz-text font-weight-600">03.</div>
                        <h3 class="text-dark-gray text-extra-large alt-font display-block tz-text">Customer support</h3>
                        <div class="text-medium text-dark-gray margin-six-bottom tz-text">Lorem Ipsum is simply dummy text printing.</div>
                        <div class="text-medium tz-text"><p>Lorem Ipsum is simply dummy text of the printing &amp; typesetting industry. Lorem Ipsum has been the industry's standard dummy.</p></div>
                        <div class="separator-line2 bg-greenish-blue margin-twenty-top tz-background-color"></div>
                    </div>
                    <!-- end feature box -->
                    <!-- feature box -->
                    <div class="col-md-3 col-sm-6 col-xs-12 padding-six no-padding-tb sm-margin-nine-bottom xs-margin-fifteen-bottom">
                        <div class="margin-seven-bottom xs-margin-five-bottom title-extra-large-4 alt-font text-very-light-gray tz-text font-weight-600">04.</div>
                        <h3 class="text-dark-gray text-extra-large alt-font display-block tz-text">Project management</h3>
                        <div class="text-medium text-dark-gray margin-six-bottom tz-text">Lorem Ipsum is simply dummy text printing.</div>
                        <div class="text-medium tz-text"><p>Lorem Ipsum is simply dummy text of the printing &amp; typesetting industry. Lorem Ipsum has been the industry's standard dummy.</p></div>
                        <div class="separator-line2 bg-greenish-blue margin-twenty-top tz-background-color"></div>
                    </div>
                    <!-- end feature box -->
                </div>
            </div>
        </section>
        <!-- end feature box section -->
        <section class="padding-90px-tb xs-padding-60px-tb cover-background tz-builder-bg-image border-none bg-img-four" id="content-section15" data-img-size="(W)1920px X (H)900px" style="background: linear-gradient(rgba(22, 22, 22, 0.8), rgba(22, 22, 22, 0.8)) repeat scroll 0% 0%, transparent url('<?php echo base_url('assets/frontend/');?>images/bg-image/hero-bg4.jpg') repeat scroll 0% 0%;">
            <div class="container">
                <div class="row">
                    <!-- content details -->
                    <div class="col-lg-7 col-md-8 col-sm-12 col-xs-12 center-col text-center">
                        <h2 class="alt-font text-white font-weight-500 title-extra-large-2 line-height-50 sm-section-title-large xs-section-title-large sm-no-margin-top margin-six-bottom sm-margin-five-bottom tz-text">Introduce your<br>business or company</h2>
                        <div class="title-medium sm-title-medium xs-title-medium text-white width-85 sm-width-100 center-col font-weight-100 margin-six-bottom sm-margin-five-bottom tz-text">Since our foundation in 2005 our goal has been to use digital technology to create experiences.</div>
                        <div class="text-medium sm-text-medium text-light-gray margin-twelve-bottom sm-margin-fifteen-bottom width-85 sm-width-100 center-col tz-text"><p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's.Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's.</p></div>
                        <a class="btn-large btn-circle btn bg-greenish-blue sm-no-margin-bottom btn-circle text-white inner-link" href="#content-section13"><span class="tz-text">CONTINUE READING</span><i class="fa fa-long-arrow-right icon-extra-small tz-icon-color"></i></a>
                    </div>
                    <!-- end content details -->
                </div>
            </div>
        </section>
        <section id="clients-section2" class="padding-50px-tb bg-white builder-bg clients-section2 xs-padding-top-60px border-none">
            <div class="container">
                <div class="row">
                    <!-- clients logo -->
                    <div class="owl-slider-style4 owl-carousel owl-theme owl-no-pagination owl-dark-pagination owl-without-next-prev-arrow outside-arrow-simple black-pagination sm-no-owl-buttons sm-show-pagination owl-pagination-bottom-30px">
                        <!-- client logo image -->
                        <div class="item">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="client-logo-outer">
                                    <div class="client-logo-inner">
                                        <a href="#">
                                            <img src="<?php echo base_url('assets/frontend/');?>images/clients-1.jpg" id="tz-bg-149" data-img-size="(W)800px X (H)500px" alt="">
                                        </a>
                                    </div>
                                </div>
                            </div>                               
                        </div>
                        <!-- end client logo image -->
                        <!-- client logo image -->
                        <div class="item">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="client-logo-outer">
                                    <div class="client-logo-inner">
                                        <a href="#">
                                            <img src="<?php echo base_url('assets/frontend/');?>images/clients-2.jpg" id="tz-bg-150" data-img-size="(W)800px X (H)500px" alt="">
                                        </a>
                                    </div>
                                </div>
                            </div>                               
                        </div>
                        <!-- client logo image -->
                        <!-- end client logo image -->
                        <div class="item">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="client-logo-outer">
                                    <div class="client-logo-inner">
                                        <a href="#">
                                            <img src="<?php echo base_url('assets/frontend/');?>images/clients-3.jpg" id="tz-bg-151" data-img-size="(W)800px X (H)500px" alt="">
                                        </a>
                                    </div>
                                </div>
                            </div>                               
                        </div>
                        <!-- client logo image -->
                        <!-- end client logo image -->
                        <div class="item">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="client-logo-outer">
                                    <div class="client-logo-inner">
                                        <a href="#">
                                            <img src="<?php echo base_url('assets/frontend/');?>images/clients-4.jpg" id="tz-bg-152" data-img-size="(W)800px X (H)500px" alt="">
                                        </a>
                                    </div>
                                </div>
                            </div>                               
                        </div>
                        <!-- client logo image -->
                        <!-- end client logo image -->
                        <div class="item">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="client-logo-outer">
                                    <div class="client-logo-inner">
                                        <a href="#">
                                            <img src="<?php echo base_url('assets/frontend/');?>images/clients-5.jpg" id="tz-bg-153" data-img-size="(W)800px X (H)500px" alt="">
                                        </a>
                                    </div>
                                </div>
                            </div>                               
                        </div>
                        <!-- client logo image -->
                        <!-- end client logo image -->
                        <div class="item">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="client-logo-outer">
                                    <div class="client-logo-inner">
                                        <a href="#">
                                            <img src="<?php echo base_url('assets/frontend/');?>images/clients-6.jpg" id="tz-bg-154" data-img-size="(W)800px X (H)500px" alt="">
                                        </a>
                                    </div>
                                </div>
                            </div>                               
                        </div>
                        <!-- client logo image -->
                        <!-- end client logo image -->
                        <div class="item">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="client-logo-outer">
                                    <div class="client-logo-inner">
                                        <a href="#">
                                            <img src="<?php echo base_url('assets/frontend/');?>images/clients-7.jpg" id="tz-bg-155" data-img-size="(W)800px X (H)500px" alt="">
                                        </a>
                                    </div>
                                </div>
                            </div>                               
                        </div>
                        <!-- end client logo image -->
                    </div>
                    <!-- end clients logo -->
                </div>
            </div>
        </section>
        <section class="padding-110px-tb bg-light-gray builder-bg xs-padding-60px-tb border-none" id="feature-section4">
            <div class="container">
                <div class="row">
                    <!-- section title -->
                    <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                        <h2 class="section-title-large sm-section-title-medium xs-section-title-large text-dark-gray font-weight-700 alt-font margin-three-bottom xs-margin-fifteen-bottom tz-text">OUR SERVICES</h2>
                        <div class="text-medium width-60 margin-lr-auto md-width-70 sm-width-100 tz-text margin-thirteen-bottom xs-margin-nineteen-bottom">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</div>
                    </div>
                    <!-- end section title -->
                </div>
                <div class="row three-column">
                    <!-- feature box -->
                    <div class="col-md-4 col-sm-6 col-xs-12 margin-three-bottom xs-margin-ten-bottom">
                        <div class="icon-medium float-left text-greenish-blue vertical-align-middle margin-seven-right tz-text"><i class="fa ti-user tz-icon-color" aria-hidden="true"></i></div>
                        <h3 class="text-medium font-weight-600 text-dark-gray overflow-hidden vertical-align-middle line-height-30 tz-text">ONLINE EARNING</h3>
                        <div class="text-medium width-95 margin-nine-top xs-width-100 xs-margin-five-top tz-text"> <p> Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been he industry's standard dummy text ever since. </p> </div>
                    </div>
                    <!-- end feature box -->
                    <!-- feature box -->
                    <div class="col-md-4 col-sm-6 col-xs-12 margin-three-bottom xs-margin-ten-bottom">
                        <div class="icon-medium text-greenish-blue float-left vertical-align-middle margin-seven-right"><span class="fa ti-bookmark-alt tz-icon-color"></span></div>
                        <h3 class="text-medium font-weight-600 text-dark-gray overflow-hidden vertical-align-middle line-height-30 tz-text">ADVERTISEMENT</h3>
                        <div class="text-medium width-95 margin-nine-top xs-width-100 xs-margin-five-top tz-text"> <p> Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been he industry's standard dummy text ever since. </p> </div>
                    </div>
                    <!-- end feature box -->
                    <!-- feature box -->
                    <div class="col-md-4 col-sm-6 col-xs-12 margin-three-bottom xs-margin-ten-bottom">
                        <div class="icon-medium text-greenish-blue float-left vertical-align-middle margin-seven no-margin-tb no-margin-left"><span class="fa ti-pencil-alt tz-icon-color"></span></div>
                        <h3 class="text-medium font-weight-600 text-dark-gray overflow-hidden vertical-align-middle line-height-30 tz-text">UNIQUE SHORTCODE</h3>
                        <div class="text-medium width-95 margin-nine-top xs-width-100 xs-margin-five-top tz-text"> <p> Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been he industry's standard dummy text ever since. </p> </div>
                    </div>
                    <!-- end feature box -->
                    <!-- feature box -->
                    <div class="col-md-4 col-sm-6 col-xs-12 xs-margin-ten-bottom">
                        <div class="icon-medium text-greenish-blue float-left vertical-align-middle margin-seven-right"><span class="fa ti-bar-chart-alt tz-icon-color"></span></div>
                        <h3 class="text-medium font-weight-600 text-dark-gray overflow-hidden vertical-align-middle line-height-30 tz-text">MARKET PLACE</h3>
                        <div class="text-medium width-95 margin-nine-top xs-margin-five-top tz-text"> <p> Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been he industry's standard dummy text ever since. </p> </div>
                    </div>
                    <!-- end feature box -->
                    <!-- feature box -->
                    <div class="col-md-4 col-sm-6 col-xs-12 xs-margin-ten-bottom">
                        <div class="icon-medium text-greenish-blue float-left vertical-align-middle margin-seven-right"><span class="fa ti-comments tz-icon-color"></span></div>
                        <h3 class="text-medium font-weight-600 text-dark-gray overflow-hidden vertical-align-middle line-height-30 tz-text">SUPPORT</h3>
                        <div class="text-medium width-95 margin-nine-top xs-margin-five-top tz-text"> <p> Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been he industry's standard dummy text ever since. </p> </div>
                    </div>
                    <!-- end feature box -->
                    <!-- feature box -->
                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <div class="icon-medium text-greenish-blue float-left vertical-align-middle margin-seven-right"><i class="fa ti-ruler-pencil tz-icon-color" aria-hidden="true"></i></div>
                        <h3 class="text-medium font-weight-600 text-dark-gray overflow-hidden vertical-align-middle line-height-30 tz-text">DESIGN</h3>
                        <div class="text-medium width-95 margin-nine-top xs-margin-five-top tz-text"> <p> Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been he industry's standard dummy text ever since. </p> </div>
                    </div>
                    <!-- end feature box -->
                </div>
            </div>
        </section>
        <section class="bg-white builder-bg padding-110px-tb xs-padding-60px-tb border-none" id="team-section9">
            <div class="container">
                <div class="row">
                    <!-- section title -->
                    <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                        <h2 class="section-title-large sm-section-title-medium xs-section-title-large text-dark-gray font-weight-700 alt-font margin-three-bottom xs-margin-fifteen-bottom tz-text">MEET OUR PEOPLE</h2>
                        <div class="text-medium width-60 margin-lr-auto md-width-70 sm-width-100 tz-text margin-thirteen-bottom xs-margin-nineteen-bottom">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</div>
                    </div>
                    <!-- end section title -->
                </div>
                <div class="row">
                    <!-- team member -->
                    <div class="col-md-4 col-sm-4 col-xs-12 text-center xs-margin-fifteen-bottom">
                        <div class="team position-relative bg-white tz-background-color">
                            <img alt="" src="<?php echo base_url('assets/frontend/');?>images/team-01.jpg" data-img-size="(W)750px X (H)893px" class="margin-twelve-bottom">
                            <div class="team-details text-center">
                                <div class="team-name padding-twelve-bottom margin-twelve-bottom border-bottom tz-border">
                                    <span class="alt-font font-weight-600 text-dark-gray display-block tz-text">SARA SMITH</span>
                                    <span class="text-small tz-text">FOUNDER AND CEO</span>
                                </div>
                                <div class="team-content padding-twelve-bottom">
                                    <div class="display-inline-block margin-five no-margin-tb"><a href="#"><i class="fa ti-facebook icon-extra-small tz-icon-color text-dark-gray"></i></a></div>
                                    <div class="display-inline-block margin-five no-margin-tb"><a href="#"><i class="fa ti-twitter-alt icon-extra-small tz-icon-color text-dark-gray"></i></a></div>
                                    <div class="display-inline-block margin-five no-margin-tb"><a href="#"><i class="fa ti-linkedin icon-extra-small tz-icon-color text-dark-gray"></i></a></div>
                                    <div class="display-inline-block margin-five no-margin-tb"><a href="#"><i class="fa ti-pinterest icon-extra-small tz-icon-color text-dark-gray"></i></a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end team member -->
                    <!-- team member -->
                    <div class="col-md-4 col-sm-4 col-xs-12 text-center xs-margin-fifteen-bottom">
                        <div class="team position-relative bg-white tz-background-color">
                            <img alt="" src="<?php echo base_url('assets/frontend/');?>images/team-02.jpg" data-img-size="(W)750px X (H)893px" class="margin-twelve-bottom">
                            <div class="team-details text-center">
                                <div class="team-name padding-twelve-bottom margin-twelve-bottom border-bottom tz-border">
                                    <span class="alt-font font-weight-600 text-dark-gray display-block tz-text">SOMMER CHRISTIAN</span>
                                    <span class="text-small tz-text">CREATIVE DIRECTOR</span>
                                </div>
                                <div class="team-content padding-twelve-bottom">
                                    <div class="display-inline-block margin-five no-margin-tb"><a href="#"><i class="fa ti-facebook icon-extra-small tz-icon-color text-dark-gray"></i></a></div>
                                    <div class="display-inline-block margin-five no-margin-tb"><a href="#"><i class="fa ti-twitter-alt icon-extra-small tz-icon-color text-dark-gray"></i></a></div>
                                    <div class="display-inline-block margin-five no-margin-tb"><a href="#"><i class="fa ti-linkedin icon-extra-small tz-icon-color text-dark-gray"></i></a></div>
                                    <div class="display-inline-block margin-five no-margin-tb"><a href="#"><i class="fa ti-pinterest icon-extra-small tz-icon-color text-dark-gray"></i></a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end team member -->
                    <!-- team member -->
                    <div class="col-md-4 col-sm-4 col-xs-12 text-center xs-margin-fifteen-bottom">
                        <div class="team position-relative bg-white tz-background-color">
                            <img alt="" src="<?php echo base_url('assets/frontend/');?>images/team-03.jpg" data-img-size="(W)750px X (H)893px" class="margin-twelve-bottom">
                            <div class="team-details text-center">
                                <div class="team-name padding-twelve-bottom margin-twelve-bottom border-bottom tz-border">
                                    <span class="alt-font font-weight-600 text-dark-gray display-block tz-text">ANDREW LUPKIN</span>
                                    <span class="text-small tz-text">DEVELOPER HEAD</span>
                                </div>
                                <div class="team-content padding-twelve-bottom">
                                    <div class="display-inline-block margin-five no-margin-tb"><a href="#"><i class="fa ti-facebook icon-extra-small tz-icon-color text-dark-gray"></i></a></div>
                                    <div class="display-inline-block margin-five no-margin-tb"><a href="#"><i class="fa ti-twitter-alt icon-extra-small tz-icon-color text-dark-gray"></i></a></div>
                                    <div class="display-inline-block margin-five no-margin-tb"><a href="#"><i class="fa ti-linkedin icon-extra-small tz-icon-color text-dark-gray"></i></a></div>
                                    <div class="display-inline-block margin-five no-margin-tb"><a href="#"><i class="fa ti-pinterest icon-extra-small tz-icon-color text-dark-gray"></i></a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end team member -->
                </div>
            </div>
        </section>
        <section class="padding-110px-tb bg-light-gray builder-bg xs-padding-60px-tb border-none" id="counter-section6">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                        <!-- timer -->
                        <div id="counter">
                            <div class="col-md-3 col-sm-6 col-xs-12 sm-margin-fifteen-bottom xs-margin-seventeen-bottom">
                                <div class="counter-content">                                          
                                    <span class="timer counter-number title-extra-large sm-title-extra-large-1 alt-font text-dark-gray margin-three-bottom xs-margin-one-half-bottom display-block tz-text font-weight-600" data-to="1500" data-speed="7000">1500</span>
                                    <span class="text-medium sm-text-medium display-block tz-text">Projects Completed</span>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6 col-xs-12 sm-margin-fifteen-bottom xs-margin-seventeen-bottom">
                                <div class="counter-content">                                          
                                    <span class="timer counter-number title-extra-large sm-title-extra-large-1 alt-font text-dark-gray margin-three-bottom xs-margin-one-half-bottom display-block tz-text font-weight-600" data-to="1400" data-speed="7000">1400</span>
                                    <span class="text-medium sm-text-medium display-block tz-text">Happy Clients</span>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6 col-xs-12 xs-margin-seventeen-bottom">
                                <div class="counter-content">                                          
                                    <span class="timer counter-number title-extra-large sm-title-extra-large-1 alt-font text-dark-gray margin-three-bottom xs-margin-one-half-bottom display-block tz-text font-weight-600" data-to="1250" data-speed="7000">1250</span>
                                    <span class="text-medium sm-text-medium display-block tz-text">Cups of Coffee</span>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6 col-xs-12 xs-no-margin-bottom">
                                <div class="counter-content">                                          
                                    <span class="timer counter-number title-extra-large sm-title-extra-large-1 alt-font text-dark-gray margin-three-bottom xs-margin-one-half-bottom display-block tz-text font-weight-600" data-to="1600" data-speed="7000">1600</span>
                                    <span class="text-medium sm-text-medium display-block tz-text">Hours Worked</span>
                                </div>
                            </div>
                        </div>
                        <!-- end timer -->
                    </div>
                </div>
            </div>
        </section>
        <section class="padding-110px-tb title-style6 bg-white builder-bg xs-padding-60px-tb" id="title-section6">
            <div class="container">                    
                <div class="row equalize xs-equalize-auto">
                    <!-- section title -->
                    <div class="col-md-6 col-sm-6 col-xs-12 xs-margin-twenty-seven-bottom display-table" style="">
                        <div class="display-table-cell-vertical-middle">
                            <!-- section title -->
                            <h2 class="alt-font title-extra-large sm-title-large xs-title-large margin-eight-bottom line-height-40 text-light-purple-blue tz-text sm-margin-ten-bottom">Set up your awesome<br>business website quickly.</h2>
                            <!-- end section title -->
                            <div class="text-medium tz-text width-90 sm-width-100"><p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</p></div>
                        </div>
                    </div>
                    <!-- end section title -->
                    <div class="col-md-6 col-sm-6 col-xs-12  display-table" style="">
                        <div class="display-table-cell-vertical-middle">
                            <div class="title-skill md-padding-fifteen sm-padding-nineteen xs-no-padding">
                                <div class="progress-bar-main progress-bar-style1">
                                    <!-- progress bar item -->
                                    <div class="progress-bar-sub">
                                        <div class="progress">
                                            <div style="width: 80%;" aria-valuemax="100" aria-valuemin="0" aria-valuenow="80" role="progressbar" class="progress-bar"></div>
                                        </div>
                                        <div class="progress-name tz-text"><span class="text-black">Working Hours</span></div>
                                    </div>
                                    <!-- end progress bar item -->
                                    <!-- progress bar item -->
                                    <div class="progress-bar-sub">
                                        <div class="progress">
                                            <div style="width: 90%;" aria-valuemax="100" aria-valuemin="0" aria-valuenow="90" role="progressbar" class="progress-bar"></div>
                                        </div>
                                        <div class="progress-name tz-text"><span class="text-black">Awesome Projects</span></div>
                                    </div>
                                    <!-- end progress bar item -->
                                    <!-- progress bar item -->
                                    <div class="progress-bar-sub">
                                        <div class="progress">
                                            <div style="width: 95%;" aria-valuemax="100" aria-valuemin="0" aria-valuenow="95" role="progressbar" class="progress-bar"></div>
                                        </div>
                                        <div class="progress-name tz-text"><span class="text-black">Cups of Coffee</span></div>
                                    </div>
                                    <!-- end progress bar item -->
                                    <!-- progress bar item -->
                                    <div class="progress-bar-sub">
                                        <div class="progress">
                                            <div style="width: 90%;" aria-valuemax="100" aria-valuemin="0" aria-valuenow="90" role="progressbar" class="progress-bar"></div>
                                        </div>
                                        <div class="progress-name no-margin-bottom tz-text"><span class="text-black">Happy Customers</span></div>
                                    </div>
                                    <!-- end progress bar item -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>                    
            </div>
        </section>
        <section class="bg-light-purple-blue builder-bg border-none" id="tab-section6">
            <div class="container-fluid">
                <div class="row equalize">
                    <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 tz-builder-bg-image sm-height-600-px xs-height-400-px cover-background bg-img-five" data-img-size="(W)1000px X (H)800px" style="background: linear-gradient(rgba(0, 0, 0, 0.01), rgba(0, 0, 0, 0.01)) repeat scroll 0% 0%, transparent url('<?php echo base_url('assets/frontend/');?>images/bg-image/hero-bg24.jpg') repeat scroll 0% 0%;"></div>
                    <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 display-table" style="">
                        <div class="display-table-cell-vertical-middle padding-twenty-two md-padding-seven xs-padding-nineteen xs-no-padding-lr">
                            <h2 class="title-extra-large border-bottom-light font-weight-100 text-white xs-title-large padding-nine-bottom margin-nine-bottom tz-text sm-padding-ten-bottom sm-margin-ten-bottom"><span class="font-weight-600">We're small but impressive.</span><br> Experience the power of LeadGen.</h2>                                
                            <div class="tab-style6">
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <!-- tab navigation -->
                                        <ul class="nav nav-tabs nav-tabs-light alt-font text-left margin-ten-bottom">
                                            <li class="active"><a href="#tab_sec1" data-toggle="tab"><span class="tz-text">COMPANY MISSION</span></a></li>
                                            <li><a href="#tab_sec2" data-toggle="tab"><span class="tz-text">WHY CHOOSE US</span></a></li>
                                            <li><a href="#tab_sec3" data-toggle="tab"><span class="tz-text">OUR PROMISE</span></a></li>
                                            <li><a href="#tab_sec4" data-toggle="tab"><span class="tz-text">WHAT WE DO</span></a></li>
                                        </ul>
                                        <!-- tab end navigation -->
                                    </div>
                                </div>                                    
                                <div class="tab-content">
                                    <!-- tab content -->
                                    <div class="tab-pane med-text fade in active" id="tab_sec1">
                                        <div class="row">
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <div class="text-white tz-text"><p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the standard dummy text. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the standard dummy text.</p></div>
                                                <div class="text-white tz-text"><p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the standard dummy text. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p></div>
                                                <a class="btn btn-medium propClone btn-circle bg-white text-light-purple-blue margin-three-top inner-link" href="#testimonials-section14"><span class="tz-text">READ MORE</span><i class="fa fa-angle-right icon-extra-small tz-icon-color"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end tab content -->
                                    <!-- tab content -->
                                    <div class="tab-pane fade in" id="tab_sec2">
                                        <div class="row">
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <div class="text-white tz-text"><p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the standard dummy text. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the standard dummy text.</p></div>
                                                <div class="text-white tz-text"><p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the standard dummy text. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p></div>
                                                <a class="btn btn-medium propClone btn-circle bg-white text-light-purple-blue margin-three-top inner-link" href="#testimonials-section14"><span class="tz-text">READ MORE</span><i class="fa fa-angle-right icon-extra-small tz-icon-color"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end tab content -->
                                    <!-- tab content -->
                                    <div class="tab-pane fade in" id="tab_sec3">
                                        <div class="row">
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <div class="text-white tz-text"><p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the standard dummy text. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the standard dummy text.</p></div>
                                                <div class="text-white tz-text"><p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the standard dummy text. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p></div>
                                                <a class="btn btn-medium propClone btn-circle bg-white text-light-purple-blue margin-three-top inner-link" href="#testimonials-section14"><span class="tz-text">READ MORE</span><i class="fa fa-angle-right icon-extra-small tz-icon-color"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end tab content -->
                                    <!-- tab content -->
                                    <div class="tab-pane fade in" id="tab_sec4">
                                        <div class="row">
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <div class="text-white tz-text"><p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the standard dummy text. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the standard dummy text.</p></div>
                                                <div class="text-white tz-text"><p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the standard dummy text. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p></div>
                                                <a class="btn btn-medium propClone btn-circle bg-white text-light-purple-blue margin-three-top inner-link" href="#testimonials-section14"><span class="tz-text">READ MORE</span><i class="fa fa-angle-right icon-extra-small tz-icon-color"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end tab content -->
                                </div>                                    
                            </div>                                
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section id="testimonials-section14" class="builder-bg testimonial-style1 bg-white padding-110px-tb xs-padding-top-60px">
            <div class="container">
                <div class="row">
                    <div class="testimonial-style3 owl-carousel owl-theme owl-dark-pagination owl-pagination-bottom">
                        <!-- testimonial item -->
                        <div class="item">
                            <div class="col-md-12 col-sm-12 col-xs-12 xs-no-padding-15 text-center">
                                <div class="margin-ten-bottom"><img class="img-round-100" src="<?php echo base_url('assets/frontend/');?>images/avtar-11.jpg" data-img-size="(W)149px X (H)149px" alt="" id="tz-bg-64"/></div>
                                <div class="text-medium margin-six-bottom tz-text width-95 sm-width-100 center-col" id="tz-slider-text94">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since type.</div>
                                <div class="text-small alt-font text-dark-gray tz-text font-weight-600" id="tz-slider-text95">MELISSA SMITH - GOOGLE</div>
                            </div>
                        </div>
                        <!-- end testimonial item -->
                        <!-- testimonial item -->
                        <div class="item">
                            <div class="col-md-12 col-sm-12 col-xs-12 xs-no-padding-15 text-center">
                                <div class="margin-ten-bottom"><img class="img-round-100" src="<?php echo base_url('assets/frontend/');?>images/avtar-10.jpg" data-img-size="(W)149px X (H)149px" alt="" id="tz-bg-65"/></div>
                                <div class="text-medium margin-six-bottom tz-text width-95 sm-width-100 center-col" id="tz-slider-text96">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since type.</div>
                                <div class="text-small alt-font text-dark-gray tz-text font-weight-600" id="tz-slider-text97">JEREMY GIRARD - MICROSOFT</div>
                            </div>
                        </div>
                        <!-- end testimonial item -->
                        <!-- testimonial item -->
                        <div class="item">
                            <div class="col-md-12 col-sm-12 col-xs-12 xs-no-padding-15 text-center">
                                <div class="margin-ten-bottom"><img class="img-round-100" src="<?php echo base_url('assets/frontend/');?>images/avtar-12.jpg" data-img-size="(W)149px X (H)149px" id="tz-bg-66" alt=""/></div>
                                <div class="text-medium margin-six-bottom tz-text width-95 sm-width-100 center-col" id="tz-slider-text98">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since type.</div>
                                <div class="text-small alt-font text-dark-gray tz-text font-weight-600" id="tz-slider-text99">PAUL SCRIVENS - FACEBOOK</div>
                            </div>
                        </div>
                        <!-- end testimonial item -->
                        <!-- testimonial item -->
                        <div class="item">
                            <div class="col-md-12 col-sm-12 col-xs-12 xs-no-padding-15 text-center">
                                <div class="margin-ten-bottom"><img class="img-round-100" src="<?php echo base_url('assets/frontend/');?>images/avtar-13.jpg" data-img-size="(W)149px X (H)149px" id="tz-bg-67" alt=""/></div>
                                <div class="text-medium margin-six-bottom tz-text width-95 sm-width-100 center-col" id="tz-slider-text100">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since type.</div>
                                <div class="text-small alt-font text-dark-gray tz-text font-weight-600" id="tz-slider-text101">NATHAN FORD - GOOGLE</div>
                            </div>
                        </div>
                        <!-- end testimonial item -->
                        <!-- testimonial item -->
                        <div class="item">
                            <div class="col-md-12 col-sm-12 col-xs-12 xs-no-padding-15 text-center">
                                <div class="margin-ten-bottom"><img class="img-round-100" src="<?php echo base_url('assets/frontend/');?>images/avtar-01.jpg" data-img-size="(W)149px X (H)149px" id="tz-bg-68" alt=""/></div>
                                <div class="text-medium margin-six-bottom tz-text width-95 sm-width-100 center-col" id="tz-slider-text102">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since type.</div>
                                <div class="text-small alt-font text-dark-gray tz-text font-weight-600" id="tz-slider-text103">MELISSA SMITH - GOOGLE</div>
                            </div>
                        </div>
                        <!-- end testimonial item -->
                    </div>
                </div>
            </div>
        </section>
        <section class="padding-110px-tb bg-light-gray builder-bg contact-form-style1 xs-padding-60px-tb" id="contact-section9">
            <div class="container">
                <div class="row">
                    <!-- contact form -->
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="padding-eighteen bg-white box-shadow tz-background-color xs-padding-eleven border-radius-8">
                            <h5 class="alt-font text-dark-gray display-block tz-text margin-fifteen-bottom">Ready to Get Started?</h5>
                            <form action="javascript:void(0)" method="post">
                                <input type="text" name="name" data-email="required" id="name" placeholder="* Your Name" class="medium-input border-radius-8">                                    
                                <input type="text" name="email" data-email="required" id="email" placeholder="* Your Email" class="medium-input border-radius-8">                                    
                                <textarea name="comment" id="comment" placeholder="Your Message" class="medium-input border-radius-8"></textarea>                                    
                                <button class="default-submit btn-medium btn-circle btn bg-greenish-blue text-white tz-text" type="submit">SEND MESSAGE</button>                                    
                            </form>
                        </div>
                    </div>
                    <!-- end contact form -->
                    <!-- contact details -->
                    <div class="col-md-6 col-sm-6 col-xs-12 xs-margin-fifteen-top">
                        <div class="padding-eighteen no-padding-top no-padding-bottom xs-no-padding">
                            <h2 class="alt-font text-dark-gray title-large display-block xs-title-extra-large-2 tz-text margin-nine-bottom width-90 md-width-100">Looking For a Excellent Business Idea?</h2>
                            <div class="text-medium tz-text margin-ten-bottom">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the standard dummy text.</div>
                            <a class="btn-medium btn-circle btn border-2-cyan btn-border text-greenish-blue margin-twenty-bottom" href="#"><span class="tz-text">GET DIRECTIONS</span><i class="fa fa-long-arrow-right icon-extra-small tz-icon-color"></i></a>
                            <div class="contact-details padding-eighteen-top border-top">                                
                                <h6 class="alt-font text-dark-gray tz-text text-large margin-five-bottom">Our Headquarters</h6>
                                <p class="text-medium tz-text"><?php echo $address;?></p>
                                <p class="text-medium tz-text no-margin-bottom"><?php echo $phone;?></p>
                                <a href="mailto:no-reply@domain.com" class="text-dark-gray text-decoration-underline text-medium tz-text no-margin-bottom"><?php echo $email;?></a>
                            </div>
                        </div>
                    </div>
                    <!-- end contact details -->
                </div>
            </div>
        </section> 
        <footer id="footer-section8" class="bg-white builder-bg footer-style8 padding-60px-tb xs-padding-40px-tb">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 col-sm-12 col-xs-12 sm-text-center sm-margin-five-bottom ">
                        <!-- logo -->
                        <a class="margin-eight-bottom display-inline-block inner-link" href="#home"><img src="<?php echo base_url($this->general->get_system_var('logo'));?>" data-img-size="(W)163px X (H)39px" alt=""></a>
                        <!-- end logo -->
                        <div class="tz-text width-80 sm-width-100"><p class="no-margin-bottom">We've been crafting beautiful websites, launching stunning brands and making clients happy for years. With our prestigious craftsmanship.</p></div>
                    </div>
                    <!-- links -->
                    <div class="col-md-2 col-sm-4 col-xs-12 xs-margin-nine-bottom xs-text-center">
                        <ul class="links">
                            <li class="text-medium margin-seven-bottom font-weight-600 text-dark-gray tz-text xs-margin-one-half-bottom">Company</li>
                            <li><a class="tz-text text-medium-gray inner-link" href="#content-section13">About Us</a></li>
                            <li><a class="tz-text text-medium-gray inner-link" href="#testimonials-section14">Testimonials</a></li>
                            <li><a class="tz-text text-medium-gray inner-link" href="#contact-section9">FAQ's</a></li>
                        </ul>
                    </div>
                    <div class="col-md-2 col-sm-4 col-xs-12 xs-margin-nine-bottom xs-text-center">
                        <ul class="links">
                            <li class="text-medium margin-seven-bottom font-weight-600 text-dark-gray tz-text xs-margin-one-half-bottom">Useful Links</li>
                            <li><a class="tz-text text-medium-gray inner-link" href="#content-section36">Our process</a></li>
                            <li><a class="tz-text text-medium-gray inner-link" href="#team-section9">People</a></li>
                            <li><a class="tz-text text-medium-gray inner-link" href="#clients-section2">Client</a></li>
                        </ul>
                    </div>
                    <div class="col-md-2 col-sm-4 col-xs-12 xs-margin-nine-bottom xs-text-center">
                        <ul class="links">
                            <li class="text-medium margin-seven-bottom font-weight-600 text-dark-gray tz-text xs-margin-one-half-bottom">Follow Us</li>
                            <li><a class="tz-text text-medium-gray inner-link" href="#">Facebook</a></li>
                            <li><a class="tz-text text-medium-gray inner-link" href="#">Twitter</a></li>
                            <li><a class="tz-text text-medium-gray inner-link" href="#">Google Plus</a></li>
                        </ul>
                    </div>
                    <!-- end links -->
                </div>
                <div class="row equalize">
                    <div class="border-top margin-five-top padding-five-top tz-border">
                        <div class="col-md-6 col-sm-6 col-xs-12 display-table xs-text-center xs-margin-nine-bottom">
                            <div class="display-table-cell-vertical-middle">
                                <span class="tz-text text-small">© 2016 LeadGen is Proudly Powered By <a class="text-light-gray2" href="http://www.themezaa.com/">ThemeZaa.</a></span>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12 display-table text-right xs-text-center">
                            <div class="display-table-cell-vertical-middle social social-icon-color icon-extra-small no-margin">
                                <?php echo $this->general->get_social_media('facebook', 'fa fa-facebook tz-icon-color', 'margin-eight-right');?>
                                <?php echo $this->general->get_social_media('twitter', 'fa fa-twitter tz-icon-color', 'margin-eight-right');?>
                                <?php echo $this->general->get_social_media('google_plus', 'fa fa-google-plus tz-icon-color', 'margin-eight-right');?>
								<?php echo $this->general->get_social_media('pinterest', 'fa fa-pinterest tz-icon-color', 'margin-eight-right');?>
								<?php echo $this->general->get_social_media('linkedin', 'fa fa-linkedin tz-icon-color', 'margin-eight-right');?>
								<?php echo $this->general->get_social_media('youtube', 'fa fa-youtube tz-icon-color', 'margin-eight-right');?>
								<?php echo $this->general->get_social_media('instagram', 'fa fa-instagram tz-icon-color', 'margin-eight-right');?>
								
								<?php echo $this->general->get_social_media('delicious', 'fa fa-delicious tz-icon-color', 'margin-eight-right');?>
								<?php echo $this->general->get_social_media('dribbble', 'fa fa-dribbble tz-icon-color', 'margin-eight-right');?>
								<?php echo $this->general->get_social_media('foursquare', 'fa fa-foursquare tz-icon-color', 'margin-eight-right');?>
								<?php echo $this->general->get_social_media('gg-circle', 'fa fa-gg-circle tz-icon-color', 'margin-eight-right');?>
								<?php echo $this->general->get_social_media('forumbee', 'fa fa-forumbee tz-icon-color', 'margin-eight-right');?>
								<?php echo $this->general->get_social_media('qq', 'fa fa-qq tz-icon-color', 'margin-eight-right');?>
								<?php echo $this->general->get_social_media('snapchat', 'fa fa-snapchat tz-icon-color', 'margin-eight-right');?>
								<?php echo $this->general->get_social_media('tumblr', 'fa fa-tumblr tz-icon-color', 'margin-eight-right');?>
								<?php echo $this->general->get_social_media('twitch', 'fa fa-twitch tz-icon-color', 'margin-eight-right');?>
								<?php echo $this->general->get_social_media('vk', 'fa fa-vk tz-icon-color', 'margin-eight-right');?>
								<?php echo $this->general->get_social_media('whatsapp', 'fa fa-whatsapp tz-icon-color', 'margin-eight-right');?>
								<?php echo $this->general->get_social_media('vimeo', 'fa fa-vimeo tz-icon-color', 'margin-eight-right');?>
								
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>

        <!-- javascript libraries -->
        <script type="text/javascript" src="<?php echo base_url('assets/frontend/');?>js/jquery.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/frontend/');?>js/jquery.appear.js"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/frontend/');?>js/smooth-scroll.js"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/frontend/');?>js/bootstrap.min.js"></script>
        <!-- wow animation -->
        <script type="text/javascript" src="<?php echo base_url('assets/frontend/');?>js/wow.min.js"></script>
        <!-- owl carousel -->
        <script type="text/javascript" src="<?php echo base_url('assets/frontend/');?>js/owl.carousel.min.js"></script>        
        <!-- images loaded -->
        <script type="text/javascript" src="<?php echo base_url('assets/frontend/');?>js/imagesloaded.pkgd.min.js"></script>
        <!-- isotope -->
        <script type="text/javascript" src="<?php echo base_url('assets/frontend/');?>js/jquery.isotope.min.js"></script> 
        <!-- magnific popup -->
        <script type="text/javascript" src="<?php echo base_url('assets/frontend/');?>js/jquery.magnific-popup.min.js"></script>
        <!-- navigation -->
        <script type="text/javascript" src="<?php echo base_url('assets/frontend/');?>js/jquery.nav.js"></script>
        <!-- equalize -->
        <script type="text/javascript" src="<?php echo base_url('assets/frontend/');?>js/equalize.min.js"></script>
        <!-- fit videos -->
        <script type="text/javascript" src="<?php echo base_url('assets/frontend/');?>js/jquery.fitvids.js"></script>
        <!-- number counter -->
        <script type="text/javascript" src="<?php echo base_url('assets/frontend/');?>js/jquery.countTo.js"></script>
        <!-- time counter  -->
        <script type="text/javascript" src="<?php echo base_url('assets/frontend/');?>js/counter.js"></script>
        <!-- twitter Fetcher  -->
        <script type="text/javascript" src="<?php echo base_url('assets/frontend/');?>js/twitterFetcher_min.js"></script>
        <!-- main -->
        <script type="text/javascript" src="<?php echo base_url('assets/frontend/');?>js/main.js"></script>
       
    </body>

</html>