@extends($templatePath.'.shop_layout')
@php
  //echo json_encode($product->reviewDetails);
@endphp

@section('center')
          <div class="product-details"><!--product-details-->
            <div class="row" style="margin-bottom: 3rem">

              <div class="col-lg-4 col-md-6 col-xs-12">

                <div id="product-detail-image" style="margin-left: 15px; padding: 20px;position: relative;">
                  @if ($product->price != $product->getFinalPrice() && $product->kind != SC_PRODUCT_GROUP)
                  <img src="{{ asset($templateFile.'/images/home/sale2.png') }}" class="newarrival" alt="" />
                  @elseif($product->type == SC_PRODUCT_NEW)
                  <img src="{{ asset($templateFile.'/images/home/new2.png') }}" class="newarrival" alt="" />
                  @elseif($product->type == SC_PRODUCT_HOT)
                  <img src="{{ asset($templateFile.'/images/home/hot2.png') }}" class="newarrival" alt="" />
                  @elseif($product->kind == SC_PRODUCT_BUILD)
                  <img src="{{ asset($templateFile.'/images/home/bundle2.png') }}" class="newarrival" alt="" />
                  @elseif($product->kind == SC_PRODUCT_GROUP)
                  <img src="{{ asset($templateFile.'/images/home/group2.png') }}" class="newarrival" alt="" />
                  @endif

                  <!-- Wrapper for slides -->
                  <div class="product-images">
                    <div class="view-product item">
                      <img src="{{ asset($product->getImage()) }}">
                    </div>
                  @if ($product->images->count())
                    @foreach ($product->images as $image)
                      <div class="view-product item">
                        <img src="{{ asset($image->getImage()) }}">
                      </div>
                      @endforeach
                  @endif
                  </div>

                  <!-- Slider Nav -->
                  <div class="product-images-nav">
                  @if ($product->images->count())
                    <div class="view-product item">
                      <img src="{{ asset($product->getImage()) }}">
                    </div>
                  
                    @foreach ($product->images as $image)
                      <div class="view-product item">
                        <img src="{{ asset($image->getImage()) }}">
                      </div>
                      @endforeach
                  @endif
                  </div>

                </div>
              </div>
              
              <div class="col-lg-4 col-md-6 col-xs-12" style="padding: 1rem 3rem">
                  <h1 id="product-detail-name" style="font-size: 25px; margin-bottom: 13px; color: black">{{ $product->name }}</h1>
                  
                  <div class="rating-links">
                    @for($i = 1; $i <= $product->reviewDetails["meanMark"]; $i++)
                    <i class="fa fa-star" aria-hidden="true" style="color: orange"></i>
                    @endfor
                    @for(; $i <= 5; $i++)
                    <i class="fa fa-star" aria-hidden="true" style="color: darkgray"></i>
                    @endfor

                    <span> {{ $product->reviewDetails["count"] }} reviews </span>
                    {{--
                      <a style="margin-left: 10px; color: #878787; cursor: pointer" onclick="openReviewTab()">
                      @auth
                        @if(isset($product->reviewDetails["myReview"]))
                          Edit Your Review
                        @else
                          Add Your Review
                        @endif
                      @endauth
                      @guest
                        Reviews
                      @endguest
                    </a>
                    --}}
                  </div>

                  <ul style="padding-left: 2rem">
                    <li style="list-style: disc">
                      <p>SKU: <span  id="product-detail-model">{{ $product->sku }}</span></p>
                    </li>
                    <li style="list-style: disc">
                      @if (sc_config('product_brand') && !empty($product->brand->name))
                        <b>{{ trans('product.brand') }}:</b> <span id="product-detail-brand">{{ empty($product->brand->name)?'None':$product->brand->name }}</span><br>
                      @endif 
                    </li>
                  </ul>
                  @if (sc_config('product_available') && $product->date_available >= date('Y-m-d H:i:s'))
                    <b>{{ trans('product.date_available') }}:</b>
                    <span id="product-detail-available">
                      {{ $product->date_available }}
                    </span>
                    <br>
                  @endif
                  
                  <div class="description">
                    {{ $product->description }}
                  </div>

                  @if ($product->kind == SC_PRODUCT_GROUP)
                  <div class="products-group">
                    @php
                      $groups = $product->groups
                    @endphp
                    <b>{{ trans('product.groups') }}</b>:<br>
                    @foreach ($groups as $group)
                      <span class="sc-product-group" data-id="{{ $group->product_id }}">{!! sc_image_render($group->product->image) !!}</span>
                    @endforeach
                  </div>
                  @endif

                  @if ($product->kind == SC_PRODUCT_BUILD)
                  <div class="products-group">
                    @php
                      $builds = $product->builds
                    @endphp
                    <b>{{ trans('product.builds') }}</b>:<br>
                    <span class="sc-product-build">{!! sc_image_render($product->image) !!} = </span>
                    @foreach ($builds as $k => $build)
                      {!! ($k)?'<i class="fa fa-plus" aria-hidden="true"></i>':'' !!} <span class="sc-product-build">{{ $build->quantity }} x <a target="_new" href="{{ $build->product->getUrl() }}">{!! sc_image_render($build->product->image) !!}</a></span>
                    @endforeach
                  </div>
                  @endif

              </div>

              <div class="col-lg-4 col-md-6 col-xs-12" style="padding: 0 2rem">
                <div class="product-information"><!--/product-information-->
                  <form id="buy_block" action="{{ route('cart.add') }}" method="post">
                    {{ csrf_field() }}
                    <input type="hidden" name="product_id" id="product-detail-id" value="{{ $product->id }}" />
                      
                    <div id="product-detail-price">
                      {!! $product->showPriceDetail() !!}
                    </div>

                    @if ($product->kind == SC_PRODUCT_GROUP)
                    <div class="product-detail-cart-group" style="display:none">
                      <label class="label">{{ trans('product.quantity') }}:</label>
                      <div class="content">
                        <input class="form-control" type="number" name="qty" value="1" min="1" />
                      </div>
                    </div>
                    @elseif($product->allowSale())
                    <label class="label">{{ trans('product.quantity') }}:</label>
                    <div class="content">
                      <input class="form-control" type="number" name="qty" value="1" min="1" />
                    </div>
                    @endif


                    <div  id="product-detail-attr">
                      @if ($product->attributes())
                      {!! $product->renderAttributeDetails() !!}
                      @endif
                    </div>

                    @if (sc_config('product_stock'))
                    <label class="label">{{ trans('product.stock_status') }}:</label>
                    <div id="stock_status" class="content">
                      <label style="margin-top: .5rem">
                        @if($product->stock <=0 && !sc_config('product_buy_out_of_stock'))
                        {{ trans('product.out_stock') }}
                        @else
                        {{ trans('product.in_stock') }}
                        @endif
                      </label>
                    </div>
                    <br>
                    @endif
                    @if ($product->kind == SC_PRODUCT_GROUP)
                    <div class="product-detail-cart-group" style="display:none">
                      <button type="submit" class="btn btn-primary cart">
                        <i class="fa fa-shopping-cart"></i>
                        {{trans('front.add_to_cart')}}
                      </button>
                    </div>
                    @elseif($product->allowSale())
                    <button type="submit" class="btn btn-primary cart">
                      <i class="fa fa-shopping-cart"></i>
                      {{trans('front.add_to_cart')}}
                    </button>
                    @endif

                  </form>
                </div><!--/product-information-->
              </div><!--/product-details-->

            </div>
            
            <div class="category-tab shop-details-tab"><!--product description-tab-->
              <ul class="nav nav-tabs nav-fill">
                  <li class="nav-item active">
                      <a class="nav-link active" href="#tab-general" data-toggle="tab">{{ trans('product.content') }}</a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link" href="#tab-specification" data-toggle="tab">{{ trans('product.specification') }}</a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link" href="#tab-case_study" data-toggle="tab">{{ trans('product.case_study') }}</a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link" href="#tab-review" data-toggle="tab">{{ trans('product.review') }}</a>
                  </li>
              </ul>
              <!-- <div>
                <ul class="nav nav-tabs">
                  <li class="active"><a href="#details" data-toggle="tab">{{ trans('product.description') }}</a></li>
                </ul>
              </div> -->
              <div class="tab-content">
                <div class="ckeditor-content tab-pane fade  active in" id="tab-general" >
                  {!! sc_html_render($product->content) !!}
                </div>
                <div class="ckeditor-content tab-pane fade" id="tab-specification" >
                  {!! sc_html_render($product->specification) !!}
                </div>
                <div class="ckeditor-content tab-pane fade" id="tab-case_study" >
                  {!! sc_html_render($product->case_study) !!}
                </div>
                <div class="ckeditor-content tab-pane fade" id="tab-review" >
                  <!-- product review tab -->
                <!-- <div class="category-tab product-review-tab" id="product-reviews"> -->
                  <h2 class="text-center origin" style="font-size: 30px; ">{{$product->reviewDetails["count"]}} reviews for this product</h2>
                  @auth
                    <div class="review-container" style="padding: 0 2rem;">
                      <div class="row"> 
                        <div class="col">
                          <h4 class="origin"> Write your review for this product </h4>
                        </div>
                        <div class="col text-right"> 
                          @if(isset($product->reviewDetails["myReview"]))
                          <p> {{ $product->reviewDetails["myReview"]["updated_at"] }} </p>
                          @endif
                        </div>
                      </div>
                      
                      <form id="product-review-form" action="/product/review" method="POST">
                        @csrf
                        @php
                          $content = '';
                          if(old('content')) {
                            $content = old('content');
                          } elseif(isset($product->reviewDetails["myReview"]["content"])) {
                            $content = $product->reviewDetails["myReview"]["content"];
                          }
                        @endphp
                        <textarea rows="5" name="content" class="form-control text">{{ $content }}</textarea>
                        <div class="edit-review-mark">
                          @php
                            $mark = 0;
                            if(old('mark')) {
                              $mark = old('mark');
                            } elseif(isset($product->reviewDetails["myReview"])) {
                              $mark = $product->reviewDetails["myReview"]["mark"];
                            }
                          @endphp
                          @for($i = 1; $i <= $mark; $i++)
                          <i class="fa fa-star active" aria-hidden="true" id="mark-{{ $i }}"></i>
                          @endfor
                          @for(; $i <= 5; $i++)
                          <i class="fa fa-star" aria-hidden="true" id="mark-{{ $i }}"></i>
                          @endfor
                        </div>

                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="hidden" name="mark" id="product-mark" value="{{ $mark }}">
                        @if(isset($product->reviewDetails["myReview"]))
                        <input type="hidden" name="id" value="{{ $product->reviewDetails['myReview']['id'] }}">
                        @endif
                        <div class="text-right">
                          <input type="submit" class="btn btn-primary">
                        </div>
                      </form>
                    </div>
                  @endauth
                  
                  @foreach($product->reviewDetails["otherReviews"] as $review)
                  <div class="review-container">
                    <div class="row" style="margin-bottom: 20px"> 
                      <div class="col">
                        <img src="{{ $review['user']['avatar'] }}" class="avatar">
                        <strong>{{ $review['user']['name'] }}</strong>
                      </div>
                      <div class="col text-center">
                          @for($i = 1; $i <= $review['mark']; $i++)
                          <i class="fa fa-star" aria-hidden="true" style="color: orange"></i>
                          @endfor
                          @for(; $i <= 5; $i++)
                          <i class="fa fa-star" aria-hidden="true" style="color: darkgray"></i>
                          @endfor
                      </div>
                      <div class="col text-right">
                        <p>{{ $review["updated_at"] }}</p>
                      </div>
                    </div>
                    <div>
                      {{ $review["content"] }}
                    </div>
                  </div>
                  @endforeach
                <!-- </div> -->
                <!-- product review tab -->
                </div>
              </div>
            </div><!--/product description-tab-->
            
