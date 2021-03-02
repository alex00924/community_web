@extends('admin.layout')

@section('main')
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <h2 class="box-title">{{ $title_description??'' }}</h2>

                <div class="box-tools">
                    <div class="btn-group pull-right" style="margin-right: 5px">
                        <a href="{{ route('admin_scraping.mr_admin') }}" class="btn  btn-flat btn-default" title="List"><i
                                class="fa fa-list"></i><span class="hidden-xs"> {{trans('admin.back_list')}}</span></a>
                    </div>
                </div>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form action="{{ $url_action }}" method="post" accept-charset="UTF-8" class="form-horizontal" id="form-main"
                enctype="multipart/form-data">


                <div class="box-body">
                    <div class="fields-group">

                        <div class="box-body">
                            <div class="fields-group">

                                <div class="form-group   {{ $errors->has('name') ? ' has-error' : '' }}">
                                    <label for="name" class="col-sm-2  control-label">{{ trans('scraping.name') }} <span class="seo" title="SEO"><i class="fa fa-coffee" aria-hidden="true"></i></span></label>
                                    <div class="col-sm-8">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-pencil fa-fw"></i></span>
                                            <input type="text" id="name" name="name"
                                                value="{!! old('name',($imagedb['name']??'')) !!}" class="form-control"
                                                placeholder="" />
                                        </div>
                                        @if ($errors->has('name'))
                                        <span class="help-block">
                                            <i class="fa fa-info-circle"></i> {{ $errors->first('name') }}
                                        </span>
                                        @else
                                        <span class="help-block">
                                            <i class="fa fa-info-circle"></i> {{ trans('admin.max_c',['max'=>100]) }}
                                        </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group   {{ $errors->has('taglist') ? ' has-error' : '' }}">
                                    <label for="alias" class="col-sm-2  control-label">{!! trans('scraping.taglist') !!} <span class="seo" title="SEO"><i class="fa fa-coffee" aria-hidden="true"></i></span></label>
                                    <div class="col-sm-8">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-pencil fa-fw"></i></span>
                                            <input type="text" id="taglist" name="taglist"
                                                value="{!! old('alias',($imagedb['taglist']??'')) !!}" class="form-control"
                                                placeholder="" />
                                        </div>
                                        @if ($errors->has('alias'))
                                        <span class="help-block">
                                            <i class="fa fa-info-circle"></i> {{ $errors->first('alias') }}
                                        </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group   {{ $errors->has('image') ? ' has-error' : '' }}">
                                    <label for="image"
                                        class="col-sm-2  control-label">{{ trans('scraping.image') }}</label>
                                    <div class="col-sm-8">
                                        <div class="input-group">
                                            <input type="text" id="image" name="image"
                                                value="{!! old('image',($imagedb['image']??'')) !!}"
                                                class="form-control input-sm image" placeholder="" />
                                            <span class="input-group-btn">
                                                <a data-input="image" data-preview="preview_image" data-type="brand"
                                                    class="btn btn-sm btn-primary lfm">
                                                    <i class="fa fa-picture-o"></i>
                                                    {{trans('product.admin.choose_image')}}
                                                </a>
                                            </span>
                                        </div>
                                        @if ($errors->has('image'))
                                        <span class="help-block">
                                            <i class="fa fa-info-circle"></i> {{ $errors->first('image') }}
                                        </span>
                                        @endif
                                        
                                        <div id="preview_image" class="img_holder">
                                            @if (old('image',$imagedb['image']??''))
                                            <img src="{{ asset(old('image',$imagedb['image']??'')) }}">
                                            @endif
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>


                        <!-- /.box-body -->

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

                        <!-- /.box-footer -->
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