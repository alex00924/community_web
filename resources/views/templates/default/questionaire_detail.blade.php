@extends($templatePath.'.shop_layout')

@section('main')
<section >
    <div class="container">
        <h2 class="title text-center">{{ trans('front.questionaire.survey') }}</h2>
        <!-- Center colunm-->
        <h4 style="font-weight: 600; font-size: 20px; text-align: center">{{ $questionaire["title"] }} </h4>
        <br><br>
        <div class="row">
            @if($questionaire["type"] == 'General')
            <div class="col-xs-4">
            @else
            <div class="col-xs-12" style="padding: 0 20%">
            @endif
                @foreach($answers as $answer_key => $answer)
                <div class="statistic-question {{ $questionaire['type'] == 'General' ? 'clickable' : '' }}" data-question_id = "{{ $answer->question->id }}" > {{ ($answer_key+1) . ". " . $answer->question->question }} </div>
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
            @if($questionaire['type'] == 'General')
            <div class="col-xs-8" style="padding-top: 5rem">
                <h2 style="font-size: 20px; font-weight: 500; text-align: center">Statistic Results</h2>
                <br><br>
                <h3 style="font-size: 18px; font-weight: 500; text-align: center" id="chart-title1"></h3>
                <br><br>
                <div style="width: 100%;">
                    <p id="statistic-result" style="text-align: center"></p>
                </div>
                <br>
                <div style="width: 100%; padding: 0 10%; height: 500px; ">
                    <canvas id="statistic-chart"></canvas>
                </div>
            </div>
            @endif
        </div>
    </div>
</section>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.css">
@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>
<script type="text/javascript">
    let questionaire = @json($questionaire);
    let chartColors = [
        "rgb(255, 99, 132)",
        "rgb(255, 159, 64)",
        "rgb(255, 205, 86)",
        "rgb(75, 192, 192)",
        "rgb(54, 162, 235)",
        "rgb(153, 102, 255)",
        "rgb(201, 203, 207)"
    ];
    let statisticPieChart;

    $(document).ready(function() {
        if (questionaire["type"] == "General") {
            $(".clickable").first().addClass("clicked");
            let ctx = document.getElementById("statistic-chart").getContext("2d");
            statisticPieChart = new Chart(ctx, {
                data: {
                    datasets: [{}]
                },
                type: 'doughnut',
                option: {
                    legend: {
                        position: "right"
                    }
                }
            });
            loadStatistics();
        }
    });
    
    $(".clickable").click(function() {
        $(".clickable").removeClass("clicked");
        $(this).addClass("clicked");
        loadStatistics();
    });

    function loadStatistics() {
        let questionId = $(".clicked").data("question_id");
        let question = questionaire["questions"].find(element => element["id"] == questionId);
        let chartLabels = [];
        let chartBgColors = [];
        let chartData = [];
        let resHtml = '';

        $("#chart-title1").html(question["question"]);

        if (question["answer_type"] == "triangle") {
            chartData = [0, 0, 0];
            let sumVals = [0, 0, 0];

            question["options"].forEach(function(option, idx) {
                chartLabels[idx] = option["option"];
                chartBgColors[idx] = chartColors[idx % chartColors.length];
            });
            question["answers"].forEach(function(answer, idx) {
                for (let i = 0 ; i < 3; i ++) {
                    sumVals[i] += answer[i];
                }
                chartData[answer.indexOf(Math.max(...answer))]++;
            });

            let length = Math.max(1, question["answers"].length);
            resHtml = "(Mean Values) &emsp;&emsp;";
            for (let i = 0 ; i < 3; i ++) {
                if (i > 0) {
                    resHtml += "&emsp;";
                }
                resHtml += chartLabels[i] + " - " + sumVals[i] / length;
            }
        } else {
            let totalCnt = 0;
            question["options"].forEach(function(option, idx) {
                totalCnt += option["cnt"];
                chartLabels[idx] = option["option"];
                chartBgColors[idx] = chartColors[idx % chartColors.length];
                chartData[idx] = option["cnt"];
            });
            question["options"].forEach(function(option, idx) {
                let percentage = totalCnt == 0 ? 0 : option["cnt"] * 100 / totalCnt;
                if (idx > 0) {
                    resHtml += "&emsp;";
                }
                resHtml += option["option"] + " - " + percentage + "%";
            });
        }
        statisticPieChart.data.labels = chartLabels;
        statisticPieChart.data.datasets[0].data = chartData;
        statisticPieChart.data.datasets[0].backgroundColor = chartBgColors;
        statisticPieChart.update();
        $("#statistic-result").html(resHtml);
    }
</script>
@endpush