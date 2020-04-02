@extends($templatePath.'.shop_layout')

@section('main')
<section >
    <div class="container">
      <div class="row">
            <h2 class="title text-center">{{ trans('front.questionaire.survey') }}</h2>
            <!-- Center colunm-->
        </div>
    </div>
</section>
@endsection

@push('scripts')
    <script>
    </script>
@endpush