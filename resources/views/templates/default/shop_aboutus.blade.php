@extends($templatePath.'.shop_layout')
@php
  $categoriesTop = array();
  $categoriesTop[0]["name"] = "Our Team";
  $categoriesTop[0]["url"] = "our-team";
  $categoriesTop[1]["name"] = "Why Finish Line?";
  $categoriesTop[1]["url"] = "why-finish";
  $categoriesTop[2]["name"] = "News";
  $categoriesTop[2]["url"] = "news";
  $categoriesTop[3]["name"] = "Careers";
  $categoriesTop[3]["url"] = "careers";
@endphp
@section('main')
<section >
  <div class="container">
    <div class="row">
      <h1 class="title text-center">{{ $title }}</h1>
      <div class="col-xs-12 col-sm-5 col-md-3">
        @section('left')
        <div class="about-sidebar">
          <div class="panel-group category-products" style="border: none">
            <h2 style="color: #000; text-align: left">{{ trans('front.whoweare') }}</h2>
            @foreach ($categoriesTop as $key =>  $category)
              <div class="panel panel-default">
                <div class="about-heading">
                  <h3 class="panel-title">
                    <a href="{{ route('aboutus.detail', ['alias' => $category['url']]) }}">
                      @if ($alias == $category['url']) 
                        <font color="#0e8ce4">{{ $category["name"] }}</font>
                      @else 
                        <font color="#000">{{ $category["name"] }}</font>
                      @endif
                    </a>
                  </h3>
                </div>
              </div>
            @endforeach
            <div class="divider"> </div>
          </div>
        </div>
        @show
      </div>
      <div class="col-xs-12 col-sm-7 col-md-9">
        {!! sc_html_render($page->content) !!}
      </div>
    </div>
  </div>
</section>
@endsection

@section('breadcrumb')
  <div class="breadcrumbs">
    <ol class="breadcrumb">
      <li><a href="{{ route('home') }}">{{ trans('front.home') }}</a></li>
      <li class="active">{{ $title }}</li>
    </ol>
  </div>
@endsection
