@extends($templatePath.'.shop_layout')

@section('main')
<section >
    <div class="container">
      <h2 class="title text-center">{{ trans('front.questionaire.marketing_research') }}</h2>
      
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