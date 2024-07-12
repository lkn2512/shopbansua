{{-- <button id="support-link" class="button-chat"></button> --}}
{{-- <div id="support-box" class="support-box" style="display: none;">
    <div class="chat-header">
        <span>Chat với chủ shop</span>
        <button id="close-support-box" class="close-btn"><i class="fa-solid fa-xmark"></i></button>
    </div>
    <div class="chat-body">
        <div class="message-container">
            <div class="message admin">
                <span>Xin chào! Có thể tôi giúp gì cho bạn?</span>
            </div>
            <!-- Các tin nhắn sẽ được thêm vào đây -->
        </div>
    </div>
    <div class="chat-footer">
        <input type="text" id="message-input" placeholder="Nhập tin nhắn...">
        <button type="submit" id="send-message-btn" class="send-btn">Gửi</button>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#support-link').click(function(e) {
            e.preventDefault();
            $('#support-box').toggle();
        });

        $('#close-support-box').click(function() {
            $('#support-box').hide();
        });

        $('#send-message-btn').click(function() {
            sendMessage();
        });

        $('#message-input').keypress(function(event) {
            if (event.keyCode === 13) { // Kiểm tra nếu phím Enter được nhấn
                event.preventDefault(); // Ngăn chặn hành động mặc định của Enter
                sendMessage();
            }
        });
        $(document).ready(function() {
            $('#send-message-btn').click(function() {
                sendMessage();
            });
        });

        function sendMessage() {
            var message = $('#message-input').val();
            if (message.trim() !== '') {
                // Hiển thị tin nhắn người dùng
                $('.message-container').append('<div class="message user"><span>' + message + '</span></div>');
                $('#message-input').val('');

                // Gửi tin nhắn đến server (nếu cần xử lý logic gửi tin nhắn ở đây)

                // Giả lập tin nhắn từ admin (thay bằng logic thực tế từ server)
                setTimeout(function() {
                    var adminMessage = 'Xin chào! Có thể tôi giúp gì cho bạn?';
                    $('.message-container').append('<div class="message admin"><span>' + adminMessage +
                        '</span></div>');
                    // Cuộn xuống dòng tin nhắn mới nhất
                    var chatBody = $('.chat-body');
                    chatBody.scrollTop(chatBody[0].scrollHeight);
                }, 1000); // Giả lập thời gian phản hồi từ admin
            }
        }
    });
</script>
<style>
    .button-chat {
        position: fixed;
        bottom: 20px;
        right: 20px;
        border-radius: 50%;
        width: 50px;
        height: 50px;
        background-image: url('frontend/images/home/chat.png');
        background-size: cover;
        background-position: center;
        border: none;
    }

    .close-btn {
        border: none;
    }

    .support-box {
        position: fixed;
        bottom: 20px;
        right: 20px;
        width: 300px;
        background-color: #ffffff;
        border: 1px solid #ccc;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        z-index: 9999;
        display: none;
        border-radius: 8px;
    }

    .chat-header {
        background-color: #f0f0f0;
        padding: 10px;
        border-top-left-radius: 8px;
        border-top-right-radius: 8px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .chat-header span {
        font-weight: bold;
        color: #333333;
    }

    .close-btn {
        border: none;
        background-color: transparent;
        cursor: pointer;
    }

    .chat-body {
        padding: 10px;
        max-height: 300px;
        overflow-y: auto;
    }

    .message {
        margin-bottom: 10px;
        padding: 8px 12px;
        border-radius: 10px;
        max-width: 80%;
        clear: both;
    }

    .message.admin {
        background-color: #f0f0f0;
        align-self: flex-start;
        float: left;
        clear: both;
    }

    .message.user {
        background-color: #007bff;
        color: #ffffff;
        align-self: flex-end;
        float: right;
        clear: both;
    }

    .chat-footer {
        display: flex;
        align-items: center;
        border-top: 1px solid #ccc;
        padding: 10px;
    }

    .chat-footer input[type="text"] {
        flex: 1;
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 20px;
        outline: none;
    }

    .chat-footer button {
        margin-left: 10px;
        padding: 8px 20px;
        border: none;
        border-radius: 20px;
        background-color: #007bff;
        color: #ffffff;
        cursor: pointer;
        outline: none;
    }

    .chat-footer button:hover {
        background-color: #0056b3;
    }
</style> --}}
