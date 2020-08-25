@extends($templatePath.'.shop_layout')

@section('main')

<div class="row" style="padding: 2rem 0;font-family: Karla;" id="network-container">
    <h2 class="network-title">Networking on PC & on Mobile</h2>
    @if($network_users)
      @foreach($network_users as $network)
        <div class="col-xs-12 col-md-6">
          <div class="row" style="padding-bottom: 20px !important;">
            <div class="col-xs-12 col-md-4 network-left">
              <div class="network-img">
                  <img src="{{$network['avatar']}}" alt="person" class="m--img-rounded">
              </div>
              <div class="f-name">
                {{$network['first_name'] . ' ' . $network['last_name']}}
              </div>
            </div>
            <div class="col-xs-12 col-md-4 network-right">
              <div class="network-col">
                <b class="f-16">About:</b>
                <p style="word-wrap: break-word;padding-left: 10px;">{{$network['background']}}</p>
              </div>
            </div>
            <div class="col-xs-12 col-md-4 network-right">
              <div class="network-col1">
                <b class="f-16">Skills:</b>
                <ul class="m-l-20">
                  @if($network['skill'])
                    @foreach($network['skill'] as $skill)
                      <li>{{$skill}}</li>
                    @endforeach
                  @endif
                </ul>
              </div>
              <div class="network-col2">
                <b class="f-16">Needs:</b>
                <ul class="m-l-20">
                  @if($network['need'])
                    @foreach($network['need'] as $need)
                      <li>{{$need}}</li>
                    @endforeach
                  @endif
                </ul>
              </div>
            </div>
          </div>
        </div>
      @endforeach
    @endif
 
  </div>
@endsection
