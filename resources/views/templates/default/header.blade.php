  <header id="header" style="margin-bottom: 5rem;font-family: Karla;"><!--header-->
    <div class="header-middle"><!--header-middle-->
      <div class="container">
        <div class="row vertical-align">
          <div class="col-sm-4" style="display: grid;">
            <div class="logo pull-left">
              <a href="{{ route('home') }}">
                <img style="height: 80px;padding: 10px 0 0 20px;" alt="fluids for life" src="/data/logo/logo_top.png"/>
                <span class="logo_title">FluidsForLife</span>
              </a>
            </div>
          </div>
          <div class="col-sm-8" style="padding: 20px 0;">
            <div class="shop-menu pull-right">
              <ul class="nav navbar-nav">
                @php
                $cartsCount = \Cart::count();
                @endphp
                <li><a href="{{ route('wishlist') }}"><span  class="cart-qty  sc-wishlist" id="shopping-wishlist">{{ Cart::instance('wishlist')->count() }}</span><i class="fa fa-heart"></i> {{ trans('front.wishlist') }}</a></li>
                <li><a href="{{ route('compare') }}"><span  class="cart-qty sc-compare" id="shopping-compare">{{ Cart::instance('compare')->count() }}</span><i class="fa fa-crosshairs"></i> {{ trans('front.compare') }}</a></li>
                <li><a href="{{ route('cart') }}"><span class="cart-qty sc-cart" id="shopping-cart">{{ Cart::instance('default')->count() }}</span><i class="fa fa-shopping-cart"></i> {{ trans('front.cart_title') }}</a>
                </li>
                @guest
                <li><a href="{{ route('login') }}"><i class="fa fa-lock"></i> {{ trans('front.login') }}</a></li>
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
    </div><!--/header-middle-->

    <div class="header-bottom"><!--header-bottom-->
      <div class="container">
        <div class="row">
          <div class="col-xs-9">
            <div class="navbar-header">
              <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
            </div>
            @php
              $routeName = \Request::route()->getName();
            @endphp
            <div class="mainmenu pull-left">
              <ul class="nav navbar-nav collapse navbar-collapse" style="max-height: fit-content">
                <li>
                  <a href="{{ route('home') }}" class="{{ ( $routeName == 'home') ? 'active' : '' }}">
                    {{ trans('front.home') }}
                  </a>
                </li>
		<li>
		<a class="{{ ( $routeName == 'product.all') ? 'active' : '' }}" href="{{ route('product.all') }}">
		{{ trans('front.all_product') }}
		</a>
		</li>
                <li class="dropdown">
                    <a href="#" class="{{ ($routeName == 'product.all' || $routeName == 'compare' || $routeName == 'cart' || $routeName == 'categories' || $routeName == 'brands' || $routeName == 'vendors') ? 'active' : '' }}">
                      {{ trans('front.shop') }}<i class="fa fa-angle-down"></i>
                    </a>
                    <ul role="menu" class="sub-menu">
                        <li><a class="{{ ( $routeName == 'compare') ? 'active' : '' }}" href="{{ route('compare') }}">{{ trans('front.compare') }}</a></li>
                        <li><a class="{{ ( $routeName == 'cart') ? 'active' : '' }}" href="{{ route('cart') }}">{{ trans('front.cart_title') }}</a></li>
                        <li><a class="{{ ( $routeName == 'categories') ? 'active' : '' }}" href="{{ route('categories') }}">{{ trans('front.categories') }}</a></li>
                        <li><a class="{{ ( $routeName == 'brands') ? 'active' : '' }}" href="{{ route('brands') }}">{{ trans('front.brands') }}</a></li>
                    </ul>
                </li>

                @if (!empty(sc_config('Content')))
                <li class="dropdown">
				          <a href="#">{{ trans('front.cms_category') }}<i class="fa fa-angle-down"></i></a>
                  <ul role="menu" class="sub-menu">
                    @php
                      $nameSpace = sc_get_module_namespace('Cms','Content').'\Models\CmsCategory';
                      $cmsCategories = (new $nameSpace)->where('status', 1)->get();
                    @endphp
                    @foreach ($cmsCategories as $cmsCategory)
                      <li><a class="{{ ( \Request::fullUrl() == $cmsCategory->getUrl() ) ? 'active' : '' }}" href="{{ $cmsCategory->getUrl() }}">{{ sc_language_render($cmsCategory->title) }}</a></li>
                    @endforeach
                  </ul>
                </li>
                @endif
                <li class="dropdown">
                    <a href="#" class="{{ ($routeName == 'questionaire.index' || $routeName == 'marketing') ? 'active' : '' }}">
                      {{ trans('front.questionaire.questionnaire') }}<i class="fa fa-angle-down"></i>
                    </a>
                    <ul role="menu" class="sub-menu">
                      <li><a class="{{ $routeName == 'questionaire.index' ? 'active' : '' }}" href="{{ route('questionaire.index') }}">{{ trans('front.questionaire.survey') }}</a></li>
                    </ul>
                </li>
                @if(Auth::user())
                <li>
                  <a class="{{ ( request()->is('network*') ) ? 'active' : '' }}" href="/network">
                    {{ trans('front.network') }}
                  </a>
                </li>
                @endif
                <li>
                  <a class="{{ ( request()->is('aboutus') ) ? 'active' : '' }}" href="/aboutus">
                  About Us
                  </a>
                </li>
                @if (!empty($layoutsUrl['menu']))
                  @foreach ($layoutsUrl['menu'] as $url)
                    <li><a class="{{ ( \Request::fullUrl() == sc_url_render($url->url) ) ? 'active' : '' }}" {{ ($url->target =='_blank')?'target=_blank':''  }} href="{{ sc_url_render($url->url) }}">{{ sc_language_render($url->name) }}</a></li>
                  @endforeach
                @endif

                <li>
                  <a class="{{ ( request()->is('news-covid') ) ? 'active' : '' }}" href="/news-covid">
                  COVID-19
                  </a>
                </li>
                <li><a class="{{ ( $routeName == 'news') ? 'active' : '' }}"  href="{{ route('news') }}">{{ trans('front.information') }}</a></li>
              </ul>
            </div>
          </div>
          <div class="col-xs-3">
            <div class="search_box">
              <form id="searchbox" method="get" action="{{ route('search') }}" >
                <div class="input-group">
                  <input type="text" class="form-control" placeholder="{{ trans('front.search_form.keyword') }}..." name="keyword">
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div><!--/header-bottom-->
  </header><!--/header-->
