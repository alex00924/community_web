@extends('admin.layout')

@section('main')
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <!-- Box body -->
            <div class="row box-body" >
                <div class="col-xs-4" style="overflow: auto; max-height: 80vh">
                    @foreach($questionaires as $questionaire_key => $questionaire)
                    <h3 class="text-center" style="font-size: 20px; font-weight: 400; margin-top: 3rem; margin-bottom: 1rem"> {{ $questionaire['title'] }} </h3>
                    <div class="table-responsive no-padding box-shadow">
                        <table class="table table-hover" id="question-table">
                            <tbody>
                                @foreach ($questionaire['questions'] as $question_key => $question)
                                    <tr data-questionaire_key="{{ $questionaire_key }}" data-question_key="{{ $question_key }}" class="clickable">
                                        <td>{{ ($question_key+1) . ". " . $question['question'] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endforeach
                </div>

                <div class="col-xs-8" style="padding-top: 5rem">
                    <h2 style="font-size: 20px; font-weight: 500; text-align: center" id="chart-title1"></h2>
                    <br>
                    <h2 style="font-size: 16px; font-weight: 400; text-align: center" id="chart-title2"></h2>
                    <br>
                    <div style="width: 100%;">
                        <p id="statistic-result" style="text-align: center"></p>
                    </div>
                    <br>
                    <div style="width: 100%; padding: 0 10%; height: 500px; ">
                        <canvas id="statistic-chart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.css">
@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>
<script type="text/javascript">
    let questionaires = @json($questionaires);
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
    });
    
    $(".clickable").click(function() {
        $(".clickable").removeClass("clicked");
        $(this).addClass("clicked");
        loadStatistics();
    });

    function loadStatistics() {
        let questionaireIdx = $(".clicked").data("questionaire_key");
        let questionIdx = $(".clicked").data("question_key");
        let question = questionaires[questionaireIdx]["questions"][questionIdx];
        let chartLabels = [];
        let chartBgColors = [];
        let chartData = [];
        let resHtml = '';

        $("#chart-title1").html(questionaires[questionaireIdx]["title"]);
        $("#chart-title2").html(question["question"]);

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
                resHtml += chartLabels[i] + " - " + Math.round(sumVals[i] / length);
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
                let percentage = totalCnt == 0 ? 0 : Math.round(option["cnt"] * 100 / totalCnt_;
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