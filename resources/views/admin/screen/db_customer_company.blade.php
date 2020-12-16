@extends('admin.layout')
@section('main')
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <h2 class="box-title">{{ $title_description??'' }}</h2>

                <div class="box-tools">
                    <div class="btn-group pull-right" style="margin-right: 5px">
                        <a href="{{ route('admin_category.index') }}" class="btn  btn-flat btn-default" title="List"><i
                                class="fa fa-list"></i><span class="hidden-xs"> {{trans('admin.back_list')}}</span></a>
                    </div>
                </div>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form action="{{ $url_action }}" method="post" accept-charset="UTF-8" class="form-horizontal" id="form-main"
                enctype="multipart/form-data">
                @csrf
                <div class="box-body">
                    <div class="fields-group">                      
                        @foreach ($languages as $code => $language)
                        <div class="form-group">
                            <label class="col-sm-2  control-label"></label>
                            <div class="col-sm-8">
                                <b>{{ $language->name }}</b>
                                {!! sc_image_render($language->icon,'20px','20px') !!}
                            </div>
                        </div>
                        <div class="form-group   {{ $errors->has('company') ? ' has-error' : '' }}">
                            <label for="name" class="col-sm-2  control-label">{{ trans('db_customer.admin.company') }} <span class="seo" title="SEO"><i class="fa fa-coffee" aria-hidden="true"></i></span></label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-pencil fa-fw"></i></span>
                                    <input type="text" id="company" name="company"
                                        value="{!! old()?old('company'):$company['company']??'' !!}"
                                        class="form-control" placeholder="" />
                                </div>
                                @if ($errors->has('company'))
                                <span class="help-block">
                                    <i class="fa fa-info-circle"></i> {{ $errors->first('company') }}
                                </span>
                                @else
                                @endif
                            </div>
                        </div>
                        <div class="form-group   {{ $errors->has('treatment') ? ' has-error' : '' }}">
                            <label for="name" class="col-sm-2  control-label">{{ trans('db_customer.admin.treatment') }} <span class="seo" title="SEO"><i class="fa fa-coffee" aria-hidden="true"></i></span></label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-pencil fa-fw"></i></span>
                                    <input type="text" id="treatment" name="treatment"
                                        value="{!! old()?old('treatment'):$company['treatment']??'' !!}"
                                        class="form-control" placeholder="" />
                                </div>
                                @if ($errors->has('treatment'))
                                <span class="help-block">
                                    <i class="fa fa-info-circle"></i> {{ $errors->first('treatment') }}
                                </span>
                                @else
                                @endif
                            </div>
                        </div>
                        <div class="form-group   {{ $errors->has('indication') ? ' has-error' : '' }}">
                            <label for="name" class="col-sm-2  control-label">{{ trans('db_customer.admin.indication') }} <span class="seo" title="SEO"><i class="fa fa-coffee" aria-hidden="true"></i></span></label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-pencil fa-fw"></i></span>
                                    <input type="text" id="indication" name="indication"
                                        value="{!! old()?old('indication'):$company['indication']??'' !!}"
                                        class="form-control" placeholder="" />
                                </div>
                                @if ($errors->has('indication'))
                                <span class="help-block">
                                    <i class="fa fa-info-circle"></i> {{ $errors->first('indication') }}
                                </span>
                                @else
                                @endif
                            </div>
                        </div>
                        <div class="form-group   {{ $errors->has('phase') ? ' has-error' : '' }}">
                            <label for="name" class="col-sm-2  control-label">{{ trans('db_customer.admin.phase') }} <span class="seo" title="SEO"><i class="fa fa-coffee" aria-hidden="true"></i></span></label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-pencil fa-fw"></i></span>
                                    <input type="text" id="phase" name="phase"
                                        value="{!! old()?old('phase'):$company['phase']??'' !!}"
                                        class="form-control" placeholder="" />
                                </div>
                                @if ($errors->has('phase'))
                                <span class="help-block">
                                    <i class="fa fa-info-circle"></i> {{ $errors->first('phase') }}
                                </span>
                                @else
                                @endif
                            </div>
                        </div>
                        <div class="form-group   {{ $errors->has('characteristics') ? ' has-error' : '' }}">
                            <label for="name" class="col-sm-2  control-label">{{ trans('db_customer.admin.characteristics') }} <span class="seo" title="SEO"><i class="fa fa-coffee" aria-hidden="true"></i></span></label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-pencil fa-fw"></i></span>
                                    <input type="text" id="characteristics" name="characteristics"
                                        value="{!! old()?old('characteristics'):$company['characteristics']??'' !!}"
                                        class="form-control" placeholder="" />
                                </div>
                                @if ($errors->has('characteristics'))
                                <span class="help-block">
                                    <i class="fa fa-info-circle"></i> {{ $errors->first('characteristics') }}
                                </span>
                                @else
                                @endif
                            </div>
                        </div>
                        <div class="form-group   {{ $errors->has('focus') ? ' has-error' : '' }}">
                            <label for="name" class="col-sm-2  control-label">{{ trans('db_customer.admin.focus') }} <span class="seo" title="SEO"><i class="fa fa-coffee" aria-hidden="true"></i></span></label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-pencil fa-fw"></i></span>
                                    <input type="text" id="focus" name="focus"
                                        value="{!! old()?old('focus'):$company['focus']??'' !!}"
                                        class="form-control" placeholder="" />
                                </div>
                                @if ($errors->has('focus'))
                                <span class="help-block">
                                    <i class="fa fa-info-circle"></i> {{ $errors->first('focus') }}
                                </span>
                                @else
                                @endif
                            </div>
                        </div>
                        <div class="form-group   {{ $errors->has('position') ? ' has-error' : '' }}">
                            <label for="name" class="col-sm-2  control-label">{{ trans('db_customer.admin.position') }} <span class="seo" title="SEO"><i class="fa fa-coffee" aria-hidden="true"></i></span></label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-pencil fa-fw"></i></span>
                                    <input type="text" id="position" name="position"
                                        value="{!! old()?old('position'):$company['position']??'' !!}"
                                        class="form-control" placeholder="" />
                                </div>
                                @if ($errors->has('position'))
                                <span class="help-block">
                                    <i class="fa fa-info-circle"></i> {{ $errors->first('position') }}
                                </span>
                                @else
                                @endif
                            </div>
                        </div>
                        <div class="form-group   {{ $errors->has('portfolio') ? ' has-error' : '' }}">
                            <label for="name" class="col-sm-2  control-label">{{ trans('db_customer.admin.portfolio') }} <span class="seo" title="SEO"><i class="fa fa-coffee" aria-hidden="true"></i></span></label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-pencil fa-fw"></i></span>
                                    <input type="text" id="portfolio" name="portfolio"
                                        value="{!! old()?old('portfolio'):$company['portfolio']??'' !!}"
                                        class="form-control" placeholder="" />
                                </div>
                                @if ($errors->has('portfolio'))
                                <span class="help-block">
                                    <i class="fa fa-info-circle"></i> {{ $errors->first('portfolio') }}
                                </span>
                                @else
                                @endif
                            </div>
                        </div>
                        <div class="form-group   {{ $errors->has('technology') ? ' has-error' : '' }}">
                            <label for="name" class="col-sm-2  control-label">{{ trans('db_customer.admin.technology') }} <span class="seo" title="SEO"><i class="fa fa-coffee" aria-hidden="true"></i></span></label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-pencil fa-fw"></i></span>
                                    <input type="text" id="technology" name="technology"
                                        value="{!! old()?old('technology'):$company['technology']??'' !!}"
                                        class="form-control" placeholder="" />
                                </div>
                                @if ($errors->has('technology'))
                                <span class="help-block">
                                    <i class="fa fa-info-circle"></i> {{ $errors->first('technology') }}
                                </span>
                                @else
                                @endif
                            </div>
                        </div>
                        <div class="form-group   {{ $errors->has('website') ? ' has-error' : '' }}">
                            <label for="name" class="col-sm-2  control-label">{{ trans('db_customer.admin.website') }} <span class="seo" title="SEO"><i class="fa fa-coffee" aria-hidden="true"></i></span></label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-pencil fa-fw"></i></span>
                                    <input type="text" id="website" name="website"
                                        value="{!! old()?old('website'):$company['website']??'' !!}"
                                        class="form-control" placeholder="" />
                                </div>
                                @if ($errors->has('website'))
                                <span class="help-block">
                                    <i class="fa fa-info-circle"></i> {{ $errors->first('website') }}
                                </span>
                                @else
                                @endif
                            </div>
                        </div>
                        <div class="form-group   {{ $errors->has('additional_info') ? ' has-error' : '' }}">
                            <label for="name" class="col-sm-2  control-label">{{ trans('db_customer.admin.additional_info') }} <span class="seo" title="SEO"><i class="fa fa-coffee" aria-hidden="true"></i></span></label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-pencil fa-fw"></i></span>
                                    <input type="text" id="additional_info" name="additional_info"
                                        value="{!! old()?old('additional_info'):$company['additional_info']??'' !!}"
                                        class="form-control" placeholder="" />
                                </div>
                                @if ($errors->has('additional_info'))
                                <span class="help-block">
                                    <i class="fa fa-info-circle"></i> {{ $errors->first('additional_info') }}
                                </span>
                                @else
                                @endif
                            </div>
                        </div>
                        <div class="form-group   {{ $errors->has('notes') ? ' has-error' : '' }}">
                            <label for="name" class="col-sm-2  control-label">{{ trans('db_customer.admin.notes') }} <span class="seo" title="SEO"><i class="fa fa-coffee" aria-hidden="true"></i></span></label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-pencil fa-fw"></i></span>
                                    <input type="text" id="notes" name="notes"
                                        value="{!! old()?old('notes'):$company['notes']??'' !!}"
                                        class="form-control" placeholder="" />
                                </div>
                                @if ($errors->has('notes'))
                                <span class="help-block">
                                    <i class="fa fa-info-circle"></i> {{ $errors->first('notes') }}
                                </span>
                                @else
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="box-footer">
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
    $('.select2').select2()
});



</script>

@endpush