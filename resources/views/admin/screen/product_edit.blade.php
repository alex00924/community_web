@extends('admin.layout')

@section('main')
<style>
    #start-add {
        margin: 20px;
    }

    .select-product {
        margin: 10px 0;
    }
    .attribute-cell {
        background: #337ab7;
        color: white;
        height: 30px;
        padding: 1rem;
    }
    .attribute-cell.small-cell {
        width: 150px;
    }
</style>
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <h2 class="box-title">{{ $title_description??'' }}</h2>

                <div class="box-tools">
                    <div class="btn-group pull-right" style="margin-right: 5px">
                        <a href="{{ route('admin_product.index') }}" class="btn  btn-flat btn-default" title="List"><i
                                class="fa fa-list"></i><span class="hidden-xs"> {{trans('admin.back_list')}}</span></a>
                    </div>
                </div>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form action="{{ route('admin_product.edit',['id'=>$product['id']]) }}" method="post" accept-charset="UTF-8"
                class="form-horizontal" id="form-main" enctype="multipart/form-data">

@if (sc_config('product_kind'))
            <div class="col-xs-12" id="start-add">
                <div class="col-md-4"></div>
                <div class="col-md-4 form-group">
                    <div class="input-group input-group-sm" style="width: 300px;text-align: center;">
                        <b>{{ trans('product.type') }}:</b> {{ $kinds[$product->kind]??'' }}
                    </div>
                </div>
            </div>    
