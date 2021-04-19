@extends($templatePath.'.shop_layout')

@section('main')
<section >
<div class="container">
    <div class="row">
        <h1 class="title text-center">{{ $title }}</h1>
        @if (count($compare) ==0)
            <div class="col-md-12 alert alert-info text-info">
               No Products Currently Chosen
            </div>
        @else
<div class="table-responsive">
<table class="table box table-bordered">
    <thead>
        <th> # </th>
        <th> Name </th>
        <th> Image </th>
        <th> Price </th>
        <th> Description </th>
        @foreach($benefits as $benefit)
        <th> {{ $benefit }}</th>
        @endforeach
        <th> Action </th>
    </thead>
    <tbody>
    @php
        $n = 0;
    @endphp
    @foreach($compare as $key => $item)
        @php
            $n++;
            $product = App\Models\ShopProduct::find($item->id);
            $productBenefits = $product->getBenefitDetails();
        @endphp
        <tr>
            <td> {{ $n }} </td>
            <td align="center">
                {{ $product->name }}({{ $product->sku }})
            </td>
            <td>
                <a href="{{ $product->getUrl() }}"><img width="100" src="{{asset($product->getImage())}}" alt=""></a>
            </td>
            <td>
                {!! $product->showPrice() !!}
            </td>
            <td>
                {!! $product->description !!}
            </td>
            @foreach($productBenefits as $detail)
            <td>
                {!! $detail !!}
            </td>
            @endforeach
            <td>
                <a onClick="return confirm('Are you sure to remove this item?')" title="Remove Item" alt="Remove Item" class="cart_quantity_delete" href="{{route("compare.remove",['id'=>$item->rowId])}}"><i class="fa fa-times"></i></a>
            </td>
       </tr>
    @endforeach

    </tbody>
  </table>
  </div>
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
</script>
@endpush
