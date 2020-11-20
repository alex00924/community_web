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
  <p class="scraping-name">Website Scraping</p>
  <form id="website-scrapping" role="form" method="post" action="{{route('admin_scraping.web_scraping')}}" enctype='multipart/form-data'>
    @csrf
      <input type="file" name="web_scrape" id="web_scrape" style="display: none;" accept=".csv"/>
      <label class="uploadButton" for="web_scrape"><span>Import Website List (.csv)</span></label>
      <button type="button" class="button_simple" onclick="website_scrapping()"><p><strong>Email Extract</strong></p></button>
  </form>
</div>

{{--<div class="scraping-item">
  <p class="scraping-name">Crunchbase Scraping</p>
  <form id="crunchbase-scrapping" role="form" method="post" action="{{route('admin_scraping.crunchbase_scraping')}}" enctype='multipart/form-data'>
    @csrf
      <button type="button" class="button_simple" onclick="crunchbase_scrapping()"><p><strong>Scraping</strong></p></button>
  </form>
</div>

<div class="scraping-item">
  <p class="scraping-name">Linkedin Scraping</p>
  <form id="crunchbase-scrapping" role="form" method="post" action="{{route('admin_scraping.linkedin_scraping')}}" enctype='multipart/form-data'>
    @csrf
      <input type="text" id="linkedin" name="linkedin">
      <button type="submit" class="button_simple"><p><strong>Scraping</strong></p></button>
  </form>
</div>--}}
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

  function website_scrapping()
  {
		document.getElementById('preloader').style.display = 'block';

    setTimeout(function(){
			document.getElementById('preloader').style.display = 'none';
		},10000);

    $("#website-scrapping").submit();
  }

  function article_scrapping()
  {
    document.getElementById('preloader').style.display = 'block';

    setTimeout(function(){
      document.getElementById('preloader').style.display = 'none';
    },10000);

    $("#article-scrapping").submit();
  }

  function crunchbase_scrapping()
  {
    document.getElementById('preloader').style.display = 'block';

    setTimeout(function(){
      document.getElementById('preloader').style.display = 'none';
    },10000);

    $("#crunchbase-scrapping").submit();
  }

</script>
@endpush