@endif


                <div class="box-body">
                    <div class="fields-group">

                        {{-- Descriptions --}}
                        @php
                        $descriptions = $product->descriptions->keyBy('lang')->toArray();
                        @endphp

                        @foreach ($languages as $code => $language)

                        <div class="form-group">
                            <label class="col-sm-2  control-label"></label>
                            <div class="col-sm-8">
                                <b>{{ $language->name }}</b>
                                {!! sc_image_render($language->icon,'20px','20px') !!}
                            </div>
                        </div>

                        <div class="form-group   {{ $errors->has('descriptions.'.$code.'.name') ? ' has-error' : '' }}">
                            <label for="{{ $code }}__name"
                                class="col-sm-2  control-label">{{ trans('product.name') }} <span class="seo" title="SEO"><i class="fa fa-coffee" aria-hidden="true"></i></span></label>

                            <div class="col-sm-8">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-pencil fa-fw"></i></span>
                                    <input type="text" id="{{ $code }}__name" name="descriptions[{{ $code }}][name]"
                                        value="{!!old('descriptions.'.$code.'.name',($descriptions[$code]['name']??'')) !!}"
                                        class="form-control {{ $code.'__name' }}" placeholder="" maxlength="70" />
                                </div>
                                @if ($errors->has('descriptions.'.$code.'.name'))
                                <span class="help-block">
                                    <i class="fa fa-info-circle"></i>
                                    {{ $errors->first('descriptions.'.$code.'.name') }}
                                </span>
                                @else
                                    <span class="help-block admin-pages">
                                        <i class="fa fa-info-circle"></i> {{ trans('admin.max_c',['max'=>70]) }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div
                            class="form-group   {{ $errors->has('descriptions.'.$code.'.keyword') ? ' has-error' : '' }}">
                            <label for="{{ $code }}__keyword"
                                class="col-sm-2  control-label">{{ trans('product.keyword') }} <span class="seo" title="SEO"><i class="fa fa-coffee" aria-hidden="true"></i></span></label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-pencil fa-fw"></i></span>
                                    <input type="text" id="{{ $code }}__keyword"
                                        name="descriptions[{{ $code }}][keyword]"
                                        value="{!! old('descriptions.'.$code.'.keyword',($descriptions[$code]['keyword']??'')) !!}"
                                        class="form-control {{ $code.'__keyword' }}" placeholder="" maxlength="100" />
                                </div>
                                @if ($errors->has('descriptions.'.$code.'.keyword'))
                                <span class="help-block">
                                    <i class="fa fa-info-circle"></i>
                                    {{ $errors->first('descriptions.'.$code.'.keyword') }}
                                </span>
                                @else
                                    <span class="help-block admin-pages">
                                        <i class="fa fa-info-circle"></i> {{ trans('admin.max_c',['max'=>100]) }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div
                            class="form-group   {{ $errors->has('descriptions.'.$code.'.description') ? ' has-error' : '' }}">
                            <label for="{{ $code }}__description"
                                class="col-sm-2  control-label">{{ trans('product.description') }} <span class="seo" title="SEO"><i class="fa fa-coffee" aria-hidden="true"></i></span></label>
                            <div class="col-sm-8">
                                    <textarea  id="{{ $code }}__description"
                                        name="descriptions[{{ $code }}][description]"
                                        class="form-control {{ $code.'__description' }}" placeholder="" maxlength="160" />{{ old('descriptions.'.$code.'.description',($descriptions[$code]['description']??'')) }}</textarea>
                                @if ($errors->has('descriptions.'.$code.'.description'))
                                <span class="help-block">
                                    <i class="fa fa-info-circle"></i>
                                    {{ $errors->first('descriptions.'.$code.'.description') }}
                                </span>
                                @else
                                    <span class="help-block admin-pages">
                                        <i class="fa fa-info-circle"></i> {{ trans('admin.max_c',['max'=>160]) }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        @if ($product->kind == SC_PRODUCT_SINGLE)
                        <div
                            class="form-group {{ $errors->has('descriptions.'.$code.'.content') ? ' has-error' : '' }}">
                            <label for="{{ $code }}__content"
                                class="col-sm-2 control-label">{{ trans('product.content') }}</label>
                            <div class="col-sm-8">
                                <textarea id="{{ $code }}__content" class="editor"
                                    name="descriptions[{{ $code }}][content]">
                                    {!! old('descriptions.'.$code.'.content',($descriptions[$code]['content']??'')) !!}</textarea>
                                @if ($errors->has('descriptions.'.$code.'.content'))
                                <span class="help-block">
                                    <i class="fa fa-info-circle"></i>
                                    {{ $errors->first('descriptions.'.$code.'.content') }}
                                </span>
                                @endif
                            </div>
                        </div>

                        <div
                            class="form-group {{ $errors->has('descriptions.'.$code.'.specification') ? ' has-error' : '' }}">
                            <label for="{{ $code }}__specification"
                                class="col-sm-2 control-label">{{ trans('product.specification') }}</label>
                            <div class="col-sm-8">
                                <textarea id="{{ $code }}__specification" class="editor"
                                    name="descriptions[{{ $code }}][specification]">
                                    {!! old('descriptions.'.$code.'.specification',($descriptions[$code]['specification']??'')) !!}</textarea>
                                @if ($errors->has('descriptions.'.$code.'.specification'))
                                <span class="help-block">
                                    <i class="fa fa-info-circle"></i>
                                    {{ $errors->first('descriptions.'.$code.'.specification') }}
                                </span>
                                @endif
                            </div>
                        </div>

                        <div
                            class="form-group {{ $errors->has('descriptions.'.$code.'.case_study') ? ' has-error' : '' }}">
                            <label for="{{ $code }}__case_study"
                                class="col-sm-2 control-label">{{ trans('product.case_study') }}</label>
                            <div class="col-sm-8">
                                <textarea id="{{ $code }}__case_study" class="editor"
                                    name="descriptions[{{ $code }}][case_study]">
                                    {!! old('descriptions.'.$code.'.case_study',($descriptions[$code]['case_study']??'')) !!}</textarea>
                                @if ($errors->has('descriptions.'.$code.'.case_study'))
                                <span class="help-block">
                                    <i class="fa fa-info-circle"></i>
                                    {{ $errors->first('descriptions.'.$code.'.case_study') }}
                                </span>
                                @endif
                            </div>
                        </div>

                        @endif

                        @endforeach
                        {{-- //Descriptions --}}


                        {{-- Category --}}
                        @if ($product->kind == SC_PRODUCT_SINGLE || $product->kind == SC_PRODUCT_BUILD)
                        <hr>

                        @php
                        $listCate = [];
                        $category = old('category',$product->categories->pluck('id')->toArray());
                        if(is_array($category)){
                            foreach($category as $value){
                                $listCate[] = (int)$value;
                            }
                        }
                        @endphp

                        <div class="form-group {{ $errors->has('category') ? ' has-error' : '' }}">
                            <label for="category"
                                class="col-sm-2 control-label">{{ trans('product.admin.select_category') }}</label>
                            <div class="col-sm-8">
                                <select class="form-control input-sm category select2" multiple="multiple"
                                    data-placeholder="{{ trans('product.admin.select_category') }}" style="width: 100%;"
                                    name="category[]">
                                    <option value=""></option>
                                    @foreach ($categories as $k => $v)
                                    <option value="{{ $k }}"
                                        {{ (count($listCate) && in_array($k, $listCate))?'selected':'' }}>{{ $v }}
                                    </option>
                                    @endforeach
                                </select>
                                @if ($errors->has('category'))
                                <span class="help-block">
                                    <i class="fa fa-info-circle"></i> {{ $errors->first('category') }}
                                </span>
                                @endif
                            </div>
                        </div>
                        @endif
                        {{-- //Category --}}

                        {{-- Images --}}
                        <div class="form-group   {{ $errors->has('image') ? ' has-error' : '' }}">
                            <label for="image" class="col-sm-2  control-label">{{ trans('product.image') }}</label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <input type="text" id="image" name="image"
                                        value="{!! old('image',$product->image) !!}" class="form-control input-sm image"
                                        placeholder="" />
                                    <span class="input-group-btn">
                                        <a data-input="image" data-preview="preview_image" data-type="product"
                                            class="btn btn-sm btn-primary lfm">
                                            <i class="fa fa-picture-o"></i> {{trans('product.admin.choose_image')}}
                                        </a>
                                    </span>
                                </div>
                                @if ($errors->has('image'))
                                <span class="help-block">
                                    <i class="fa fa-info-circle"></i> {{ $errors->first('image') }}
                                </span>
                                @endif
                                <div id="preview_image" class="img_holder">
                                    @if (old('image',$product->image))
                                        <img src="{{ asset(old('image',$product->image)) }}">
                                    @endif
                                </div>
                                @php
                                $listsubImages = old('sub_image',$product->images->pluck('image')->all());
                                @endphp
                                @if (!empty($listsubImages))
                                @foreach ($listsubImages as $key => $sub_image)
                                @if ($sub_image)
                                <div class="group-image">
                                    <div class="input-group"><input type="text" id="sub_image_{{ $key }}"
                                            name="sub_image[]" value="{!! $sub_image !!}"
                                            class="form-control input-sm sub_image" placeholder="" /><span
                                            class="input-group-btn"><span><a data-input="sub_image_{{ $key }}"
                                                    data-preview="preview_sub_image_{{ $key }}" data-type="product"
                                                    class="btn btn-sm btn-flat btn-primary lfm"><i
                                                        class="fa fa-picture-o"></i>
                                                    {{trans('product.admin.choose_image')}}</a></span><span
                                                title="Remove" class="btn btn-flat btn-sm btn-danger removeImage"><i
                                                    class="fa fa-times"></i></span></span></div>
                                    <div id="preview_sub_image_{{ $key }}" class="img_holder"><img
                                            src="{{ asset($sub_image) }}"></div>
                                </div>

                                @endif
                                @endforeach
                                @endif
                                <button type="button" id="add_sub_image" class="btn btn-flat btn-success">
                                    <i class="fa fa-plus" aria-hidden="true"></i>
                                    {{ trans('product.admin.add_sub_image') }}
                                </button>

                            </div>
                        </div>
                        {{-- //Images --}}


                        {{-- Sku --}}
                        <div class="form-group {{ $errors->has('sku') ? ' has-error' : '' }}">
                            <label for="sku" class="col-sm-2 control-label">{{ trans('product.sku') }}</label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-pencil fa-fw"></i></span>
                                    <input type="text" style="width: 100px;" id="sku" name="sku"
                                        value="{!! old('sku',$product->sku) !!}" class="form-control input-sm sku"
                                        placeholder="" />
                                </div>
                                @if ($errors->has('sku'))
                                <span class="help-block">
                                    <i class="fa fa-info-circle"></i> {{ $errors->first('sku') }}
                                </span>
                                @else
                                <span class="help-block">
                                    <i class="fa fa-info-circle"></i> {{ trans('product.sku_validate') }}
                                </span>
                                @endif
                            </div>
                        </div>
                        {{-- //Sku --}}


                        {{-- Alias --}}
                        <div class="form-group {{ $errors->has('alias') ? ' has-error' : '' }}">
                            <label for="alias" class="col-sm-2 control-label">{!! trans('product.alias') !!}</label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-pencil fa-fw"></i></span>
                                    <input type="text" id="alias" name="alias"
                                        value="{!! old('alias', $product->alias) !!}" class="form-control input-sm alias"
                                        placeholder="" />
                                </div>
                                @if ($errors->has('alias'))
                                <span class="help-block">
                                    <i class="fa fa-info-circle"></i> {{ $errors->first('alias') }}
                                </span>
                                @else
                                <span class="help-block admin-pages">
                                    <i class="fa fa-info-circle"></i> {{ trans('product.alias_validate') }}<br />
									<i class="fa fa-info-circle"></i> avoid numbers (in most cases) and underscores all the time<br />
									<i class="fa fa-info-circle"></i> almost NEVER start a page name with a number<br />
									<i class="fa fa-info-circle"></i> use lowercase letters with dashes separating words<br />
									<i class="fa fa-info-circle"></i> avoid uncommon acronyms (e.g.IVT = In-Vitro), but something like 3d-cell-printer is ok<br />
									<i class="fa fa-info-circle"></i> avoid website addresses as part of file name
                                </span>
                                @endif
                            </div>
                        </div>
                        {{-- //Alias --}}

@if (sc_config('product_brand'))
                        {{-- Brand --}}
                        <div class="form-group  {{ $errors->has('brand_id') ? ' has-error' : '' }}">
                            <label for="brand_id" class="col-sm-2 control-label">{{ trans('product.brand') }}</label>
                            <div class="col-sm-8">
                                <select class="form-control input-sm brand_id select2" style="width: 100%;"
                                    name="brand_id">
                                    <option value=""></option>
                                    @foreach ($brands as $k => $v)
                                    <option value="{{ $k }}"
                                        {{ (old('brand_id') ==$k || (!old() && $product->brand_id ==$k) ) ? 'selected':'' }}>
                                        {{ $v->name }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('brand_id'))
                                <span class="help-block">
                                    <i class="fa fa-info-circle"></i> {{ $errors->first('brand_id') }}
                                </span>
                                @endif
                            </div>
                        </div>
                        {{-- //Brand --}}
@endif

@if (sc_config('product_vendor'))
                        {{-- Vendor --}}
                        <div class="form-group  {{ $errors->has('vendor_id') ? ' has-error' : '' }}">
                            <label for="vendor_id" class="col-sm-2 control-label">{{ trans('product.vendor') }}</label>
                            <div class="col-sm-8">
                                <select class="form-control input-sm vendor_id select2" style="width: 100%;"
                                    name="vendor_id">
                                    <option value=""></option>
                                    @foreach ($vendors as $k => $v)
                                    <option value="{{ $k }}"
                                        {{ (old('vendor_id') ==$k || (!old() && $product->vendor_id ==$k) ) ? 'selected':'' }}>
                                        {{ $v->name }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('vendor_id'))
                                <span class="help-block">
                                    <i class="fa fa-info-circle"></i> {{ $errors->first('vendor_id') }}
                                </span>
                                @endif
                            </div>
                        </div>
                        {{-- //Vendor --}}
@endif

@if (sc_config('product_cost'))
                        {{-- Cost --}}
                        @if ($product->kind == SC_PRODUCT_SINGLE)
                        <div class="form-group  kind kind0 kind1  {{ $errors->has('cost') ? ' has-error' : '' }}">
                            <label for="cost" class="col-sm-2  control-label">{{ trans('product.cost') }}</label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-pencil fa-fw"></i></span>
                                    <input type="number" style="width: 100px;" id="cost" name="cost"
                                        value="{!! old('cost',$product->cost) !!}" class="form-control input-sm cost"
                                        placeholder="" />
                                </div>
                                @if ($errors->has('cost'))
                                <span class="help-block">
                                    <i class="fa fa-info-circle"></i> {{ $errors->first('cost') }}
                                </span>
                                @endif
                            </div>
                        </div>
                        @endif
                        {{-- //Cost --}}
@endif

@if (sc_config('product_price'))
                        @if ($product->kind == SC_PRODUCT_SINGLE || $product->kind == SC_PRODUCT_BUILD)
                        {{-- Price --}}
                        <div class="form-group   {{ $errors->has('price') ? ' has-error' : '' }}">
                            <label for="price" class="col-sm-2  control-label">{{ trans('product.price') }}</label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-pencil fa-fw"></i></span>
                                    <input type="number" style="width: 100px;" id="price" name="price"
                                        value="{!! old('price',$product->price) !!}" class="form-control input-sm price"
                                        placeholder="" />
                                </div>
                                @if ($errors->has('price'))
                                <span class="help-block">
                                    <i class="fa fa-info-circle"></i> {{ $errors->first('price') }}
                                </span>
                                @endif
                            </div>
                        </div>
                        {{-- //Price --}}
@endif

@if (sc_config('product_promotion'))
                        {{-- price promotion --}}
                        <div class="form-group  kind kind0 kind1">
                            <label for="price"
                                class="col-sm-2  control-label">{{ trans('product.price_promotion') }}</label>
                            <div class="col-sm-8">
                                @if (old('price_promotion') || $product->promotionPrice)
                                <div class="price_promotion">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-pencil fa-fw"></i></span>
                                        <input type="number" style="width: 100px;" id="price_promotion"
                                            name="price_promotion"
                                            value="{!! old('price_promotion',$product->promotionPrice->price_promotion) !!}"
                                            class="form-control input-sm price_promotion" placeholder="" />
                                        <span title="Remove" class="btn btn-flat btn-sm btn-danger removePromotion"><i
                                                class="fa fa-times"></i></span>
                                    </div>

                                    <div class="form-inline">
                                        <div class="input-group">
                                            {{ trans('product.price_promotion_start') }}<br>
                                            <div class="input-group">
                                                <span class="input-group-addon"><i
                                                        class="fa fa-calendar fa-fw"></i></span>
                                                <input type="text" style="width: 100px;" id="price_promotion_start"
                                                    name="price_promotion_start"
                                                    value="{!!old('price_promotion_start',$product->promotionPrice->date_start)!!}"
                                                    class="form-control input-sm price_promotion_start date_time"
                                                    placeholder="" />
                                            </div>
                                        </div>

                                        <div class="input-group">
                                            {{ trans('product.price_promotion_end') }}<br>
                                            <div class="input-group">
                                                <span class="input-group-addon"><i
                                                        class="fa fa-calendar fa-fw"></i></span>
                                                <input type="text" style="width: 100px;" id="price_promotion_end"
                                                    name="price_promotion_end"
                                                    value="{!!old('price_promotion_end',$product->promotionPrice->date_end)!!}"
                                                    class="form-control input-sm price_promotion_end date_time"
                                                    placeholder="" />
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <button type="button" style="display: none;" id="add_product_promotion"
                                    class="btn btn-flat btn-success">
                                    <i class="fa fa-plus" aria-hidden="true"></i>
                                    {{ trans('product.admin.add_product_promotion') }}
                                </button>
                                @else
                                <button type="button" id="add_product_promotion" class="btn btn-flat btn-success">
                                    <i class="fa fa-plus" aria-hidden="true"></i>
                                    {{ trans('product.admin.add_product_promotion') }}
                                </button>
                                @endif

                            </div>
                        </div>
                        {{-- //price promotion --}}
                        @endif
@endif

@if (sc_config('product_stock'))
                        {{-- Stock --}}
                        @if ($product->kind == SC_PRODUCT_SINGLE || $product->kind == SC_PRODUCT_BUILD)
                        <div class="form-group  {{ $errors->has('stock') ? ' has-error' : '' }}">
                            <label for="stock" class="col-sm-2  control-label">{{ trans('product.stock') }}</label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-pencil fa-fw"></i></span>
                                    <input type="number" style="width: 100px;" id="stock" name="stock"
                                        value="{!! old('stock',$product->stock) !!}" class="form-control input-sm stock"
                                        placeholder="" />
                                </div>
                                @if ($errors->has('stock'))
                                <span class="help-block">
                                    <i class="fa fa-info-circle"></i> {{ $errors->first('stock') }}
                                </span>
                                @endif
                            </div>
                        </div>
                        @endif
                        {{-- //Stock --}}
@endif

@if (sc_config('product_type'))
                        {{-- Type --}}
                        @if ($product->kind == SC_PRODUCT_SINGLE || $product->kind == SC_PRODUCT_BUILD)
                        <hr>
                        <div class="form-group  kind kind0 kind1  {{ $errors->has('type') ? ' has-error' : '' }}">
                            <label for="type" class="col-sm-2  control-label">{{ trans('product.type') }}</label>
                            <div class="col-sm-8">
                                @foreach ( $types as $key => $type)
                                <label class="radio-inline"><input type="radio" name="type" value="{!! $key !!}"
                                        {{ (old('type',$product->type) == $key)?'checked':'' }}>{{ $type }}</label>
                                @endforeach
                                @if ($errors->has('type'))
                                <span class="help-block">
                                    <i class="fa fa-info-circle"></i> {{ $errors->first('type') }}
                                </span>
                                @endif
                            </div>
                        </div>
                        
                        <div id="supplyName" class="form-group" @if($product->type != 3) style="display: none;" @endif>
                            <label for="supply_name" class="col-sm-2  control-label">{{ trans('product.supplyName') }} 
                                <span class="seo" title="SEO"></span></label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-pencil fa-fw"></i></span>
                                    <input type="text" id="supply_name" name="supply_name" value="{{$product->supplyName}}"
                                        class="form-control input-sm" placeholder="" />
                                </div>
                            </div>
                        </div>

                        <div id="supplyLink" class="form-group" @if($product->type != 3) style="display: none;" @endif>
                            <label for="supply_link" class="col-sm-2  control-label">{{ trans('product.supplyLink') }} 
                                <span class="seo" title="SEO"></span></label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-pencil fa-fw"></i></span>
                                    <input type="text" id="supply_link" name="supply_link" value="{{$product->supplyLink}}"
                                        class="form-control input-sm" placeholder="" />
                                </div>
                            </div>
                        </div>
                        @endif
                        {{-- //Type --}}
@endif

@if (sc_config('product_virtual'))
                        {{-- Virtual --}}
                        @if ($product->kind == SC_PRODUCT_SINGLE || $product->kind == SC_PRODUCT_BUILD)
                        <div class="form-group  kind kind0 kind1  {{ $errors->has('virtual') ? ' has-error' : '' }}">
                            <label for="virtual" class="col-sm-2  control-label">{{ trans('product.virtual') }}</label>
                            <div class="col-sm-8">
                                @foreach ( $virtuals as $key => $virtual)
                                <label class="radio-inline"><input type="radio" name="virtual" value="{{ $key }}"
                                        {{ (old('virtual',$product->virtual) == $key)?'checked':'' }}>{{ $virtual }}</label>
                                @endforeach
                                @if ($errors->has('virtual'))
                                <span class="help-block">
                                    <i class="fa fa-info-circle"></i> {{ $errors->first('virtual') }}
                                </span>
                                @endif
                            </div>
                        </div>
                        @endif
                        {{-- //Virtual --}}
@endif

@if (sc_config('product_available'))
                        {{-- Date vailalable --}}
                        @if ($product->kind == SC_PRODUCT_SINGLE || $product->kind == SC_PRODUCT_BUILD)
                        <div
                            class="form-group  kind kind0 kind1  {{ $errors->has('date_available') ? ' has-error' : '' }}">
                            <label for="date_available"
                                class="col-sm-2  control-label">{{ trans('product.date_available') }}</label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-calendar fa-fw"></i></span>
                                    <input type="text" style="width: 100px;" id="date_available" name="date_available"
                                        value="{!!old('date_available',$product->date_available)!!}"
                                        class="form-control input-sm date_available date_time" placeholder="" />
                                </div>
                                @if ($errors->has('date_available'))
                                <span class="help-block">
                                    <i class="fa fa-info-circle"></i> {{ $errors->first('date_available') }}
                                </span>
                                @endif
                            </div>
                        </div>
                        @endif
                        {{-- //Date vailalable --}}
@endif

                        {{-- Sort --}}
                        <div class="form-group   {{ $errors->has('sort') ? ' has-error' : '' }}">
                            <label for="sort" class="col-sm-2  control-label">{{ trans('product.sort') }}</label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-pencil fa-fw"></i></span>
                                    <input type="number" style="width: 100px;" id="sort" name="sort"
                                        value="{!! old('sort',$product['sort']) !!}" class="form-control sort"
                                        placeholder="" />
                                </div>
                                @if ($errors->has('sort'))
                                <span class="help-block">
                                    <i class="fa fa-info-circle"></i> {{ $errors->first('sort') }}
                                </span>
                                @endif
                            </div>
                        </div>
                        {{-- //Sort --}}

                        {{-- Status --}}
                        <div class="form-group  ">
                            <label for="status" class="col-sm-2  control-label">{{ trans('product.status') }}</label>
                            <div class="col-sm-8">
                                @if (old())
                                <input type="checkbox" name="status" {{ old('status',$product['status'])?'checked':''}}>
                                @else
                                <input type="checkbox" name="status" checked>
                                @endif

                            </div>
                        </div>
                        {{-- //Status --}}
                        
                        {{-- //benefit --}}
                        <div
                            class="form-group">
                            <label class="col-sm-2  control-label">{{ trans('benefit.title') }} </label>
                            <div class="col-sm-8">
                                @foreach($benefits as $key => $benefit)
                                <div style="margin: 5px 0">
                                    <span> {{ $benefit }} </span>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-pencil fa-fw"></i></span>
                                        <input type="text" name="benefits[{{ $key }}]"
                                            value="{!! old('benefits'.$key, ($productBenefits[$key]??'')) !!}"
                                            class="form-control input-sm"/>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        {{-- //benefit --}}

@if (sc_config('product_kind'))
                        @if ($product->kind == SC_PRODUCT_GROUP)
                        {{-- List product in groups --}}
                        <hr>
                        <div class="form-group {{ $errors->has('productInGroup') ? ' has-error' : '' }}">
                            <label class="col-sm-2 control-label"></label>
                            <div class="col-sm-8"><label>{{ trans('product.admin.select_product_in_group') }}</label>
                            </div>
                        </div>
                        <div class="form-group {{ $errors->has('productInGroup') ? ' has-error' : '' }}">
                            <div class="col-sm-2">
                            </div>
                            <div class="col-sm-8">
                                @php
                                $listgroups= [];
                                $groups = old('productInGroup',$product->groups->pluck('product_id')->toArray());
                                if(is_array($groups)){
                                foreach($groups as $value){
                                $listgroups[] = (int)$value;
                                }
                                }
                                @endphp
                                @if ($listgroups)
                                @foreach ($listgroups as $pID)
                                @if ((int)$pID)
                                @php
                                $newHtml = str_replace('value="'.(int)$pID.'"', 'value="'.(int)$pID.'" selected',
                                $htmlSelectGroup);
                                @endphp
                                {!! $newHtml !!}
                                @endif
                                @endforeach
                                @endif
                                <div id="position_group_flag"></div>
                                @if ($errors->has('productInGroup'))
                                <span class="help-block">
                                    <i class="fa fa-info-circle"></i> {{ $errors->first('productInGroup') }}
                                </span>
                                @endif
                                <button type="button" id="add_product_in_group" class="btn btn-flat btn-success">
                                    <i class="fa fa-plus" aria-hidden="true"></i>
                                    {{ trans('product.admin.add_product') }}
                                </button>
                                @if ($errors->has('productInGroup'))
                                <span class="help-block">
                                    <i class="fa fa-info-circle"></i> {{ $errors->first('productInGroup') }}
                                </span>
                                @endif
                            </div>
                        </div>
                        {{-- //end List product in groups --}}
                        @endif



                        @if ($product->kind == SC_PRODUCT_BUILD)
                        <hr>
                        {{-- List product build --}}
                        <div class="form-group {{ $errors->has('productBuild') ? ' has-error' : '' }}">
                            <label class="col-sm-2 control-label"></label>
                            <div class="col-sm-8">
                                <label>{{ trans('product.admin.select_product_in_build') }}</label>
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('productBuild') ? ' has-error' : '' }}">
                            <div class="col-sm-2">
                            </div>
                            <div class="col-sm-8">
                                <div class="row"></div>

                                @php
                                $listBuilds= [];
                                $groups = old('productBuild',$product->builds->pluck('product_id')->toArray());
                                $groupsQty = old('productBuildQty',$product->builds->pluck('quantity')->toArray());
                                if(is_array($groups)){
                                foreach($groups as $key => $value){
                                $listBuilds[] = (int)$value;
                                $listBuildsQty[] = (int)$groupsQty[$key];
                                }
                                }
                                @endphp

                                @if ($listBuilds)
                                @foreach ($listBuilds as $key => $pID)
                                @if ((int)$pID && $listBuildsQty[$key])
                                @php
                                $newHtml = str_replace('value="'.(int)$pID.'"', 'value="'.(int)$pID.'" selected',
                                $htmlSelectBuild);
                                $newHtml = str_replace('name="productBuildQty[]" value="1" min=1',
                                'name="productBuildQty[]" value="'.$listBuildsQty[$key].'"', $newHtml);
                                @endphp
                                {!! $newHtml !!}
                                @endif
                                @endforeach
                                @endif
                                <div id="position_build_flag"></div>
                                @if ($errors->has('productBuild'))
                                <span class="help-block">
                                    <i class="fa fa-info-circle"></i> {{ $errors->first('productBuild') }}
                                </span>
                                @endif
                                <button type="button" id="add_product_in_build" class="btn btn-flat btn-success">
                                    <i class="fa fa-plus" aria-hidden="true"></i>
                                    {{ trans('product.admin.add_product') }}
                                </button>
                                @if ($errors->has('productBuild') || $errors->has('productBuildQty'))
                                <span class="help-block">
                                    <i class="fa fa-info-circle"></i> {{ $errors->first('productBuild') }}
                                </span>
                                @endif
                            </div>
                        </div>
                        {{-- //end List product build --}}
                        @endif
@endif

@php
    $attributeID = 1;
@endphp

@if (sc_config('product_attribute'))
                    @if ($product->kind == SC_PRODUCT_SINGLE)
                        {{-- List product attributes --}}
                        <hr>
                        @if (!empty($attributeGroup))
                        <div class="form-group">
                            <label class="col-xs-2 control-label">{{ trans('product.attribute') }}</label>
                            <div class="col-sm-8" id="attribute-container">

                                @php
                                $dataAtt = [];
                                if(old('attribute')){
                                    $oldAttr = old('attribute');
                                    foreach ($oldAttr as $groupKey => $row) {
                                        $dataAtt[$groupKey]['name'] = $row;
                                    }
                                } else {
                                    $getDataAtt = $product->attributes->groupBy('attribute_group_id')->toArray();
                                    if(count($getDataAtt)) {
                                        foreach ($getDataAtt as $groupKey => $row) {
                                            $dataAtt[$groupKey]['name'] = array_column($row, 'name');
                                        }
                                    }
                                }
                                @endphp

                                @foreach ($attributeGroup as $attGroupId => $attName)
                                    <table style="width: 100%; margin-bottom: 10px" data-groupid="{{ $attGroupId }}" data-group="{{ $attName }}">
                                        <tr>
                                            <td colspan="2"><b>{{ $attName }}:</b><br></td>
                                        </tr>
                                    @if (!empty($dataAtt[$attGroupId]['name']))
                                        @foreach ($dataAtt[$attGroupId]['name'] as $idx => $attValue)
                                            @if ($attValue)
                                                @php
                                                $newHtml = str_replace('attribute_group', $attGroupId, $htmlProductAtrribute);
                                                $newHtml = str_replace('attribute_value', $attValue, $newHtml);
                                                $newHtml = str_replace('attribute_idx', $attributeID, $newHtml);
                                                $attributeID++;
                                                @endphp
                                                {!! $newHtml !!}
                                            @endif
                                        @endforeach
                                    @endif
                                        <tr>
                                            <td colspan="2"><br><button type="button"
                                                    class="btn btn-flat btn-success add-attribute"
                                                    data-id="{{ $attGroupId }}">
                                                    <i class="fa fa-plus" aria-hidden="true"></i>
                                                    {{ trans('product.admin.add_attribute') }}
                                                </button><br></td>
                                        </tr>
                                    </table>
                                @endforeach
                            </div>
                        </div>

                        <div class="form-group kind kind0">
                            <label class="col-xs-2 control-label">{{ trans('product.attribute_price') }}</label>
                            <div class="col-sm-8" id="attribute-price-container">
                                <div id="attribute-price-group-container">
                                </div>
                                <br>
                                <label id="attribute-price-table-label"></label>
                                <table class="table table-bordered table-hover" id="attribute-price-table">
                                    <tbody id="attribute-price-table-body">
                                    </tbody>
                                </table>
                                <input id="attribute_price" name="attribute_price" type="hidden" value="{!! old('attribute_price') !!}">
                            </div>
                        </div>
                        @endif
                        {{-- //end List product attributes --}}
                    @endif
@endif

                    </div>
                </div>



                <!-- /.box-body -->

                <div class="box-footer">
                    @csrf
                    <div class="col-md-2"></div>

                    <div class="col-md-8">
                        <div class="btn-group pull-right">
                            <button type="submit" class="btn btn-primary">{{ trans('admin.submit') }}</button>
                        </div>

                        <div class="btn-group pull-left">
                            <button type="reset" class="btn btn-warning">{{ trans('admin.reset') }}</button>
                        </div>
                    </div>
                </div>

                <!-- /.box-footer -->
            </form>
        </div>
    </div>
</div>



@endsection

@push('styles')
<!-- Select2 -->
<link rel="stylesheet" href="{{ asset('admin/AdminLTE/bower_components/select2/dist/css/select2.min.css')}}">

{{-- switch --}}
<link rel="stylesheet" href="{{ asset('admin/plugin/bootstrap-switch.min.css')}}">

{{-- input image --}}
{{-- <link rel="stylesheet" href="{{ asset('admin/plugin/fileinput.min.css')}}"> --}}

@endpush

@push('scripts')
<!--ckeditor-->
<script src="{{ asset('packages/ckeditor/ckeditor.js') }}"></script>
<script src="{{ asset('packages/ckeditor/adapters/jquery.js') }}"></script>

<!-- Select2 -->
<script src="{{ asset('admin/AdminLTE/bower_components/select2/dist/js/select2.full.min.js')}}"></script>

{{-- input image --}}
{{-- <script src="{{ asset('admin/plugin/fileinput.min.js')}}"></script> --}}

{{-- switch --}}
<script src="{{ asset('admin/plugin/bootstrap-switch.min.js')}}"></script>

{{-- Inline Edit --}}
<script src="{{ asset('SimpleTableCellEditor/SimpleTableCellEditor.es6.min.js')}}"></script>

<script type="text/javascript">
    $("[name='top'],[name='status']").bootstrapSwitch();
</script>

<script type="text/javascript">
let attributeID = {!! $attributeID !!};
    // Promotion
$('#add_product_promotion').click(function(event) {
    $(this).before('<div class="price_promotion"><div class="input-group"><span class="input-group-addon"><i class="fa fa-pencil fa-fw"></i></span><input type="number" style="width: 100px;"  id="price_promotion" name="price_promotion" value="0" class="form-control input-sm price" placeholder="" /><span title="Remove" class="btn btn-flat btn-sm btn-danger removePromotion"><i class="fa fa-times"></i></span></div><div class="form-inline"><div class="input-group">{{ trans('product.price_promotion_start') }}<br><div class="input-group"><span class="input-group-addon"><i class="fa fa-calendar fa-fw"></i></span><input type="text" style="width: 100px;"  id="price_promotion_start" name="price_promotion_start" value="" class="form-control input-sm price_promotion_start date_time" placeholder="" /></div></div><div class="input-group">{{ trans('product.price_promotion_end') }}<br><div class="input-group"><span class="input-group-addon"><i class="fa fa-calendar fa-fw"></i></span><input type="text" style="width: 100px;"  id="price_promotion_end" name="price_promotion_end" value="" class="form-control input-sm price_promotion_end date_time" placeholder="" /></div></div></div></div>');
    $(this).hide();
    $('.removePromotion').click(function(event) {
        $(this).closest('.price_promotion').remove();
        $('#add_product_promotion').show();
    });
    $('.date_time').datepicker({
      autoclose: true,
      format: 'yyyy-mm-dd'
    })
});
$('.removePromotion').click(function(event) {
    $('#add_product_promotion').show();
    $(this).closest('.price_promotion').remove();
});
//End promotion

// Add sub images
var id_sub_image = {{ old('sub_image')?count(old('sub_image')):0 }};
$('#add_sub_image').click(function(event) {
    id_sub_image +=1;
    $(this).before('<div class="group-image"><div class="input-group"><input type="text" id="sub_image_'+id_sub_image+'" name="sub_image[]" value="" class="form-control input-sm sub_image" placeholder=""  /><span class="input-group-btn"><span><a data-input="sub_image_'+id_sub_image+'" data-preview="preview_sub_image_'+id_sub_image+'" data-type="product" class="btn btn-sm btn-flat btn-primary lfm"><i class="fa fa-picture-o"></i> {{trans('product.admin.choose_image')}}</a></span><span title="Remove" class="btn btn-flat btn-sm btn-danger removeImage"><i class="fa fa-times"></i></span></span></div><div id="preview_sub_image_'+id_sub_image+'" class="img_holder"></div></div>');
    $('.removeImage').click(function(event) {
        $(this).closest('div').remove();
    });
    $('.lfm').filemanager();
});
    $('.removeImage').click(function(event) {
        $(this).closest('.group-image').remove();
    });
//end sub images

// Select product in group
$('#add_product_in_group').click(function(event) {
    var htmlSelectGroup = '{!! $htmlSelectGroup !!}';
    $(this).before(htmlSelectGroup);
    $('.select2').select2();
    $('.removeproductInGroup').click(function(event) {
        $(this).closest('table').remove();
    });
});
$('.removeproductInGroup').click(function(event) {
    $(this).closest('table').remove();
});
//end select in group

// Select product in build
$('#add_product_in_build').click(function(event) {
    var htmlSelectBuild = '{!! $htmlSelectBuild !!}';
    $(this).before(htmlSelectBuild);
    $('.select2').select2();
    $('.removeproductBuild').click(function(event) {
        $(this).closest('table').remove();
    });
});
$('.removeproductBuild').click(function(event) {
    $(this).closest('table').remove();
});
//end select in build

$('input[type=radio][name=type]').change(function() {
    if (this.value == 3) {
        $("#supplyName").attr('style','display: block;');
        $("#supplyLink").attr('style','display: block;');
    }
    else {
        $("#supplyName").attr('style','display: none;');
        $("#supplyLink").attr('style','display: none;');
    }
});

// Select product attributes
$('.add-attribute').click(function(event) {
    var htmlProductAtrribute = '{!! $htmlProductAtrribute??'' !!}';
    var attGroup = $(this).attr("data-id");
    htmlProductAtrribute = htmlProductAtrribute.replace(/attribute_group/g, attGroup);
    htmlProductAtrribute = htmlProductAtrribute.replace("attribute_value", "");
    htmlProductAtrribute = htmlProductAtrribute.replace("attribute_idx", attributeID);
    attributeID++;
    $(this).closest('tr').before(htmlProductAtrribute);
    readAttributes();
    $('.removeAttribute').click(function(event) {
        $(this).closest('tr').remove();
        readAttributes();
    });
});
$('.removeAttribute').click(function(event) {
    $(this).closest('tr').remove();
    readAttributes();
});
//end select attributes

$(document).ready(function() {
    $('.select2').select2()
    readAttributeGroup();
    readAttributes(true);
});

//Date picker
$('.date_time').datepicker({
  autoclose: true,
  format: 'yyyy-mm-dd'
})

var currTextarea = $('textarea.editor').first().prop("id");

let detailEditor = $('textarea.editor').ckeditor(
    {
        filebrowserImageBrowseUrl: '{{ route('admin.home').'/'.config('lfm.url_prefix') }}?type=product',
        filebrowserImageUploadUrl: '{{ route('admin.home').'/'.config('lfm.url_prefix') }}/upload?type=product&_token={{csrf_token()}}',
        filebrowserBrowseUrl: '{{ route('admin.home').'/'.config('lfm.url_prefix') }}?type=Files',
        filebrowserUploadUrl: '{{ route('admin.home').'/'.config('lfm.url_prefix') }}/upload?type=file&_token={{csrf_token()}}',
        filebrowserWindowWidth: '900',
        filebrowserWindowHeight: '500',
        validateSize: 10,
        autoClose: true,
        onAttachmentUpload: function(response) {
            let tmpHtml = "<div style='width: 100%; margin: 10px 0; text-align: center'> <a href='/data/file/" + response + "'>";
            tmpHtml += "<img src='/images/attachment.png' style='width: 100px; height: auto' /> <br>";
            tmpHtml += response + "</a> </div>";
            CKEDITOR.instances[currTextarea].insertHtml(tmpHtml);
        }
    }
);

CKEDITOR.on("instanceReady", function(event)
{
    $('div.cke').on("click", function() {
        currTextarea = $(this).prop("id");
        currTextarea = currTextarea.substr(4);
    });
});


    //----------------------------- Attribute Price ---------------//
    let attributes = [];
    let attributeGroup = {};
    let attributePrice = {}; // [{groupdID___valueID---groupID___valueID : Price}]
    let orgAttributePrice = {};

    @if(old('attribute_price'))
        orgAttributePrice = JSON.parse('{!! old('attribute_price') !!}');
    @elseif($product->attribute_price)
        orgAttributePrice = JSON.parse('{!! $product->attribute_price !!}');
    @endif

    function readAttributeGroup() {
        attributeGroup = {};
        $("#attribute-container table").each(function(idx, table) {
            attributeGroup[$(table).data("groupid")] = $(table).data("group");
        });
    }

    // read product attribute values
    function readAttributes(isConvert = false) {
        attributes = [];
        $("#attribute-container table").each(function(idx, table) {
            let groupId = $(table).data("groupid");
            if ($(table).find("input").length > 0) {
                let attributeVals = [];
                $(table).find("input").each(function(id, item) {
                    attributeVals.push({id: $(item).closest('tr').prop('id'), val: $(item).val()});
                });
                attributes.push({groupId, attributeVals});
            }
        });
        if (isConvert) {
            convertPriceStyle();
        }
        loadPriceItems();
    }

    // remove attribute prices, length of whom is not valid attribute group count.
    function filterAttributePrice() {
        for (const [key, value] of Object.entries(attributePrice)) {
            if (key.split("---").length != attributes.length) {
                delete attributePrice[key];
            }
        }
    }

    // load price Items
    function loadPriceItems() {
        let groupContainer = "";
        if (attributes.length > 2)  {
            for (let i = 2; i < attributes.length; i++) {
                groupContainer += "<label>" + attributeGroup[attributes[i]["groupId"]] + " :</label>";
                groupContainer += '<select class="form-control" onchange="updatePriceTable()">';
                attributes[i]["attributeVals"].forEach(function(attribute) {
                    groupContainer += '<option value="' + attribute.id + '">' + attribute.val + '</option>';
                });
                groupContainer += '</select>';
            }
        }
        
        $("#attribute-price-group-container").html(groupContainer);

        updatePriceTable();
        filterAttributePrice();
        updateFormAttributePrice();
    }

    // load price table from prices
    function updatePriceTable() {
        let tableHtml = "";
        let tableLabel = "";
        let price = 0;

        if (attributes.length == 0) {
            attributePrice = {};
        } else if (attributes.length == 1) {
            for (let i = 0 ; i < 2; i ++) {
                tableHtml += "<tr>";
                attributes[0]["attributeVals"].forEach(function(attribute) {
                    if (i == 0) {
                        tableHtml += '<td class="attribute-cell">' + attribute.val + '</td>';
                    } else {
                        price = attributePrice[attributes[0].groupId + "___" + attribute.id];
                        price = price ? price : "";
                        tableHtml += '<td class="editable" data-ids="' + attribute.id + '">' + price + "</td>";
                    }
                });
                tableHtml += "</tr>";
            }
            tableLabel = attributeGroup[attributes[0]["groupId"]];
        } else {
            for (let i = -1 ; i < attributes[1]["attributeVals"].length; i++) {
                tableHtml += "<tr>";
                for (let k = -1 ; k < attributes[0]["attributeVals"].length; k++) {
                    // first cell : (0,0)
                    if (i == -1 && k == -1) {
                        tableHtml += "<td>#</td>";
                        continue;
                    }

                    // first row : (0, *)
                    if (i == -1) {
                        tableHtml += '<td class="attribute-cell">' + attributes[0]["attributeVals"][k].val + "</td>";
                        continue;
                    }

                    // first column : (*, 0)
                    if (k == -1) {
                        tableHtml += '<td class="attribute-cell small-cell">' + attributes[1]["attributeVals"][i].val + "</td>";
                        continue;
                    }
                    let dataID = attributes[0]["attributeVals"][k].id + "_" + attributes[1]["attributeVals"][i].id;
                    let priceKey = attributes[0].groupId + "___" + attributes[0]["attributeVals"][k].id + "---" + attributes[1].groupId + "___" + attributes[1]["attributeVals"][i].id;
                    if (attributes.length > 2) {
                        $("#attribute-price-group-container select").each(function(idx, select) {
                            priceKey += "---" + attributes[2 + idx].groupId + "___" + $(select).children("option:selected").val();
                        });
                    }
                    price = attributePrice[priceKey];
                    price = price ? price : "";
                    tableHtml += '<td class="editable" data-ids="' + dataID + '">' + price + "</td>";
                }
                tableHtml += "</tr>";
            }
            
            tableLabel = attributeGroup[attributes[0]["groupId"]] + "<strong> : </strong>" + attributeGroup[attributes[1]["groupId"]];
            
        }
        $("#attribute-price-table-label").html(tableLabel);
        $("#attribute-price-table-body").html(tableHtml);
    }


    // Inline Edit for table
    let simpleEditor = new SimpleTableCellEditor("attribute-price-table");
    simpleEditor.SetEditableClass("editable");

    $('#attribute-price-table').on("cell:edited", function (event) {
        let dataId = $(event.element).data("ids");
        console.log(dataId);
        let key = "";
        let newVal = Number.parseInt(event.newValue);
        if (attributes.length < 1) {
            return;
        }

        if (attributes.length == 1) {
            key = attributes[0].groupId + "___" + dataId;
            attributePrice[key] = newVal;
        } else {
            let dataIds = dataId.split("_");
            key = attributes[0].groupId + "___" + dataIds[0] + "---" + attributes[1].groupId + "___" + dataIds[1];
            if (attributes.length > 2) {
                $("#attribute-price-group-container select").each(function(idx, select) {
                    key += "---" + attributes[2 + idx].groupId + "___" + $(select).children("option:selected").val();
                });
            }
            attributePrice[key] = newVal;
        }
        console.log(key);
        console.log(attributePrice);
        updateFormAttributePrice();
    });

    function updateFormAttributePrice() {
        let arrPrices = {};
        for (const [key, price] of Object.entries(attributePrice)) {
            let newKey = "";
            let arrIDs = key.split("---");
            arrIDs.forEach(function(ids) {
                if (newKey) {
                    newKey += "---";
                }

                let arrId = ids.split("___");
                let attributeVal = getAttributeValue(arrId[0], arrId[1]);
                if (!attributeVal) {
                    delete attributePrice[key];
                }
                newKey += arrId[0] + "___" + attributeVal;
            });
            arrPrices[newKey] = price;
        }
        console.log(arrPrices);
        $("#attribute_price").val(JSON.stringify(arrPrices));
    }

    function convertPriceStyle() {
        
        for (const [key, price] of Object.entries(orgAttributePrice)) {
            let newKey = "";
            let arrIDs = key.split("---");
            arrIDs.forEach(function(ids) {
                if (newKey) {
                    newKey += "---";
                }

                let arrId = ids.split("___");
                
                let attributeId = getAttributeId(arrId[0], arrId[1]);
                if (attributeId == 0) {
                    return;
                }
                newKey += arrId[0] + "___" + attributeId;
            });
            attributePrice[newKey] = price;
        }
    }

    // function getGroupId(group) {
    //     for (const [id, name] of Object.entries(attributeGroup)) {
    //         if (name == group) {
    //             return id;
    //         }
    //     }
    //     return 0;
    // }
    
    function getAttributeId(groupId, val) {
        for (let i = 0 ; i < attributes.length; i ++) {
            if (attributes[i].groupId != groupId) {
                continue;
            }

            for (let k = 0 ; k < attributes[i]["attributeVals"].length; k++) {
                if (attributes[i]["attributeVals"][k].val == val) {
                    return attributes[i]["attributeVals"][k].id;
                }
            }
        }
        return 0;
    }

    function getAttributeValue(groupId, id) {
        for (let i = 0 ; i < attributes.length; i ++) {
            if (attributes[i].groupId != groupId) {
                continue;
            }

            for (let k = 0 ; k < attributes[i]["attributeVals"].length; k++) {
                if (attributes[i]["attributeVals"][k].id == id) {
                    return attributes[i]["attributeVals"][k].val;
                }
            }
        }
        return "";
    }

    //----------------------------- Attribute Price ---------------//
</script>

@endpush