<!DOCTYPE html>
<html lang="en">

<head>

    <!-- SITE TITTLE -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="<?php echo csrf_token(); ?>" content="<?php echo csrf_hash(); ?>" class="csrf" />

    <title><?php echo $this->renderSection('title'); ?> <?php echo ' - ' . env('APP_NAME'); ?></title>

    <!-- PLUGINS CSS STYLE -->

    <!-- Bootstrap -->
    <link href="<?php echo site_url('web/'); ?>plugins/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="<?php echo site_url('web/'); ?>plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- Owl Carousel -->
    <link href="<?php echo site_url('web/'); ?>plugins/slick-carousel/slick/slick.css" rel="stylesheet">
    <link href="<?php echo site_url('web/'); ?>plugins/slick-carousel/slick/slick-theme.css" rel="stylesheet">
    <!-- Fancy Box -->
    <link href="<?php echo site_url('web/'); ?>plugins/fancybox/jquery.fancybox.pack.css" rel="stylesheet">
    <link href="<?php echo site_url('web/'); ?>plugins/jquery-nice-select/css/nice-select.css" rel="stylesheet">
    <link href="<?php echo site_url('web/'); ?>plugins/seiyria-bootstrap-slider/dist/css/bootstrap-slider.min.css" rel="stylesheet">
    <!-- CUSTOM CSS -->
    <link href="<?php echo site_url('web/'); ?>css/style.css" rel="stylesheet">

    <!-- FAVICON -->
    <link href="<?php echo site_url('web/'); ?>img/favicon.png" rel="shortcut icon">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

    <link href="<?php echo site_url('manager_assets/toastr/toastr.min.css'); ?>" rel="stylesheet" />

    <style>
        .btn-sm {
            padding: 6px 20px;
            font-size: .875rem;
            line-height: 1.5;
            border-radius: .2rem;
        }

    .img-custom{
        max-width: 50%;
       
    }
    </style>

    <?php echo $this->renderSection('styles'); ?>

</head>

<body class="body-wrapper">

    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <nav class="navbar navbar-expand-lg  navigation">
                        <a class="navbar-brand" href="index.html">
                            <img src="<?php echo site_url('web/'); ?>images/logo-x.png" alt="">
                        </a>
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav ml-auto main-nav ">
                                
                            <li class="nav-item active">
                                    <a class="nav-link" href="<?php echo route_to('web.home'); ?>">Home</a>
                                </li>
                                <li class="nav-item ">
                                    <a class="nav-link" href="<?php echo route_to('pricing'); ?>">Nossos Planos</a>
                                </li>
                                <?php if(auth()->check()) : ?>

                                    <?php if(!auth()->user()->isSuperadmin()):?>

                                        <li class="nav-item">
                                            <a class="nav-link" href="<?php echo route_to('dashboard'); ?>">Dashboard</a>
                                        </li>
                                    <?php else : ?>
                                            <li class="nav-item">
                                            <a class="nav-link" href="<?php echo route_to('manager'); ?>">Manager</a>
                                            </li>
                                    <?php endif ; ?>
                                    
                                <?php endif ; ?>

                                <li class="nav-item dropdown dropdown-slide">
                                    <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Pages <span><i class="fa fa-angle-down"></i></span>
                                    </a>
                                    <!-- Dropdown list -->
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="category.html">Category</a>
                                        <a class="dropdown-item" href="single.html">Single Page</a>
                                        <a class="dropdown-item" href="store-single.html">Store Single</a>
                                        <a class="dropdown-item" href="dashboard.html">Dashboard</a>
                                        <a class="dropdown-item" href="user-profile.html">User Profile</a>
                                        <a class="dropdown-item" href="submit-coupon.html">Submit Coupon</a>
                                        <a class="dropdown-item" href="blog.html">Blog</a>
                                        <a class="dropdown-item" href="single-blog.html">Single Post</a>
                                    </div>
                                </li>
                                <li class="nav-item dropdown dropdown-slide">
                                    <a class="nav-link dropdown-toggle" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <?php echo $language; ?> <span><i class="fa fa-angle-down"></i></span>
                                    </a>
                                    <!-- Dropdown list -->
                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="<?php echo $urls->url_en ; ?>">English</a>
                                        <a class="dropdown-item" href="<?php echo $urls->url_es ; ?>">Españhol</a>
                                        <a class="dropdown-item" href="<?php echo $urls->url_pt_br ; ?>">Português Brasil</a>
                                        
                                    </div>
                                </li>
                            </ul>
                            <ul class="navbar-nav ml-auto mt-10">
                            <?php if(!auth()->check()) : ?>
                                  
                                  <li class="nav-item">
                                      <a class="nav-link login-button" href="<?php echo route_to('login'); ?>">Entrar</a>
                                  </li>
                                  <li class="nav-item">
                                      <a class="nav-link login-button" href="<?php echo route_to('register'); ?>">Criar Conta</a>
                                  </li>
                                  
                              <?php endif ; ?>
                              <li class="nav-item">
                                    <a class="nav-link add-button" href="<?php echo route_to('dashboard'); ?>"><i class="fa fa-plus-circle"></i> Criar Anúncio</a>
                                </li>
                            </ul>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </section>

    <section class="page-search">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<!-- Advance Search -->
				<div class="advance-search">
					<form>
						<div class="form-row">
							<div class="form-group col-md-4">
								<input type="text" class="form-control" id="inputtext4" placeholder="What are you looking for">
							</div>
							<div class="form-group col-md-3">
								<input type="text" class="form-control" id="inputCategory4" placeholder="Category">
							</div>
							<div class="form-group col-md-3">
								<input type="text" class="form-control" id="inputLocation4" placeholder="Location">
							</div>
							<div class="form-group col-md-2">
								
								<button type="submit" class="btn btn-primary">Search Now</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</section>
   
    <?php echo $this->include('Dashboard/Layout/_session_messages'); ?>

    <?php echo $this->renderSection('content'); ?>

    <!--============================
