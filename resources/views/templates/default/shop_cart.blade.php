@extends($templatePath.'.shop_layout')

@section('main')
<section>
    <div class="container">
      <div class="row">
<h1 class="title text-center">{{ $title }}</h1>
@if (count($cart) ==0)
    <div class="col-md-12 alert alert-danger text-danger">
        No items in cart
    </div>
@else
 
<div class="table-responsive">
<table class="table box table-bordered">
    <thead>
      <tr  style="background: #eaebec">
        <th style="width: 50px;">No.</th>
        <th style="width: 100px;">{{ trans('product.sku') }}</th>
        <th>{{ trans('product.name') }}</th>
        <th>{{ trans('product.price') }}</th>
        <th >{{ trans('product.quantity') }}</th>
        <th>{{ trans('product.total_price') }}</th>
        <th>{{ trans('cart.delete') }}</th>
      </tr>
    </thead>
    <tbody>
    @php 
     $ads = 0;
    @endphp
    @foreach($cart as $item)
        @php
            $n = (isset($n)?$n:0);
            $n++;
            $product = App\Models\ShopProduct::find($item->id);
            if ($product->type == 3) 
                $ads++;
        @endphp
    <tr class="row_cart">
        <td >{{ $n }}</td>
        <td>{{ $product->sku }}</td>
        <td>
            {{ $product->getName() }}<br>
{{-- Process attributes --}}
                @if ($item->options->count())
                    (
                    @foreach ($item->options as $keyAtt => $att)
                        <b>{{ $attributesGroup[$keyAtt] }}</b>: <i>{{ $att }}</i> ;
                    @endforeach
                    )<br>
                @endif
{{-- //end Process attributes --}}
            <a href="{{$product->getUrl() }}"><img width="100" src="{{asset($product->getImage())}}" alt=""></a>
        </td>
        <td>
            @if ($product->type == 3)
            <span class="sc-new-price">Variable</span>
            @else
            <span class="sc-new-price">{!! sc_currency_render($item->price) !!}</span>
            @endif
        </td>
        <td><input style="width: 70px;" type="number" data-id="{{ $item->id }}" data-rowid="{{$item->rowId}}" onChange="updateCart($(this));" class="item-qty" name="qty-{{$item->id}}" value="{{$item->qty}}"><span class="text-danger item-qty-{{$item->id}}" style="display: none;"></span></td>
        <td align="right">{{sc_currency_render($item->subtotal)}}</td>
        <td>
            <a onClick="return confirm('Are you sure to delete this item?')" title="Remove Item" alt="Remove Item" class="cart_quantity_delete" href="{{route("cart.remove",['id'=>$item->rowId])}}"><i class="fa fa-times" aria-hidden="true" aria-hidden="true"></i></a>
        </td>
    </tr>
    @endforeach
    </tbody>
    <tfoot>
        <tr style="background: #eaebec">
            <td colspan="7">
                <div class="pull-left">
                    <button class="btn btn-default" type="button" style="cursor: pointer;padding:10px 30px" onClick="location.href='{{ route('home') }}'"><i class="fa fa-arrow-left" aria-hidden="true"></i> {{ trans('cart.back_to_shop') }}</button>
                </div>
                <div class="pull-right">
                    <button class="btn" type="button" style="cursor: pointer;padding:10px 30px" onClick="if(confirm('Confirm ?')) window.location.href='{{ route('cart.clear') }}';" >
                        <i class="fa fa-window-close" aria-hidden="true" aria-hidden="true"></i>
                        {{ trans('cart.remove_all') }}
                    </button>
                </div>
            </td>
        </tr>
    </tfoot>
  </table>
  </div>

<form class="sc-shipping-address" id="form-order" role="form" method="POST" action="{{ route('cart.process') }}" data-toggle="validator" enctype="multipart/form-data">
<div class="row">
    <div class="col-md-6">
            @csrf
            <table class="table  table-bordered table-responsive">
                <tr>
                @if (sc_config('customer_lastname'))
                    <td class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
                        <label for="first_name" class="control-label"><i class="fa fa-user-o" aria-hidden="true"></i> {{ trans('cart.first_name') }}:</label> 
                        <input name="first_name" type="text" placeholder="{{ trans('cart.first_name') }}" value="{{(old('first_name'))?old('first_name'):$shippingAddress['first_name']}}" required>
                            @if($errors->has('first_name'))
                                <span class="help-block">{{ $errors->first('first_name') }}</span>
                            @endif
                    </td>
                    <td class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
                        <label for="last_name" class="control-label"><i class="fa fa-user-o" aria-hidden="true"></i> {{ trans('cart.last_name') }}:</label> 
                        <input name="last_name" type="text" placeholder="{{ trans('cart.last_name') }}" value="{{(old('last_name'))?old('last_name'):$shippingAddress['last_name']}}" required>
                            @if($errors->has('last_name'))
                                <span class="help-block">{{ $errors->first('last_name') }}</span>
                            @endif
                    </td> 

                @else
                <td colspan="2" class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
                    <label for="first_name" class="control-label"><i class="fa fa-user-o" aria-hidden="true"></i> {{ trans('cart.name') }}:</label> 
                    <input name="first_name" type="text" placeholder="{{ trans('cart.name') }}" value="{{(old('first_name'))?old('first_name'):$shippingAddress['first_name']}}" required>
                    @if($errors->has('first_name'))
                        <span class="help-block">{{ $errors->first('first_name') }}</span>
                    @endif
                </td>
                @endif
                </tr>

                <tr>
                    @if (sc_config('customer_phone'))
                    <td  class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <label for="email" class="control-label"><i class="fa fa-envelope-o" aria-hidden="true"></i> {{ trans('cart.email') }}:</label> 
                        <input name="email" type="text" placeholder="{{ trans('cart.email') }}" value="{{(old('email'))?old('email'):$shippingAddress['email']}}" required>
                            @if($errors->has('email'))
                                <span class="help-block">{{ $errors->first('email') }}</span>
                            @endif
                    </td>
                    <td class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                        <label for="phone" class="control-label"><i class="fa fa-phone" aria-hidden="true" aria-hidden="true"></i> {{ trans('cart.phone') }}:</label> 
                        <input name="phone" type="text" placeholder="{{ trans('cart.phone') }}" value="{{(old('phone'))?old('phone'):$shippingAddress['phone']}}" required>
                        @if($errors->has('phone'))
                            <span class="help-block">{{ $errors->first('phone') }}</span>
                        @endif
                    </td>
                    @else
                    <td  colspan="2" class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <label for="email" class="control-label"><i class="fa fa-envelope" aria-hidden="true"></i> {{ trans('cart.email') }}:</label> 
                        <input name="email" type="text" placeholder="{{ trans('cart.email') }}" value="{{(old('email'))?old('email'):$shippingAddress['email']}}" required>
                        @if($errors->has('email'))
                            <span class="help-block">{{ $errors->first('email') }}</span>
                        @endif
                    </td>
                    @endif

                </tr>


                @if (sc_config('customer_country'))
                    <tr>
                        <td colspan="2" class="form-group{{ $errors->has('country') ? ' has-error' : '' }}">
                            <label  for="country" class="control-label"><i class="fa fa-dribbble" aria-hidden="true" aria-hidden="true"></i> {{ trans('cart.country') }}:</label>
                            @php
                                $ct = (old('country'))?old('country'):$shippingAddress['country'];
                            @endphp
                            <select class="form-control country " style="width: 100%;" name="country"  required>
                                <option value="">__{{ trans('cart.country') }}__</option>
                                @foreach ($countries as $k => $v)
                                    <option value="{{ $k }}" {{ ($ct ==$k) ? 'selected':'' }}>{{ $v }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('country'))
                                <span class="help-block">
                                    {{ $errors->first('country') }}
                                </span>
                            @endif
                        </td>
                    </tr>    
                @endif

                
                <tr>
                    @if (sc_config('customer_postcode'))
                    <td class="form-group {{ $errors->has('postcode') ? ' has-error' : '' }}">
                        <label for="postcode" class="control-label"><i class="fa fa-tablet" aria-hidden="true"></i> {{ trans('cart.postcode') }}:</label> 
                        <input name="postcode" type="text" placeholder="{{ trans('cart.postcode') }}" value="{{ (old('postcode'))?old('postcode'):$shippingAddress['postcode']}}"  required>
                        @if($errors->has('postcode'))
                            <span class="help-block">{{ $errors->first('postcode') }}</span>
                        @endif
                    </td>
                    @endif

                    @if (sc_config('customer_company'))
                    <td class="form-group{{ $errors->has('company') ? ' has-error' : '' }}">
                        <label for="company" class="control-label"><i class="fa fa-university" aria-hidden="true"></i> {{ trans('cart.company') }}</label>
                        <input name="company" type="text" placeholder="{{ trans('cart.company') }}" value="{{ (old('company'))?old('company'):$shippingAddress['company']}}" required>
                        @if($errors->has('company'))
                        <span class="help-block">{{ $errors->first('company') }}</span>
                        @endif
                    </td>
                    @endif
                </tr>

                <tr>
                    @if (sc_config('customer_address2'))
                    <td class="form-group {{ $errors->has('address1') ? ' has-error' : '' }}">
                        <label for="address1" class="control-label"><i class="fa fa-list-ul" aria-hidden="true"></i> {{ trans('cart.address1') }}:</label> 
                        <input name="address1" type="text" placeholder="{{ trans('cart.address1') }}" value="{{ (old('address1'))?old('address1'):$shippingAddress['address1']}}" required>
                        @if($errors->has('address1'))
                            <span class="help-block">{{ $errors->first('address1') }}</span>
                        @endif
                    </td>                    
                    <td class="form-group{{ $errors->has('address2') ? ' has-error' : '' }}">
                        <label for="address2" class="control-label"><i class="fa fa-list-ul" aria-hidden="true"></i> {{ trans('cart.address2') }}</label>
                        <input name="address2" type="text" placeholder="{{ trans('cart.address2') }}" value="{{ (old('address2'))?old('address2'):$shippingAddress['address2']}}" required>
                        @if($errors->has('address2'))
                        <span class="help-block">{{ $errors->first('address2') }}</span>
                        @endif
                    </td>
                    @else
                    <td colspan="2" class="form-group {{ $errors->has('address1') ? ' has-error' : '' }}">
                        <label for="address1" class="control-label"><i class="fa fa-list-ul" aria-hidden="true"></i> {{ trans('cart.address') }}:</label> 
                        <input name="address1" type="text" placeholder="{{ trans('cart.address') }}" value="{{ (old('address1'))?old('address1'):$shippingAddress['address1']}}" required>
                        @if($errors->has('address1'))
                            <span class="help-block">{{ $errors->first('address1') }}</span>
                        @endif
                    </td>  
                    @endif
                </tr>

                <tr>
                    <td colspan="2" class="{{ $errors->has('comment') ? 'has-error' : '' }}">
                        <label for="comment" class="control-label"><i class="fa fa-calendar-o" aria-hidden="true"></i> {{ trans('cart.note') }}:</label>
                        <textarea rows="5" id="comment" name="comment" placeholder="{{ trans('cart.note') }}....">{{ (old('comment'))?old('comment'):$shippingAddress['comment'] }}</textarea>
                        @if($errors->has('comment'))
                        <span class="help-block">{{ $errors->first('comment') }}</span>
                        @endif
                    </td>
                </tr>

                <tr id="po_doc-container" style="display: none">
                    <td colspan="2" class="{{ $errors->has('purchase_order_document') ? 'has-error' : '' }}">
                        <label for="purchase_order_document" class="control-label"><i class="fa fa-shopping-cart" aria-hidden="true"></i> {{ trans('cart.po_doc') }}:</label>
                        <input type="file" id="purchase_order_document" class="form-control" name="purchase_order_document" value="{{ (old('purchase_order_document'))?old('purchase_order_document'):'' }}"
                        accept= ".doc, .docx, .xls, .xlsx, .ppt, .pptx, .pdf" >
                        @if($errors->has('purchase_order_document'))
                        <span class="help-block">{{ $errors->first('purchase_order_document') }}</span>
                        @endif
                    </td>
                </tr>

            </table>

    </div>
    @if ($ads == 0)
    <div class="col-md-6">
    
    {{-- Total --}}
        <div class="row">
            <div class="col-md-12">
                <table class="table box table-bordered" id="showTotal">
                    @foreach ($dataTotal as $key => $element)
                    @if ($element['value'] !=0)

                        @if ($element['code']=='total')
                            <tr class="showTotal" style="background:#f5f3f3;font-weight: bold;">
                        @else
                        <tr class="showTotal">
                        @endif
                                <th>{!! $element['title'] !!}</th>
                            <td style="text-align: right" id="{{ $element['code'] }}">{{$element['text'] }}</td>
                        </tr>
                    @endif

                    @endforeach
                </table>

        {{-- Coupon --}}
                @if ($extensionDiscount)
                <div class="row">
                    <div class="form-group col-md-6">
                        <label class="control-label" for="inputGroupSuccess3"><i class="fa fa-exchange" aria-hidden="true" aria-hidden="true"></i> {{ trans('cart.coupon') }}
                            <span style="display:inline; cursor: pointer; display: {{ ($hasCoupon)?'inline':'none' }}" class="text-danger" id="removeCoupon">({{ trans('cart.remove_coupon') }} <i class="fa fa fa-times" aria-hidden="true"></i>)</span>
                        </label>
                        <div id="coupon-group" class="input-group {{ Session::has('error_discount')?'has-error':'' }}">
                            <input type="text" {{ ($extensionDiscount['permission'])?'':'disabled' }} placeholder="Your coupon" class="form-control" id="coupon-value" aria-describedby="inputGroupSuccess3Status">
                            <span class="input-group-addon {{ ($extensionDiscount['permission'])?'':'disabled' }}"  {!! ($extensionDiscount['permission'])?'id="coupon-button"':'' !!} style="cursor: pointer;" data-loading-text="<i class='fa fa-spinner fa-spin' aria-hidden='true'></i> checking">{{ trans('cart.apply') }}</span>
                        </div>
                        <span class="status-coupon" style="display: none;" class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true"></span>
                        <div class="coupon-msg  {{ Session::has('error_discount')?'text-danger':'' }}" style="text-align: left;padding-left: 10px;">{{ Session::has('error_discount')?Session::get('error_discount'):'' }}</div>
                    </div>
                </div>
                @endif
        {{-- //End coupon --}}


        {{-- Shipping method --}}
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group {{ $errors->has('shippingMethod') ? ' has-error' : '' }}">
                            <h3 class="control-label"><i class="fa fa-truck" aria-hidden="true" aria-hidden="true"></i> {{ trans('cart.shipping_method') }}:<br></h3>
                            @if($errors->has('shippingMethod'))
                                <span class="help-block">{{ $errors->first('shippingMethod') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            @foreach ($shippingMethod as $key => $shipping)
                                <div style="margin: 5px 10px">
                                    <label class="radio-inline">
                                        <input type="radio" name="shippingMethod" value="{{ $shipping['code'] }}"  {{ (old('shippingMethod') == $key)?'checked':'' }} style="position: relative;" {{ ($shipping['permission'])?'':'disabled' }}>
                                        {{ $shipping['title'] }} ({{ sc_currency_render($shipping['value']) }})
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
        {{-- //Shipping method --}}


        {{-- Payment method --}}
                <div class="row v-center">
                    <div class="col-xs-6">
                        <div class="form-group {{ $errors->has('paymentMethod') ? ' has-error' : '' }}">
                            <h3 class="control-label"><i class="fa fa-credit-card-alt" aria-hidden="true"></i> {{ trans('cart.payment_method') }}:<br></h3>
                            @if($errors->has('paymentMethod'))
                                <span class="help-block">{{ $errors->first('paymentMethod') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            @foreach ($paymentMethod as $key => $payment)
                                <div style="margin: 5px 10px">
                                    <label class="radio-inline">
                                        <input type="radio" name="paymentMethod" value="{{ $payment['code'] }}"  {{ (old('paymentMethod') == $key)?'checked':'' }} style="position: relative;" {{ ($payment['permission'])?'':'disabled' }} onchange="changePaymentMethod()"/>
                                        <img title="{{ $payment['title'] }}" alt="{{ $payment['title'] }}" src="{{ asset($payment['image']) }}" style="width: 120px;">
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-xs-6">
                        <div style="font-size: 25px; font-weight: 500">
                            <i class="fa fa-lock" aria-hidden="true"></i>
                            Secure Checkout 
                        </div>
                        <div style="margin-left: 25px"> 128-bit Encryption </div>
                    </div>
                </div>
        {{-- //Payment method --}}
            </div>
        </div>
    {{-- End total --}}

        <div class="row" style="padding-bottom: 20px;">
            <div class="col-xs-6">
                <div class="form-group">
                    <div style="margin: 10px 10px">
                        <label class="radio-inline">
                            <input type="checkbox" id="termsCondition" name="termsCondition" {{ (old('termsCondition') == $key)?'checked':'' }} style="position: relative;" onchange="changeTermsCondition()"/>
                            <div style="margin-left: 30px; margin-top: -35px"> I have read and accept </div>
                            <a style="margin-left: 30px;" href="/terms-condition" target="_blank">Terms and Condition</a>
                        </label>
                    </div>
                </div>
            </div>
            <div class="col-xs-6 text-center">
                <div class="pull-right">
                    <button class="btn btn-success" id="submit-order" type="submit" style="cursor: pointer;padding:10px 30px" disabled><i class="fa fa-check" aria-hidden="true"></i> {{ trans('cart.checkout') }}</button>
                </div>
            </div>
        </div>
    </div>    
    @endif
</div>
</form>
@endif
        </div>
    </div>
</section>
@endsection
@section('breadcrumb')
    <div class="breadcrumbs">
        <ol class="breadcrumb">
          <li><a href="{{ route('home') }}">{{ trans('front.home') }}</a></li>
          <li class="active">{{ $title }}</li>
        </ol>
      </div>
@endsection

@push('scripts')

<script type="text/javascript">
    var cart = @json($cart);
    var products = @json($products);
    var skuArr = [];
    $.each(cart, function (key, val) {
        skuArr.push(val.name);
    });
    function updateCart(obj){
        var new_qty = obj.val();
        var rowid = obj.data('rowid');
        var id = obj.data('id');
            $.ajax({
            url: '{{ route('cart.update') }}',
            type: 'POST',
            dataType: 'json',
            async: false,
            cache: false,
            data: {
                id: id,
                rowId: rowid,
                new_qty: new_qty,
                _token:'{{ csrf_token() }}'},
            success: function(data){
                error= parseInt(data.error);
                if(error ===0)
                {
                        window.location.replace(location.href);
                }else{
                    $('.item-qty-'+id).css('display','block').html(data.msg);
                }

                }
        });
    }
    function changePaymentMethod() {
        let payMethod = $("input[name='paymentMethod']:checked").val();
        if (payMethod == "PO") {
            $("#po_doc-container").show();
        } else {
            $("#po_doc-container").hide();
        }
    }
    changePaymentMethod();
    $('#form-order').submit(function() {
        let paymentMethod = $('input[name=paymentMethod]:checked', '#form-order').val();
        if (paymentMethod == "PO") {
            if (!$("#comment").val() || !$("#purchase_order_document").val()) {
                alert("When use purchase order option, you have to choose PO document and write notes.");
                $("#comment").focus();
                return false;
            }
        }
    });

    function changeTermsCondition() {
        if ($("#termsCondition").is(":checked")) {
            $("#submit-order").prop("disabled", false);
        } else {
            $("#submit-order").prop("disabled", true);
        }
    }
    changeTermsCondition();
@if ($extensionDiscount)
    $('#coupon-button').on('click', function() {
        var coupon = $('#coupon-value').val();
        var couponSku = coupon.split('_')[0];
        var isExistCoupon = skuArr.includes(couponSku);
        if (isExistCoupon){
            if(coupon==''){
                $('#coupon-group').addClass('has-error');
                $('.coupon-msg').html('{{ trans('cart.coupon_empty') }}').addClass('text-danger').show();
            }else{
            $('#coupon-button').button('loading');
            setTimeout(function() {
                $.ajax({
                    url: '{{ route('discount.process') }}',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        code: coupon,
                        uID: {{ $uID }},
                        _token: "{{ csrf_token() }}",
                    },
                })
                .done(function(result) {
                        $('#coupon-value').val('');
                        $('.coupon-msg').removeClass('text-danger');
                        $('.coupon-msg').removeClass('text-success');
                        $('#coupon-group').removeClass('has-error');
                        $('.coupon-msg').hide();
                    if(result.error ==1){
                        $('#coupon-group').addClass('has-error');
                        $('.coupon-msg').html(result.msg).addClass('text-danger').show();
                    }else{
                        $('#removeCoupon').show();
                        $('.coupon-msg').html(result.msg).addClass('text-success').show();
                        $('.showTotal').remove();
                        $('#showTotal').prepend(result.html);
                    }
                })
                .fail(function() {
                    console.log("error");
                })
            $('#coupon-button').button('reset');
            }, 2000);
        }
    } else {
        $('#coupon-group').addClass('has-error');
    }

    });
    $('#removeCoupon').click(function() {
            $.ajax({
                url: '{{ route('discount.remove') }}',
                type: 'POST',
                dataType: 'json',
                data: {
                    _token: "{{ csrf_token() }}",
                },
            })
            .done(function(result) {
                    $('#removeCoupon').hide();
                    $('#coupon-value').val('');
                    $('.coupon-msg').removeClass('text-danger');
                    $('.coupon-msg').removeClass('text-success');
                    $('.coupon-msg').hide();
                    $('.showTotal').remove();
                    $('#showTotal').prepend(result.html);
            })
            .fail(function() {
                console.log("error");
            })
            // .always(function() {
            //     console.log("complete");
            // });
    });   
@endif

</script>
@endpush
