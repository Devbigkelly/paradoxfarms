<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="description" content="<?php echo $this->general->get_system_var('meta_description');?>">
  <meta name="keywords" content="<?php echo $this->general->get_system_var('meta_tags');?>">
  <meta name="author" content="<?php echo $system_name;?>">
  <meta property="og:title" content="<?php echo $system_name;?>">
  <meta property="og:description" content="<?php echo $this->general->get_system_var('meta_description');?>">
  <meta property="og:image" content="<?php echo base_url('assets/preview.png');?>">
  <meta property="og:url" content="<?php echo base_url();?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo $title;?></title>
  <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/backend/');?>plugins/toastr/toastr.min.css">
  <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/dashboard/');?>css/app.css">
  
  
</head>
 <body class="login">
        <div class="container sm:px-10">
            <div class="block xl:grid grid-cols-2 gap-4">
                <!-- BEGIN: Login Info -->
                <div class="hidden xl:flex flex-col min-h-screen">
                    <a href="#" class="-intro-x flex items-center pt-5">
                        <img alt="Midone - HTML Admin Template" class="w-6" src="dist/images/logo.svg">
                        <span class="text-white text-lg ml-3"> Rubick </span> 
                    </a>
                    <div class="my-auto">
                        <img alt="Midone - HTML Admin Template" class="-intro-x w-1/2 -mt-16" src="dist/images/illustration.svg">
                        <div class="-intro-x text-white font-medium text-4xl leading-tight mt-10">
                            A few more clicks to 
                            <br>
                            sign in to your account.
                        </div>
                        <div class="-intro-x mt-5 text-lg text-white text-opacity-70 dark:text-slate-400">Manage all your e-commerce accounts in one place</div>
                    </div>
                </div>
                <!-- END: Login Info -->
                <!-- BEGIN: Login Form -->
                <div class="h-screen xl:h-auto flex py-5 xl:py-0 my-10 xl:my-0">
                    <div class="my-auto mx-auto xl:ml-20 bg-white dark:bg-darkmode-600 xl:bg-transparent px-5 sm:px-8 py-8 xl:p-0 rounded-md shadow-md xl:shadow-none w-full sm:w-3/4 lg:w-2/4 xl:w-auto">
                        <h2 class="intro-x font-bold text-2xl xl:text-3xl text-center xl:text-left">
                            Sign In
                        </h2>
                        <div class="intro-x mt-2 text-slate-400 xl:hidden text-center">A few more clicks to sign in to your account. Manage all your e-commerce accounts in one place</div>
                        <div class="intro-x mt-8">
                            <input type="text" class="intro-x login__input form-control py-3 px-4 block" placeholder="Email">
                            <input type="password" class="intro-x login__input form-control py-3 px-4 block mt-4" placeholder="Password">
                        </div>
                        <div class="intro-x flex text-slate-600 dark:text-slate-500 text-xs sm:text-sm mt-4">
                            <div class="flex items-center mr-auto">
                                <input id="remember-me" type="checkbox" class="form-check-input border mr-2">
                                <label class="cursor-pointer select-none" for="remember-me">Remember me</label>
                            </div>
                            <a href="#">Forgot Password?</a> 
                        </div>
                        <div class="intro-x mt-5 xl:mt-8 text-center xl:text-left">
                            <button class="btn btn-primary py-3 px-4 w-full xl:w-32 xl:mr-3 align-top">Login</button>
                            <button class="btn btn-outline-secondary py-3 px-4 w-full xl:w-32 mt-3 xl:mt-0 align-top">Register</button>
                        </div>
                        <div class="intro-x mt-10 xl:mt-24 text-slate-600 dark:text-slate-500 text-center xl:text-left"> By signin up, you agree to our <a class="text-primary dark:text-slate-200" href="#">Terms and Conditions</a> & <a class="text-primary dark:text-slate-200" href="#">Privacy Policy</a> </div>
                    </div>
                </div>
                <!-- END: Login Form -->
            </div>
        </div>
        <!-- BEGIN: Dark Mode Switcher-->
        <div data-url="login-dark-login.html" class="dark-mode-switcher cursor-pointer shadow-md fixed bottom-0 right-0 box border rounded-full w-40 h-12 flex items-center justify-center z-50 mb-10 mr-10">
            <div class="mr-4 text-slate-600 dark:text-slate-200">Dark Mode</div>
            <div class="dark-mode-switcher__toggle border"></div>
        </div>
        <!-- END: Dark Mode Switcher-->
        


<!-- jQuery -->
<script src="<?php echo base_url('assets/backend');?>/plugins/jquery/jquery.min.js"></script>
<script src="<?php echo base_url('assets/backend/');?>plugins/toastr/toastr.min.js"></script>
<?php $error=$this->session->flashdata('error');
	if ($error == TRUE){?>
	<script>
	$(document).ready(function(){
		toastr.error("<?php echo $error;?>");
	});
	</script>
	<?php }?>
	<?php $success=$this->session->flashdata('success');
	if ($success == TRUE){?>
	<script>
	$(document).ready(function(){
		toastr.success("<?php echo $success;?>");
	});
	</script>
	<?php }?>
	<?php $info=$this->session->flashdata('info');
	if ($info == TRUE){?>
	<script>
	$(document).ready(function(){
		toastr.info("<?php echo $info;?>");
	});
	</script>
	<?php }?>
	<?php $warning=$this->session->flashdata('warning');
	if ($warning == TRUE){?>
	<script>
	$(document).ready(function(){
		toastr.warning("<?php echo $warning;?>");
	});
	</script>
	<?php }?>
</body>
</html>

