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
                        <a href="{{ route('admin_questionaire.index') }}" class="btn  btn-flat btn-default" title="Save"  style="margin: 0 5px">
                            <i class="fa fa-save"></i>
                            <span class="hidden-xs"> {{trans('questionaire.admin.save')}}</span>
                        </a>
                    </div>
                </div>
            </div>
            <!-- /.box-header -->
            Questionaire
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
<!--ckeditor-->
<script src="{{ asset('packages/ckeditor/adapters/jquery.js') }}"></script>

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

<script type="text/javascript">
    
);
</script>

@endpush