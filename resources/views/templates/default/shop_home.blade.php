@extends($templatePath.'.shop_layout')

@section('main')
  <div class="row welcome">
    <div class="col-xs-12 col-md-10 col-lg-8" style="margin: auto;font-family: Karla;">
      <h1 style="font-family: Karla;font-size: 30px; font-weight: 500">Connecting biologists with tools to elevate their game:</h1>
      <p style="font-size: 20px; text-align: left">
        ・Information about various microfluidic systems for life sciences
      </p>
      <p style="font-size: 20px; text-align: left">
        ・Find specialized equipment for your needs
      </p>
      <p style="font-size: 20px; text-align: left">
        ・Network with biologists and engineers
      </p>
      <img  alt="fluids for life" src="/images/welcome_bg.jpg" style="margin: auto; width: 100%" usemap="#image-map">
      <map name="image-map">
          <area alt="" title="Information" href="{{ route('news') }}" coords="142,281,58" shape="circle">
          <area alt="" title="Networking" href="/network/ambassadors.html" coords="314,254,97" shape="circle">
          <area alt="" title="Equipment" href="{{ route('product.all') }}" coords="544,224,123" shape="circle">
      </map>
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
