@if (sc_config('SITE_STATUS') == 'off')
  @include($templatePath . '.maintenance')
  @php
    exit();
  @endphp
@endif

<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ $description??sc_store('description') }}">
    <meta name="keyword" content="{{ $keyword??sc_store('keyword') }}">
    <title>{{$title??sc_store('title')}}</title>
    <meta property="og:image" content="{{ !empty($og_image)?asset($og_image):asset('images/org.jpg') }}" />
    <meta property="og:url" content="{{ \Request::fullUrl() }}" />
    <meta property="og:type" content="Website" />
    <meta property="og:title" content="{{ $title??sc_store('title') }}" />
    <meta property="og:description" content="{{ $description??sc_store('description') }}" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

<!--Module meta -->
  @isset ($blocksContent['meta'])
      @foreach ( $blocksContent['meta']  as $layout)
        @php
          $arrPage = explode(',', $layout->page)
        @endphp
        @if ($layout->page == '*' ||  (isset($layout_page) && in_array($layout_page, $arrPage)))
          @if ($layout->type =='html')
            {!! $layout->text !!}
          @endif
        @endif
      @endforeach
  @endisset
<!--//Module meta -->

<!-- css default for item s-cart -->
@include('common.css')
<!--//end css defaut -->

    <link href="{{ asset($templateFile.'/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{ asset($templateFile.'/css/font-awesome.min.css')}}" rel="stylesheet">
    <link href="{{ asset($templateFile.'/css/prettyPhoto.css')}}" rel="stylesheet">
    <link href="{{ asset($templateFile.'/css/animate.css')}}" rel="stylesheet">
    <link href="{{ asset($templateFile.'/css/main.css')}}" rel="stylesheet">
    <link href="{{ asset($templateFile.'/css/responsive.css')}}" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="{{ asset($templateFile.'/js/html5shiv.js')}}"></script>
    <script src="{{ asset($templateFile.'/js/respond.min.js')}}"></script>
    <![endif]-->
    <link rel="icon" href="{{ asset($templateFile.'/images/ico/favicon.png')}}">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="{{ asset($templateFile.'/images/ico/apple-touch-icon-144-precomposed.png')}}">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="{{ asset($templateFile.'/images/ico/apple-touch-icon-114-precomposed.png')}}">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="{{ asset($templateFile.'/images/ico/apple-touch-icon-72-precomposed.png')}}">
    <link rel="apple-touch-icon-precomposed" href="{{ asset($templateFile.'/images/ico/apple-touch-icon-57-precomposed.png')}}">

  <!--Module header -->
  @isset ($blocksContent['header'])
      @foreach ( $blocksContent['header']  as $layout)
      @php
        $arrPage = explode(',', $layout->page)
      @endphp
        @if ($layout->page == '*' ||  (isset($layout_page) && in_array($layout_page, $arrPage)))
          @if ($layout->type =='html')
            {!! $layout->text !!}
          @endif
        @endif
      @endforeach
  @endisset
<!--//Module header -->

</head>
<!--//head-->
<body>

@include($templatePath.'.header')

<div class="main-content" style="padding: 5rem 0">
<!--Module banner -->
  @isset ($blocksContent['banner_top'])
      @foreach ( $blocksContent['banner_top']  as $layout)
      @php
        $arrPage = explode(',', $layout->page)
      @endphp
        @if ($layout->page == '*' ||  (isset($layout_page) && in_array($layout_page, $arrPage)))
          @if ($layout->type =='html')
            {!! $layout->text !!}
          @elseif($layout->type =='view')
            @if (view()->exists('block.'.$layout->text))
             @include('block.'.$layout->text)
            @endif
          @elseif($layout->type =='module')
            {!! sc_block_render($layout->text) !!}
          @endif
        @endif
      @endforeach
  @endisset
<!--//Module banner -->


<!--Module top -->
  @isset ($blocksContent['top'])
      @foreach ( $blocksContent['top']  as $layout)
        @php
          $arrPage = explode(',', $layout->page)
        @endphp
        @if ($layout->page == '*' ||  (isset($layout_page) && in_array($layout_page, $arrPage)))
          @if ($layout->type =='html')
            {!! $layout->text !!}
          @elseif($layout->type =='view')
            @if (view()->exists('block.'.$layout->text))
             @include('block.'.$layout->text)
            @endif
          @elseif($layout->type =='module')
            {!! sc_block_render($layout->text) !!}
          @endif
        @endif
      @endforeach
  @endisset
<!--//Module top -->


  <section>
    <div class="container">
      <div class="row">
        <div class="col-sm-12" id="breadcrumb">
          <!--breadcrumb-->
          @yield('breadcrumb')
          <!--//breadcrumb-->

          <!--fillter-->
          @yield('filter')
          <!--//fillter-->
        </div>

        <!--Notice -->
        @include($templatePath.'.notice')
        <!--//Notice -->

        <!--body-->
        @section('main')
          @include($templatePath.'.left')
          @include($templatePath.'.center')
          @include($templatePath.'.right')
        @show
        <!--//body-->

      </div>
    </div>
  </section>
</div>

@include($templatePath.'.footer')

<script src="{{ asset($templateFile.'/js/jquery.js')}}"></script>
<script src="{{ asset($templateFile.'/js/jquery-ui.min.js')}}"></script>
<script src="{{ asset($templateFile.'/js/bootstrap.min.js')}}"></script>
<script src="{{ asset($templateFile.'/js/jquery.scrollUp.min.js')}}"></script>
<script src="{{ asset($templateFile.'/js/jquery.prettyPhoto.js')}}"></script>
<script src="{{ asset($templateFile.'/js/main.js')}}"></script>


@stack('scripts')

<!-- js default for item s-cart -->
@include('common.js')
<!--//end js defaut -->

   <!--Module bottom -->
   @isset ($blocksContent['bottom'])
       @foreach ( $blocksContent['bottom']  as $layout)
         @php
           $arrPage = explode(',', $layout->page)
         @endphp
         @if ($layout->page == '*' ||  (isset($layout_page) && in_array($layout_page, $arrPage)))
           @if ($layout->type =='html')
             {!! $layout->text !!}
           @elseif($layout->type =='view')
             @if (view()->exists('block.'.$layout->text))
              @include('block.'.$layout->text)
             @endif
           @elseif($layout->type =='module')
             {!! sc_block_render($layout->text) !!}
           @endif
         @endif
       @endforeach
   @endisset
 <!--//Module bottom -->

 
  @auth
  <!-- Fonts -->
    <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,600,700,300' rel='stylesheet' type='text/css'>
    <!-- <link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css'> -->
    <link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.2/css/font-awesome.min.css'>

    <!-- Growl Notification -->
    <link href="{{ asset('growl_notification/dark-theme.min.css') }}" rel="stylesheet">
    <link href="{{ asset('growl_notification/custom-growl.css') }}" rel="stylesheet">
    <script src="{{ asset('growl_notification/growl-notification.min.js') }}"></script>
    
    <!-- Chat -->
    <script src="{{ asset('chat/chatkit.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('chat/client_chat.css') }}">
    <script src="{{ asset('chat/client_chat.js') }}"></script>
  @include('chat.client_chat_content')
  @endauth
</body>
</html>
