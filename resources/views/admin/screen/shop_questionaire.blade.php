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
            <div class="row box-body v-center" >
                <div class="col-xs-5">
                    <div class="table-responsive no-padding box-shadow">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Question</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach ($questionaire as $question)
                                    <tr id="tr-question_{{ $question->id }}">
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
                        <div id="answer-container">
                            answer1
                            <br>
                            answer2
                        </div>
                    </div>
                </div>

                <div class="col-xs-4">
                    <div class="table-responsive no-padding box-shadow">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>Next Question</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach ($questionaire as $question)
                                    <tr id="tr-next-question_{{ $question->id }}">
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
</script>

@endpush