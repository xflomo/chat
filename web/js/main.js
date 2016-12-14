$(document).ready(function(){
    $.material.init();
});

$(window).load(function(){
    // TODO abfrage integrieren nach aktueller chatraum id
    if($("#chatMessages").length >0){
        loadChatMessages();
    }
});

function loadChatMessages() {
    $.ajax({
        url : "/ajax",
        type: "POST",
        data: {
            ajaxCall: "getMessagesFromChatroom"
        },
        success: function(html){
            $("#chatMessages").html(html);
            $(".chatbox-content").scrollTop($(".chatbox-content").prop("scrollHeight"));
        }
    });
}

function loadChatRoom() {
    $(".chat-start-container").fadeOut(350);
    $(".loading-container").fadeIn(700);

    $.ajax({
        url : "/ajax",
        type: "POST",
        data: {
            ajaxCall: "createNewChatroom"
        },
        success: function(html){
            setTimeout(function(){
                window.location.href = "/chatroom/"+html;
            }, 1000);
        }
    });
}

$( ".chatbox-input .input" ).keyup(function( event ) {
    if(event.keyCode==13){
        sendMessage(this.innerHTML);
    }else{
        writeChatMessage(this.innerHTML);
    }
});

$( ".chat-left-nav.member-list" ).on( "click", ".add-chatroom", function() {
    $(".chat-left-nav.add-chatgroup-nav").animate({
        left: '0px'
    });
});

$( ".chat-left-nav.add-chatgroup-nav" ).on( "click", ".add-chatroom", function() {
    $(".chat-left-nav.add-chatgroup-nav").animate({
        left: '-360px'
    });
});

// Disable Umbruch
$(document).on('keypress', '.chatbox-input .input', function(e){
    return e.which != 13;
});

function writeChatMessage(value) {
    if(value.length > 0 && value != " " && value != "&nbsp;"){
        $(".chatbox-input .input-placeholder").css('visibility', 'hidden');
    }else{
        $(".chatbox-input .input-placeholder").css('visibility', 'visible');
    }
}

function sendMessage(message) {
    // TODO Replace mit php anbindung AJAX Call

    $(".chatbox-input .input-placeholder").css('visibility', 'visible');
    $(".chatbox-input .input").html("");
    if(message.length > 0 && message != " " && message != "&nbsp;") {
        $.ajax({
            url: "/ajax",
            type: "POST",
            data: {
                ajaxCall: "newChatMessage",
                value: message
            },
            success: function () {
                loadChatMessages();
            }
        });
    }
}