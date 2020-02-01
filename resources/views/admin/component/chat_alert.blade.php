@php
  $newOrders = \App\Models\ShopOrder::where('status',1)->orderBy('id','desc');
  $totalNewOrders = $newOrders->count();
  $orders = $newOrders->limit(10)->get();
@endphp
          <!-- Notifications: style can be found in dropdown.less -->
          <li class="dropdown notifications-menu">
            <a href="{{route('admin_chat')}}">
              <i class="fa fa-bell-o"></i>
              <span class="label label-danger">{{$totalNewOrders}}</span>
            </a>
          </li>
