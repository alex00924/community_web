@extends('admin.layout')

@section('main')
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <div class="pull-left">
                    <div class="btn-group">
                        <a href="" class="btn  btn-flat btn-primary" title="{{trans('questionaire.admin.add_new')}}" style="margin: 0 5px">
                            <span class="hidden-xs"> {{trans('questionaire.marketing.generatePDF')}}</span>
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
                                <th>Questionnaire</th>
                                <th>Email</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                               @foreach ($emails as $key => $email)
                                    @php
                                    $questionaire = App\Models\Questionaire::find($email->questionaire_id);
                                    @endphp
                                    <tr data-id="{{ $email->questionaire_id }}" data-email="{{ $email->email }}" class="linkable">
                                        <td>{{ $email->id }}</td>
                                        <td>{{ $questionaire->title }}</td>
                                        <td>{{ $email->email }}</td>
                                        <td>
                                            <a href="{{ route('admin_questionaire.edit', ['id' => $email->questionaire_id]) }}">
                                                <span title="Edit" type="button" class="btn btn-flat btn-primary">
                                                    <i class="fa fa-edit"></i>
                                                </span>
                                            </a>
                                            &nbsp;
                                            @if (Session::get('userrole') == 1)
                                            <span title="Delete" id="{{$email->questionaire_id}}" class="btn btn-flat btn-danger btn-delete">
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
    var category = @json($category);
    let deleteUrl = "{{ route('admin_questionaire.delete', ['id'=>'question_ID']) }}";
    let questionIndexUrl = "{{ route('admin_questionaire.emailQuestion', ['questionaire_id' => 'questionaire_ID', 'user_email' => 'user_Email']) }}";
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
            dataType: "json",
            success: function(response){
                if (response.error == 1) {
                    console.log(response.msg);
                } else {
                    $("tr[data-id='" + id + "']").remove();
                }
            }

        });
    }
    
    $('.btn-delete').on('click', function (event) {
        deleteItem($(this).attr('id'));
        event.stopPropagation();
    })
    $("#question-table tr.linkable").click(function(e) {
        document.location.href =  questionIndexUrl.replace("questionaire_ID", $(this).data('id')).replace("user_Email", $(this).data('email'));
    })
</script>

@endpush