@extends('admin.layout')

@section('main')
  <div id="preloader"></div>
   <div class="row">
      <div class="col-md-12">
         <div class="box">
      <div class="box-header with-border">
        <div class="pull-right">
         {!! $menu_search??'' !!}
        </div>
        <!-- /.box-tools -->
      </div>

      <div class="box-header with-border">
         <div class="pull-right">
         {!! $menu_right??'' !!}
         </div>

         <span>

         {!! $menu_left??'' !!}
         {!! $menu_sort??'' !!}

         </span>
      </div>
      <!-- /.box-header -->
    <section id="pjax-container" class="table-list">
      <div class="box-body table-responsive no-padding" >
         <table class="table table-hover">
            <thead>
               <tr>
                @foreach ($listTh as $key => $th)
                    <th>{!! $th !!}</th>
                @endforeach
               </tr>
            </thead>
            <tbody>
                @foreach ($dataTr as $keyRow => $tr)
                    <tr>
                        @foreach ($tr as $key => $trtd)
                            <td>{!! $trtd !!}</td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
            @if ($title == trans('db_customer.admin.individual'))
            <style>
               tr {
                  width: max-content;
                }  
                th, td {
                  word-break: unset !important;
                  max-width: unset !important;
                }
                td:nth-child(16) {
                  display: -webkit-box;
                  -webkit-box-orient: vertical;
                  -webkit-line-clamp: 2;
                  overflow: hidden;
                  width: 170px !important;
                  line-height: 1.8 !important;
                }
            </style>
            @endif
         </table>
      </div>
      <div class="box-footer clearfix">
         {!! $result_items??'' !!}
         {!! $pagination??'' !!}
      </div>
    </section>
      <!-- /.box-body -->
    </div>
  </div>
</div>
@endsection


@push('styles')
<style type="text/css">
  .box-body td,.box-body th{
  max-width:150px;word-break:break-all;
}
.uploadButton {
  cursor: pointer;
  display: -webkit-box;
  display: -ms-flexbox;
  display: inline-block;
  -webkit-box-pack: center;
  -ms-flex-pack: center;
  justify-content: center;
  -webkit-box-align: center;
  -ms-flex-align: center;
  align-items: center;
  -webkit-box-sizing: border-box;
  box-sizing: border-box;
  padding: 8px 10px;
  height: 34px;
  margin-right: 10px;
  font-size: 16px;
  text-align: center;
  color: #FFF;
  background: #4cb747;
}
.button_simple {
  background: #2aade3;
  display: inline-block;
  padding: 8px 10px;
  height: 34px;
  border: none;
  color:#fff;
  margin-right: 10px;
  /* transform: translateY(2px); */
}
#preloader {
  position: fixed;
  left: 0;
  top: 0;
  z-index: 999;
  width: 100%;
  height: 100%;
  overflow: visible;
  background: url('/images/loading.gif') no-repeat center center;
  background-color: rgba(153, 153, 153, 0.25);
  display: none;
}
</style>
@endpush

@push('scripts')
    {{-- //Pjax --}}
   <script src="{{ asset('admin/plugin/jquery.pjax.js')}}"></script>

  <script type="text/javascript">

    $('.grid-refresh').click(function(){
      $.pjax.reload({container:'#pjax-container'});
    });

    $(document).on('submit', '#button_search', function(event) {
      $.pjax.submit(event, '#pjax-container')
    })

    $(document).on('pjax:send', function() {
      $('#loading').show()
    })
    $(document).on('pjax:complete', function() {
      $('#loading').hide()
    })

    // tag a
    $(function(){
     $(document).pjax('a.page-link', '#pjax-container')
    })


    $(document).ready(function(){
    // does current browser support PJAX
      if ($.support.pjax) {
        $.pjax.defaults.timeout = 2000; // time in milliseconds
      }
    });

    {!! $script_sort??'' !!}

    $(document).on('ready pjax:end', function(event) {
      $('.table-list input').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue',
        increaseArea: '20%' /* optional */
      });
    })

  </script>
    {{-- //End pjax --}}


<script type="text/javascript">
{{-- sweetalert2 --}}
var selectedRows = function () {
    var selected = [];
    $('.grid-row-checkbox:checked').each(function(){
        selected.push($(this).data('id'));
    });

    return selected;
}

$('.grid-trash').on('click', function() {
  var ids = selectedRows().join();
  deleteItem(ids);
});

  function deleteItem(ids){
  const swalWithBootstrapButtons = Swal.mixin({
    customClass: {
      confirmButton: 'btn btn-success',
      cancelButton: 'btn btn-danger'
    },
    buttonsStyling: true,
  })

  swalWithBootstrapButtons.fire({
    title: 'Are you sure to delete this item ?',
    text: "",
    type: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Yes, delete it!',
    confirmButtonColor: "#DD6B55",
    cancelButtonText: 'No, cancel!',
    reverseButtons: true,

    preConfirm: function() {
        return new Promise(function(resolve) {
            $.ajax({
                method: 'post',
                url: '{{ $url_delete_item }}',
                data: {
                  ids:ids,
                  _token: '{{ csrf_token() }}',
                },
                success: function (data) {
                    if(data.error == 1){
                      swalWithBootstrapButtons.fire(
                        'Cancelled',
                        data.msg,
                        'error'
                      )
                      $.pjax.reload('#pjax-container');
                      return;
                    }else{
                      $.pjax.reload('#pjax-container');
                      resolve(data);
                    }

                }
            });
        });
    }

  }).then((result) => {
    if (result.value) {
      swalWithBootstrapButtons.fire(
        'Deleted!',
        'Item has been deleted.',
        'success'
      )
    } else if (
      // Read more about handling dismissals
      result.dismiss === Swal.DismissReason.cancel
    ) {
      // swalWithBootstrapButtons.fire(
      //   'Cancelled',
      //   'Your imaginary file is safe :)',
      //   'error'
      // )
    }
  })
}
{{--/ sweetalert2 --}}


</script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' /* optional */
    });
  });

  $("#savein_db").click(function() {
      var file_data = $('#import_individual')[0].files;
      var form_data = new FormData();
      form_data.append('import_individual', file_data[0]);
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
      $.ajax({
          url: $('#insert_individual').attr('action'),
          method: "POST",
          data: form_data,
          contentType: false,
          processData: false,
          dataType: 'json',
          beforeSend: function() {
            document.getElementById('preloader').style.display = 'block';
          },
          success: function(response) {
            if (response.res === 1){
              document.getElementById('preloader').style.display = 'none';
              window.location.href = "{{ route('admin_dbcumstomer.individual.index')}}";
            }
          }
      })
    })

    $("#savein_db_company").click(function() {
      var file_data = $('#import_company')[0].files;
      var form_data = new FormData();
      form_data.append('import_company', file_data[0]);
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
      $.ajax({
          url: $('#insert_company').attr('action'),
          method: "POST",
          data: form_data,
          contentType: false,
          processData: false,
          dataType: 'json',
          beforeSend: function() {
            document.getElementById('preloader').style.display = 'block';
          },
          success: function(response) {
            if (response.res === 1){
              document.getElementById('preloader').style.display = 'none';
              window.location.href = "{{ route('admin_dbcumstomer.company.index')}}";
            }
          }
      })
    })
</script>
@endpush
