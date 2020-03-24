
          <div class="category-tab"><!--category-tab-->
            <div class="col-sm-12">
              <ul class="nav nav-tabs">
                  <li class="active"><a href="#cate1" data-toggle="tab">{{ trans('front.products_build') }}</a></li>
                  <li><a href="#cate2" data-toggle="tab">{{ trans('front.products_group') }}</a></li>
              </ul>
            </div>
            <div class="tab-content">

                <div class="tab-pane fade active in" id="cate1" >
                  @foreach ($products_build as $product)
                    <div class="col-sm-3">
                      <div class="product-image-wrapper product-single">
                        <div class="single-products  product-box-{{ $product->id }}">
                          <div class="productinfo text-center">
                            <a href="{{ $product->getUrl() }}"><img src="{{ asset($product->getThumb()) }}" alt="{{ $product->name }}" /></a>
                            <a href="{{ $product->getUrl() }}"><div class="product-name-container"><p>{{ $product->name }}</p></div></a>
                            <div class="price">
                              {!! $product->showPrice() !!}
                            </div>
                            @if ($product->allowSale())
                             <a class="btn btn-default add-to-cart" onClick="addToCartAjax('{{ $product->id }}','default')"><i class="fa fa-shopping-cart"></i>{{trans('front.add_to_cart')}}</a>
                            @else
                              &nbsp;
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
                      @endif
                        </div>
                      </div>
                    </div>
                @endforeach
              </div>
                <div class="tab-pane fade" id="cate2" >
                  @foreach ($products_group as $product)
                    <div class="col-sm-3">
                      <div class="product-image-wrapper product-single">
                        <div class="single-products  product-box-{{ $product->id }}">
                          <div class="productinfo text-center">
                            <a href="{{ $product->getUrl() }}"><img src="{{ asset($product->getThumb()) }}" alt="{{ $product->name }}" /></a>
                            <a href="{{ $product->getUrl() }}"><div class="product-name-container"><p>{{ $product->name }}</p></div></a>
                            <div class="price">{!! $product->showPrice() !!}</div>
                            @if ($product->allowSale())
                             <a class="btn btn-default add-to-cart" onClick="addToCartAjax('{{ $product->id }}','default')"><i class="fa fa-shopping-cart"></i>{{trans('front.add_to_cart')}}</a>
                            @else
                              &nbsp;
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
                      @endif
                        </div>
                      </div>
                    </div>
                @endforeach
                </div>
          </div><!--/category-tab-->
