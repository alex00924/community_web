@extends('admin.layout')

@section('main')
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <div class="pull-right">
                    <div class="btn-group">
                        <a href="{{ route('admin_questionaire.createQuestion', ['questionaire_id' => $questionaire_id]) }}" class="btn  btn-flat btn-success" title="{{trans('questionaire.admin.add_new')}}" style="margin: 0 5px">
                            <i class="fa fa-plus"></i>
                            <span class="hidden-xs"> {{trans('questionaire.admin.add_new')}}</span>
                        </a>
                    </div>
                    <div class="btn-group">
                        <a href="{{ route('admin_questionaire.index') }}" class="btn  btn-flat btn-default" title="{{trans('questionaire.admin.back_questionaire')}}" style="margin: 0 5px">
                            <i class="fa fa-list"></i>
                            <span class="hidden-xs"> {{trans('questionaire.admin.back_questionaire')}}</span>
                        </a>
                    </div>
                </div>
            </div>
            <!-- /.box-header -->
            
            <!-- Box body -->
            <div class="row box-body" >
                <div class="col-xs-5">
                    <div class="table-responsive no-padding box-shadow">
                        <table class="table table-hover" id="question-table">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Question</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach ($questionaire as $key => $question)
                                    <tr id="tr-question_{{ $question->id }}" data-id="{{ $key }}" class="clickable">
                                        <td>{{ $question->id }}</td>
                                        <td>{!! nl2br(e($question->question)) !!}</td>
                                        <td>
                                            <a href="{{ route('admin_questionaire.editQuestion', ['questionaire_id' => $questionaire_id, 'id' => $question->id]) }}">
                                                <span title="Edit" type="button" class="btn btn-flat btn-primary">
                                                    <i class="fa fa-edit"></i>
                                                </span>
                                            </a>
                                            &nbsp;
                                            @if (Session::get('userrole') == 1)
                                            <span id="{{$question->id}}" title="Delete" class="btn btn-flat btn-danger btn-delete">
                                                <i class="fa fa-trash"></i>
                                            </span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="col-xs-3">
                    <div class="box-shadow">
                        <h2 style="padding: 10px 0; text-align: center; font-size: 18px; font-weight: 500;"> Answers </h2>
                        <div id="answer-container" class="answers">
                            
                        </div>
                    </div>
                </div>

                <div class="col-xs-4">
                    <div class="table-responsive no-padding box-shadow">
                        <table class="table table-hover" id="next-question-table">
                            <thead>
                            <tr>
                                <th>Next Question</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach ($questionaire as $key => $question)
                                    <tr id="tr-next-question_{{ $question->id }}" data-id="{{ $question->id }}" class="clickable">
                                        <td>{{ $question->question }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="loading-image" style="width: 100%; height: 100%; background: rgba(0,0,0,.6); z-index: 1001; display: none; position: fixed; top: 0; left: 0">
    <img src="/admin/images/loading.gif" style="position: absolute; width: 100px; height: 100px; left: calc(50% - 50px); top: calc(50% - 50px)">
    <div style="position: absolute; top: calc(50% + 80px); width: 100%; text-align: center">
        <p style="font-size: 18px; color: white"> Updating...</p>
    </div>
</div>
@endsection

@push('styles')
<!-- Select2 -->
<link rel="stylesheet" href="{{ asset('admin/AdminLTE/bower_components/select2/dist/css/select2.min.css')}}">

{{-- switch --}}
<link rel="stylesheet" href="{{ asset('admin/plugin/bootstrap-switch.min.css')}}">

@endpush

@push('scripts')
<!-- Select2 -->
<script src="{{ asset('admin/AdminLTE/bower_components/select2/dist/js/select2.full.min.js')}}"></script>

{{-- switch --}}
<script src="{{ asset('admin/plugin/bootstrap-switch.min.js')}}"></script>

<script type="text/javascript">
    $("[name='top'],[name='status']").bootstrapSwitch();
</script>

<script type="text/javascript">
    let category = @json($category);
    let deleteUrl = "{{ route('admin_questionaire.deleteQuestion', ['id'=>'question_ID']) }}";
    let questionaire = @json($questionaire);
    let answers = null;

    function deleteItem(id) {
        if (!confirm("Are you sure to delete this question?")) {
            return;
        }
        if (id < 1) {
            return;
        }
        $.ajax({
            type: "POST",
            data: {"_token": "{{ csrf_token() }}"},
            url: deleteUrl.replace('question_ID', id),
            success: function(response){
                if (response.error == 1) {
                    console.log(response.msg);
                } else {
                    if ($("#tr-question_" + id).hasClass('clicked')) {
                        $("#tr-question_" + id).remove();
                        $("#tr-next-question_" + id).remove();
                        $("#question-table tr.clickable").first().addClass('clicked');
                        loadHierarchy();
                    } else {
                        $("#tr-question_" + id).remove();
                    }
                }
            }

        });
    }
    
    $(document).ready(function() {
        $("#question-table tr.clickable").first().addClass('clicked');
        loadHierarchy();
    });
    $(".btn-delete").on('click', function(event) {
        deleteItem($(this).attr('id'));
        event.stopPropagation();
    });
    $("#question-table tr.clickable").click(function() {
        if ($(this).hasClass('clicked')) {
            return;
        }
        $("#question-table tr.clickable").removeClass('clicked');
        $(this).addClass("clicked");
        loadHierarchy();
    });
    
    $("#next-question-table tr.clickable").click(function() {
        let currentElement = $(this);

        if (currentElement.hasClass('clicked')) {
            return;
        }

        let questionIdx = $("#question-table tr.clickable.clicked").data('id');
        let answerIdx = $("#answer-container div.clicked").data('id');
        let nextQuestionId = $(this).data('id');
        if (questionIdx < 0 || answerIdx < 0 || !nextQuestionId) {
            return;
        }
            
        for(var i=0; i<questionaire[questionIdx].options.length; i++){
            $("#loading-image").show();
            questionaire[questionIdx].options[i].next_question_id = nextQuestionId;
            $.ajax({
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    question: questionaire[questionIdx].id,
                    option: questionaire[questionIdx].options[i].id,
                    nextQuestion: nextQuestionId
                },
                url: "{{ route('admin_questionaire.updateNextQuestion') }}",
                success: function(response){
                    if (response.indexOf("Invalid") > -1) {
                        alert(response);
                    } else {
                        $("#next-question-table tr.clickable").removeClass("clicked");
                        currentElement.addClass('clicked');
                    }
                    $("#loading-image").hide();
                }
            });
        }
    });

    function loadHierarchy() {
        $("#answer-container").empty();
        $("#next-question-table tr.clicked").removeClass("clicked");

        let question_id = $("#question-table tr.clickable.clicked").data("id");
        answers = questionaire[question_id].options;
        if (!answers) {
            return;
        }
        answers.forEach(function(answer, idx) {
            let html = '<div data-id="' + idx + '">' + answer.option + '</div>';
            $("#answer-container").append(html);
        });
        $("#answer-container div").click(function() {
            $("#answer-container div").removeClass('clicked');
            $(this).addClass("clicked");
            updateNextAnswer();
        });

        $("#answer-container div").first().addClass('clicked');
        updateNextAnswer();
    }

    function updateNextAnswer() {
        $("#next-question-table tr.clicked").removeClass("clicked");

        if (!answers) {
            return;
        }

        let id = $("#answer-container div.clicked").data('id');
        if (id < 0) {
            return;
        }

        let nextQuestionId = answers[id].next_question_id;
        if(!nextQuestionId) {
            return;
        }

        $("#next-question-table #tr-next-question_" + nextQuestionId).addClass('clicked');
    }

</script>

@endpush