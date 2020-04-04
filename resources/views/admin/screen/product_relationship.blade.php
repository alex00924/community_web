@extends('admin.layout')

@section('main')
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <!-- Box body -->
            <div class="row box-body" >

                <div class="col-xs-6">
                    <div class="row">
                        <div class="col-xs-1"></div>
                        <div class="col-xs-10">
                            <h2 style="font-size: 24px; font-weight: 500; text-align: center; margin-top: 2rem; margin-bottom: 1rem"> Products </h2>
                            <div class="table-responsive no-padding box-shadow" style="max-height: 70vh; overfloat: auto">
                                <table class="table table-hover" id="product-table">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Image</th>
                                            <th>SKU</th>
                                            <th>Name</th>
                                            <th>Category</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($products as $key => $product)
                                            <tr data-id="{{ $product->id }}"  class="clickable">
                                                <td>{{ $product->id }}</td>
                                                <td>
                                                    <img src="{{ $product->getThumb() }}" style="max-width: 50px; max-height: 50px">
                                                </td>
                                                <td>{{ $product->sku }}</td>
                                                <td>{{ $product->name }}</td>
                                                <td>{{ implode('; ', $product->categories->pluck('name')->toArray()) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xs-6">
                    <div class="row text-center">
                        <div class="col-xs-1"></div>
                        <div class="col-xs-10">
                            <h2 style="font-size: 24px; font-weight: 500; text-align: center; margin-top: 2rem; margin-bottom: 1rem"> Related Products </h2>
                            <div class="table-responsive no-padding box-shadow" style="max-height: 70vh; overfloat: auto">
                                <table class="table table-hover" id="related-product-table">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Image</th>
                                            <th>SKU</th>
                                            <th>Name</th>
                                            <th>Category</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($products as $key => $product)
                                            <tr data-id="{{ $product->id }}" id="related-tr_{{ $product->id }}"  class="clickable">
                                                <td>{{ $product->id }}</td>
                                                <td>
                                                    <img src="{{ $product->getThumb() }}" style="max-width: 50px; max-height: 50px">
                                                </td>
                                                <td>{{ $product->sku }}</td>
                                                <td>{{ $product->name }}</td>
                                                <td>{{ implode('; ', $product->categories->pluck('name')->toArray()) }}</td>
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
    </div>
</div>
<div id="loading-image" style="width: 100%; height: 100%; background: rgba(0,0,0,.6); z-index: 1001; display: none; position: fixed; top: 0; left: 0">
    <img src="/admin/images/loading.gif" style="position: absolute; width: 100px; height: 100px; left: calc(50% - 50px); top: calc(50% - 50px)">
    <div style="position: absolute; top: calc(50% + 80px); width: 100%; text-align: center">
        <p style="font-size: 18px; color: white"> Please wait...</p>
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
    let getUrl = "{{ route('admin_product.getRelationship', ['product_id' => 'productID']) }}";
    let updateUrl = "{{ route('admin_product.updateRelationship') }}";

    $(document).ready(function() {
        $('#product-table .clickable').first().addClass('clicked');
        loadRelation();
    })

    $("#product-table tr.clickable").click(function() {
        if ($(this).hasClass('clicked')) {
            return;
        }

        $('#product-table .clicked').removeClass('clicked');
        $('#related-product-table .clicked').removeClass('clicked');
        $(this).addClass('clicked');
        
        loadRelation();
    });

    function loadRelation() {
        let productId = $("#product-table .clicked").data('id');
        $("#loading-image").show();

        $.ajax({
            type: "GET",
            data: {"_token": "{{ csrf_token() }}"},
            url: getUrl.replace('productID', productId),
            success: function(response){
                $("#loading-image").hide();
                let ids = JSON.parse(response);
                ids.forEach(function(id) {
                    $("#related-tr_"+id).addClass('clicked');
                });
            }
        });
    }

    $('#related-product-table tr.clickable').click(function() {
        let productId = $("#product-table tr.clicked").data('id');
        let relatedProductId = $(this).data('id');
        let hasRelation = true;
        
        if (!productId || !relatedProductId) {
            return;
        }
        if ($(this).hasClass('clicked')) {
            hasRelation = false;
            $(this).removeClass('clicked');
        } else {
            $(this).addClass('clicked');
        }
        $("#loading-image").show();

        $.ajax({
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                productId,
                relatedProductId,
                hasRelation
            },
            url: updateUrl,
            success: function(response){
                $("#loading-image").hide();
            }
        });
    });
</script>

@endpush