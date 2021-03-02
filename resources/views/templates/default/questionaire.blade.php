@extends($templatePath.'.shop_layout')

@section('main')
<section >
    <div class="container">
      <div class="row">
            @if ($category === 'survey')
            <h1 class="title text-center">{{ trans('front.questionaire.survey') }}</h1>
            @else
            <h1 class="title text-center">{{ trans('front.questionaire.marketingsurvey') }}</h1>
            @endif
            <!-- Center colunm-->
            <div class="center_column table-responsive" style="box-shadow: 0px 0px 5px rgba(100, 100, 100, 0.5);">
                <table class="table table-hover" id="question-table">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Type</th>
                        <th>Specification</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach ($questionaires as $key => $questionaire)
                            <tr data-id="{{ $questionaire->id }}"  class="linkable">
                                <td>{{ $questionaire->id }}</td>
                                <td>{{ $questionaire->title }}</td>
                                <td>{{ $questionaire->type }}</td>
                                @php
                                    $html = '';
                                    if($questionaire->type == 'Product' && !empty($questionaire->target_id))
                                    {
                                        $product = App\Models\ShopProduct::find($questionaire->target_id);
                                        if($product)
                                        {
                                            $html = '<img src="' . $product->image . '" style="width: 50px; height: auto;"/>';
                                            $html .='<span>' . $product->name . '</span>';
                                        }
                                    }
                                @endphp
                                <td class="{{ strlen($html) > 0 ? 'v-center' : '' }}"> @php echo $html; @endphp </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
    <script>
        var category = @json($category);
        let detailUrl = "{{ route('questionaire.detail', ['questionaire_id' => 'questionaireID', 'question_id' => 0]) }}";
        $(document).ready(function() {
            initEvents();
        });

        function initEvents() {
            $(".linkable").click(function() {
                let url = detailUrl.replace("questionaireID", $(this).data("id"));
                document.location.href = url;
            });
        }
    </script>
@endpush