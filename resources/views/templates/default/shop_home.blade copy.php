@extends($templatePath.'.shop_layout')

@section('center')
          <div class="features_items row no-margin"><!--features_items-->
            <h2 class="title text-center">{{ trans('front.features_items') }}</h2>
                @foreach ($products_new as  $key => $product_new)
                  <div class=" col-xs-6 col-sm-4 col-lg-3">
                    <div class="product-image-wrapper product-single">
                      <div class="single-products product-box-{{ $product_new->id }}">
                          <div class="productinfo text-center">
                            <a href="{{ $product_new->getUrl() }}">
                              <div class="product-image-container">
                                <img src="{{ asset($product_new->getThumb()) }}" alt="{{ $product_new->name }}" />
                              </div>
                            </a>
                            <a href="{{ $product_new->getUrl() }}"><div class="product-name-container"><p>{{ $product_new->name }}</p></div></a>
                            <div class="price">
                              {!! $product_new->showPrice() !!}
                            </div>
                            @if ($product_new->allowSale())
                             <a class="btn btn-default add-to-cart" onClick="addToCartAjax('{{ $product_new->id }}','default')"><i class="fa fa-shopping-cart"></i>{{trans('front.add_to_cart')}}</a>
                            @else
                              &nbsp;
                            @endif

                          </div>
                      @if ($product_new->price != $product_new->getFinalPrice() && $product_new->kind != SC_PRODUCT_GROUP)
                      <img src="{{ asset($templateFile.'/images/home/sale.png') }}" class="new" alt="" />
                      @elseif($product_new->type == SC_PRODUCT_NEW)
                      <img src="{{ asset($templateFile.'/images/home/new.png') }}" class="new" alt="" />
                      @elseif($product_new->type == SC_PRODUCT_HOT)
                      <img src="{{ asset($templateFile.'/images/home/hot.png') }}" class="new" alt="" />
                      @elseif($product_new->kind == SC_PRODUCT_BUILD)
                      <img src="{{ asset($templateFile.'/images/home/bundle.png') }}" class="new" alt="" />
                      @elseif($product_new->kind == SC_PRODUCT_GROUP)
                      <img src="{{ asset($templateFile.'/images/home/group.png') }}" class="new" alt="" />
                      @endif
                      </div>
                      <div class="choose">
                        <ul class="nav nav-pills nav-justified">
                          <li><a onClick="addToCartAjax('{{ $product_new->id }}','wishlist')"><i class="fa fa-heart"></i>{{trans('front.add_to_wishlist')}}</a></li>
                          <li><a onClick="addToCartAjax('{{ $product_new->id }}','compare')"><i class="fa fa-exchange"></i>{{trans('front.add_to_compare')}}</a></li>
                        </ul>
                      </div>
                    </div>
                  </div>
               @endforeach
          </div><!--features_items-->

          <div class="recommended_items"><!--recommended_items-->
            <h2 class="title text-center">{{ trans('front.products_hot') }}</h2>

            <div id="recommended-item-carousel" class="carousel slide" data-ride="carousel">
              <div class="carousel-inner" style="padding-top: 15px;">
                @foreach ($products_hot as  $key => $product_hot)
                @if ($key % 4 == 0)
                  <div class="item {{  ($key ==0)?'active':'' }}">
                @endif
                  <div class=" col-xs-6 col-sm-4 col-lg-3">
                    <div class="product-image-wrapper product-single">
                      <div class="single-products   product-box-{{ $product_hot->id }}">
                          <div class="productinfo text-center">
                            <a href="{{ $product_hot->getUrl() }}">
                              <div class="product-image-container">
                                <img src="{{ asset($product_hot->getThumb()) }}" alt="{{ $product_hot->name }}" />
                              </div>
                            </a>
                            <a href="{{ $product_hot->getUrl() }}"><div class="product-name-container"><p>{{ $product_hot->name }}</p></div></a>
                            <div class="price">
                              {!! $product_hot->showPrice() !!}
                            </div>                            
                          </div>

                      @if ($product_hot->price != $product_hot->getFinalPrice() && $product_hot->kind != SC_PRODUCT_GROUP)
                      <img src="{{ asset($templateFile.'/images/home/sale.png') }}" class="new" alt="" />
                      @elseif($product_hot->type == SC_PRODUCT_NEW)
                      <img src="{{ asset($templateFile.'/images/home/new.png') }}" class="new" alt="" />
                      @elseif($product_hot->type == SC_PRODUCT_HOT)
                      <img src="{{ asset($templateFile.'/images/home/hot.png') }}" class="new" alt="" />
                      @elseif($product_hot->kind == SC_PRODUCT_BUILD)
                      <img src="{{ asset($templateFile.'/images/home/bundle.png') }}" class="new" alt="" />
                      @elseif($product_hot->kind == SC_PRODUCT_GROUP)
                      <img src="{{ asset($templateFile.'/images/home/group.png') }}" class="new" alt="" />
                      @endif

                      </div>
                      <div class="choose">
                        <ul class="nav nav-pills nav-justified">
                          <li><a onClick="addToCartAjax('{{ $product_hot->id }}','wishlist')" title="{{trans('front.add_to_wishlist')}}"><i class="fa fa-heart"></i></a></li>
                          <li>
                            @if ($product_hot->allowSale())
                             <a class="btn btn-default add-to-cart" onClick="addToCartAjax('{{ $product_hot->id }}','default')" title="{{trans('front.add_to_cart')}}"><i class="fa fa-shopping-cart"></i></a>
                            @else
                              &nbsp;
                            @endif
                          </li>
                          <li><a onClick="addToCartAjax('{{ $product_hot->id }}','compare')" title="{{trans('front.add_to_compare')}}"><i class="fa fa-exchange"></i></a></li>
                        </ul>
                      </div>
                    </div>
                  </div>
                @if ($key % 4 == 3 || $key+1 == $products_hot->count())
                  </div>
                @endif
               @endforeach

              </div>
               <a class="left recommended-item-control" href="#recommended-item-carousel" data-slide="prev">
                <i class="fa fa-angle-left"></i>
                </a>
                <a class="right recommended-item-control" href="#recommended-item-carousel" data-slide="next">
                <i class="fa fa-angle-right"></i>
                </a>
            </div>
          </div><!--/recommended_items-->
@endsection



@push('styles')
@endpush

@push('scripts')

@endpush
