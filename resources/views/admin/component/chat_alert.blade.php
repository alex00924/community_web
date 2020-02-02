@php
    use \App\Admin\Controllers\ChatkitController;    
    $chatkitInfo_alert = ChatkitController::getChatkitAlertInformation();
@endphp
          <!-- Notifications: style can be found in dropdown.less -->
          <li class="dropdown notifications-menu">
            <a href="{{route('admin_chat')}}">
              <i class="fa fa-bell-o"></i>
              <span class="label label-danger" id="chat-alert"></span>
            </a>
          </li>

<script>
    @if (isset($chatkitInfo_alert))
        var chatkitInfo = @json($chatkitInfo_alert);
    @endif
</script>