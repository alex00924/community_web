@extends($templatePath.'.shop_layout')

@section('main')

<div class="row" style="padding: 2rem 0;font-family: Karla;" id="network-container">
    <h2 class="network-title">Networking on PC & on Mobile</h2>

    <div class="col-xs-12 col-md-6">
      <div class="row">
        <div class="col-xs-12 col-md-6 network-left">
          <div class="network-img">
              <img src="images/network_person_1.png" alt="person" class="m--img-rounded">
          </div>
          <div class="f-name">
            Max Narovlyansky, PhD
          </div>
        </div>
        <div class="col-xs-12 col-md-6 network-right">
          <div class="network-col1">
            <b class="f-16">Skills:</b>
            <ul class="m-l-20">
              <li>Microfluidics</li>
              <li>Drug discovery</li>
              <li>Bio-chemistry</li>
              <li>Multi-physics modeling</li>
              <li>Sensors & analytics</li>
            </ul>
          </div>
          <div class="network-col2">
            <b class="f-16">Needs:</b>
            <ul class="m-l-20">
              <li style="color: red">Partners for NIH grant for use of MPS for COVID19</li>
              <li>Organoid specialists</li>
              <li>Fundraising</li>
            </ul>
          </div>
        </div>
      </div>
    </div>

    <div class="col-xs-12 col-md-6">
      <div class="row">
        <div class="col-xs-12 col-md-6 network-left">
          <div class="network-img">
              <img src="images/network_person_2.png" alt="person" class="m--img-rounded">
          </div>
          <div class="f-name">
            Jean Zhang, PhD
          </div>
        </div>
        <div class="col-xs-12 col-md-6 network-right">
          <div class="network-col1">
            <b class="f-16">Skills:</b>
            <ul class="m-l-20">
              <li>Drug discovery</li>
              <li>Cancer biology</li>
              <li>Organoid culture</li>
              <li>Chemical library screening</li>
            </ul>
          </div>
          <div class="network-col2">
            <b class="f-16">Needs:</b>
            <ul class="m-l-20">
              <li style="color: red">Leadership opportunities in biotech</li>
              <li>Technology specialists</li>
              <li>Flexible partnership</li>
            </ul>
          </div>
        </div>
      </div>
    </div>
 
  </div>
@endsection
