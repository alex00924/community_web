@extends('admin.layout')

@section('main')
   <div class="row">
      <div class="col-md-12">
         <div class="box">
                <div class="box-header with-border">
                    <h2 class="box-title">{{ $title_description??'' }}</h2>

                    <div class="box-tools">
                        <div class="btn-group pull-right" style="margin-right: 5px">
                            <a href="{{ route('admin_benefit.index') }}" class="btn  btn-flat btn-default" title="List"><i class="fa fa-list"></i><span class="hidden-xs"> {{trans('admin.back_list')}}</span></a>
                        </div>
                    </div>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form action="{{ $url_action }}" method="post" accept-charset="UTF-8" class="form-horizontal" id="form-main">
                    <div class="box-body">
                        <div class="fields-group">

                            <div class="form-group   {{ $errors->has('benefit') ? ' has-error' : '' }}">
                                <label for="benefit" class="col-sm-2  control-label">{{ trans('benefit.benefit') }}</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-pencil fa-fw"></i></span>
                                        <input type="text" id="benefit" name="benefit" value="{!! old('benefit',($obj['benefit']??'')) !!}" class="form-control name" placeholder="" />
                                    </div>
                                        @if ($errors->has('benefit'))
                                            <span class="help-block">
                                                {{ $errors->first('benefit') }}
                                            </span>
                                        @endif
                                </div>
                            </div>
                            <hr>
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
@endpush

@push('scripts')

</script>
@endpush
