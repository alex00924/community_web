<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-164544142-1"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'UA-164544142-1');
    </script>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Fluids For Life {{ isset($title) ? ' | ' . $title : '' }}</title>

    <meta name="description" content="{{ isset($description) ? $description : ''}}" />
    <meta name="keyword" content="{{ isset($keyword) ? $keyword : '' }}" />
    <meta property="og:image" content="{{ !empty($og_image)?asset($og_image):asset('images/org.jpg') }}" />
    <meta property="og:url" content="{{ \Request::fullUrl() }}" />
    <meta property="og:type" content="Website" />
    <meta property="og:title" content="Fluids For Life{{isset($title)?' | ' . $title : ''}}" />
    <meta property="og:description" content="Connecting biologists with microfluidics / engineering, information, and networking tools. FlowCell, FluidsForLife.com, eCommerce, internet marketing, microfluidics, life sciences, micro-physiological systems" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "Shopping Website",
            "name": "Fluids for Life",
            "url": "http://fluidsforlife.com",
            "description": "Connecting biologists with microfluidics / engineering, information, and networking tools. FlowCell, FluidsForLife.com, eCommerce, internet marketing, microfluidics, life sciences, micro-physiological systems",
            "contactPoint": {
                "@type": "ContactPoint",
                "telephone": "+1-617-775-9778",
                "email": "maxn@flowcell.co",
                "address": "29 Littles Point Rd. Swampscott, MA 01907, USA",
                "contactType": "Customer service"
            }
        }
      </script>
    @include('common.css')
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('templates/default/images/ico/apple-touch-icon.png')}}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('templates/default/images/ico/favicon-32x32.png')}}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('templates/default/images/ico/favicon-16x16.png')}}">
    <link rel="manifest" href="{{ asset('templates/default/images/ico/site.webmanifest')}}">
    <link rel="mask-icon" href="{{ asset('templates/default/images/ico/safari-pinned-tab.svg')}}" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">
 
</head>
<!--//head-->
<body>  <header id="header" style="margin-bottom: 5rem;font-family: Karla;"><!--header-->
    <div class="header-middle"><!--header-middle-->
      <div class="container">
        <div class="row vertical-align">
          <div class="logo-head-wedge col-sm-2" style="display: grid;">
            <div class="logo pull-left">
              <a href="{{ route('home') }}">
                <img style="height: 80px;padding: 10px 0 0 20px;" alt="fluids for life" src="/data/logo/logo_top.png"/>
                <span class="logo_title">FluidsForLife</span>
              </a>
            </div>
          </div>
          <div class="navbar-head-wedge col-sm-10" style="padding: 20px 0;">
            <div class="navbar-header">
              <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
            </div>
            <div class="mainmenu pull-left">
              <ul class="primary nav navbar-nav collapse navbar-collapse">
                <li>
                  <a href="{{ route('home') }}">
                    {{ trans('front.home') }}
                  </a>
                </li>
                <li>
                <a href="{{ route('product.all') }}">
                {{ trans('front.all_product') }}
                </a>
                </li>
                <li class="dropdown">
                    <a href="#">
                      {{ trans('front.shop') }}<i class="fa fa-angle-down"></i>
                    </a>
                    <ul role="menu" class="sub-menu">
                        <li><a href="{{ route('compare') }}">{{ trans('front.compare') }}</a></li>
                        <li><a href="{{ route('cart') }}">{{ trans('front.cart_title') }}</a></li>
                        <li><a href="{{ route('categories') }}">{{ trans('front.categories') }}</a></li>
                        <li><a href="{{ route('brands') }}">{{ trans('front.brands') }}</a></li>
                    </ul>
                </li>               
                <li class="dropdown">
                    <a href="#">
                      {{ trans('front.questionaire.questionnaire') }}<i class="fa fa-angle-down"></i>
                    </a>
                    <ul role="menu" class="sub-menu">
                      <li><a href="{{ route('questionaire.index') }}">{{ trans('front.questionaire.survey') }}</a></li>
                    </ul>
                </li>
                <li>
                  <a href="/about-us">
                  About Us
                  </a>
                </li>
                <li><a href="{{ route('news') }}">{{ trans('front.information') }}</a></li>
              </ul>
            </div>

          </div>
        </div>
      </div>
    </div><!--/header-middle-->

    <div class="header-bottom"><!--header-bottom-->
      <div class="container">
        <div class="row">
          <div class="search-module col-xs-8">
			<div class="search_box">
              <form id="searchbox" method="get" action="{{ route('search') }}" >
                <div class="input-group">
                  <input type="text" class="form-control" placeholder="{{ trans('front.search_form.keyword') }}..." name="keyword">
                </div>
              </form>
            </div>

          </div>
          <div class="cart-module col-xs-4">
		      <div class="shop-menu pull-right">
              <ul class="nav navbar-nav">
                @php
                $cartsCount = \Cart::count();
                @endphp
                <li><a title="Wishlist" href="{{ route('wishlist') }}"><span  class="cart-qty sc-wishlist" id="shopping-wishlist">{{ Cart::instance('wishlist')->count() }}</span><i class="fa fa-heart"></i></a></li>
                <li><a title="Compare Products" href="{{ route('compare') }}"><span  class="cart-qty sc-compare" id="shopping-compare">{{ Cart::instance('compare')->count() }}</span><i class="fa fa-crosshairs"></i></a></li>
                <li><a title="View Cart" href="{{ route('cart') }}"><span class="cart-qty sc-cart" id="shopping-cart">{{ Cart::instance('default')->count() }}</span><i class="fa fa-shopping-cart"></i></a>
                </li>
                @guest
                <li><a href="{{ route('login') }}"> {{ trans('front.login') }} </a></li>
                @else
                <li><a href="{{ route('member.index') }}"><i class="fa fa-user"></i> {{ trans('front.account') }}</a></li>
                <li><a href="{{ route('logout') }}" rel="nofollow" onclick="event.preventDefault();
                  document.getElementById('logout-form').submit();"><i class="fa fa-power-off"></i> {{ trans('front.logout') }}</a></li>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                  @csrf
                </form>
                @endguest

              </ul>
            </div>
		  
          </div>
        </div>
      </div>
    </div><!--/header-bottom-->
  </header><!--/header-->
