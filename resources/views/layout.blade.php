<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('assets/images/short.jpg') }}">
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400;500;600;700&display=swap" rel="stylesheet">

    <title>Your Favourite Foods</title>

    <!-- Additional CSS Files -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap.min.css')}}">

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/font-awesome.css')}}">

    <link rel="stylesheet" href="{{ asset('assets/css/css-library.css')}}">

    <link rel="stylesheet" href="{{ asset('assets/css/owl-carousel.css')}}">

    <link rel="stylesheet" href="{{ asset('assets/css/lightbox.css')}}">

{{--    <script src="{{ asset('assets/js/angular.min.js')}}"></script>--}}
{{--    <script src="{{ asset('assets/js/bKash-checkout.js')}}"></script>--}}
{{--    <script src="{{ asset('assets/js/bKash-checkout-sandbox.js')}}"></script>--}}

    </head>

    <body ng-app="">

    <!-- ***** Preloader Start ***** -->
    <div id="preloader">
        <div class="jumper">
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>
    <!-- ***** Preloader End ***** -->


    <!-- ***** Header Area Start ***** -->
    <header class="header-area">
        <div class="container">

            <nav class="navbar navbar-expand-lg navbar-light">
                <a href="{{url('/')}}" class="logo navbar-brand">
                    <img width="100px" src="{{ asset('assets/images/logo.png')}}">
                </a>

                <!-- Toggler/collapsible button -->
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#adminNavbar" aria-controls="adminNavbar" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- Navbar links -->
                <div class="collapse navbar-collapse" id="adminNavbar">
                    <ul class="navbar-nav mr-auto">
                        <!-- Simple menu item -->
                        <li class="nav-item scroll-to-section">
                            <a class="nav-link" href="/">Home</a>
                        </li>
                        <li class="nav-item scroll-to-section">
                            <a class="nav-link" href="/#about">About</a>
                        </li>
                        <!-- Parent menu with child dropdown -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="/menu" id="menu" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Menu
                            </a>
                            <div class="dropdown-menu" aria-labelledby="menu">
                                <a class="dropdown-item" href="/menu/breakfast">breakfast</a>
                                <a class="dropdown-item" href="/menu/dinner">dinner</a>
                                <a class="dropdown-item" href="/menu/lunch">lunch</a>
                            </div>
                        </li>

                        <li class="nav-item scroll-to-section">
                            <a class="nav-link" href="/trace-my-order">Trace Order</a>
                        </li>
                        <li class="nav-item scroll-to-section">
                            <a class="nav-link" href="/#chefs">Chefs</a>
                        </li>
                        <li class="nav-item scroll-to-section">
                            <a class="nav-link" href="/#reservation">Reservation</a>
                        </li>
                        <li class="nav-item scroll-to-section">
                            <a class="nav-link" href="/cart"><i class="fa fa-shopping-cart"></i></a>
                        </li>
                        <?php
                        if(Auth::user())
                        {
                            $cart_amount=DB::table('carts')->where('user_id',Auth::user()->id)->where('product_order','no')->count();
                        }
                        else
                        {
                            $cart_amount=0;
                        }
                        ?>
                        <span class='badge d-none d-md-block' id='lblCartCount'> {{ $cart_amount }} </span>



                    </ul>
                    <ul class="navbar-nav ml-auto">
                        @auth
                            <li style="margin-top:-13px;">
                                <x-app-layout> </x-app-layout>
                            </li>
                        @else
                            <li class="nav-item scroll-to-section float-right">
                                <a class="nav-link" href="/login">Log in</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item scroll-to-section">
                                    <a class="nav-link" href="/register">Register</a>
                                </li>
                            @endif
                        @endauth
                    </ul>

                </div>
            </nav>

        </div>
    </header>
    <!-- ***** Header Area End ***** -->

    <div style="min-height:750px">
        @yield('page-content')
    </div>

    <!-- ***** Footer Start ***** -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-xs-12">
                    <div class="right-text-content">
                            <ul class="social-icons">
                                <li><a href="https://web.facebook.com/"><i class="fa fa-facebook"></i></a></li>
                                <li><a href="https://twitter.com/"><i class="fa fa-twitter"></i></a></li>
                                <li><a href="https://www.linkedin.com/"><i class="fa fa-linkedin"></i></a></li>
                                <li><a href="https://www.instagram.com/"><i class="fa fa-instagram"></i></a></li>
                            </ul>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="logo">
                        <a href="{{url('/')}}"><img src="{{ asset('assets/images/logo.png')}}" alt=""></a>
                    </div>
                </div>
                <div class="col-lg-4 col-xs-12">
                    <div class="left-text-content">
                        <p>© copyright 2025</p>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- jQuery -->
    <script src="{{ asset('assets/js/jquery-2.1.0.min.js')}}"></script>

    <!-- Bootstrap -->
{{--    <script src="{{ asset('assets/js/popper.js')}}"></script>--}}
    <script src="{{ asset('assets/js/bootstrap.min.js')}}"></script>

    <!-- Plugins -->
    <script src="{{ asset('assets/js/owl-carousel.js')}}"></script>
    <script src="{{ asset('assets/js/accordions.js')}}"></script>
    <script src="{{ asset('assets/js/datepicker.js')}}"></script>
    <script src="{{ asset('assets/js/scrollreveal.min.js')}}"></script>
{{--    <script src="{{ asset('assets/js/waypoints.min.js')}}"></script>--}}
{{--    <script src="{{ asset('assets/js/jquery.counterup.min.js')}}"></script>--}}
{{--    <script src="{{ asset('assets/js/imgfix.min.js')}}"></script>--}}
    <script src="{{ asset('assets/js/slick.js')}}"></script>
    <script src="{{ asset('assets/js/lightbox.js')}}"></script>
    <script src="{{ asset('assets/js/isotope.js')}}"></script>

    <!-- Global Init -->
    <script src="{{ asset('assets/js/custom.js')}}"></script>
    <script>

        $(function() {
            var selectedClass = "";
            $("p").click(function(){
            selectedClass = $(this).attr("data-rel");
            $("#portfolio").fadeTo(50, 0.1);
                $("#portfolio div").not("."+selectedClass).fadeOut();
            setTimeout(function() {
              $("."+selectedClass).fadeIn();
              $("#portfolio").fadeTo(50, 1);
            }, 500);

            });
        });

    </script>
  </body>
</html>
