@extends($templatePath.'.shop_layout')
@push('scripts')
  <script src="{{ URL::asset('js/dashboard.js') }}"></script>
@endpush
@section('main')

<div class="row" style="padding: 2rem 0;font-family: Karla;" id="personal-dashboard">
    <div class="col-xs-12 col-md-6">
      <div class="theme-title"><h3><b>Interests</b></h3></div>
      <hr>
      <div class="theme-item" id="skill">
        <span id="skill-arrow" class="vp45yf z1asCe" style="right:20px"><svg focusable="false" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M7.41 8.59L12 13.17l4.59-4.58L18 10l-6 6-6-6 1.41-1.41z"></path></svg></span>
        <div style="display: inline;"><h4>New Skills</h4></div>
      </div>
      <div class="skill-content">
        @if(count($new_skills) > 0)
          @foreach($new_skills as $skill)
            <hr>
            <div style="display:inline-flex; padding: 5px 0 5px 30px;">
              <div class="clinical-category">{{$skill['name']}}</div>
              <div class="clinical-item">{{substr($skill['created_at'],0,10)}}</div>
            </div>
          @endforeach
        @else
          <hr>
          <div style="display:inline-flex; padding: 5px 0 5px 30px;">
            <div class="clinical-category">there is no New Skill</div>
            <div class="clinical-item"></div>
          </div>
        @endif
      </div>
      <hr>
      <div class="theme-item" id="need">
        <span id="need-arrow" class="vp45yf z1asCe" style="right:20px"><svg focusable="false" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M7.41 8.59L12 13.17l4.59-4.58L18 10l-6 6-6-6 1.41-1.41z"></path></svg></span>
        <div style="display: inline;"><h4>New Needs</h4></div>
      </div>
      <div class="need-content">
        @if(count($new_needs) > 0)
          @foreach($new_needs as $need)
            <hr>
            <div style="display:inline-flex; padding: 5px 0 5px 30px;">
              <div class="clinical-category">{{$need['name']}}</div>
              <div class="clinical-item">{{substr($need['created_at'],0,10)}}</div>
            </div>
          @endforeach
        @else
          <hr>
          <div style="display:inline-flex; padding: 5px 0 5px 30px;">
            <div class="clinical-category">there is no New Need</div>
            <div class="clinical-item"></div>
          </div>
        @endif
      </div>
    </div>
    <div class="col-xs-12 col-md-6">
      <div class="theme-title"><h3><b>Recent Newsletters and Updates</b></h3></div>
      <hr>
      <div class="theme-item" id="clinical">
        <span id="clinical-arrow" class="vp45yf z1asCe" style="right:20px"><svg focusable="false" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M7.41 8.59L12 13.17l4.59-4.58L18 10l-6 6-6-6 1.41-1.41z"></path></svg></span>
        <div style="display: inline;"><h4>New and Updated Clinical Trials</h4></div>
      </div>
      <div class="clinical-content">
      <hr>
        <div style="display:inline-flex; padding: 5px 0 5px 30px;">
          <div class="clinical-category">New Studies</div>
          <div class="clinical-item">{{ count($new_study) ?? 0 }}</div>
        </div>
        <hr>
        <div style="display:inline-flex; padding: 5px 0 5px 30px;">
          <div class="clinical-category">New Conditions</div>
          <div class="clinical-item">{{ count($new_condition) ?? 0 }}</div>
        </div>
        <hr>
        <div style="display:inline-flex; padding: 5px 0 5px 30px;">
          <div class="clinical-category">New Treatments</div>
          <div class="clinical-item">{{ count($new_drug) ?? 0 }}</div>
        </div>
        <hr>
        <div style="display:inline-flex; padding: 5px 0 5px 30px;">
          <div class="clinical-category">New Biomarkers</div>
          <div class="clinical-item">0</div>
        </div>
      </div>
      <hr>
      <div class="theme-item" id="newsletter">
        <span id="newsletter-arrow" class="vp45yf z1asCe" style="right:20px"><svg focusable="false" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M7.41 8.59L12 13.17l4.59-4.58L18 10l-6 6-6-6 1.41-1.41z"></path></svg></span>
        <div style="display: inline;"><h4>New and Updated Scientific Articles</h4></div>
      </div>
      <div class="newsletter-content">
        <hr>
        <div style="display:inline-flex; padding: 5px 0 5px 30px;">
          <div class="clinical-category">there is no Updated</div>
          <div class="clinical-item"></div>
        </div>
      </div>
      <hr>
    </div>
 
</div>
@endsection
