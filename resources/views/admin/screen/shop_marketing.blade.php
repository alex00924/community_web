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
                                <th>Email</th>
                                <th>Shared state</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach ($marketing as $key => $marketing)
                                    <tr data-id="{{ $marketing->id }}"  class="linkable">
                                        <td>{{ $marketing->id }}</td>
                                        <td>{{ $marketing->email }}</td>
                                        @if ($marketing->shared == 0)
                                            <td>pending</td>    
                                        @else
                                            <td>shared</td>                                        
                                        @endif
                                        <td>
                                            <span title="share" class="btn btn-flat {{ $marketing->shared == 0 ? 'btn-info' : '' }}">
                                                Share
                                            </span>
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
   
    function shareLink(email) {
        if (!confirm("Are you sure to send link to this email?")) {
            return;
        }
        if (id < 1) {
            return;
        }
        $.ajax({
            type: "POST",
            data: {"_token": "{{ csrf_token() }}"},
            // url: 'questionaire/marketing',
            url: route('admin_questionaire.sendlink'),
            success: function(response){
                // if (response.error == 1) {
                //     console.log(response.msg);
                // } else {
                    
                // }
            }

        });
    }

    $("#question-table tr.linkable").click(function() {
        document.location.href =  questionIndexUrl.replace("questionaire_ID", $(this).data('id'));
    })
</script>

@endpush