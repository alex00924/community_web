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
                <div class="col-xs-8">
                    <div class="table-responsive no-padding box-shadow">
                        <table class="table table-hover" id="question-table">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Question</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach ($questionaire as $key => $question)
                                    <tr id="tr-question_{{ $question->id }}" data-id="{{ $key }}" class="clickable">
                                        <td>{{ $question->id }}</td>
                                        <td>{!! nl2br(e($question->question->question)) !!}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="col-xs-4">
                    <div class="box-shadow">
                        <h2 style="padding: 10px 0; text-align: center; font-size: 18px; font-weight: 500;"> Answers </h2>
                        <div id="answer-container" class="answers">
                        <table class="table table-hover" id="question-table">
                        <tbody>
                            @foreach ($questionaire as $key => $question)
                                <tr id="tr-question_{{ $question->id }}" data-id="{{ $key }}" class="clickable">
                                    <td>{!! nl2br(e($question->answer)) !!}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        </table>
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

   
</script>

@endpush