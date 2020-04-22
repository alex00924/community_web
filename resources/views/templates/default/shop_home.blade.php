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

@endpush
