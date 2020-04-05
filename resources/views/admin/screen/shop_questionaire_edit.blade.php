@extends('admin.layout')

@section('main')
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <h2 class="box-title">{{ $title_description??'' }}</h2>

                <div class="box-tools">
                    <div class="btn-group pull-right" style="margin-right: 5px">
                        <a href="{{ route('admin_questionaire.index') }}" class="btn  btn-flat btn-default" title="List"><i
                                class="fa fa-list"></i><span class="hidden-xs"> {{trans('questionaire.admin.back_questionaire')}}</span></a>
                    </div>
                </div>
            </div>
            <!-- /.box-header -->
            <form action="{{ route('admin_questionaire.edit', ['id' => $questionaire->id]) }}" id="questionaire-form" method="POST" accept-charset="UTF-8" class="form-horizontal">
                <!-- Box body -->
                <div class="box-body">
                    <div class="fields-group">

                        <div class="form-group {{ $errors->has('title') ? ' has-error' : '' }}">
                            <label class="col-xs-2 control-label" for="title">{{ trans('questionaire.admin.questionaire') }}</label>
                            <div class="col-xs-8">
                                <input id="title" name="title" class="form-control input-sm" value="{{ empty(old('title')) ? $questionaire->title : old('title') }}" required>
                                @if ($errors->has('title'))
                                <span class="help-block">
                                    <i class="fa fa-info-circle"></i>
                                    {{ $errors->first('title') }}
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('type') ? ' has-error' : '' }}">
                            <label class="col-xs-2 control-label" for="type">{{ trans('questionaire.admin.type') }}</label>
                            <div class="col-xs-8">
                                @php
                                $type = empty(old('type')) ? $questionaire->type : old('type');
                                @endphp
                                <select class="form-control select2" style="width: 100%;" name="type" id="type" required onchange="updateTarget()">
                                    <option value="General" {{ ($type == 'General') ? 'selected':'' }}> General </option>
                                    <option value="Product" {{ ($type == 'Product') ? 'selected':'' }}> Product </option>
                                </select>
                                @if ($errors->has('type'))
                                <span class="help-block">
                                    <i class="fa fa-info-circle"></i>
                                    {{ $errors->first('type') }}
                                </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-xs-2 control-label" for="type">{{ trans('questionaire.admin.access_level') }}</label>
                            <div class="col-xs-8">
                                @php
                                    $access_level = empty(old('access_level')) ? $questionaire->access_level : old('access_level');
                                @endphp
                                <label class="radio-inline">
                                    <input type="radio" name="access_level" {{ ( $access_level == '1' ) ? 'checked' : '' }} value="1">
                                    Yes
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="access_level" {{ ( $access_level == '0' ) ? 'checked' : '' }} value="0">
                                    No
                                </label>
                            </div>
                        </div>

                        <input type="hidden" id="target_id" name="target_id" value="{{ empty(old('target_id')) ? $questionaire->target_id : old('target_id') }}">
                        <div class="form-group">
                            <label class="col-xs-2 control-label">{{ trans('questionaire.admin.target') }}</label>
                            <div class="col-xs-8" style="overflow: auto; height: 60vh">
                                <div class="table-responsive no-padding box-shadow target-container" id="target-product" style="display: none">
                                    <table class="table table-hover">
                                        <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Image</th>
                                            <th>Name</th>
                                            <th>SKU</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($products as $product)
                                            <tr id="target-element_{{ $product->id }}" data-id="{{ $product->id }}" class="clickable">
                                                <td> {{ $product->id }} </td>
                                                <td> <img style="width: 50px; height: auto;" src="{{ $product->image }}" /></td>
                                                <td> {{ $product->name }} </td>
                                                <td> {{ $product->sku }} </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
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
    $(document).ready(function() {
        $('.select2').select2();
        let target_id = $("#target_id").val();
        updateTarget();
        if (target_id) {
            $("#target-element_" + target_id).addClass("clicked");
            $("#target_id").val(target_id);
        }
    });
    
    $(".clickable").click(function() {
        $(".clickable").removeClass("clicked");
        $(this).addClass("clicked");
        $("#target_id").val($(this).data("id"));
    });

    function updateTarget() {
        let target = $("#type").val();
        $("#target_id").val("");
        $(".clickable").removeClass("clicked");

        switch(target) {
            case "General":
                $(".target-container").hide();
                break;
            case "Product":
                $(".target-container").hide();
                $("#target-product").show();
                break;
        }

    }

    $("#questionaire-form").submit(function() {
        if ($("#type").val() == "Product" && !$("#target_id").val()) {
            alert("Please choose target item");
            return;
        }
    });
</script>
@endpush