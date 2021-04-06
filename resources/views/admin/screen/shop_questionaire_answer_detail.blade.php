@extends('admin.layout')

@section('main')
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <div class="pull-right">
                    <div class="btn-group">
                        <a href="{{ route('admin_questionaire.email') }}" class="btn  btn-flat btn-default" title="{{trans('questionaire.admin.back_questionaire')}}" style="margin: 0 5px">
                            <i class="fa fa-list"></i>
                            <span class="hidden-xs"> {{trans('questionaire.admin.back_questionaire')}}</span>
                        </a>
                    </div>
                </div>
            </div>
            <!-- /.box-header -->
            
            <!-- Box body -->
            <div class="row box-body" >
                <div class="col-xs-7">
                    <div class="table-responsive no-padding box-shadow">
                        <table class="table table-hover" id="question-table">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Question</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach ($questionaire as $key => $question)
                                    <tr id="tr-question_{{ $question->id }}" data-id="{{ $key }}" class="clickable">
                                        <td>{{ $question->id }}</td>
                                        <td>{!! nl2br(e($question->question->question)) !!}</td>
                                        <td style="opacity: 0">
                                            <span type="button" class="btn btn-flat btn-primary"><i class="fa fa-edit"></i></span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="col-xs-5">
                    <div class="table-responsive no-padding box-shadow">
                        <table class="table table-hover" id="question-table">
                            <thead>
                            <tr>
                                <th>Answer</th>
                                <th>Tags</th>
                                <th>Tag Action</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach ($questionaire as $key => $question)
                                    <tr id="tr-question_{{ $question->id }}" data-id="{{ $key }}" class="clickable">
                                        <td>{!! nl2br(e($question->answer)) !!}</td>
                                        <td>{!! nl2br(e($question->interest_tag)) !!}</td>
                                        <td>
                                            <span type="button" class="btn btn-flat btn-success" data-toggle="modal" data-target="#myModal" data-answerid="{{ $question->answer }}" data-tag=""><i class="fa fa-plus"></i></span>
                                            <span type="button" class="btn btn-flat btn-primary" data-toggle="modal" data-target="#myModal" data-answerid="{{ $question->answer }}" data-tag="{{ $question->interest_tag }}"><i class="fa fa-edit"></i></span>
                                            <span type="button" class="btn btn-flat btn-danger deleteButton" id="{{ $question->answer }}"><i class="fa fa-trash"></i></span>
                                            <!-- <button type="button" class="btn btn-flat btn-success" data-toggle="modal" data-target="#myModal" data-answerid="{{ $question->answer }}" style="margin: 0px; padding: 0px 5px; font-size: 12px">Add Tag</button> -->

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>                  
                </div>
                <!-- Modal -->
                <div class="modal fade" id="myModal" role="dialog">
                    <div class="modal-dialog">
                    
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Add Tag</h4>
                        </div>
                        <div class="modal-body">
                            <form action="" id="questionaire-form" method="POST" accept-charset="UTF-8" class="form-horizontal">
                                <div class="form-group  ">
                                    <div class="col-sm-12">
                                        <input type="text" id="tag" name="tag" class="form-control input-sm image" placeholder="" />
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-success" data-dismiss="modal" id="tag-submit">Ok</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                    
                    </div>
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

    $('#myModal').on('show.bs.modal', function(e) {
        var answer = $(e.relatedTarget).data('answerid');
        var oldtag = $(e.relatedTarget).data('tag');
        $('#tag').val(oldtag);
        $("#tag-submit").click(function() {
        var tagname = $('#tag').val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: $('#questionaire-form').attr('action'),
                method: "POST",
                data: {
                    answer: answer,
                    tag: tagname,
                },
                dataType: "json",
                success: function(response) {
                    if (response.error == 0) {
                        location.reload(true);
                    }
                }
            })
        })
    })

    $('.deleteButton').on('click', function(e) {
        e.preventDefault();
        var answer = this.id;
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: $('#questionaire-form').attr('action'),
            method: "POST",
            data: {
                answer: answer,
                tag: '',
            },
            dataType: "json",
            success: function(response) {
                if (response.error == 0) {
                    location.reload(true);
                }
            }
        })
    })
</script>

@endpush