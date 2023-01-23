<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="description" content="">
      <title>Intelligent Canal Systems</title>
      <!-- Bootstrap -->
      <link rel="stylesheet" href="<?php echo base_url(); ?>assets/operators/css/bootstrap.min.css">
      <link rel="stylesheet" href="<?php echo base_url(); ?>assets/operators/css/owl.carousel.css">
      <link rel="stylesheet" href="<?php echo base_url(); ?>assets/operators/css/owl.theme.default.min.css">
      <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/operators/css/style.css">
      <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/operators/css/custom.css">
      <style>
      .alert-dismissible {
         position: absolute;
         right: 0;
      }
      </style>
   </head>
   <body>
      <!-- ---start-wrapper-area-- -->
      <div class="wrapper-area">
         <!-- ---start-header-area-- -->
         <header class="header-area">
            <div class="container">
               <nav class="navbar navbar-custum new-navbar navbar-fixed-top">
                  <div class="row">
                     <!-- Brand and toggle get grouped for better mobile display -->
                     <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="#"><img src="<?php echo base_url(); ?>assets/operators/img/new-logo.png" alt="brand-logo" width="200px"></a>
                     </div>
                     <!-- Collect the nav links, forms, and other content for toggling -->
                     <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                        <ul class="nav navbar-nav navbar-right">
                           <li class="nav-item active"><a href="<?php echo base_url('Operator'); ?>">Home</a></li>
                           <!-- submenu start-->
                           <!-- submenu start-->
                           <li class="nav-item dropdown">
                              <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> System Information <span class="caret"></span> </a>
                              <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                 <li><a class="dropdown-item" href="<?php echo base_url('Operator/admin_user_config'); ?>">Admin User Config</a></li>
                                 <li class="dropdown-submenu">
                                    <a class="dropdown-item dropdown-toggle">System Reports</a>
                                    <ul class="dropdown-menu">
                                       <li><a class="dropdown-item" href="<?php echo base_url('Operator/water_usage_report'); ?>">Water Usage Report</a></li>
                                       <li><a class="dropdown-item" href="<?php echo base_url('Operator/system_total_report'); ?>">System total Reports</a></li>
                                    </ul>
                                 </li>
                                 <li><a class="dropdown-item" href="<?php echo base_url('Operator/transfers'); ?>">Transfers</a></li>
                              </ul>
                           </li>
                           <!-- submenu start-->
                           <li class="nav-item dropdown">
                              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Water Users <span class="caret"></span> </a>
                              <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                 <li><a class="dropdown-item" href="<?php echo base_url('Operator/usage'); ?>">Usage</a></li>
                                 <li><a class="dropdown-item" href="<?php echo base_url('Operator/user_details'); ?>">User Details</a></li>
                                 <li><a class="dropdown-item" href="<?php echo base_url('Operator/client_usage_report'); ?>">Client Usage Report</a></li>
                              </ul>
                           </li>
                           <li class="nav-item"><a href="<?php echo base_url('Operator/contact'); ?>">Contact</a></li>
                           <li class="nav-item sign-btn"><a href="#"  data-toggle="modal" data-target="#signout">Signout</a></li>
                        </ul>
                     </div>
                  </div>
                  <!-- /.navbar-collapse -->
               </nav>
               <!-- Modal start -->
               <div class="modal fade" id="signout" role="dialog">
                  <div class="modal-dialog modal-sm">
                     <div class="modal-content">
                        <div class="modal-header">
                           <button type="button" class="close" data-dismiss="modal">&times;</button>
                           <h4 class="modal-title">Sign-Out</h4>
                        </div>
                        <div class="modal-body">
                           <p> Are you sure you want to Sign-Out?</p>
                        </div>
                        <div class="modal-footer">
                           <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                           <a href="<?php echo base_url('Operator/logout'); ?>" class="btn btn-danger" >Sign-Out</a>
                        </div>
                     </div>
                  </div>
               </div>
               <!-- Modal end -->
               <div class="bg-header-area">
                  <div class="row">
                     <div class="col-xs-12 col-sm-7 col-md-5 col-lg-7">
                        <div class="left-banner-tax">
                           <h3>Welcome to the Irrigator Portal</h3>
                          <!--  <h3>Or Artificial Waterways&#44; For Water </h3>
                           <h3>Conveyance, Or To Service</h3>
                           <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </p> -->
                        </div>
                     </div>
                     <div class="col-md-5 col-sm-5 col-xs-12">
                        <div class="right-mobile-area">
                           <div class="mobile-img">
                              <img src="<?php echo base_url(); ?>assets/operators/img/ics-phone.png">
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </header>
         <!-- ---end-header-area-- -->
         <div class="bg-all-box">
            <!-- ---start-second-area-- -->
            <!-- <section class="sign-box-area">
               <div class="container">
                  <div class="row">
                     <div class="col-md-4 col-sm-4 col-xs-12">
                        <div class="box-block">
                           <div class="icon-block">
                              <img src="<?php echo base_url(); ?>assets/operators/img/icon-1.png">
                           </div>
                           <div class="taxt-block">
                              <h4>Sign In To Your Account</h4>
                              <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do</p>
                           </div>
                        </div>
                     </div>
                     <div class="col-md-4 col-sm-4 col-xs-12">
                        <div class="box-block">
                           <div class="icon-block">
                              <img src="<?php echo base_url(); ?>assets/operators/img/icon-2.png">
                           </div>
                           <div class="taxt-block">
                              <h4>Add Reading Anytime</h4>
                              <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do dolor sit amet, consectetur</p>
                           </div>
                           <div class="learn-btn">
                              <a href="#">Learn More	&#8594; <span class="right-arrow"><i class="fa fa-long-arrow-right"></i></span></a>
                           </div>
                        </div>
                     </div>
                     <div class="col-md-4 col-sm-4 col-xs-12">
                        <div class="box-block">
                           <div class="icon-block">
                              <img src="<?php echo base_url(); ?>assets/operators/img/icon-3.png">
                           </div>
                           <div class="taxt-block">
                              <h4>Edit Whenever You Want</h4>
                              <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do</p>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </section> -->
            <!-- ---end-second-area-- -->
            <!-- ---start-third-area-- -->
            <section class="proposal-area">
               <div class="container-fluid">
                  <div class="row proposal-all-block">
                     <div class="col-md-6 col-sm-6 col-xs-12 proposal-left-tax">
                        <div class="proposal-tax-block">
                           <div class="proposal-taxes">
                              <!-- <h3>App Proposal</h3>
                              <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English.</p>
                              <p>It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p> -->
                           </div>
                           <div class="landing-all-btn">
                              <!-- <a href="#">Learn More</a> -->
                           </div>
                        </div>
                     </div>
                     <div class="col-md-6 col-sm-6 col-xs-12 proposal-right-img">
                        <div class="proposal-img-block">
                           <div class="proposal-img">
                              <img src="<?php echo base_url(); ?>assets/operators/image/2.jpg">
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </section>
            <!-- ---end-third-area-- -->
            <!-- ---start-fourth-area-- -->
            <section class="everything-area">
               <div class="container">
                  <div class="row everything-all-block">
                     <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="everything-left-block">
                           <div class="everything-img">
                              <div class="img-every">
                                 <img src="<?php echo base_url(); ?>assets/operators/image/3.JPG">
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="col-md-6 col-sm-6 col-xs-12 everything-left-tax">
                        <div class="everything-right-block">
                           <div class="proposal-taxes">
                              <!-- <h3>See Everythings Whats <br> Going On Your Fingure Tips</h3>
                              <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English.</p>
                              <p>It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p> -->
                           </div>
                           <div class="landing-all-btn">
                              <!-- <a href="#">Learn More</a> -->
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </section>
            <!-- ---end-fourth-area-- -->
         </div>
         <!-- ---start-five-area-- -->
         <section class="everydrop-area">
            <div class="container">
               <div class="row everydrop-all-block">
                  <div class="col-md-6 col-sm-6 col-xs-12 everydrop-left-tax">
                     <div class="everydrop-right-block">
                        <div class="proposal-taxes">
                           <!-- <h3>You Know All About Every Drop</h3>
                           <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English.</p>
                           <p>It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p> -->
                        </div>
                        <div class="landing-all-btn">
                           <!-- <a href="#">Learn More</a> -->
                        </div>
                     </div>
                  </div>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                     <div class="everydrop-left-block">
                        <div class="everydrop-img">
                           <div class="img-everydrop">
                              <img src="<?php echo base_url(); ?>assets/operators/image/4.jpg" width="100%">
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </section>
         <!-- ---end-five-area-- -->
         <!-- ---start-six-area-- -->
         <!-- <section class="mobile-screen-area">
            <div class="mobile-screen-title">
               <h4> Modern & Trendy Design </h4>
            </div>
            <div class="container">
               <div class="owl-carousel owl-theme">
                  <div class="item"><img src="<?php echo base_url(); ?>assets/operators/image/carousel1.JPG" alt=""></div>
                  <div class="item"><img src="<?php echo base_url(); ?>assets/operators/image/carousel2.JPG" alt=""></div>
                  <div class="item"><img src="<?php echo base_url(); ?>assets/operators/image/carousel3.JPG" alt=""></div>
                  <div class="item"><img src="<?php echo base_url(); ?>assets/operators/image/carousel4.jpg" alt=""></div>
                  <div class="item"><img src="<?php echo base_url(); ?>assets/operators/image/carousel5.JPG" alt=""></div>
               </div>
            </div>
         </section> -->
         <!-- ---end-six-area-- -->

         <!-- Footer -->
         <footer class="footer-bg">
            <img src="<?php echo base_url(); ?>assets/operators/img/modified.png" alt="" width="100%">
            <div class="footer-icon">
               <a href="#">
               Privacy Policy | Terms Of Service
               </a>
               <a href="#">
               <img src="<?php echo base_url(); ?>assets/operators/img/social_icons.png" alt="social_icons" width="100%">
               </a>
               <!-- Copyright -->
               <a href="#">
               info@intelligentcanals.com
               </a>
            </div>
         </footer>
         <!-- Footer -->
         <div class="footer-bottom">
            <p>  Copyright @ics 2020.All rights reserved</p>
         </div>
      </div>
      <!-- ---end-wrapper-area-- -->

      <script src="<?php echo base_url(); ?>assets/operators/js/jquery.min.js"></script>
      <script src="<?php echo base_url(); ?>assets/operators/js/jquery-1.12.4.js"></script>
      <script src="<?php echo base_url(); ?>assets/operators/js/owl.carousel.js"></script>
      <script src="<?php echo base_url(); ?>assets/operators/js/bootstrap.min.js"></script>
      <script src="<?php echo base_url(); ?>assets/operators/js/main.js"></script>
      <script type="text/javascript">
         var $owl = $('.owl-carousel');

         $owl.children().each( function( index ) {
           $(this).attr( 'data-position', index ); // NB: .attr() instead of .data()
         });

         $owl.owlCarousel({
           autoplay:true,
           autoplayTimeout:3000,

           autoplayHoverPause:true,
           center: true,
           loop: true,
           items: 5,
           dots:true,
           responsive:{
                 0:{
                     items:1
                 },
                 600:{
                     items:3
                 },
                 1000:{
                     items:5
                 }
             }
         });

         $(document).on('click', '.owl-item>div', function() {
           // see https://owlcarousel2.github.io/OwlCarousel2/docs/api-events.html#to-owl-carousel
           var $speed = 300;  // in ms
           $owl.trigger('to.owl.carousel', [$(this).data( 'position' ), $speed] );
         });



      </script>
   </body>
</html>
