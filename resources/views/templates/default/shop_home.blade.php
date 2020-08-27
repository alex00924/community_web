@extends($templatePath.'.shop_layout')

@section('main')
  <div class="row welcome">
    <div class="col-xs-12 col-md-10 col-lg-8" style="margin: auto;font-family: Karla;">
      <h1 style="font-family: Karla;font-size: 30px; font-weight: 500">Connecting biologists with tools to elevate their game:</h1>
      <p style="font-size: 20px; text-align: left">
        ・<u><a id="r1Link" href="{{ route('news') }}" style="color: #000;">Information</a></u> about various microfluidic systems for life sciences
      </p>
      <p style="font-size: 20px; text-align: left">
        ・Find specialized <u><a id="r3Link" href="{{ route('product.all') }}" style="color: #000;">equipment</a></u> for your needs
      </p>
      <p style="font-size: 20px; text-align: left">
        ・<u><a id="r2Link" href="/network/ambassadors.html" style="color: #000;">Network</a></u> with biologists and engineers
      </p>
      <canvas id='myCanvas'></canvas>
      <img  alt="fluids for life" src="/images/welcome_bg.jpg" style="margin: auto; width: 100%" usemap="#image-map">
      <map name="image-map">
          <area id="r1" title="Information" href="{{ route('news') }}" coords="142,281,58" shape="circle" 
            onmouseover="myHover(this);" onmouseout='myLeave(this);'>
          <area id="r2" title="Networking" href="/network/ambassadors.html" coords="314,254,97" shape="circle" 
            onmouseover="myHover(this);" onmouseout='myLeave(this);'>
          <area id="r3" title="Equipment" href="{{ route('product.all') }}" coords="544,224,123" shape="circle" 
            onmouseover="myHover(this);" onmouseout='myLeave(this);'>
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
