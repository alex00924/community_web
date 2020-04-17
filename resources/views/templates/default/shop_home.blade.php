@extends($templatePath.'.shop_layout')

@section('main')
  <div class="row welcome">
    <div class="col-xs-12 col-md-10 col-lg-8" style="margin: auto;">
      <h1 style="font-size: 30px; font-weight: 500">Fluids For Life</h1>
      <p style="font-size: 25px; text-align: left">
        Connecting biologists with microfluidics / engineering, information, and networking tools
      </p>
      <img src="/images/welcome_bg.jpg" style="margin: auto; max-width: 100%">
    </div>
    <div class="col-xs-12 col-md-10 col-lg-8 text-center" style="position: relative; margin: auto">
      <a href="#covid-19-container" class="btn btn-danger">COVID-19</a>
      <a href="#information-container" class="btn btn-success">Information</a>
      <a href="#equipment-container" class="btn btn-info">Equipment</a>
      <a href="#network-container" class="btn btn-network">Networking</a>
      <a href="#feedback-container" class="btn btn-feedback">Feedback</a>
    </div>
  </div>

  <!-- COVID-19 -->
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

  <div class="row v-center" style="padding: 2rem 0" id="information-container">
  
  </div>

  <div class="row v-center" style="padding: 2rem 0" id="equipment-container">
  
  </div>

  <div class="row" style="padding: 2rem 0" id="network-container">
    <h2 style="font-size: 25px; font-weight: 500">Networking on PC & on Mobile</h2>

    <div class="col-xs-12 col-md-6 col-lg-4">
      <div style="width: 100%; text-align: center; padding: 1rem 0">
        <img src="images/network_person_1.png" alt="person" style="margin: auto">
      </div>
      <div class="row">
        <div class="col-xs-12" style="background: rgb(0,122,192); color: white; padding: 8px 10px;">
          Max Narovlyansky, PhD
        </div>
        <div class="col-xs-6" style="background: rgb(0,176,240); color: white; padding: 8px 10px;">
          <b>Skills:</b>
          <ul>
            <li>Microfluidics</li>
            <li>Drug discovery</li>
            <li>Bio-chemistry</li>
            <li>Multi-physics modeling</li>
            <li>Sensors & analytics</li>
          </ul>
        </div>
        <div class="col-xs-6" style="background: rgb(180,199,231); color: white; padding: 8px 10px;">
          <b>Needs:</b>
          <ul>
            <li style="color: red">Partners for NIH grant for use of MPS for COVID19</li>
            <li>Organoid specialists</li>
            <li>Fundraising</li>
          </ul>
        </div>
      </div>
    </div>

    <div class="col-xs-12 col-md-6 col-lg-4">
      <div style="width: 100%; text-align: center; padding: 1rem 0">
        <img src="images/network_person_2.png" alt="person" style="margin: auto">
      </div>
      <div class="row">
        <div class="col-xs-12" style="background: rgb(0,122,192); color: white; padding: 8px 10px;">
          Jean Zhang, PhD
        </div>
        <div class="col-xs-6" style="background: rgb(0,176,240); color: white; padding: 8px 10px;">
          <b>Skills:</b>
          <ul>
            <li>Drug discovery</li>
            <li>Cancer biology</li>
            <li>Organoid culture</li>
            <li>Chemical library screening</li>
          </ul>
        </div>
        <div class="col-xs-6" style="background: rgb(180,199,231); color: white; padding: 8px 10px;">
          <b>Needs:</b>
          <ul>
            <li style="color: red">Leadership opportunities in biotech</li>
            <li>Technology specialists</li>
            <li>Flexible partnership</li>
          </ul>
        </div>
      </div>    
    </div>

    <div class="col-xs-12 col-md-6 col-lg-4">
      <div style="width: 100%; text-align: center">
        <img src="images/network_mobile.png" alt="mobile" style="margin: auto">
      </div>
    </div>
  
  </div>

  <div class="row v-center" style="padding: 2rem 0" id="feedback-container">
    <p>
      we want to continually improve the user experience. Please contact us with suggestions.
    </p>
  </div>

@endsection



@push('styles')
@endpush

@push('scripts')

@endpush
