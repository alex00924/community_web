@extends($templatePath.'.shop_layout')

@section('main')
<section >
    <div class="container">
        <h2 class="title text-center">{{ trans('front.questionaire.survey') }}</h2>
        <!-- Center colunm-->
        <h4 style="font-weight: 600; font-size: 20px; text-align: center">{{ $questionaire->title }} </h4>
        <br><br>
        <div class="row">
            <div class="col-xs-12" style="padding: 0 20%">
                @foreach($answers as $answer_key => $answer)
                <div style="font-weight: 500; font-size: 18px"> {{ ($answer_key+1) . ". " . $answer->question->question }} </div>
                <ul class="answer-ul">
                    @foreach($answer->question->options as $key => $option)
                        @if($answer->question->answer_type == "triangle")
                            @php
                                $answerOpts = json_decode($answer->answer);
                            @endphp
                            <li> {{ $option->option }} : {{ $answerOpts[$key] }}% </li>
                        @else
                            <li class="{{ $answer->answer == $option->option ? 'selected' : '' }}"> {{ $option->option }} </li>
                        @endif
                    @endforeach
                </ul>
                @endforeach
            </div>
        </div>
    </div>
</section>
@endsection