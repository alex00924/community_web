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
                        <div class="form-group   {{ $errors->has('fullname') ? ' has-error' : '' }}">
                            <label for="name" class="col-sm-2  control-label">{{ trans('db_customer.admin.fullname') }} <span class="seo" title="SEO"><i class="fa fa-coffee" aria-hidden="true"></i></span></label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-pencil fa-fw"></i></span>
                                    <input type="text" id="fullname" name="fullname"
                                        value="{!! old()?old('fullname'):$individual['fullname']??'' !!}"
                                        class="form-control" placeholder="" />
                                </div>
                                @if ($errors->has('fullname'))
                                <span class="help-block">
                                    <i class="fa fa-info-circle"></i> {{ $errors->first('fullname') }}
                                </span>
                                @else
                                @endif
                            </div>
                        </div>
                        <div class="form-group   {{ $errors->has('firstname') ? ' has-error' : '' }}">
                            <label for="name" class="col-sm-2  control-label">{{ trans('db_customer.admin.firstname') }} <span class="seo" title="SEO"><i class="fa fa-coffee" aria-hidden="true"></i></span></label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-pencil fa-fw"></i></span>
                                    <input type="text" id="firstname" name="firstname"
                                        value="{!! old()?old('firstname'):$individual['firstname']??'' !!}"
                                        class="form-control" placeholder="" />
                                </div>
                                @if ($errors->has('firstname'))
                                <span class="help-block">
                                    <i class="fa fa-info-circle"></i> {{ $errors->first('firstname') }}
                                </span>
                                @else
                                @endif
                            </div>
                        </div>
                        <div class="form-group   {{ $errors->has('lastname') ? ' has-error' : '' }}">
                            <label for="name" class="col-sm-2  control-label">{{ trans('db_customer.admin.lastname') }} <span class="seo" title="SEO"><i class="fa fa-coffee" aria-hidden="true"></i></span></label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-pencil fa-fw"></i></span>
                                    <input type="text" id="lastname" name="lastname"
                                        value="{!! old()?old('lastname'):$individual['lastname']??'' !!}"
                                        class="form-control" placeholder="" />
                                </div>
                                @if ($errors->has('lastname'))
                                <span class="help-block">
                                    <i class="fa fa-info-circle"></i> {{ $errors->first('lastname') }}
                                </span>
                                @else
                                @endif
                            </div>
                        </div>
                        <div class="form-group   {{ $errors->has('current_company') ? ' has-error' : '' }}">
                            <label for="name" class="col-sm-2  control-label">{{ trans('db_customer.admin.current_company') }} <span class="seo" title="SEO"><i class="fa fa-coffee" aria-hidden="true"></i></span></label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-pencil fa-fw"></i></span>
                                    <input type="text" id="current_company" name="current_company"
                                        value="{!! old()?old('current_company'):$individual['current_company']??'' !!}"
                                        class="form-control" placeholder="" />
                                </div>
                                @if ($errors->has('current_company'))
                                <span class="help-block">
                                    <i class="fa fa-info-circle"></i> {{ $errors->first('current_company') }}
                                </span>
                                @else
                                @endif
                            </div>
                        </div>
                        <div class="form-group   {{ $errors->has('interest') ? ' has-error' : '' }}">
                            <label for="name" class="col-sm-2  control-label">{{ trans('db_customer.admin.interest') }} <span class="seo" title="SEO"><i class="fa fa-coffee" aria-hidden="true"></i></span></label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-pencil fa-fw"></i></span>
                                    <input type="text" id="interest" name="interest"
                                        value="{!! old()?old('interest'):$individual['interest']??'' !!}"
                                        class="form-control" placeholder="" />
                                </div>
                                @if ($errors->has('interest'))
                                <span class="help-block">
                                    <i class="fa fa-info-circle"></i> {{ $errors->first('interest') }}
                                </span>
                                @else
                                @endif
                            </div>
                        </div>
                        <div class="form-group   {{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="name" class="col-sm-2  control-label">{{ trans('db_customer.admin.email') }} <span class="seo" title="SEO"><i class="fa fa-coffee" aria-hidden="true"></i></span></label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-pencil fa-fw"></i></span>
                                    <input type="text" id="email" name="email"
                                        value="{!! old()?old('email'):$individual['email']??'' !!}"
                                        class="form-control" placeholder="" />
                                </div>
                                @if ($errors->has('email'))
                                <span class="help-block">
                                    <i class="fa fa-info-circle"></i> {{ $errors->first('email') }}
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
                                        value="{!! old()?old('position'):$individual['position']??'' !!}"
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
                        <div class="form-group   {{ $errors->has('position_type') ? ' has-error' : '' }}">
                            <label for="name" class="col-sm-2  control-label">{{ trans('db_customer.admin.position_type') }} <span class="seo" title="SEO"><i class="fa fa-coffee" aria-hidden="true"></i></span></label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-pencil fa-fw"></i></span>
                                    <input type="text" id="position_type" name="position_type"
                                        value="{!! old()?old('position_type'):$individual['position_type']??'' !!}"
                                        class="form-control" placeholder="" />
                                </div>
                                @if ($errors->has('position_type'))
                                <span class="help-block">
                                    <i class="fa fa-info-circle"></i> {{ $errors->first('position_type') }}
                                </span>
                                @else
                                @endif
                            </div>
                        </div>
                        <div class="form-group   {{ $errors->has('org_type') ? ' has-error' : '' }}">
                            <label for="name" class="col-sm-2  control-label">{{ trans('db_customer.admin.org_type') }} <span class="seo" title="SEO"><i class="fa fa-coffee" aria-hidden="true"></i></span></label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-pencil fa-fw"></i></span>
                                    <input type="text" id="org_type" name="org_type"
                                        value="{!! old()?old('org_type'):$individual['org_type']??'' !!}"
                                        class="form-control" placeholder="" />
                                </div>
                                @if ($errors->has('org_type'))
                                <span class="help-block">
                                    <i class="fa fa-info-circle"></i> {{ $errors->first('org_type') }}
                                </span>
                                @else
                                @endif
                            </div>
                        </div>
                        <div class="form-group   {{ $errors->has('size') ? ' has-error' : '' }}">
                            <label for="name" class="col-sm-2  control-label">{{ trans('db_customer.admin.size') }} <span class="seo" title="SEO"><i class="fa fa-coffee" aria-hidden="true"></i></span></label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-pencil fa-fw"></i></span>
                                    <input type="text" id="size" name="size"
                                        value="{!! old()?old('size'):$individual['size']??'' !!}"
                                        class="form-control" placeholder="" />
                                </div>
                                @if ($errors->has('size'))
                                <span class="help-block">
                                    <i class="fa fa-info-circle"></i> {{ $errors->first('size') }}
                                </span>
                                @else
                                @endif
                            </div>
                        </div>
                        <div class="form-group   {{ $errors->has('influencer_category') ? ' has-error' : '' }}">
                            <label for="name" class="col-sm-2  control-label">{{ trans('db_customer.admin.influencer_category') }} <span class="seo" title="SEO"><i class="fa fa-coffee" aria-hidden="true"></i></span></label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-pencil fa-fw"></i></span>
                                    <input type="text" id="influencer_category" name="influencer_category"
                                        value="{!! old()?old('influencer_category'):$individual['influencer_category']??'' !!}"
                                        class="form-control" placeholder="" />
                                </div>
                                @if ($errors->has('influencer_category'))
                                <span class="help-block">
                                    <i class="fa fa-info-circle"></i> {{ $errors->first('influencer_category') }}
                                </span>
                                @else
                                @endif
                            </div>
                        </div>
                        <div class="form-group   {{ $errors->has('linkedin') ? ' has-error' : '' }}">
                            <label for="name" class="col-sm-2  control-label">{{ trans('db_customer.admin.linkedin') }} <span class="seo" title="SEO"><i class="fa fa-coffee" aria-hidden="true"></i></span></label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-pencil fa-fw"></i></span>
                                    <input type="text" id="linkedin" name="linkedin"
                                        value="{!! old()?old('linkedin'):$individual['linkedin']??'' !!}"
                                        class="form-control" placeholder="" />
                                </div>
                                @if ($errors->has('linkedin'))
                                <span class="help-block">
                                    <i class="fa fa-info-circle"></i> {{ $errors->first('linkedin') }}
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
                                        value="{!! old()?old('notes'):$individual['notes']??'' !!}"
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
                        <div
                            class="form-group   {{ $errors->has('descriptions.'.$code.'.description') ? ' has-error' : '' }}">
                            <label for="{{ $code }}__description"
                                class="col-sm-2  control-label">{{ trans('db_customer.admin.headline') }} <span class="seo" title="SEO"><i class="fa fa-coffee" aria-hidden="true"></i></span></label>
                            <div class="col-sm-8">
                                    <textarea type="text" id="headline" 
                                        name="headline"
                                        class="form-control {{ $code.'__description' }}" placeholder="" />{{  old()?old('headline'):$individual['headline']??''  }}</textarea>
                                @if ($errors->has('headline'))
                                <span class="help-block">
                                    <i class="fa fa-info-circle"></i> {{ $errors->first('headline') }}
                                </span>
                                @else
                                    <span class="help-block">
                                        <i class="fa fa-info-circle"></i> {{ trans('admin.max_c',['max'=>300]) }}
                                    </span>
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