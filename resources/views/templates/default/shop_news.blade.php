@extends($templatePath.'.shop_layout')

@section('main')
<section >
<div class="container">
    <div class="row">
        <h1 class="title text-center">{{ $title }}</h1>
        <!-- <div class="col-xs-10 text-right">
          <a class="btn btn-danger" href="/news-covid"> {{ trans('front.covid') }} </a>
        </div> -->
        <div class="category-menu col-xs-12 col-sm-5 col-md-3">
          <div class="left-sidebar">
          @if ($newscategory->count())
              <div class="panel-group category-products" id="accordian">
			  <h2>{{ trans('front.categories') }}</h2>
                @foreach ($newscategory as $key =>  $category)
                  <div class="panel panel-default">
                    <div class="panel-heading">
                      <h4 class="panel-title">
                        <a href="{{ $category->getUrl() }}">
                        @if ($category->category_name == $categoryName)
                          <font color="#0e8ce4">{{ $category->category_name . " (" . count($category->categorylist) . ")" }}</font>
                        @else
                          <font>{{ $category->category_name . " (" . count($category->categorylist) . ")" }}</font>
                        @endif
                        </a>
                      </h4>
                    </div>
                  </div>
                @endforeach
              </div>
          @endif
          </div>
        </div>
        @php
          $maincatblog = true;
        @endphp
        @if ($maincatblog)
          <link rel="canonical" href="https://fluidsforlife.com/news" />
        @else
        @endif
        <!-- Center colunm-->
          <div class="center_column col-xs-12 col-sm-7 col-md-9">
            <ul class="blog-posts">
            @foreach ($news as $newsDetail)
              <li class="post-item">
                <article class="entry">
                  <div class="row">
                    <div class="col-sm-3">
                      <div class="entry-thumb image-hover2"> <a href="{{ $newsDetail->getUrl() }}">
                        <figure><img src="{{ asset($newsDetail->getThumb()) }}" alt="{{ $newsDetail->title }}" alt="Blog"></figure>
                        </a> </div>
                    </div>
                    <div class="col-sm-9">
                      <h3 class="entry-title"><a href="{{ $newsDetail->getUrl() }}">{{ $newsDetail->title }}</a></h3>
                      <div class="entry-meta-data"> <span class="author">  <span class="date"><i class="pe-7s-date"></i>&nbsp; {{ $newsDetail->created_at }}</span> </div>
                      <div class="entry-excerpt">{{ $newsDetail->description }}</div>
                      <a href="{{ $newsDetail->getUrl() }}" class="button read-more">{{ trans('front.view_more') }}&nbsp; <i class="fa fa-angle-double-right"></i></a> </div>
                  </div>
                </article>
                <hr>
              </li>
            @endforeach
            </ul>
            @if ($link)
            <div class="sortPagiBar">
              <div class="pagination-area " >
                    {{ $news->links() }}
              </div>
            </div>
            @else
            <div class="sortPagiBar">
            </div>
            @endif
          </div>
      <!-- ./row-->
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
