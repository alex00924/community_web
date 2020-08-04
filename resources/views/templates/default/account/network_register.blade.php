@extends($templatePath.'.shop_layout')
@push('styles')
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.2/css/select2.min.css"/>
  <link rel="stylesheet" href="{{ URL::asset('css/multiSelect.css') }}">
@endpush

@push('scripts')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.2/js/select2.min.js"></script>
  <script src="{{ URL::asset('js/multiSelect.js') }}"></script>
  <script src="{{ URL::asset('js/network_register.js') }}"></script>
@endpush
@section('main')

<div class="row" style="padding: 2rem 0;font-family: Karla;" id="network-container">
      <h2 class="network-title">Do you want to do Networking on this site?
        <label class="toggle-switch toggle-switch-dark">
            <input type="checkbox" id="network_status" @if($user['network_status'] == 'on') checked @endif data-user_id="">
          <span class="toggle-slider round"></span>
        </label>
      </h2>
    <div class="col-xs-12 col-md-2"></div>
    <div class="col-xs-12 col-md-8">
      <form action="{{route('member.network_register')}}" method="post" enctype="multipart/form-data">
        {!! csrf_field() !!}

            <div class="row" style="padding-bottom: 10px !important;">
                <label class="col-md-2" for="background" style="padding-top: 10px;">About</label>
                <textarea class="col-md-10 network-back" rows="4" id="background" name="background" 
                  @if($user['network_status'] != 'on') disabled @endif>{{$user['background'] ?? ''}}</textarea>
            </div>

            <div class="row">
                <label class="col-md-2" for="sel_skills" style="padding-top: 10px;">Skills</label>
                <div class="col-md-10">
                    <select class="js-select" multiple="multiple" id="sel_skill" name="sel_skills[]" 
                      @if($user['network_status'] != 'on') disabled @endif>
                      @if(!empty($skills))
                        @foreach($skills as $skill)
                            <option value="{{$skill['name']}}" 
                              @if(strpos($user['skill'],$skill['name']) !== false) selected @endif
                              data-badge="">{{$skill['name']}}</option>
                        @endforeach
                      @endif
                    </select>
                </div>
            </div>

            <div class="row" style="padding-bottom: 10px !important;">
                <label class="col-md-2" for="sel_needs" style="padding-top: 10px;">Needs</label>
                <div class="col-md-10">
                    <select class="js-select" multiple="multiple" id="sel_need" name="sel_needs[]" 
                      @if($user['network_status'] != 'on') disabled @endif>
                      @if(!empty($needs))
                        @foreach($needs as $need)
                            <option value="{{$need['name']}}"
                              @if(strpos($user['need'],$need['name']) !== false) selected @endif
                              data-badge="">{{$need['name']}}</option>
                        @endforeach
                      @endif
                    </select>
                </div>
            </div>

            <div class="submit" style="text-align: center;">
                <button type="submit" name="SubmitCreate" class="btn btn-default">Register</button>
            </div>

      </form>
    </div>
    <div class="col-xs-12 col-md-2"></div>
</div>

@endsection
