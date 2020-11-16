@extends('admin.layout')

@section('main')

<div class="scraping-item">
  <p class="scraping-name">Scientific Article Scraping</p>
  <form role="form" method="post" action="{{route('admin_scraping.email_extractor')}}" enctype='multipart/form-data'>
    @csrf
      <input type="file" name="scrape" id="scrape" style="display: none;" accept=".csv"/>
      <label class="uploadButton" for="scrape"><span>Import PMID List (.csv)</span></label>
      <button type="sumbit" class="button_simple"><p><strong>Email Extract</strong></p></button>
  </form>
</div>

<div class="scraping-item">
  <p class="scraping-name">Website Scraping</p>
  <form role="form" method="post" action="{{route('admin_scraping.web_scraping')}}" enctype='multipart/form-data'>
    @csrf
      <input type="file" name="web_scrape" id="web_scrape" style="display: none;" accept=".csv"/>
      <label class="uploadButton" for="web_scrape"><span>Import Website List (.csv)</span></label>
      <button type="sumbit" class="button_simple"><p><strong>Email Extract</strong></p></button>
  </form>
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
</style>
@endpush

