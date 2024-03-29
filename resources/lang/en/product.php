<?php

return [
    'id'                    => 'ID',
    'sku'                   => 'SKU',
    'alias'                 => 'Url customize <span class="seo" title="SEO"><i class="fa fa-coffee" aria-hidden="true"></i></span>',
    'sku_validate'          => 'Only characters in the group: "A-Z", "a-z", "0-9" and "-_" ',
    'discoundcode_validate' => 'Only 6 characters in the group: "A-Z", "a-z" and "0-9"',
    'alias_validate'        => 'Maximum 100 characters in the group: "A-Z", "a-z", "0-9" and "-_" ',
    'description'           => 'Product description',
    'price'                 => 'Price',
    'attribute_price'       => 'Attribute Prices',
    'price_promotion'       => 'Price promotion',
    'price_promotion_start' => 'Start date',
    'price_promotion_end'   => 'End date',
    'quantity'              => 'Quantity',
    'total_price'           => 'Total',
    'attribute'             => 'Attributes',
    'add_product'           => 'Add product',
    'edit_product'          => 'Edit product',
    'category'              => 'Category',
    'name'                  => 'Name',
    'keyword'               => 'Keyword',
    'description'           => 'Description',
    'content'               => 'General',
    'specification'         => 'Specification',
    'case_study'            => 'Case Study',
    'type'                  => 'Type',
    'kind'                  => 'Kind',
    'virtual'               => 'Virtual',
    'cost'                  => 'Price cost',
    'stock'                 => 'Stock',
    'stock_status'          => 'Stock status',
    'view'                  => 'View',
    'sold'                  => 'Sold',
    'sort'                  => 'Sort',
    'image'                 => 'Image',
    'status'                => 'Status',
    'date_available'        => 'Date available',
    'import_multi'          => 'Import multiple',
    'new'                   => 'New',
    'sale'                  => 'Sale',
    'brand'                 => 'Brand',
    'vendor'                => 'Vendor',
    'availability'          => 'Availability',
    'in_stock'              => 'In stock',
    'out_stock'              => 'Out of stock',
    'overview'              => 'Quick Overview',
    'comment'               => 'Comment',
    'price_group'           => 'Click view price',
    'price_group_chose'     => 'Please chose product',
    'groups'                => 'Products group',
    'builds'                => 'Products build',
    'review'                => 'Reviews',
    'benefit'               => 'Benefits',
    'supplyName'            => 'Supplier Name',
    'supplyLink'            => 'Supplier Website',
    'coupon_apply'          => 'FlowCell promotion item ',
    'admin'                 => [
        'title'                   => 'Product',
        'manager'                 => 'Product Manager',
        'relationship'            => 'Product Relationship',
        'create_success'          => 'Create new item success!',
        'edit_success'            => 'Edit item success!',
        'list'                    => 'Product list',
        'action'                  => 'Action',
        'delete'                  => 'Delete',
        'edit'                    => 'Edit',
        'add_new'                 => 'Add new',
        'add_new_title'           => 'Add new product',
        'add_new_des'             => 'Create a new product',
        'export'                  => 'Export',
        'refresh'                 => 'Refresh',
        'select_kind'             => 'Select product kind',
        'result_item'             => 'Showing <b>:item_from</b> to <b>:item_to</b> of <b>:item_total</b> items</b>',
        'sort'                    => 'Sort',

        'select_category'         => 'Select category',
        'select_product_in_group' => 'Select products in group',
        'select_product_in_build' => 'Select products build',
        'add_product'             => 'Add product',
        'add_attribute'           => 'Add attribute',
        'add_attribute_place'     => 'Add an attribute value',
        'add_attribute_price'     => 'Add an attribute price. Empty means default price',
        'add_sub_image'           => 'Add more images',
        'add_product_promotion'   => 'Add promotion price',
        'choose_image'            => 'Choose',

        'sort_order'              => [
            'id_asc'     => 'ID asc',
            'id_desc'    => 'ID desc',
            'name_asc'   => 'Name asc',
            'name_desc'  => 'Name desc',
            'sku_asc'    => 'SKU a-z',
            'sku_desc'   => 'SKU z-a',
            'price_asc'  => 'Price a-z',
            'price_desc' => 'Price z-a',
            'view_desc' => 'View desc',
            'view_asc' => 'View asc',
            'sold_desc' => 'Sold desc',
            'sold_asc' => 'Sold asc',
        ],
        'search'                  => 'Search',
        'search_place'            => 'Search Name, SKU or ID',
        'cant_remove_child'        => 'Please remove list products from Builds or Groups before delete them',
    ],
    'types'                 => [
        'normal' => 'Normal',
        'new'    => 'New',
        'hot'    => 'Hot',
        'free'    => 'Free',
    ],
    'kinds'                 => [
        'single' => 'Single',
        'build'  => 'Build',
        'group'  => 'Group',
    ],
    'virtuals'              => [
        'physical'  => 'Physical',
        'download'  => 'Download',
        'only_view' => 'Only view',
        'service'   => 'Service',
    ],
    'config_manager' => [
        'title' => ' Config product',
        'field'                   => 'Field config',
        'value'                    => 'Value',
        'brand'                    => 'Use BRAND',
        'vendor'                    => 'Use VENDOR',
        'price'                    => 'Use PRICE',
        'stock'                    => 'Use STOCK',
        'cost'                    => 'Use COST PRICE',
        'type'                    => 'Use TYPE (new, hot,...)',
        'kind'                    => 'Use KIND (single, group, bundle)',
        'virtual'                    => 'Use TYPE VIRTUAL',
        'attribute'                    => 'Use ATTRIBUTE (color, size,...)',
        'promotion'                    => 'Use PROMOTION PRICE',
        'available'                    => 'Use AVAILABLE TIME',
    ]

];