=            Footer            =
=============================-->

    <footer class="footer section section-sm">
        <!-- Container Start -->
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-7 offset-md-1 offset-lg-0">
                    <!-- About -->
                    <div class="block about">
                        <!-- footer logo -->
                        <img src="<?php echo site_url('web/'); ?>images/logo-f.png" alt="">
                        <!-- description -->
                        <p class="alt-color">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                    </div>
                </div>
                <!-- Link list -->
                <div class="col-lg-2 offset-lg-1 col-md-3">
                    <div class="block">
                        <h4>Site Pages</h4>
                        <ul>
                            <li><a href="#">Boston</a></li>
                            <li><a href="#">How It works</a></li>
                            <li><a href="#">Deals & Coupons</a></li>
                            <li><a href="#">Articls & Tips</a></li>
                            <li><a href="#">Terms of Services</a></li>
                        </ul>
                    </div>
                </div>
                <!-- Link list -->
                <div class="col-lg-2 col-md-3 offset-md-1 offset-lg-0">
                    <div class="block">
                        <h4>Admin Pages</h4>
                        <ul>
                            <li><a href="#">Boston</a></li>
                            <li><a href="#">How It works</a></li>
                            <li><a href="#">Deals & Coupons</a></li>
                            <li><a href="#">Articls & Tips</a></li>
                            <li><a href="#">Terms of Services</a></li>
                        </ul>
                    </div>
                </div>
                <!-- Promotion -->
                <div class="col-lg-4 col-md-7">
                    <!-- App promotion -->
                    <div class="block-2 app-promotion">
                        <a href="">
                            <!-- Icon -->
                            <img src="<?php echo site_url('web/'); ?>images/footer/phone-icon.png" alt="mobile-icon">
                        </a>
                        <p>Get the Dealsy Mobile App and Save more</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- Container End -->
    </footer>
    <!-- Footer Bottom -->
    <footer class="footer-bottom">
        <!-- Container Start -->
        <div class="container">
            <div class="row">
                <div class="col-sm-6 col-12">
                    <!-- Copyright -->
                    <div class="copyright">
                        <p>Copyright © 2016. All Rights Reserved</p>. Downloaded from <a href="https://themeslab.org/" target="_blank">Themeslab</a>
                    </div>
                </div>
                <div class="col-sm-6 col-12">
                    <!-- Social Icons -->
                    <ul class="social-media-icons text-right">
                        <li><a class="fa fa-facebook" href=""></a></li>
                        <li><a class="fa fa-twitter" href=""></a></li>
                        <li><a class="fa fa-pinterest-p" href=""></a></li>
                        <li><a class="fa fa-vimeo" href=""></a></li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- Container End -->
        <!-- To Top -->
        <div class="top-to">
            <a id="top" class="" href=""><i class="fa fa-angle-up"></i></a>
        </div>
    </footer>

    <!-- JAVASCRIPTS
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="<?php //echo site_url('web/');
                    ?>plugins/jquery-ui/jquery-ui.min.js"></script>
    <script src="<?php // echo site_url('web/'); 
                    ?>plugins/tether/js/tether.min.js"></script>
    <script src="<?php //  echo site_url('web/'); 
                    ?>plugins/raty/jquery.raty-fa.js"></script>
    <script src="<?php //echo site_url('web/');
                    ?>plugins/jquery-nice-select/js/jquery.nice-select.min.js"></script> 
    <script src="<?php //echo site_url('web/');
                    ?>plugins/seiyria-bootstrap-slider/dist/bootstrap-slider.min.js"></script> 
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCC72vZw-6tGqFyRhhg5CkF2fqfILn2Tsw"></script>-->

    <script src="<?php echo site_url('web/'); ?>plugins/jquery/jquery.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js" integrity="sha256-lSjKY0/srUM9BE3dPm+c4fBo1dky2v27Gdjm2uoZaL0=" crossorigin="anonymous"></script>
    <script src="<?php echo site_url('web/'); ?>plugins/slick-carousel/slick/slick.min.js"></script>
    <script src="<?php echo site_url('web/'); ?>plugins/fancybox/jquery.fancybox.pack.js"></script>
    <script src="<?php echo site_url('web/'); ?>plugins/bootstrap/dist/js/popper.min.js"></script>
    <script src="<?php echo site_url('web/'); ?>plugins/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="<?php echo site_url('web/'); ?>plugins/smoothscroll/SmoothScroll.min.js"></script>
    <script src="<?php echo site_url('web/'); ?>js/scripts.js"></script>

    <script src="<?php echo site_url('manager_assets/'); ?>toastr/toastr.min.js"></script>

    <script src="<?php echo site_url('web/loadingoverlay/loadingoverlay.min.js'); ?>"></script>
    <script>
        $(document).ready(function(){

           $('.btn-gn').on('click', function(){ 
        // .btn-gn é onde informanos a class do botao a ser clicado para disparar o evento LoaderOverlay
           
            $.LoadingOverlay("show",{
                background : "rgba(165, 190, 100, 0.5)"
            });
           });

        });
               
    </script>

    <?php echo $this->renderSection('scripts'); ?>

</body>

</html>