@if (count($productsToCategory))
            <div class="recommended_items"><!--recommended_items-->
              <h2 class="title text-center">{{ trans('front.recommended_items') }}</h2>

              <div id="recommended-item-carousel" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">
                @foreach ($productsToCategory as  $key => $product_rel)
                  @if ($key % 4 == 0)
                    <div class="item {{  ($key ==0)?'active':'' }}">
                  @endif
                    <div class="col-xs-3">
                      <div class="product-image-wrapper product-single">
                        <div class="single-products   product-box-{{ $product_rel->id }}">
                            <div class="productinfo text-center">
                              <a href="{{ $product_rel->getUrl() }}">
                                <div class="product-image-container">
                                  <img src="{{ asset($product_rel->getThumb()) }}" alt="{{ $product_rel->name }}" />
                                </div>
                              </a>
                          {!! $product_rel->showPrice() !!}
                              <a href="{{ $product_rel->getUrl() }}"><p>{{ $product_rel->name }}</p></a>
                            </div>
                            @if ($product_rel->price != $product_rel->getFinalPrice())
                            <img src="{{ asset($templateFile.'/images/home/sale.png') }}" class="new" alt="" />
                            @elseif($product_rel->type == 1)
                            <img src="{{ asset($templateFile.'/images/home/new.png') }}" class="new" alt="" />
                            @endif
                        </div>
                      </div>
                    </div>
                  @if ($key % 4 == 3 || $key+1 == count($productsToCategory))
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
@endif


