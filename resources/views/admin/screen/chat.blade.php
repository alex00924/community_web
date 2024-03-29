@extends('admin.layout')

@section('main')
    <div class="chat-container">
        <div id="chat">
            <div id="sidepanel">
                <div id="profile">
                    <div class="wrap">
                        <img id="profile-img" src="{{ $curUser['avatar_url'] }}" class="online" alt=""/>
                        <p>{{ $curUser['name'] }}</p>
                    </div>
                </div>
                <div id="search">
                    <label for=""><i class="fa fa-search" aria-hidden="true"></i></label>
                    <input type="text" placeholder="Search contacts..." />
                </div>
                <div id="contacts">
                    <ul>
                        @foreach ($users as $user)
                        @if ($user["id"] == $curUser["id"])
                            @continue
                        @endif
                        <li class="contact" id="{{ $user['id'] }}" onclick="changeRoom( '{{ $user['id'] }}' )">
                            <div class="wrap">
                                <p class="unread"></p>
                                <span class="contact-status"></span>
                                <img src="{{ $user['avatar_url'] }}"/>
                                <div class="meta">
                                    <img src="/chat/img/typing.gif" class="typing">
                                    <div>
                                        <p class="name">{{ $user['name'] }}</p>
                                        <p class="preview"></p>
                                    </div>
                                </div>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="chat-content">
                <div class="contact-profile">
                    <img src="" id="avatar" />
                    <p></p>
                    <img src="/chat/img/typing.gif" class="typing"/>
                </div>
                <div class="messages">
                    <ul>
                    </ul>
                </div>
                <div class="message-input">
                    <div class="wrap">
                        <input type="text" placeholder="Write your message..." />
                        <button class="submit"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>
                    </div>
                </div>
            </div>
        </div>
    <div>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('chat/chat.css') }}">
@endpush

@push('scripts')
    <script>
        var rooms = @json($rooms);
        var users = @json($users);
        var curUser = @json($curUser);                  // current user
        var chattingUser;                               // chatting user
        var chatkitLocator = "{{$chatkitLocator}}";
        var chatkitUser;                                // chatkit user instance. fixed for current user
        var chatkitRoom;                                // chatkit room instance  dynamic for selecting user
    </script>

    <script src="{{ asset('chat/chat.js') }}"></script>
@endpush