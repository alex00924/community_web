@extends($templatePath.'.shop_layout')

@section('main')
<section >
<div class="container">
    <div class="row">
        <h1 class="title text-center">{{ $title }}</h1>
        {!! sc_html_render($page->content) !!}
</div>
</div>
</section>

@endsection

@section('breadcrumb')
    <div class="breadcrumbs">
      <ol class="breadcrumb">
        <li><a href="{{ route('home') }}">{{ trans('front.home') }}</a></li>
        <li class="active">{{ $title }}</li>
      </ol>
    </div>
@endsection
