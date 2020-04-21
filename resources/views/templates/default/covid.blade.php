@extends($templatePath.'.shop_layout')

@section('main')
<div class="row v-center" style="padding: 2rem 0" id="covid-19-container">
    <div class="col-xs-4">
      <img src="/images/covid-19.png" alt="COVID-19" style="max-width: 100%; height: auto">
      <p>
        <b>COVID-19</b> – shortcut to posted articles, equipment, and networking opportunities related to SARS-CoV-2
      </p>
    </div>

    <div class="col-xs-8">
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
    </div>
  </div>

  @endsection