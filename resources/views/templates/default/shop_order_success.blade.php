@extends($templatePath.'.shop_layout')

@section('main')
<section>
    <div class="container">
        <h2 class="title text-center">{{ $title }}</h2>
        <div class="row">
            <div class="col-xs-2"></div>
            <div class="col-xs-4 text-success">
                {{ trans('order.success.msg') }}
            </div>
            <div class="col-xs-4 text-right">
                <button class="btn btn-primary" onclick="exportToPdf()">Export to PDF </button>
            </div>
        </div>
        <br>
        <div class="report">
            <div class="row">
                <div class="col-xs-12">
                    <P style="font-size: 25px;"><b>
                        {{ sc_store('title') }}
                    </b></p>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-8">
                    {{ trans('front.shop_info.address') }}: {{ sc_store('address') }}
                </div>
                <div class="col-xs-4" style="text-align: right">
                    DATE &nbsp;&nbsp; <p class="property">{{ date('Y-m-d', strtotime($order->created_at)) }}</p>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-8">
                    {{ trans('front.shop_info.hotline') }}: {{ sc_store('long_phone') }}
                </div>
                <div class="col-xs-4" style="text-align: right">
                    ORDER# &nbsp;&nbsp; <p class="property">{{ $order->id }}</p>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12" >
                    <p>{{ trans('front.shop_info.email') }}: {{ sc_store('email') }}</p>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12" >
                    <p>Website: <a href="{{ route('home') }}">{{ route('home') }}</a></p>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-xs-5">
                    <p class="table-header">VENDOR</p>
                    <p>Company: {{ $title }}</p>
                    <p>{{ trans('front.shop_info.address') }}: {{ sc_store('address') }}</p>
                    <p>{{ trans('front.shop_info.hotline') }}: {{ sc_store('long_phone') }}</p>
                </div>
                <div class="col-xs-2"></div>
                <div class="col-xs-5">
                    <p class="table-header">SHIP TO</p>
                    <p>Name: {{ $order->first_name . " " . $order->last_name }}</p>
                    <p>{{ trans('front.shop_info.address') }}: {{ $order->address1 }}</p>
                    <p>{{ trans('front.shop_info.hotline') }}: {{ $order->phone }}</p>
                    <p>Email: {{ $order->email }} </p>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-xs-12">
                    <table class="table table-bordered">
                        <thead class="table-header">
                            <th>Shipping Method</th>
                            <th>Payment Method</th>
                            <th>Currency</th>
                            @if($order->payment_method == "PO")
                            <th>PO Document </th>
                            @endif
                        </thead>
                        <tbody>
                            <tr>
                                <td> {{ $order->shipping_method }} </td>
                                <td> {{ $order->payment_method }} </td>
                                <td> {{ $order->currency }} </td>
                                @if($order->payment_method == "PO")
                                <td> 
                                    <a href="{{ route('home') . $order->po_doc }}">
                                    {{ substr($order->po_doc, strpos($order->po_doc, "_")+1) }} 
                                    </a>
                                </td>
                                @endif
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-xs-12">
                    <table class="table table-bordered">
                        <thead class="table-header">
                            <th>ITEM#</th>
                            <th>DESCRIPTION</th>
                            <th>QTY</th>
                            <th>UNIT PRICE </th>
                            <th>TOTAL </th>
                        </thead>

                        <tbody>
                            @foreach($order->details as $key=>$detail)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $detail->name }}</td>
                                <td>{{ $detail->qty }}</td>
                                <td>{{ $detail->price }}</td>
                                <td class="total-column">{{ $detail->total_price }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-xs-7">
                    <div class="row" style="border: 1px solid #ddd">
                        <div class="col-xs-12 comment"> Comments or Special Instructions </div>
                        <div class="col-xs-12" style="min-height: 100px; padding: 10px"> {{ $order->comment }} </div>
                    </div>
                </div>
                <div class="col-xs-1"></div>
                <div class="col-xs-4">
                    <table class="table table-bordered">
                        <tr>
                            <td>SUBTOTAL</td>
                            <td class="total-column">{{ $order->subtotal }}</td>
                        </tr>
                        <tr>
                            <td>Tax</td>
                            <td class="total-column">{{ $order->tax }}</td>
                        </tr>
                        <tr>
                            <td>SHIPPING</td>
                            <td class="total-column">{{ $order->shipping }}</td>
                        </tr>
                        <tr>
                            <td>SUBTOTAL</td>
                            <td class="total-column">{{ $order->subtotal }}</td>
                        </tr>
                        <tr>
                            <td><b>TOTAL</b></td>
                            <td class="total">{{ $order->total }}</td>
                        </tr>
                    </table>
                </div>
            </div>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
<script src="https://unpkg.com/jspdf@latest/dist/jspdf.min.js"></script>
<script type="text/javascript">
    function exportToPdf() {
        let doc = new jsPDF('p', 'pt', 'a3');
        doc.addHTML($(".report")[0], function() {
            doc.save("Order Details.pdf");
        });
    }
</script>
@endpush