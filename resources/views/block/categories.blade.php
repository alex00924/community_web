  @php
    $modelCategory = (new \App\Models\ShopCategory);
    $categories = $modelCategory->getCategoriesAll($onlyActive = true);
    $categoriesTop = $modelCategory->getCategoriesTop();
  @endphp
  @if ($categoriesTop->count())
      <h2>{{ trans('front.categories') }}</h2>
      <div class="panel-group category-products" id="accordian">
          @foreach ($categoriesTop as $key =>  $category)
            @if (!empty($categories[$category->id]))
            <div class="panel panel-default">
              <div class="panel-heading">
                <h4 class="panel-title">
                  <a data-toggle="collapse" data-parent="#accordian" href="#{{ $key }}">
                    <span class="badge pull-right"><i class="fa fa-plus"></i></span>
                  </a>
                  <a href="{{ $category->getUrl() }}"> 
                    @if (strpos($_SERVER['PHP_SELF'],$category->alias))
                      <font color="#0e8ce4">{{ $category->name . " (" . $category->count . ")" }}</font>
                    @else
                      {{ $category->name . " (" . $category->count . ")" }}
                    @endif
                  </a>
                </h4>
              </div>
              <div id="{{ $key }}" class="panel-collapse collapse">
                <div class="panel-body">
                  <ul>
                    @foreach ($categories[$category->id] as $cateChild)
                        <li>
                            - <a href="{{ $cateChild->getUrl() }}">
                              @if (strpos($_SERVER['PHP_SELF'],$cateChild->alias))
                                <font color="#0e8ce4">{{ $cateChild->name . " (" . $cateChild->count . ")" }}</font>
                              @else
                                {{ $cateChild->name . " (" . $cateChild->count . ")" }}
                              @endif
                              </a>
                            <ul>
                              @if (!empty($categories[$cateChild->id]))
                                @foreach ($categories[$cateChild->id] as $cateChild2)
                                    <li>
                                        -- <a href="{{ $cateChild2->getUrl() }}">
                                        @if (strpos($_SERVER['PHP_SELF'],$cateChild2->alias))
                                          <font color="#0e8ce4">{{ $cateChild2->name . " (" . $cateChild2->count . ")" }}</font>
                                        @else
                                          {{ $cateChild2->name . " (" . $cateChild2->count . ")" }}
                                        @endif
                                        </a>
                                    </li>
                                @endforeach
                              @endif
                            </ul>
                        </li>
                    @endforeach
                  </ul>
                </div>
              </div>
            </div>
            @else
              <div class="panel panel-default">
                <div class="panel-heading">
                  <h4 class="panel-title"><a href="{{ $category->getUrl() }}">
                    @if (strpos($_SERVER['PHP_SELF'],$category->alias))
                      <font color="#0e8ce4">{{ $category->name . " (" . $category->count . ")" }}</font>
                    @else
                      {{ $category->name . " (" . $category->count . ")" }}
                    @endif
                  </a></h4>
                </div>
              </div>
            @endif
          @endforeach
      </div>
  @endif
