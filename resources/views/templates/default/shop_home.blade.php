@extends($templatePath.'.shop_layout')

@section('main')
  <div class="row welcome">
    <div class="col-xs-10 col-md-8 col-lg-9" style="margin: auto;font-family: Karla;">
      <h1 style="font-family: Karla;font-size: 30px; font-weight: 500">{{ $title }}</h1>
      {!! sc_html_render($page->content) !!}
    
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
