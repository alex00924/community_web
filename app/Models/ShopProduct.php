<?php
#app/Models/ShopProduct.php
namespace App\Models;

use App\Models\ShopAttributeGroup;
use App\Models\ShopCategory;
use App\Models\ShopProductCategory;
use App\Models\ShopProductDescription;
use App\Models\ShopProductGroup;
use App\Models\ShopProductPromotion;
use App\Models\ShopBenefit;
use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ShopProduct extends Model
{
    public $table = 'shop_product';
    protected $guarded = [];
    protected $appends = [
        'name',
        'keyword',
        'description',
        'content',
        'specification',
        'case_study'
    ];

    protected static $listSingle = null;


/*
List product single
 */
    public static function getListSigle()
    {
        if (self::$listSingle == null) {
            self::$listSingle = self::where('kind', SC_PRODUCT_SINGLE)->get()->keyBy('id')->toArray();
        }
        return self::$listSingle;
    }
/**
 * Get top product single
 * @param  integer $limit
 * @param  string  $orderBy field
 * @param  string  $sort    asc|desc
 */
    public static function getTopSingle($limit = 8, $orderBy = 'id', $sort = 'desc')
    {
        return self::where('kind', SC_PRODUCT_SINGLE)->orderBy($orderBy, $sort)
            ->limit($limit)->get()->keyBy('id')->toArray();
    }

/**
 * Get top product build
 * @param  integer $limit
 * @param  string  $orderBy field
 * @param  string  $sort    asc|desc
 */
    public static function getTopBuild($limit = 8, $orderBy = 'id', $sort = 'desc')
    {
        return self::where('kind', SC_PRODUCT_BUILD)->orderBy($orderBy, $sort)
            ->limit($limit)->get()->keyBy('id');
    }

/**
 * Get top product group
 * @param  integer $limit
 * @param  string  $orderBy field
 * @param  string  $sort    asc|desc
 */
    public static function getTopGroup($limit = 8, $orderBy = 'id', $sort = 'desc')
    {
        return self::where('kind', SC_PRODUCT_GROUP)->orderBy($orderBy, $sort)
            ->limit($limit)->get()->keyBy('id');
    }

    public function brand()
    {
        return $this->belongsTo(ShopBrand::class, 'brand_id', 'id');
    }
    public function vendor()
    {
        return $this->belongsTo(ShopVendor::class, 'vendor_id', 'id');
    }
    public function categories()
    {
        return $this->belongsToMany(ShopCategory::class, ShopProductCategory::class, 'product_id', 'category_id');
    }
    public function relatedProducts()
    {
        return $this->hasMany(ShopRelatedProduct::class,  'product_id', 'id');
    }
    public function inverseRelatedProducts()
    {
        return $this->hasMany(ShopRelatedProduct::class,  'related_product_id', 'id');
    }
    // get all related product lists
    public function getRelatedProducts()
    {
        $relatedIds = $this->getRelatedProductIds();
        if (count($relatedIds) < 1) {
            return [];
        }
        $totalRes = ShopProduct::whereIn('id', $relatedIds)->get();
        return $totalRes;
    }
    public function getRelatedProductIds()
    {
        $relatedProducts = $this->relatedProducts()->get();
        $inverseRelatedProducts = $this->inverseRelatedProducts()->get();

        $totalRes = [];
        foreach($relatedProducts as $relation)
        {
            $totalRes[] = $relation->related_product_id;
        }
        foreach($inverseRelatedProducts as $relation)
        {
            $totalRes[] = $relation->product_id;
        }
        return $totalRes;
    }
    public function groups()
    {
        return $this->hasMany(ShopProductGroup::class, 'group_id', 'id');
    }
    public function builds()
    {
        return $this->hasMany(ShopProductBuild::class, 'build_id', 'id');
    }
    public function images()
    {
        return $this->hasMany(ShopProductImage::class, 'product_id', 'id');
    }

    public function descriptions()
    {
        return $this->hasMany(ShopProductDescription::class, 'product_id', 'id');
    }

    public function promotionPrice()
    {
        return $this->hasOne(ShopProductPromotion::class, 'product_id', 'id');
    }
    public function attributes()
    {
        return $this->hasMany(ShopProductAttribute::class, 'product_id', 'id');
    }
    public function benefits()
    {
        return $this->hasMany(ShopProductBenefit::class, 'product_id', 'id');
    }
    public function reviews()
    {
        return $this->hasMany(ShopProductReview::class, 'product_id', 'id');
    }
/*
Get final price
 */
    public function getFinalPrice($options = null)
    {
        if (!empty($options)) {
            $keyString = "";
            foreach($options as $groupId => $attribute) {
                if (!empty($keyString)) {
                    $keyString .= "---";
                }
                $keyString .= $groupId . "___" . $attribute;
            }
            $attributePrices = json_decode($this->attribute_price, true);
            if(isset($attributePrices[$keyString])) {
                return $attributePrices[$keyString];
            }
            
        }
        $promotion = $this->processPromotionPrice();
        if ($promotion != -1) {
            return $promotion;
        } else {
            return $this->price;
        }
    }

/**
 * [showPrice description]
 * @param  [type] $classNew [description]
 * @param  [type] $classOld [description]
 * @param  [type] $divWrap  [description]
 * @return [type]           [description]
 */
    public function showPrice($classNew = null, $classOld = null, $divWrap = null)
    {
        if (!sc_config('product_price')) {
            return false;
        }
        $priceFinal = $this->getFinalPrice();
        switch ($this->kind) {
            case SC_PRODUCT_GROUP:
                $str = '<span class="' . (($classNew) ? $classNew : 'sc-new-price') . '">' . trans('product.price_group') . '</span>';
                if ($divWrap != null) {
                    $str = '<div class="' . $divWrap . '">' . $str . '</div>';
                }
                return $str;
                break;

            default:
                if ($this->price == $priceFinal) {
                    $str = '<span class="' . (($classNew) ? $classNew : 'sc-new-price') . '">' . sc_currency_render($this->price) . '</span>';
                    if ($divWrap != null) {
                        $str = '<div class="' . $divWrap . '">' . $str . '</div>';
                    }
                    return $str;
                } else {
                    $str = '<span class="' . (($classNew) ? $classNew : 'sc-new-price') . '">' . sc_currency_render($priceFinal) . '</span><span class="' . (($classNew) ? $classOld : 'sc-old-price') . '">' . sc_currency_render($this->price) . '</span>';
                    if ($divWrap != null) {
                        $str = '<div class="' . $divWrap . '">' . $str . '</div>';
                    }
                    return $str;
                }
                break;
        }

    }

    /**
     * [showPriceDetail description]
     *
     * @param   [type]  $classNew  [$classNew description]
     * @param   [type]  $classOld  [$classOld description]
     * @param   [type]  $divWrap   [$divWrap description]
     *
     * @return  [type]             [return description]
     */
    public function showPriceDetail($classNew = null, $classOld = null, $divWrap = null)
    {
        if (!sc_config('product_price')) {
            return false;
        }
        $priceFinal = $this->getFinalPrice();
        switch ($this->kind) {
            case SC_PRODUCT_GROUP:
                $str = '<span class="' . (($classNew) ? $classNew : 'sc-new-price') . '">' . trans('product.price_group_chose') . '</span>';
                if ($divWrap != null) {
                    $str = '<div class="' . $divWrap . '">' . $str . '</div>';
                }
                return $str;
                break;

            default:
                if ($this->price == $priceFinal) {
                    $str = '<span class="' . (($classNew) ? $classNew : 'sc-new-price') . '">' . sc_currency_render($this->price) . '</span>';
                    if ($divWrap != null) {
                        $str = '<div class="' . $divWrap . '">' . $str . '</div>';
                    }
                    return $str;
                } else {
                    $str = '<span class="' . (($classNew) ? $classNew : 'sc-new-price') . '">' . sc_currency_render($priceFinal) . '</span><span class="' . (($classNew) ? $classOld : 'sc-old-price') . '">' . sc_currency_render($this->price) . '</span>';
                    if ($divWrap != null) {
                        $str = '<div class="' . $divWrap . '">' . $str . '</div>';
                    }
                    return $str;
                }
                break;
        }

    }

/**
 * Get product detail
 * @param  [int] $id [description]
 * @param  [string] $alias [description]
 * @return [type]     [description]
 */
    public function getProduct($id = null, $alias = null)
    {
        if($id) {
            $product = $this->where('id', $id);  
        } else {
            $product = $this->where('alias', $alias);
        }
        $product = $product
            ->where('status', 1)
            ->with('images')
            ->with('promotionPrice');
        $product = $product->first();
        return $product;
    }

/**
 * [getProducts description]
 * @param  [type] $type      [description]
 * @param  [type] $limit     [description]
 * @param  [type] $opt       [description]
 * @param  [type] $sortBy    [description]
 * @param  string $sortOrder [description]
 * @return [type]            [description]
 */
    public function getProducts($type = null, $limit = null, $opt = null, $sortBy = 'sort', $sortOrder = 'desc')
    {
        $lang = sc_get_locale();
        $query = $this->where($this->getTable() . '.status', 1)
            ->with(['descriptions' => function ($q) use ($lang) {
                $q->where('lang', $lang);
            }])
            ->with('promotionPrice');

        if ($type) {
            $query = $query->where('type', $type);
        }

        //Hidden product out of stock
        if (empty(sc_config('product_display_out_of_stock'))) {
            $query = $query->where('stock', '>', 0);
        }
        $query = $query->sort($sortBy, $sortOrder);
        //get all
        if (!(int) $limit) {
            return $query->get();
        } else
        //paginate
        if ($opt == 'paginate') {
            return $query->paginate((int) $limit);
        } else
        //random
        if ($opt == 'random') {
            return $query->inRandomOrder()->limit($limit)->get();
        } else {
            return $query->limit($limit)->get();
        }
    }

    public function getSearch($keyword, $limit = 12, $sortBy = 'sort', $sortOrder = 'desc')
    {
        $lang = sc_get_locale();

        return $this->where('status', 1)->with(['descriptions' => function ($q) use ($lang) {
            $q->where('lang', $lang);
        }])
            ->with('promotionPrice')
            ->leftJoin((new ShopProductDescription)->getTable(), (new ShopProductDescription)->getTable() . '.product_id', $this->getTable() . '.id')
            ->where((new ShopProductDescription)->getTable() . '.lang', sc_get_locale())
            ->where(function ($sql) use ($keyword) {
                $sql->where((new ShopProductDescription)->getTable() . '.name', 'like', '%' . $keyword . '%')
                    ->orWhere($this->getTable() . '.sku', 'like', '%' . $keyword . '%');
            })
            ->sort($sortBy, $sortOrder)
            ->paginate($limit);
    }

/**
 * Get list product promotion
 * @param  [int]  $limit  [description]
 * @param  boolean $random [description]
 * @return [type]          [description]
 */
    public function getProductsSpecial($limit = null, $random = true)
    {

        $special = $this
            ->select(DB::raw($this->getTable() . '.*'))
            ->join(
                (new ShopProductPromotion)->getTable(),
                $this->getTable() . '.id', '=', (new ShopProductPromotion)->getTable() . '.product_id')
            ->where((new ShopProductPromotion)->getTable() . '.status_promotion', 1)
            ->where(function ($query) {
                $query->where((new ShopProductPromotion)->getTable() . '.date_end', '>=', date("Y-m-d"))
                    ->orWhereNull((new ShopProductPromotion)->getTable() . '.date_end');
            })
            ->where(function ($query) {
                $query->where((new ShopProductPromotion)->getTable() . '.date_start', '<=', date("Y-m-d"))
                    ->orWhereNull((new ShopProductPromotion)->getTable() . '.date_start');
            })
            ->where($this->getTable() . '.status', 1);
        if ($random) {
            $special = $special->inRandomOrder();
        }
        if ($limit) {
            $special = $special->limit($limit);
        }
        return $special->get();
    }

/*
Get products of category
category_id: array or string
 */
    public function getProductsToCategory($category_id, $limit = null, $opt = null, $sortBy = 'sort', $sortOrder = 'desc', $status = 1)
    {
        $query = (new ShopProduct)
            ->with('promotionPrice')
            ->leftJoin((new ShopProductCategory)->getTable(), (new ShopProductCategory)->getTable() . '.product_id', $this->getTable() . '.id');
        if (is_array($category_id)) {
            $query = $query->whereIn((new ShopProductCategory)->getTable() . '.category_id', $category_id);
        } else {
            $query = $query->where((new ShopProductCategory)->getTable() . '.category_id', $category_id);
        }
        //product active
        if ($status) {
            $query = $query->where($this->getTable() . '.status', 1);
        }

        //Hidden product out of stock
        if (empty(sc_config('product_display_out_of_stock'))) {
            $query = $query->where($this->getTable() . '.stock', '>', 0);
        }
        //sort product
        $query = $query->sort($sortBy, $sortOrder);

        //Get all product
        if (!(int) $limit) {
            return $query->get();
        } else
        //paginate
        if ($opt == 'paginate') {
            return $query->paginate((int) $limit);
        } else
        //random
        if ($opt == 'random') {
            return $query->inRandomOrder()->limit($limit)->get();
        }
        //
        else {
            return $query->limit($limit)->get();
        }

    }

    protected static function boot()
    {
        parent::boot();
        // before delete() method call this
        static::deleting(function ($product) {
            $product->images()->delete();
            $product->descriptions()->delete();
            $product->promotionPrice()->delete();
            $product->groups()->delete();
            $product->attributes()->delete();
            $product->benefits()->delete();
            $product->reviews()->delete();
            $product->builds()->delete();
            $product->categories()->detach();
            $product->relations()->delete();
            $product->inverseRelations()->delete();
        });
    }

/*
Get thumb
 */
    public function getThumb()
    {
        return sc_image_get_path_thumb($this->image);
    }

/*
Get image
 */
    public function getImage()
    {
        return sc_image_get_path($this->image);

    }

/**
 * [getUrl description]
 * @return [type] [description]
 */
    public function getUrl()
    {
        return route('product.detail', ['alias' => $this->alias]);
    }

//Fields language
    public function getName()
    {
        return $this->processDescriptions()['name'] ?? '';
    }
    public function getKeyword()
    {
        return $this->processDescriptions()['keyword'] ?? '';
    }
    public function getDescription()
    {
        return $this->processDescriptions()['description'] ?? '';
    }
    public function getContent()
    {
        return $this->processDescriptions()['content'] ?? '';
    }
    public function getSpecification()
    {
        return $this->processDescriptions()['specification'] ?? '';
    }
    public function getCase_study()
    {
        return $this->processDescriptions()['case_study'] ?? '';
    }
//Attributes
    public function getNameAttribute()
    {
        return $this->getName();
    }
    public function getKeywordAttribute()
    {
        return $this->getKeyword();

    }
    public function getDescriptionAttribute()
    {
        return $this->getDescription();

    }
    public function getContentAttribute()
    {
        return $this->getContent();
    }
    public function getSpecificationAttribute()
    {
        return $this->getSpecification();
    }
    public function getCaseStudyAttribute()
    {
        return $this->getCase_study();
    }
/**
 * [getArrayProductName description]
 * @return [type] [description]
 */
    public static function getArrayProductName()
    {
        $products = self::select('id', 'sku')->get();
        $arrProduct = [];
        foreach ($products as $key => $product) {
            $arrProduct[$product->id] = $product->name . ' (' . $product->sku . ')';
        }
        return $arrProduct;
    }

/**
 * [getPercentDiscount description]
 * @return [type] [description]
 */
    public function getPercentDiscount()
    {
        return round((($this->price - $this->getFinalPrice()) / $this->price) * 100);
    }

    public function getBenefitDetails()
    {
        $productBenefits = $this->benefits()->pluck('description', 'benefit_id')->all();
        $benefits = ShopBenefit::getList();
        $res = [];
        foreach($benefits as $key => $benefit)
        {
            $res[$benefit] = $productBenefits[$key] ?? '';
        }
        return $res;
    }

    public function renderAttributeDetails()
    {
        $html = '';
        $details = $this->attributes()->get()->groupBy('attribute_group_id');
        $groups = ShopAttributeGroup::getList();
        $groupTypes = ShopAttributeGroup::getTypeList();

        foreach ($details as $groupId => $detailsGroup) {
            $html .= '<div><label class="label">' . $groups[$groupId] . ' :</label> <br><div class="content">';
            
            if ($groupTypes[$groupId] == "select") {
                $html .= '<select class="form-control product-attribute-item" name="form_attr[' . $groupId . ']">';
            }
            foreach ($detailsGroup as $k => $detail) {
                if ($groupTypes[$groupId] == "select") {
                    $html .= '<option>' . $detail->name . '</option>';
                } else {
                    $html .= '<label class="radio-inline product-attribute-item"><input ' . (($k == 0) ? "checked" : "") . ' type="radio" name="form_attr[' . $groupId . ']" value="' . $detail->name . '">' . $detail->name . '</label> ';
                }
            }
            if ($groupTypes[$groupId] == "select") {
                $html .= "</select>";
            }
            $html .= "</div></div>";
        }
        return $html;
    }

    public function renderAttributeDetailsAdmin()
    {
        $html = '';
        $details = $this->attributes()->get()->groupBy('attribute_group_id');
        $groups = ShopAttributeGroup::getList();
        foreach ($details as $groupId => $detailsGroup) {
            $html .= '<br><b><label>' . $groups[$groupId] . '</label></b>: ';
            foreach ($detailsGroup as $k => $detail) {
                $html .= '<label class="radio-inline"><input ' . (($k == 0) ? "checked" : "") . ' type="radio" name="add_att[' . $this->id . '][' . $groupId . ']" value="' . $detail->name . '">' . $detail->name . '</label> ';
            }
        }
        return $html;
    }

//Scort
    public function scopeSort($query, $sortBy = null, $sortOrder = 'desc')
    {
        $sortBy = $sortBy ?? 'id';
        return $query->orderBy($sortBy, $sortOrder);
    }

/**
//Condition:
//Active
//In of stock or allow order out of stock
//Date availabe
// Not SC_PRODUCT_GROUP
 */
    public function allowSale($qty=1)
    {
        if(!sc_config('product_price')) {
            return false;
        }
        if ($this->status &&
            (sc_config('product_preorder') == 1 || $this->date_available == null || date('Y-m-d H:i:s') >= $this->date_available) &&
            (sc_config('product_buy_out_of_stock') || $this->stock>=$qty) &&
            $this->kind != SC_PRODUCT_GROUP
        ) {
            return true;
        } else {
            return false;
        }
    }

    public function processDescriptions()
    {
        return $this->descriptions->keyBy('lang')[sc_get_locale()] ?? [];
    }

/*
Check promotion price
 */
    public function processPromotionPrice()
    {
        $promotion = $this->promotionPrice;
        if ($promotion) {
            if (($promotion['date_end'] >= date("Y-m-d") || $promotion['date_end'] == null)
                && ($promotion['date_start'] <= date("Y-m-d") || $promotion['date_start'] == null)
                && $promotion['status_promotion'] = 1) {
                return $promotion['price_promotion'];
            }
        }

        return -1;
    }
    /*
    Upate stock, sold
     */
    public static function updateStock($product_id, $qty_change)
    {
        $item = ShopProduct::find($product_id);
        if ($item) {
            $item->stock = $item->stock - $qty_change;
            $item->sold = $item->sold + $qty_change;
            $item->save();

            //Process build
            $product = self::find($product_id);
            if ($product->kind == SC_PRODUCT_BUILD) {
                foreach ($product->builds as $key => $build) {
                    $productBuild = $build->product;
                    $productBuild->stock -= $qty_change * $build->quantity;
                    $productBuild->sold += $qty_change * $build->quantity;
                    $productBuild->save();
                }
            }

        }
    }

    // Get product review mean mark
    public function getReviewDetails() {
        $details = $this->reviews()->get();
        $meanMark = 0;
        $userId = -1;
        $myReview = null;
        $count = count($details);

        if (Auth::check()) {
            $user = Auth::user();
            $userId = $user->id;
        }

        foreach($details as $key => $review) {
            $meanMark += $review->mark;
            $details[$key]["user"] = $review->user;
            if ($details[$key]["user"]["id"] == $userId) {
                $myReview = $review;
                unset($details[$key]);
            }
        }
        if ($count > 0) {
            $meanMark /= $count;
        }
        
        return ["meanMark" => $meanMark, "count" => $count , "otherReviews" => $details, "myReview" => $myReview];
    }
}