@extends('admin.layout')

@section('main')
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <h2 class="box-title">{{ $title_description??'' }}</h2>

                <div class="box-tools">
                    <div class="btn-group pull-right" style="margin-right: 5px">
                        <a href="{{ route('admin_questionaire.indexQuestion', ['questionaire_id' => $questionaire_id]) }}" class="btn  btn-flat btn-default" title="List"><i
                                class="fa fa-list"></i><span class="hidden-xs"> {{trans('questionaire.admin.back_questionaire_hierarchy')}}</span></a>
                    </div>
                </div>
            </div>
            <!-- /.box-header -->
            <form action="{{ route('admin_questionaire.createQuestion', ['questionaire_id' => $questionaire_id]) }}" id="question-form" method="POST" accept-charset="UTF-8" class="form-horizontal">
                <!-- Box body -->
                <div class="box-body">
                    <div class="fields-group">

                        <div class="form-group {{ $errors->has('question') ? ' has-error' : '' }}">
                            <label class="col-xs-2 control-label" for="question">{{ trans('questionaire.admin.question') }}</label>
                            <div class="col-xs-8">
                                <textarea id="question" name="question" class="form-control input-sm" rows="5" 
                                    required>{{ old('question') }}</textarea>
                                @if ($errors->has('question'))
                                <span class="help-block">
                                    <i class="fa fa-info-circle"></i>
                                    {{ $errors->first('question') }}
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('type') ? ' has-error' : '' }}">
                            <label class="col-xs-2 control-label" for="type">{{ trans('questionaire.admin.answer_type') }}</label>
                            <div class="col-xs-8">
                                <select class="form-control select2" style="width: 100%;" name="type" id="type" required>
                                    <option value="radio" {{ (old('type') == 'radio') ? 'selected':'' }}> Radio </option>
                                    <option value="select" {{ (old('type') == 'select') ? 'selected':'' }}> Select </option>
                                    <option value="slider" {{ (old('type') == 'slider') ? 'selected':'' }}> Slider </option>
                                    <option value="triangle" {{ (old('type') == 'triangle') ? 'selected':'' }}> Triangle </option>
                                    <option value="input" {{ (old('type') == 'input') ? 'selected':'' }}> Input </option>
                                </select>
                                @if ($errors->has('type'))
                                <span class="help-block">
                                    <i class="fa fa-info-circle"></i>
                                    {{ $errors->first('type') }}
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('answers') ? ' has-error' : '' }}">
                            <label class="col-xs-2 control-label">{{ trans('questionaire.admin.answers') }}</label>
                            <div class="col-xs-8">
                                <table style="width: 100%; margin-bottom: 10px;">
                                    @php
                                        $answerID = 1;
                                    @endphp
                                    @if (!empty(old('answers')))
                                        @foreach (old('answers') as $idx => $answerVal)
                                            @php
                                                $newHtml = str_replace('answer_value', $answerVal, $htmlAnswer);
                                                $newHtml = str_replace('answer_idx', $answerID, $newHtml);
                                                $answerID++;
                                            @endphp
                                            {!! $newHtml !!}
                                        @endforeach
                                    @endif
                                    <tr>
                                        <td colspan="2"><br>
                                            <button type="button" class="btn btn-flat btn-success add-answer">
                                                <i class="fa fa-plus" aria-hidden="true"></i>
                                                {{ trans('questionaire.admin.add_answer') }}
                                            </button><br>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- End Box Body -->

                <!-- Box Footer -->
                <div class="box-footer" id="box-footer">
                    @csrf
                    <div class="col-md-2">
                    </div>

                    <div class="col-md-8">
                        <div class="btn-group pull-right">
                            <button type="submit" class="btn btn-primary">{{ trans('admin.submit') }}</button>
                        </div>

                        <div class="btn-group pull-left">
                            <button type="reset" class="btn btn-warning">{{ trans('admin.reset') }}</button>
                        </div>
                    </div>
                </div>
                <!-- End Box Footer -->
            </form>
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
    let answerID = {!! $answerID !!};
    $(document).ready(function() {
        $('.select2').select2()
    });

    $('.add-answer').click(function(event) {
        var htmlAnswer = '{!! $htmlAnswer??'' !!}';
        htmlAnswer = htmlAnswer.replace("answer_value", "");
        htmlAnswer = htmlAnswer.replace("answer_idx", answerID);
        answerID++;
        $(this).closest('tr').before(htmlAnswer);
        $('.removeAnswer').click(function(event) {
            $(this).closest('tr').remove();
        });
    });
    
    $('.removeAnswer').click(function(event) {
        $(this).closest('tr').remove();
    });

    $("#question-form").submit(function() {
        let answerCnt = $("input[name^='answers']").length;
       if (answerCnt < 2)  {
            alert("You have to add at least 2 answers for each question!");
            return false;
       }

       if (answerCnt != 3 && $("#type").val() == "triangle") {
           alert("You can choose triangle format for a question which have only 3 answers.");
           return false;
       }
    });
</script>
@endpush