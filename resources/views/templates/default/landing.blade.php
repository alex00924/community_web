@extends($templatePath.'.shop_layout')

@section('main')
<div class="modal fade" id="java-alert" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
      <div class="modal-body1">
          <div class="row" style="margin-top: 100px !important;">
              <div class="col-md-6">
                  <p class="landing-title">
                    <b>Fluids for life is connecting<br> biologists with microfluidics<br> and engineering tools.</b></p>
                  <p class="landing-text">
                    Enter your email to receive our updates and newsletter
                  </p>
                  <input type="email" id="email" name="email" size="70" placeholder="test@gmail.com">
                  <div style="padding-top: 20px;">
                    <button class="go_sign">Sign up for update</button>
                    <button class="go_web">Browser Website</button>
                  </div>
              </div>
              <div class="col-md-6">
                <img src="/images/landing.jpg" class="landing-img">
              </div>
          </div>
       
      </div>
</div>

@endsection
