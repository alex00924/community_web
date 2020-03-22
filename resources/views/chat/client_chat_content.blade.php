@php
    use \App\Http\Controllers\ChatkitController;    
    $chatkitInfo = ChatkitController::getChatkitAlertInformation();
@endphp
<script>
    var chatkitInfo = @json($chatkitInfo);
    var rooms = chatkitInfo.rooms;
    var users = chatkitInfo.users;
    var curUser = users.find(user => user.id == chatkitInfo.chatId)                  // current user
    var chattingUser = users.find(user => user.id == rooms[0].member_user_ids.find(member => member != chatkitInfo.chatId));                               // chatting user
    var chatkitLocator = chatkitInfo.chatkitLocator;
    var chatkitUser;                                // chatkit user instance. fixed for current user
    var chatkitRoom = rooms[0];                                // chatkit room instance  dynamic for selecting user
</script>
<div class="chat-icon" onclick="showChatContents()">
    <img src="/chat/img/chat_icon.png" title="Contact to Support Team">
    <span class="unread-count" id="chat-unread-cnt">0</span>
</div>
<div class="chat-container">
    <div id="chat">
        <div class="chat-content">
            <div class="contact-profile">
                <img src="" id="avatar" class="away"/>
                <p></p>
                <img src="/chat/img/typing.gif" class="typing"/>
                <img src="/chat/img/close.png" class="chat-close" onclick="hideChatContents()"/>
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
</div>