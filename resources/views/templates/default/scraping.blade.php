@extends($templatePath.'.shop_layout')

@section('main')

<form role="form" method="post" action="{{route('email_extractor')}}" enctype='multipart/form-data'>
	@csrf
    <input type="file" name="scrape" id="scrape" style="display: none;" accept=".csv"/>
    <label class="uploadButton" for="scrape"><span>insert csv file</span></label>
    <button type="sumbit" class="button_simple"><p><strong>EMAIL SCRAPING</strong></p></button>
</form>

@endsection


