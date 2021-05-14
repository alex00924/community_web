@extends('admin.layout')

@section('main')
<div id="preloader"></div>

<div class="scraping-item">
  <p class="scraping-name">Website Scraping</p>
  <div style="display: flex; align-items: center;">
    <form id="website-scrapping" role="form" method="post" action="{{route('admin_scraping.web_scraping')}}" enctype='multipart/form-data'>
      @csrf
        <input type="file" name="web_scrape" id="web_scrape" style="display: none;" accept=".csv"/>
        <label class="uploadButton" for="web_scrape"><span>Import Website List (.csv)</span></label>
        <button type="button" class="button_simple" id="scrapping-submit"><p><strong>Email Extract</strong></p></button>
    </form>
    <a href="{{env('APP_URL')}}/uploads/output.csv" target="_blank" id="download-link-csv" style="margin-left: 1rem;">Download</a>
  </div>
</div>


<div class="scraping-item">
  <p class="scraping-name">Generate Email</p>
  <div style="display: flex; align-items: center;">
    <form id="email-generator" role="form" method="post" action="{{route('admin_scraping.email-generator')}}" enctype='multipart/form-data'>
      @csrf
        <input type="file" name="email_scrape" id="email_scrape" style="display: none;" accept=".csv"/>
        <label class="uploadButton" for="email_scrape"><span>Import Company (.csv)</span></label>
        <button type="button" class="button_simple" id="generate-submit"><p><strong>Generate Email</strong></p></button>
    </form>
    <a href="{{env('APP_URL')}}/uploads/output.csv" target="_blank" id="download-email-csv" style="margin-left: 1rem;">Download</a>
  </div>
</div>

<div class="scraping-item">
  <p class="scraping-name">Email Checker</p>
  <div style="display: flex; align-items: center;">
    <form id="email-checker" role="form" method="post" action="{{route('admin_scraping.email-validate')}}" enctype='multipart/form-data'>
      @csrf
        <input type="file" name="email_checker" id="email_checker" style="display: none;" accept=".csv"/>
        <label class="uploadButton" for="email_checker"><span>Import Email (.csv)</span></label>
        <button type="button" class="button_simple" id="validate-email"><p><strong>Check Validate Email</strong></p></button>
    </form>
    <a href="{{env('APP_URL')}}/uploads/validate_email.csv" target="_blank" id="validate-email-csv" style="margin-left: 1rem;">Download</a>
  </div>
</div>
@endsection


@push('styles')
<style type="text/css">
.scraping-item {
  padding: 0 0 50px 20px;
}

.scraping-name {
  padding: 0 0 10px 0px;
  font-size: 18px;
  color: #2aade3;
}

.scrape_title {
  padding-bottom:10px;
  padding-left: 5px;
}

.uploadButton {
  cursor: pointer;
  display: -webkit-box;
  display: -ms-flexbox;
  display: inline-block;
  -webkit-box-pack: center;
  -ms-flex-pack: center;
  justify-content: center;
  -webkit-box-align: center;
  -ms-flex-align: center;
  align-items: center;
  -webkit-box-sizing: border-box;
  box-sizing: border-box;
  padding: 10px 5px;
  width: 180px;
  height: 40px;
  font-size: 16px;
  text-align: center;
  color: #FFF;
  background: #4cb747;
}

.button_simple {
  background: #2aade3;
  display: inline-block;
  padding: 10px 5px;
  width: 180px;
  height: 40px;
  border: none;
  color:#fff;
  transform: translateY(2px);
}

#preloader {
  position: fixed;
  left: 0;
  top: 0;
  z-index: 999;
  width: 100%;
  height: 100%;
  overflow: visible;
  background: url('/images/loading.gif') no-repeat center center;
  background-color: rgba(153, 153, 153, 0.25);
  display: none;
}
</style>

@endpush
@push('scripts')
<script type="text/javascript">
  $(document).ready(function() {
    $("#scrapping-submit").click(function() {
      var file_data = $('#web_scrape')[0].files;
      var form_data = new FormData();
      form_data.append('web_scrape', file_data[0]);
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
      $.ajax({
          url: $('#website-scrapping').attr('action'),
          method: "POST",
          data: form_data,
          contentType: false,
          processData: false,
          beforeSend: function() {
            document.getElementById('preloader').style.display = 'block';
          },
          success: function(response) {
            document.getElementById('preloader').style.display = 'none';
            $('#download-link-csv').attr('href' , `{{env('APP_URL')}}/uploads/output.csv?version=${new Date().getTime()}`)
          }
      })
    })

    $("#generate-submit").click(function() {
      var file_data = $('#email_scrape')[0].files;
      var form_data = new FormData();
      form_data.append('email_scrape', file_data[0]);
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
      $.ajax({
          url: $('#email-generator').attr('action'),
          method: "POST",
          data: {field: inputval},
          dataType: "json",
          beforeSend: function() {
            document.getElementById('preloader').style.display = 'block';
          },
          success: function(response) {
            if (response.res == 1){
              document.getElementById('preloader').style.display = 'none';
              $('#download-email-csv').attr('href' , `{{env('APP_URL')}}/uploads/output.csv?version=${new Date().getTime()}`)
            }
          }
      })
    })

    $("#validate-email").click(function() {
      var file_data = $('#email_checker')[0].files;
      var form_data = new FormData();
      form_data.append('email_checker', file_data[0]);
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
      $.ajax({
          url: $('#email-checker').attr('action'),
          method: "POST",
          dataType: 'JSON',
          data: form_data,
          contentType: false,
          processData: false,
          beforeSend: function() {
            document.getElementById('preloader').style.display = 'block';
          },
          success: function(response) {
            if (response.res == 1){
              document.getElementById('preloader').style.display = 'none';
              $('#validate-email-csv').attr('href' , `{{env('APP_URL')}}/uploads/validate_email.csv?version=${new Date().getTime()}`)
            }
          }
      })
    })
  })


  function article_scrapping()
  {
    document.getElementById('preloader').style.display = 'block';

    setTimeout(function(){
      document.getElementById('preloader').style.display = 'none';
    },10000);

    $("#article-scrapping").submit();
  }

</script>
@endpush
