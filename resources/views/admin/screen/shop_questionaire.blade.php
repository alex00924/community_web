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
                    </div>
                </div>
            </div>
            <!-- /.box-header -->
            
            <!-- Box body -->
            <div class="row box-body" >
                <div class="col-xs-12">
                    <div class="table-responsive no-padding box-shadow">
                        <table class="table table-hover" id="question-table">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Title</th>
                                <th>Type</th>
                                <th>Specification</th>
                                <th>Only Login User Can Access</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach ($questionaires as $key => $questionaire)
                                    <tr data-id="{{ $questionaire->id }}"  class="linkable">
                                        <td>{{ $questionaire->id }}</td>
                                        <td>{{ $questionaire->title }}</td>
                                        <td>{{ $questionaire->type }}</td>
                                        <td class="v-center">
                                            @php
                                            if($questionaire->type == 'Product' && !empty($questionaire->target_id))
                                            {
                                                $product = App\Models\ShopProduct::find($questionaire->target_id);
                                                if($product)
                                                {
                                                    $html = '<img src="' . $product->image . '" style="width: 50px; height: auto;"/>';
                                                    $html .='<span>' . $product->name . '</span>';
                                                    echo $html;
                                                }
                                            }
                                            @endphp
                                        </td>
                                        <td>{{ $questionaire->access_level == 1 ? 'Yes' : 'No' }}</td>
                                        <td>
                                            <a href="{{ route('admin_questionaire.edit', ['id' => $questionaire->id]) }}">
                                                <span title="Edit" type="button" class="btn btn-flat btn-primary">
                                                    <i class="fa fa-edit"></i>
                                                </span>
                                            </a>
                                            &nbsp;
                                            @if (Session::get('userrole') == 1)
                                            <span onclick="deleteItem({{ $questionaire->id }});" title="Delete" class="btn btn-flat btn-danger">
                                                <i class="fa fa-trash"></i>
                                            </span>
                                            @endif
                                        </td>
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
    let deleteUrl = "{{ route('admin_questionaire.delete', ['id'=>'question_ID']) }}";
    let questionIndexUrl = "{{ route('admin_questionaire.indexQuestion', ['questionaire_id' => 'questionaire_ID']) }}";

    function deleteItem(id) {
        if (!confirm("Are you sure to delete this questionaire?")) {
            return;
        }
        if (id < 1) {
            return;
        }
        $.ajax({
            type: "POST",
            data: {"_token": "{{ csrf_token() }}"},
            url: deleteUrl.replace('question_ID', id),
            success: function(response){
                if (response.error == 1) {
                    console.log(response.msg);
                } else {
                    $("#tr-questionaire_" + id).remove();
                }
            }

        });
    }

    $("#question-table tr.linkable").click(function() {
        document.location.href =  questionIndexUrl.replace("questionaire_ID", $(this).data('id'));
    })
</script>

@endpush