@endsection

@section('breadcrumb')
@endsection

@push('styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick-theme.min.css" rel="stylesheet">
@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js"></script>
<script type="text/javascript">
  let attributePrice = '{!! $product->attribute_price !!}';
  let currency = '{!! sc_currency_render(0) !!}';
  let orgPrice;
  currency = currency.substr(0, currency.length-1);

  $(document).ready(function() {
    initSliders();
    initMarkEvents();
    initAttributePrice();
  });

  function initSliders() {
    $('.product-images').slick({
      slidesToShow: 1,
      slidesToScroll: 1,
      arrows: false,
      fade: true,
      asNavFor: '.product-images-nav'
    });
    $('.product-images-nav').slick({
      slidesToShow: 3,
      slidesToScroll: 1,
      asNavFor: '.product-images',
      arrows: true,
      dots: false,
      centerMode: true,
      focusOnSelect: true,
      infinite: false,
    });
  }

  $( "#product-review-form" ).submit(function( event ) {
    if ($("#product-mark").val < 1) {
      alert("Please add mark before submit review!");
      event.preventDefault();
    }
  });

  function initMarkEvents() {
    if (!$(".edit-review-mark")) {
      return;
    }
    $(".edit-review-mark").children().each(function(idx, element) {
      $(element).hover(
        function() {
          $(".edit-review-mark").children().removeClass("focus");
          for (let i = 1; i <= idx+1; i ++) {
            $(".edit-review-mark #mark-" + i).addClass("focus");
          }
        },
        function() {
          $(".edit-review-mark").children().removeClass("focus");
        }
      );

      $(element).click(function() {
        $(".edit-review-mark").children().removeClass("active");
        for (let i = 1; i <= idx+1; i ++) {
          $(".edit-review-mark #mark-" + i).addClass("active");
        }
        $("#product-mark").val(idx+1);
      });
    });
  }
  function initAttributePrice() {
    orgPrice = $("#product-detail-price span").html();

    if (attributePrice) {
      attributePrice = JSON.parse(attributePrice);
    }

    $(".product-attribute-item").change(function(event) {
      let formArray = $("#buy_block").serializeArray();
      let attributePriceKey = "";
      let attributeName = "form_attr";
      let groupId = "";

      for(let i = 3; i < formArray.length; i ++) {
        if (attributePriceKey) {
          attributePriceKey += "---";
        }
        groupId = formArray[i].name.substr(attributeName.length + 1, formArray[i].name.length-attributeName.length-2);
        attributePriceKey += groupId + "___" + formArray[i].value;
      }
      if (attributePrice[attributePriceKey]) {
        $("#product-detail-price span").html(currency + attributePrice[attributePriceKey]);
      } else {
        $("#product-detail-price span").html(orgPrice);
      }
      
    });
  }
  
  $('.sc-product-group').click(function(event) {
    if($(this).hasClass('active')){
      return;
    }
    $('.sc-product-group').removeClass('active');
    $(this).addClass('active');
    var id = $(this).data("id");
      $.ajax({
          url:'{{ route("product.info") }}',
          type:'POST',
          dataType:'json',
          data:{id:id,"_token": "{{ csrf_token() }}"},
          beforeSend: function(){
              $('#loading').show();
          },
          success: function(data){
            //console.log(data);
            $('.product-detail-cart-group').show();
            $('#product-detail-name').html(data.name);
            $('#product-detail-model').html(data.sku);
            $('#product-detail-price').html(data.showPrice);
            $('#product-detail-brand').html(data.brand_name);
            $('#product-detail-image').html(data.showImages);
            $('#product-detail-available').html(data.availability);
            $("#product-detail-attr").html(data.attribute);
            $("#tab-general").html(data.content);
            $("#tab-specification").html(data.specification);
            $("#tab-case_study").html(data.case_study);
            $('#product-detail-id').val(data.id);
            $('#product-detail-image').carousel();
            $('#loading').hide();
            attributePrice = data.attribute_price;
            initAttributePrice();
            window.history.pushState("", "", data.url);            
          }
      });

  });

  // function openReviewTab() {
  //   $('.nav-tabs a[href="#tab-review"]').tab('show');
  //   document.location.href = "#tab-review";
  // }
</script>
@endpush
