@extends('admin.layout')

@section('main')
<div id="preloader"></div>

<div class="scraping-item">
  <p class="scraping-name">Scientific Article Scraping</p>
  <form id="article-scrapping" role="form" method="post" action="{{route('admin_scraping.email_extractor')}}" enctype='multipart/form-data'>
    @csrf
      <input type="file" name="scrape" id="scrape" style="display: none;" accept=".csv"/>
      <label class="uploadButton" for="scrape"><span>Import PMID List (.csv)</span></label>
      {{--<button type="sumbit" class="button_simple"><p><strong>Email Extract</strong></p></button>--}}
      <button type="button" class="button_simple" onclick="article_scrapping()"><p><strong>Email Extract</strong></p></button>
  </form>
</div>


<div class="scraping-item">
  <p class="scraping-name">Linkedin Scraping</p>
  <div style="display: flex; align-items: center;">
    <form id="linkedin-scrapping" role="form" method="post" action="{{route('admin_scraping.linkedin_scraping')}}" enctype='multipart/form-data'>
      @csrf
        <input type="text" id="linkedin" name="linkedin"/>
        <button type="button" class="button_simple" id="linkedin-submit"><p><strong>Scraping</strong></p></button>
    </form>
    <a href="{{env('APP_URL')}}/uploads/linkedin.csv" target="_blank" id="download-linkedin-csv" style="margin-left: 1rem;">Download</a>
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

    $("#linkedin-submit").click(function() {
      var inputval = $("#linkedin").val();
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
      $.ajax({
          url: $('#linkedin-scrapping').attr('action'),
          method: "POST",
          data: {field: inputval},
          dataType: "json",
          beforeSend: function() {
            document.getElementById('preloader').style.display = 'block';
          },
          success: function(response) {
            if (response.res == 1){
              document.getElementById('preloader').style.display = 'none';
              $('#download-linkedin-csv').attr('href' , `{{env('APP_URL')}}/uploads/output.csv?version=${new Date().getTime()}`)
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
