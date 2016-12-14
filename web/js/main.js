$(document).ready(function(){
    $.material.init();
});

function loadChatRoom() {
    $(".chat-start-container").fadeOut(350);
    $(".loading-container").fadeIn(700);
    setTimeout(function(){
        window.location.href = "http://www.chat.dev/chatroom/1234";
    }, 3500);
}