@extends($templatePath.'.shop_layout')

@section('main')
  <div class="row">
    <div class="col-xs-12 col-md-10 col-lg-8 landing">
      <h1 style="font-size: 30px; font-weight: 500; text-align: center;">
        <b>Fluids for life is connecting biologists<br> with microfluidics and engineering tools.</b></h1>
      <p style="font-size: 20px; text-align: left; padding: 20px 0 0 70px;">
        From microphysiological<br>
        systems, to single-cell<br>
        dispensers, to 3D cell<br>
        printers we can connect<br>
        you with technology to<br>
        enable your experiments.
      </p>
      <button class="collect_email">{{--Join our mailing list--}}Start Here</button>
      <div class="link_list">
        <a href="" class="">Custom designs</a>
        <a href="/" class="">FluidsForLife</a>
        <a href="/about.html" class="">About us</a>
      </div>
    </div>
  </div>
@endsection