@extends('admin.layout')

@section('main')
          <div class="box-header with-border">
              <h2 class="box-title">{{ $title_description??'' }}</h2>

              <div class="box-tools">
                  <div class="btn-group pull-right" style="margin-right: 5px">
                      <a href="{{ route('admin_extension',['extensionGroup'=>'Payment']) }}" class="btn  btn-flat btn-default" title="List"><i class="fa fa-list"></i><span class="hidden-xs"> {{trans('admin.back_list')}}</span></a>
                  </div>
              </div>
          </div>

            <!-- /.box-header -->
            <div class="box-body">
             <table id="example2" class="table table-bordered table-hover">
              <tr>
                <th width="40%">{{ trans('Extensions/Payment/Card::Card.card_public_key') }}</th>
                <td><a href="#" class="updateData_can_empty" data-name="card_public_key" data-type="text" data-pk="card_public_key" data-url="{{ route('admin_extension.process',['group'=>$group,'key'=>$key]) }}" data-value="{{ sc_config('card_public_key') }}" data-title="{{ trans('Extensions/Payment/Card::Card.card_public_key') }}"></a></td>
              </tr>
              <tr>
                <th width="40%">{{ trans('Extensions/Payment/Card::Card.card_secrect') }}</th>
                <td><a href="#" class="updateData_can_empty" data-name="card_secrect" data-type="password" data-pk="card_secrect" data-url="{{ route('admin_extension.process',['group'=>$group,'key'=>$key]) }}" data-value="{{ sc_config('card_secrect') }}" data-title="{{ trans('Extensions/Payment/Card::Card.card_secrect') }}"></a></td>
              </tr>
              <tr>
                <th width="40%">{{ trans('Extensions/Payment/Card::Card.card_currency') }}</th>
                <td><a href="#" class="updateData" data-name="card_currency" data-type="text" data-pk="card_currency" data-url="{{ route('admin_extension.process',['group'=>$group,'key'=>$key]) }}" data-title="{{ trans('Extensions/Payment/Card::Card.card_currency') }}">{{ sc_config('card_currency') }}</a></td>
              </tr>
              <tr>
                <th width="40%">{{ trans('Extensions/Payment/Card::Card.card_order_status_success') }}</th>
                <td><a href="#" class="updateData_num" data-name="card_order_status_success" data-type="select" data-pk="card_order_status_success" data-source="{{ $jsonStatusOrder }}" data-value="{{ sc_config('card_order_status_success') }}" data-url="{{ route('admin_extension.process',['group'=>$group,'key'=>$key]) }}" data-title="{{ trans('Extensions/Payment/Card::Card.card_order_status_success') }}"></a></td>
              </tr>
              <tr>
                <th width="40%">{{ trans('Extensions/Payment/Card::Card.card_order_status_faild') }}</th>
                <td><a href="#" class="updateData_num" data-name="card_order_status_faild" data-type="select" data-pk="card_order_status_faild" data-source="{{ $jsonStatusOrder }}" data-value="{{ sc_config('card_order_status_faild') }}" data-url="{{ route('admin_extension.process',['group'=>$group,'key'=>$key]) }}" data-title="{{ trans('Extensions/Payment/Card::Card.card_order_status_faild') }}"></a></td>
              </tr>

              </table>
            </div>
            <!-- /.box-body -->
@endsection

@push('styles')
<!-- Ediable -->
<link rel="stylesheet" href="{{ asset('admin/plugin/bootstrap-editable.css')}}">
@endpush

@push('scripts')
<!-- Ediable -->
<script src="{{ asset('admin/plugin/bootstrap-editable.min.js')}}"></script>
<script type="text/javascript">
$(document).ready(function() {

    $.fn.editable.defaults.params = function (params) {
      params._token = "{{ csrf_token() }}";
      return params;
    };

    $('.updateData_num').editable({
    ajaxOptions: {
    type: 'put',
    dataType: 'json'
    },
    validate: function(value) {
        if (value == '') {
            return '{{  trans('admin.not_empty') }}';
        }
        if (!$.isNumeric(value)) {
            return '{{  trans('admin.only_numeric') }}';
        }
    }
    });

    $('.updateData').editable({
    ajaxOptions: {
    type: 'put',
    dataType: 'json'
    },
    validate: function(value) {
        if (value == '') {
            return '{{  trans('admin.not_empty') }}';
        }
    }
    });

    $('.updateData_can_empty').editable({
    ajaxOptions: {
    type: 'put',
    dataType: 'json'
    }
    });
});

</script>

@endpush
