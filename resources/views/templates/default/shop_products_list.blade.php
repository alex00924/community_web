@extends($templatePath.'.shop_layout')

@section('center')
  <div class="features_items row no-margin">
    <h1 class="title text-center">{{ $title }}</h1>

    @isset ($itemsList)
      @if($itemsList->count())
      <div class="item-folder">
            @foreach ($itemsList as  $key => $item)
            <div class=" col-xs-12 col-sm-6 col-lg-3">
                <div class="item-folder-wrapper product-single">
                  <div class="single-products">
                    <div class="productinfo text-center product-box-{{ $item->id }}">
                      <a href="{{ $item->getUrl() }}">
                        <div class="product-image-container">
                          <img src="{{ asset($item->getThumb()) }}" alt="{{ $item->name }}" />
                        </div>
                      </a>
                      <a href="{{ $item->getUrl() }}"><div class="product-name-container"><p>{{ $item->name }}</p></div></a>
                    </div>
                  </div>
                </div>
            </div>
            @endforeach
        <div style="clear: both; ">
        </div>
      </div>
      @endif
    @endisset

      @if (count($products) ==0)
        {{ trans('front.empty_product') }}
      @else
          @foreach ($products as  $key => $product)
          <div class=" col-xs-12 col-sm-6 col-lg-3">
              <div class="product-image-wrapper product-single @if($product->type == 3) free-post @endif">
                <div class="single-products">
                  <div class="productinfo text-center product-box-{{ $product->id }}">
                    <a href="{{ $product->getUrl() }}">
                      <div class="product-image-container">
                        <img src="{{ asset($product->getThumb()) }}" alt="{{ $product->name }}" />
                      </div>
                    </a>
                    <a href="{{ $product->getUrl() }}">
                      <div class="{{ $product->type == 3 ?'product-ads-container':'product-name-container' }}">
                        <p>{{ $product->name }}</p>
                      </div>
                    </a>
                    @if($product->type == 3)
                      <div style="padding-bottom: 5px;"><a href="{{ $product->supplyLink }}" target="_blank" 
                        style="color: #4db848;">{{ 'by ' . $product->supplyName }}</a></div>
                    @endif
                  </div>
                      @if ($product->price != $product->getFinalPrice() && $product->kind != SC_PRODUCT_GROUP)
                      <img src="{{ asset($templateFile.'/images/home/sale.png') }}" class="new" alt="" />
                      @elseif($product->type == SC_PRODUCT_NEW)
                      <img src="{{ asset($templateFile.'/images/home/new.png') }}" class="new" alt="" />
                      @elseif($product->type == SC_PRODUCT_HOT)
                      <img src="{{ asset($templateFile.'/images/home/hot.png') }}" class="new" alt="" />
                      @elseif($product->kind == SC_PRODUCT_BUILD)
                      <img src="{{ asset($templateFile.'/images/home/bundle.png') }}" class="new" alt="" />
                      @elseif($product->kind == SC_PRODUCT_GROUP)
                      <img src="{{ asset($templateFile.'/images/home/group.png') }}" class="new" alt="" />
                      @elseif($product->type == SC_PRODUCT_FREE)
                      <img src="{{ asset($templateFile.'/images/home/free.png') }}" class="new" alt="" />
                      @endif
                </div>
                <div class="choose">
                  <ul class="nav nav-pills nav-justified">
                    @if($product->type != 3)
                      <li><a onClick="addToCartAjax({{ $product->id }},'wishlist')" title="{{trans('front.add_to_wishlist')}}"><i class="fa fa-heart fa-2x"></i></a></li>
                      <li>
                        @if ($product->allowSale())
                        <a onClick="addToCartAjax('{{ $product->id }}','default')" title="{{trans('front.add_to_cart')}}"><i class="fa fa-plus fa-2x"></i></a>
                        @else
                          &nbsp;
                        @endif
                      </li>
                    @endif
                    <li><a onClick="addToCartAjax({{ $product->id }},'compare')" title="{{trans('front.add_to_compare')}}"><i class="fa fa-exchange fa-2x"></i></a></li>
                  </ul>
                </div>
              </div>
          </div>
          @endforeach
      @endif

    <div style="clear: both; ">
        <ul class="pagination">
          {{ $products->appends(request()->except(['page','_token']))->links() }}
      </ul>
    </div>
</div>
@endsection


@section('breadcrumb')
    <div class="breadcrumbs pull-left">
        <ol class="breadcrumb">
          <li><a href="{{ route('home') }}">{{ trans('front.home') }}</a></li>
          <li class="active">{{ $title }}</li>
        </ol>
      </div>
@endsection

@section('filter')
  <form action="" method="GET" id="filter_sort">
        <div class="pull-right">
        <div>
            @php
              $queries = request()->except(['filter_sort','page']);
            @endphp
            @foreach ($queries as $key => $query)
              <input type="hidden" name="{{ $key }}" value="{{ $query }}">
            @endforeach
          <select class="custom-select" name="filter_sort">
            <option value="">{{ trans('front.filters.sort') }}</option>
            <option value="price_asc" {{ ($filter_sort =='price_asc')?'selected':'' }}>{{ trans('front.filters.price_asc') }}</option>
            <option value="price_desc" {{ ($filter_sort =='price_desc')?'selected':'' }}>{{ trans('front.filters.price_desc') }}</option>
            <option value="sort_asc" {{ ($filter_sort =='sort_asc')?'selected':'' }}>{{ trans('front.filters.sort_asc') }}</option>
            <option value="sort_desc" {{ ($filter_sort =='sort_desc')?'selected':'' }}>{{ trans('front.filters.sort_desc') }}</option>
            <option value="id_asc" {{ ($filter_sort =='id_asc')?'selected':'' }}>{{ trans('front.filters.id_asc') }}</option>
            <option value="id_desc" {{ ($filter_sort =='id_desc')?'selected':'' }}>{{ trans('front.filters.id_desc') }}</option>
          </select>
        </div>
      </div>
  </form>

@endsection

@push('styles')
@endpush
@push('scripts')
  <script type="text/javascript">
    $('[name="filter_sort"]').change(function(event) {
      $('#filter_sort').submit();
    });
  </script>
@endpush
