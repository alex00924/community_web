@extends($templatePath.'.shop_layout')

@section('main')
  <div class="row welcome">
    <div class="col-xs-12 col-md-10 col-lg-8" style="margin: auto;">
      <h1 style="font-size: 30px; font-weight: 500">Fluids For Life</h1>
      <p style="font-size: 25px; text-align: left">
        Connecting biologists with microfluidics / engineering, information, and networking tools
      </p>
      <img src="/images/welcome_bg.jpg" style="margin: auto; width: 100%" usemap="#image-map">
      <map name="image-map">
          <area alt="" title="Information" href="{{ route('news') }}" coords="142,281,58" shape="circle">
          <area alt="" title="Networking" href="/network" coords="314,254,97" shape="circle">
          <area alt="" title="Equipment" href="{{ route('product.all') }}" coords="544,224,123" shape="circle">
      </map>
    </div>
    <div class="col-xs-12 col-md-10 col-lg-8 text-center" style="position: relative; margin: auto; margin-top: 3rem">
      <a href="/news_covid" class="btn btn-danger">COVID-19</a>
      <a href="{{ route('news') }}" class="btn btn-success">Information</a>
      <a href="{{ route('product.all') }}" class="btn btn-info">Equipment</a>
      <a href="/network" class="btn btn-network">Networking</a>
      <a href="#feedback-container" class="btn btn-feedback">Feedback</a>
    </div>
  </div>
@endsection



@push('styles')
@endpush

@push('scripts')
  <script src="/js/imageMapResizer.min.js"></script>
  <script>
    $('map').imageMapResize();
  </script>
@endpush
