@extends('admin.layout')

@section('main')
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <div class="pull-right">
                    <div class="btn-group">
                        <a href="{{ route('admin_questionaire.create') }}" class="btn  btn-flat btn-success" title="{{trans('questionaire.admin.add_new')}}" style="margin: 0 5px">
                            <i class="fa fa-plus"></i>
                            <span class="hidden-xs"> {{trans('questionaire.admin.add_new')}}</span>
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
                                @foreach ($questionaire as $question)
                                    <tr id="tr-question_{{ $question->id }}" data-id="{{ $question->id }}" class="clickable">
                                        <td>{{ $question->id }}</td>
                                        <td>{{ $question->question }}</td>
                                        <td>
                                            <a href="{{ route('admin_questionaire.edit', ['id' => $question->id]) }}">
                                                <span title="Edit" type="button" class="btn btn-flat btn-primary">
                                                    <i class="fa fa-edit"></i>
                                                </span>
                                            </a>
                                            &nbsp;
                                            <span onclick="deleteItem({{ $question->id }});" title="Delete" class="btn btn-flat btn-danger">
                                                <i class="fa fa-trash"></i>
                                            </span>
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
                                @foreach ($questionaire as $question)
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
    let deleteUrl = "{{ route('admin_questionaire.delete', ['id'=>'question_ID']) }}";
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
                    $("#tr-question_" + id).remove();
                }
            }

        });
    }
    
    $(document).ready(function() {
        $("#question-table tr.clickable").first().addClass('clicked');
        loadHierarchy();
    });

    $("#question-table tr.clickable").click(function() {
        if ($(this).hasClass('clicked')) {
            return;
        }
        $("#question-table tr.clickable").removeClass('clicked');
        $(this).addClass("clicked");
        loadHierarchy();
    });

    function loadHierarchy() {
        $("#answer-container").empty();
        $("#next-question-table").removeClass("clicked");

        let question_id = $("#question-table tr.clickable.clicked").data("id");
        answers = questionaire.find(element => element.id == question_id).options;
        if (!answers) {
            return;
        }
        answers.forEach(function(answer, idx) {
            let html = '<div data-id="' + idx + '">' + answer.option + '</div>';
            $("#answer-container").append(html);
        });
        initAnswerEvent();
    }

    function initAnswerEvent() {
        $("#answer-container div").click(function() {
            $(this).addClass("clicked");
            if (!answers) {
                return;
            }
            let id = $(this).data('id');
            
        });
    }

    function loadNextQuestion() {
        
    }
</script>

@endpush