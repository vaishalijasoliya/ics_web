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
                           <li class="nav-item active"><a href="<?php echo base_url('User'); ?>">Home</a></li>
                           <!-- submenu start-->
                           <li class="nav-item dropdown">
                              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Orders <span class="caret"></span> </a>
                              <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                 <li><a class="dropdown-item" href="<?php echo base_url('User/add_water_right'); ?>">Add Water Order</a></li>
                                 <li><a class="dropdown-item" href="<?php echo base_url('User/history_orders'); ?>">Orders History</a></li>
                                 <li><a class="dropdown-item" href="<?php echo base_url('User/upcoming_orders'); ?>">Upcoming/Current orders</a></li>
                              </ul>
                           </li>
                           <!-- submenu start-->
                           <li class="nav-item dropdown">
                              <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Account <span class="caret"></span> </a>
                              <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">

                                 <li><a class="dropdown-item" href="<?php echo base_url('User/client_details'); ?>">Basic Client Details</a></li>
                                 <li><a class="dropdown-item" href="<?php echo base_url('User/usage'); ?>">Usage Information</a></li>
                              </ul>
                           </li>
                           <!-- submenu start-->
                           <li class="nav-item"><a href="<?php echo base_url('User/notification'); ?>">Notification</a></li>
                           <li class="nav-item"><a href="<?php echo base_url('User/contact'); ?>">Contact</a></li>
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
                           <a href="<?php echo base_url('User/logout'); ?>" class="btn btn-danger" >Sign-Out</a>
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

         <!-- ---start-five-area-- -->

         <!-- ---end-five-area-- -->
         <!-- ---start-six-area-- -->

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

      <script src="https://www.gstatic.com/firebasejs/7.16.1/firebase-app.js"></script>
      <script src="https://www.gstatic.com/firebasejs/7.16.1/firebase-messaging.js"></script>
      <script>
          MsgElem = document.getElementById("msg");
          TokenElem = document.getElementById("token");
          NotisElem = document.getElementById("notis");
          ErrElem = document.getElementById("err");
          // Initialize Firebase
          // TODO: Replace with your project's customized code snippet
          var config = {
              'messagingSenderId': '32085867221',
              'apiKey': 'AIzaSyDtsHjm7N3PR8q74S_RggqyoQT7fcngkpM',
              'projectId': 'icsapp-1eb45',
              'appId': '1:32085867221:web:ed4d330526e62399ea405c',
          };
          firebase.initializeApp(config);

          const messaging = firebase.messaging();
          messaging
              .requestPermission()
              .then(function () {
                  MsgElem.innerHTML = "Notification permission granted."
                  console.log("Notification permission granted.");

                  // get the token in the form of promise
                  return messaging.getToken()
              })
              .then(function(token) {
                  TokenElem.innerHTML = "token is : " + token
              })
              .catch(function (err) {
                  ErrElem.innerHTML =  ErrElem.innerHTML + "; " + err
                  console.log("Unable to get permission to notify.", err);
              });

      </script>

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
