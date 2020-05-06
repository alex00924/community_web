@extends($templatePath.'.shop_layout')

@section('main')
  <div class="row welcome">
    <div class="col-xs-12 col-md-10 col-lg-8" style="margin: auto;">
      <h1 style="font-size: 36px; font-weight: 500">Fluids For Life</h1>
      <p style="font-size: 20px; text-align: left">
        Connecting biologists with microfluidics / engineering, information, and networking tools
      </p>
      <img  alt="fluids for life" src="/images/welcome_bg.jpg" style="margin: auto; width: 100%" usemap="#image-map">
      <map name="image-map">
          <area alt="" title="Information" href="{{ route('news') }}" coords="142,281,58" shape="circle">
          <area alt="" title="Networking" href="/network" coords="314,254,97" shape="circle">
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
