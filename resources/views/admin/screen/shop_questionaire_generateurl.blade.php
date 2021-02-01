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
            <div class="box-body">
                <div class="fields-group">
                    <div class="marketing-urlgroup">
                        <div class="col-md-8 col-sm-8">
                            <input type="email" id="url" class="form-control"  name="email" placeholder="Generate URL..." readonly>                           
                        </div>
                        <span title="submit" id="url_generate" class="btn btn-primary btn-delete" style="margin-top: 20px; margin-bottom: 30px">
                            {{ trans('questionaire.marketing.generate') }}
                        </span>
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
    $(document).ready(function() {
        $('.select2').select2()
    });
    let updateurl = "{{route('admin_questionaire.updateurl')}}"
    $("#url_generate").click(function() {
        var randomstring = makeid(10);
        $("#url").val(`https://fluidsforlife.com/questionaire/marketing/${randomstring}`);
        $.ajax({
            type: "POST",
            data: {"_token": "{{ csrf_token() }}", "id": randomstring},
            url: updateurl,
            dataType: "json",
            success: function(response){
                if (response.error == 1) {
                    console.log(response.msg);
                } else {
                    console.log(response.msg);
                }
            }

        });
    });
      
    function makeid(length) {
        var result           = '';
        var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        var charactersLength = characters.length;
        for ( var i = 0; i < length; i++ ) {
            result += characters.charAt(Math.floor(Math.random() * charactersLength));
        }
        return result;
    }  
   
</script>
@endpush