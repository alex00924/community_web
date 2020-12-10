@extends($templatePath.'.shop_layout')

@section('main')
<section >
    <div class="container">
      <h2 class="title text-center">{{ trans('front.questionaire.marketing_research') }}</h2>
      <h4 class="title text-center">You will get private link from your email</h4>
      <!-- Center colunm-->
      <div class="marketing_emailgroup">
        <div class="col-md-4 col-sm-4 {{ $errors->has('email') ? ' has-error' : '' }}">
          <label>{{ trans('front.contact_form.email') }}:</label>
          <input type="email" class="form-control {{ ($errors->has('email'))?"input-error":"" }}"  name="email" placeholder="Your email..." value="{{ old('email') }}">
          @if ($errors->has('email'))
            <span class="help-block">
                {{ $errors->first('email') }}
            </span>
          @endif
        </div>
        <input type="submit"  value="{{ trans('front.contact_form.submit') }}" class="btn btn-primary marketing_email" id="email_send">
      </div>
    </div>
</section>
@endsection

@push('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
          $('#email_send').on("click", function(){
            var email = $("input[name='email']").val();
            $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
            });
            $.ajax({
                url: 'marketing/sendemail',
                method: "POST",
                data: {email: email},
                dataType: "json",
                beforeSend: function() {
                  document.getElementById('preloader').style.display = 'block';
                },
                success: function(response) {
                  if (respose.res == 'success'){
                    document.getElementById('preloader').style.display = 'none';
                  }
                }
            })
          })
        });
    </script>
@endpush