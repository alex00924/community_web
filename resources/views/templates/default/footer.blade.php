<!--Footer-->

<!--Module top footer -->
  @isset ($blocksContent['footer'])
      @foreach ( $blocksContent['footer']  as $layout)
        @php
          $arrPage = explode(',', $layout->page)
        @endphp
        @if ($layout->page == '*' ||  (isset($layout_page) && in_array($layout_page, $arrPage)))
          @if ($layout->type =='html')
            {!! $layout->text !!}
          @elseif($layout->type =='view')
            @if (view()->exists('blockView.'.$layout->text))
             @include('blockView.'.$layout->text)
            @endif
          @elseif($layout->type =='module')
            {!! sc_block_render($layout->text) !!}
          @endif
        @endif
      @endforeach
  @endisset
<!--//Module top footer -->

  <footer id="footer"><!--Footer-->
    <div class="footer-widget">
      <div class="container">
        <div class="row">
          <div class="col-sm-4">
            <div class="single-widget">
              <h2 class="text-center"><a href="{{ route('home') }}"><img style="max-width: 100px;" src="/data/logo/logo_bottom.png" alt="fluids for life"></a></h2>
             <ul class="nav nav-pills nav-stacked text-center">
               <li>{{ sc_store('title') }}</li>
             </ul>
            </div>
          </div>
          <div class="col-sm-4">
            <div class="single-widget">
              <h2>{{ trans('front.my_account') }}</h2>
              <ul class="nav nav-pills nav-stacked">
                @if (!empty($layoutsUrl['footer']))
                  @foreach ($layoutsUrl['footer'] as $url)
                    <li><a {{ ($url->target =='_blank')?'target=_blank':''  }} href="{{ sc_url_render($url->url) }}">{{ sc_language_render($url->name) }}</a></li>
                  @endforeach
                @endif
              </ul>
            </div>
          </div>
          <div class="col-sm-4">
            <div class="single-widget">
              <h2>{{ trans('front.about') }}</h2>
              <ul class="nav nav-pills nav-stacked">
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
        <div class="row pull-right">
          <p>Copyright © {{date('Y')}} <a href="{{ route('home') }}">{{ sc_store('title') }} </a> Inc. All rights reserved.</p>
        </div>
      </div>
    </div>
  </footer>
<!--//Footer-->