<div class="main-content">


  <section>
    <div class="container">
      <div class="row">

        <!--body-->
        <section >
            <div class="container">
                <div class="row">
                    <div class="col-md-12 text-danger text-center">
                        <h1>Oops! 404 Error </h1>
                        <h3>The page you're looking for does not exist</h3>
                        <br>
                        <a class="button-404-error" href="https://fluidsforlife.com/"><i class="icon-home"></i> Return To Homepage</a>
                    </div>
                </div>
            </div>
        </section>

      </div>
    </div>
  </section>
</div>
<footer id="footer"><!--Footer-->
    <div class="footer-widget">
      <div class="container">
        <div class="row">
          <div class="col-sm-3">
            <div class="single-widget">
              <h2 class="text-center"><a href="{{ route('home') }}"><img style="max-width: 100px;" src="/data/logo/logo_bottom.png" alt="FlowCell Brand"></a></h2>
             <ul class="nav nav-pills nav-stacked text-center">
               <li>FlowCell, Inc.</li>
             </ul>
            </div>
          </div>
          <div class="col-sm-3">
            <div class="single-widget">
              <h2 style="font-family: Karla;font-size: 20px;">{{ trans('front.my_account') }}</h2>
              <ul class="nav nav-pills nav-stacked">
                    <li><a href="#">My profile</a></li>
                    <li><a href="#">Compare page</a></li>
                    <li><a href="#">Wishlist page</a></li>
              </ul>
            </div>
          </div>
		  <div class="col-sm-3">
                    <div class="contact-info">
                        <div class="social-networks">
                            <h2 class="title social text-center">Connect With Us!</h2>
                            <ul>
                                <li>
                                    <a href="https://www.facebook.com/FlowCellCo/"><i class="fa fa-facebook"></i></a>
                                </li>
                                <li>
                                    <a href="https://twitter.com/flowcellco/"><i class="fa fa-twitter"></i></a>
                                </li>
                                <li>
                                    <a href="https://www.linkedin.com/company/flowcell/"><i class="fa fa-linkedin"></i></a>
                                </li>
                                <li>
                                    <a href="https://www.instagram.com/flowcellco/"><i class="fa fa-instagram"></i></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
          <div class="col-sm-3">
            <div class="single-widget">
              <h2 style="font-family: Karla;font-size: 20px;">{{ trans('front.about') }}</h2>
              <ul class="nav nav-pills nav-stacked">
				<li>{{ sc_store('title') }}</li>
                <li><a>{{ trans('front.shop_info.address') }}: {{ sc_store('address') }}</a></li>
                <li><a>{{ trans('front.shop_info.hotline') }}: {{ sc_store('long_phone') }}</a></li>
                <li><a>{{ trans('front.shop_info.email') }}: {{ sc_store('email') }}</a></li>
            </ul>
            </div>
          </div>
          <!-- <div class="col-sm-3">
            <div class="single-widget">
              <h2>{{ trans('front.subscribe.title') }}</h2>
              <form action="{{ route('subscribe') }}" method="post" class="searchform">
                @csrf

                <input type="email" name="subscribe_email" required="required" placeholder="{{ trans('front.subscribe.subscribe_email') }}">
                <button type="submit" class="btn btn-default"><i class="fa fa-arrow-circle-o-right"></i></button>
                <p>{{ trans('front.subscribe.subscribe_des') }}</p>
              </form>
            </div>
          </div> -->

        </div>
      </div>
    </div>

    <div class="footer-bottom">
      <div class="container">
        <div class="row">
          <p>Copyright © {{date('Y')}} <a href="{{ route('home') }}">{{ sc_store('title') }} </a> Inc. All rights reserved.</p>
        </div>
      </div>
    </div>
  </footer>
<link href="{{ asset('templates/default/css/bootstrap.min.css')}}" rel="stylesheet">
<link href="{{ asset('templates/default/css/font-awesome.min.css')}}" rel="stylesheet">
<link href="{{ asset('templates/default/css/prettyPhoto.css')}}" rel="stylesheet">
<link href="{{ asset('templates/default/css/animate.css')}}" rel="stylesheet">
<link href="{{ asset('templates/default/css/main.css')}}" rel="stylesheet">
<link href="{{ asset('templates/default/css/responsive.css')}}" rel="stylesheet">

@stack('styles')

<script src="{{ asset('templates/default/js/jquery.js')}}"></script>
<script src="{{ asset('templates/default/js/jquery-ui.min.js')}}"></script>
<script src="{{ asset('templates/default/js/bootstrap.min.js')}}"></script>
<script src="{{ asset('templates/default/js/jquery.scrollUp.min.js')}}"></script>
<script src="{{ asset('templates/default/js/jquery.prettyPhoto.js')}}"></script>
<script src="{{ asset('templates/default/js/main.js')}}"></script>


@stack('scripts')
 

  <!-- Start of HubSpot Embed Code -->
  <script type="text/javascript" id="hs-script-loader" async defer src="//js.hs-scripts.com/8077927.js"></script>
  <!-- End of HubSpot Embed Code -->
</body>
</html>



