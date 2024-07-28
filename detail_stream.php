<?php
include "fetch_data.php";
$streamId = $_GET['id'];

// Ambil data dari API
$apiUrl = "http://143.198.218.9:8000/api/streaming/$streamId";
$response = file_get_contents($apiUrl);
$stream = json_decode($response, true)['data'];
$liveChats = $stream['livechat'];

// Ambil token dari session atau sumber lain
$token = $_SESSION['token'] ?? '';
$comments = $stream['comments'] ?? [];
$totalComments = count($comments); // Hitung total komentar

// Cek apakah user sudah login
$isLoggedIn = !empty($token);

// Proses pengiriman komentar
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comment_content'])) {
    $commentContent = $_POST['comment_content'];
    $data = [
        'streaming_id' => $streamId,
        'comments_content' => $commentContent
    ];

    $options = [
        'http' => [
            'header'  => "Content-type: application/json\r\n" .
                "Authorization: Bearer $token\r\n",
            'method'  => 'POST',
            'content' => json_encode($data),
        ],
    ];
    $context  = stream_context_create($options);
    $result = @file_get_contents('http://143.198.218.9:8000/api/streaming/comment', false, $context);
    if ($result === FALSE) {
        $error = error_get_last();
        echo "Error: " . $error['message'];
        echo "<br>Data: " . json_encode($data);
        echo "<br>Options: " . json_encode($options);
    } else {
        // Refresh halaman untuk memuat komentar baru
        header("Location: " . $_SERVER['REQUEST_URI']);
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Live Stream with Chat</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="dist/font-awesome/css/font-awesome.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Fira+Code:wght@400;600;700&display=swap" media="all">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@100..900&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto Slab', monospace;
            background-color: #263238;
            color: white;
        }

        .header {
            background-image: url('https://th.bing.com/th/id/R.96525332caecb290910d28ebe289e5fe?rik=1IsDNYAEaEoumA&riu=http%3a%2f%2fwww.origiin.com%2fbin2017%2fwp-content%2fuploads%2f2018%2f09%2flaw-colleges-banner.jpg&ehk=P%2fKdeZUaDvgaOCO2PUHBgWlX5GI7BP4vHvPn4IcCXeY%3d&risl=&pid=ImgRaw&r=0');
            background-size: cover;
            background-position: center;
            padding: 60px 20px;
            text-align: center;
            color: white;
        }

        .header h1 {
            font-size: 3rem;
            margin-bottom: 10px;
        }

        .header p {
            font-size: 1.5rem;
            margin-bottom: 30px;
        }

        .container-custom {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        .video-container {
            flex: 3.5;
            margin-right: 20px;
        }

        .video-container iframe {
            width: 100%;
            height: 500px;
        }

        .chat-container {
            flex: 1.5;
            background-color: #1a1a1a;
            border-radius: 10px;
            padding: 10px;
            height: 500px;
            display: flex;
            flex-direction: column;
            overflow-y: auto;
            scrollbar-width: none;
            -ms-overflow-style: none;
        }

        .chat-container::-webkit-scrollbar {
            width: 0;
            height: 0;
        }

        .chat-messages {
            flex: 1;
            overflow-y: auto;
        }

        .chat-message {
            margin-bottom: 10px;
        }

        .chat-message .username {
            font-weight: bold;
            color: #ffcc00;
        }

        .chat-message .message {
            color: #ccc;
        }

        .stream-info {
            margin-top: 20px;
        }

        .stream-title {
            font-size: 1.5em;
            font-weight: bold;
        }

        .stream-status {
            font-size: 1.2em;
        }

        .stream-status.on-air {
            color: red;
        }

        .stream-status.off-air {
            color: green;
        }

        .stream-description {
            font-size: 1em;
            color: #ccc;
        }

        .chat-form {
            display: flex;
            margin-top: 10px;
        }

        .chat-form input[type="text"] {
            flex: 1;
            padding: 10px;
            border: none;
            border-radius: 5px;
            margin-right: 10px;
        }

        .chat-form button {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            background-color: #ffcc00;
            color: #010314;
            font-weight: bold;
        }

        .comment {
            margin-top: 20px;
            background-color: #1a1a1a;
            border-radius: 10px;
            padding: 10px;
            color: #ccc;
        }

        .comment .user-info {
            display: flex;
            align-items: center;
            flex-direction: column;
            text-align: center;
            margin-right: 10px;
        }

        .comment .user-info img {
            border-radius: 50%;
            margin-bottom: 5px;
        }

        .comment .user-info div {
            display: flex;
            flex-direction: column;
        }

        .comment .comment-content {
            flex-grow: 1;
        }

        .comment p {
            margin: 5px 0 0 0;
        }

        .add-comment {
            background-color: #37474F;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            color: #fff;
        }

        .add-comment h5 {
            color: #fff;
        }

        .add-comment .form-control {
            background-color: #263238;
            color: #fff;
            border: 1px solid #757575;
        }

        .add-comment .btn-primary {
            background-color: #198754;
            border: none;
        }

        .comment-card {
            background-color: #37474F;
            border-radius: 8px;
            padding: 10px;
            margin-bottom: 10px;
            color: #ccc;
            display: flex;
        }

        .comment-card .comment {
            background-color: transparent;
            display: flex;
            flex-direction: row;
            align-items: flex-start;
        }
    </style>
</head>

<body>
    <?php include 'Components/main/navbar.php'; ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="header">
                    <h1 class="text-warning">Live Stream</h1>
                    <p>Watch and Learn</p>
                </div>
                <div class="container container-custom">
                    <div class="video-container">
                        <div class="embed-responsive embed-responsive-16by1">
                            <iframe src="https://www.youtube.com/embed/DOOrIxw5xOw?si=tps1yhMB5TEhgdgv" title="YouTube live player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                        </div>
                        <div class="stream-info">
                            <div class="stream-title"><?= $stream['judul_streaming'] ?></div>
                            <div class="stream-status <?= $stream['status_stream'] == 'On Air' ? 'on-air' : 'off-air' ?>"><?= $stream['status_stream'] ?></div>
                            <div class="stream-description"><?= $stream['deskribsi'] ?></div>
                        </div>
                        <div class="add-comment">
                            <h5>Add Comment</h5>
                            <form method="post">
                                <input type="hidden" name="action" value="add_comment">

                                <?php if ($isLoggedIn) { ?>
                                    <div class="mb-3">
                                        <textarea class="form-control" name="comment_content" rows="3" placeholder="Add your comment here..."></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Add Comment</button>
                                <?php } else { ?>
                                    <p class="text-warning">Please log in to add a comment.</p>
                                <?php } ?>
                            </form>
                        </div>
                        <h3>Comments (<?= $totalComments ?>)</h3>
                        <button id="sort-button" class="btn btn-secondary mb-3">Sort by Newest</button>
                        <div id="comment-list">
                            <?php foreach ($comments as $comment) { ?>
                                <div class="comment-card">
                                    <div class="comment">
                                        <div class="user-info">
                                            <img src="https://via.placeholder.com/40" alt="User">
                                            <div>
                                                <strong><?= $comment['commentator']['username'] ?? 'Unknown' ?></strong>
                                                <small><?= $comment['created_at'] ?? 'Unknown date' ?></small>
                                            </div>
                                        </div>
                                        <div class="comment-content">
                                            <p><?= $comment['comments_content'] ?? 'No content' ?></p>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="loading" id="loading" style="display: none;">
                            <img src="loading.gif" alt="Loading...">
                        </div>
                    </div>
                    <div class="chat-container" id="chat-container">
                        <div class="chat-messages" id="chat-messages">
                            <?php foreach ($liveChats as $chat) { ?>
                                <div class="chat-message">
                                    <div class="username"><?= $chat['writer']['username'] ?>:</div>
                                    <div class="message"><?= $chat['chat'] ?></div>
                                </div>
                            <?php } ?>
                        </div>
                        <form class="chat-form" id="chat-form">

                            <?php if ($isLoggedIn) { ?>
                                <button type="submit" id="send-chat">Send</button>
                                <input type="text" name="chat" id="chat-input" placeholder="Type your message here...">
                            <?php } else { ?>
                                <p class="text-warning">Please log in to send a message.</p>
                            <?php } ?>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function loadLiveChat() {
            $.ajax({
                url: 'http://127.0.0.1:8000/api/streaming/<?= $streamId ?>',
                method: 'GET',
                success: function(data) {
                    var chatMessages = $('#chat-messages');
                    chatMessages.empty();
                    data.data.livechat.forEach(function(chat) {
                        var chatMessage = '<div class="chat-message">' +
                            '<div class="username">' + chat.writer.username + ':</div>' +
                            '<div class="message">' + chat.chat + '</div>' +
                            '</div>';
                        chatMessages.append(chatMessage);
                    });
                    chatMessages.scrollTop(chatMessages[0].scrollHeight);
                }
            });
        }

        function sendChat() {
            var chatInput = $('#chat-input').val();
            if (chatInput.trim() === '') {
                return;
            }

            $.ajax({
                url: 'http://127.0.0.1:8000/api/livechat',
                method: 'POST',
                contentType: 'application/json',
                headers: {
                    'Authorization': 'Bearer <?= $token ?>'
                },
                data: JSON.stringify({
                    streaming_id: <?= $streamId ?>,
                    chat: chatInput
                }),
                success: function() {
                    $('#chat-input').val('');
                    loadLiveChat();
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                }
            });
        }

        $(document).ready(function() {
            loadLiveChat();
            setInterval(loadLiveChat, 1000);

            $('#chat-form').submit(function(e) {
                e.preventDefault();
                sendChat();
            });

            $('#chat-input').keypress(function(e) {
                if (e.which == 13) { // Enter key pressed
                    e.preventDefault();
                    sendChat();
                }
            });
        });

        let offset = 5;
        const limit = 5;
        const totalComments = <?= $totalComments ?>;
        let comments = <?= json_encode($comments) ?>;
        const loadingElement = document.getElementById('loading');
        const commentListElement = document.getElementById('comment-list');
        const sortButton = document.getElementById('sort-button');
        let sortNewest = true;

        window.addEventListener('scroll', () => {
            if (window.innerHeight + window.scrollY >= document.body.offsetHeight) {
                if (offset < totalComments) {
                    loadMoreComments();
                }
            }
        });

        sortButton.addEventListener('click', () => {
            sortNewest = !sortNewest;
            sortButton.textContent = sortNewest ? 'Sort by Oldest' : 'Sort by Newest';
            comments = comments.reverse();
            offset = 5;
            renderComments();
        });
    </script>
</body>

</html>