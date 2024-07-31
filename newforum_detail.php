<?php include 'fetch_data.php'; ?>

<?php
// Mendapatkan ID forum dari query string
$forum_id = isset($_GET['id']) ? $_GET['id'] : null;
$forum = null;
$token = 'Bearer ' . $_SESSION['token']; 
date_default_timezone_set('Asia/Jakarta');

if ($forum_id) {
    // Mengambil data dari API detail forum
    $api_url = 'http://143.198.218.9/backend/api/forums/' . $forum_id;
    $response = file_get_contents($api_url);
    $data = json_decode($response, true);
    $forum = $data['data'];
}

function time_elapsed_string($datetime, $full = false) {
    $now = new DateTime;
    $ago = DateTime::createFromFormat('Y-m-d H:i:s', $datetime);
    if (!$ago) {
        $ago = new DateTime($datetime);
    }
    $diff = $now->diff($ago);

    $string = array(
        'y' => 'tahun',
        'm' => 'bulan',
        'd' => 'hari',
        'h' => 'jam',
        'i' => 'menit',
        's' => 'detik',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v;
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' lalu' : 'baru saja';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] === 'add_comment') {
        $comment_content = $_POST['comment_content'];
        $api_url = 'http://143.198.218.9/backend/api/forums/comment';
        $data = array(
            'forums_id' => $forum_id,
            'comments_content' => $comment_content
        );

        $options = array(
            'http' => array(
                'header'  => "Content-type: application/json\r\n" .
                             "Authorization: $token\r\n",
                'method'  => 'POST',
                'content' => json_encode($data),
            ),
        );

        $context  = stream_context_create($options);
        $result = file_get_contents($api_url, false, $context);
        if ($result === FALSE) {
            // Handle error
        }

        // Redirect to avoid form resubmission
        header("Location: " . $_SERVER['REQUEST_URI']);
        exit();
    } elseif ($_POST['action'] === 'like') {
        $api_url = 'http://143.198.218.9/backend/api/forums/' . $forum_id . '/like';

        $options = array(
            'http' => array(
                'header'  => "Authorization: $token\r\n",
                'method'  => 'POST',
            ),
        );

        $context  = stream_context_create($options);
        $result = file_get_contents($api_url, false, $context);
        if ($result === FALSE) {
            // Handle error
        }

        // Redirect to avoid form resubmission
        header("Location: " . $_SERVER['REQUEST_URI']);
        exit();
    } elseif ($_POST['action'] === 'dislike') {
        $api_url = 'http://143.198.218.9/backend/api/forums/' . $forum_id . '/dislike';

        $options = array(
            'http' => array(
                'header'  => "Authorization: $token\r\n",
                'method'  => 'POST',
            ),
        );

        $context  = stream_context_create($options);
        $result = file_get_contents($api_url, false, $context);
        if ($result === FALSE) {
            // Handle error
        }

        // Redirect to avoid form resubmission
        header("Location: " . $_SERVER['REQUEST_URI']);
        exit();
    } elseif ($_POST['action'] === 'delete_forum') {
        $api_url = 'http://143.198.218.9/backend/api/forums/' . $forum_id;

        $options = array(
            'http' => array(
                'header'  => "Authorization: $token\r\n",
                'method'  => 'DELETE',
            ),
        );

        $context  = stream_context_create($options);
        $result = file_get_contents($api_url, false, $context);
        if ($result === FALSE) {
            // Handle error
        }

        // Redirect to forum list after deletion
        header("Location: newforum.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pertanyaan</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="dist/font-awesome/css/font-awesome.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Fira+Code:wght@400;600;700&display=swap" media="all">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@100..900&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto Slab', monospace;
            background-color: #263238;
        }

        .report-card {
            background-color: #37474F;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .report-title {
            font-weight: bold;
            font-size: 24px;
        }

        .report-id {
            background-color: #ffcc80;
            border-radius: 12px;
            padding: 5px 10px;
            font-size: 14px;
            color: #000;
        }

        .report-author {
            display: flex;
            align-items: center;
            margin-top: 10px;
        }

        .report-author img {
            border-radius: 50%;
            width: 40px;
            height: 40px;
            margin-right: 10px;
        }

        .report-author-info {
            font-size: 14px;
            color: #757575;
        }

        .report-followers {
            background-color: #e3f2fd;
            border-radius: 12px;
            padding: 5px 10px;
            font-size: 14px;
            color: #000;
            text-align: center;
        }

        .divider {
            border-top: 1px solid #757575;
            margin: 10px 0;
        }

        .report-content {
            margin-top: 20px;
            color: #fff;
        }

        .report-content img {
            max-width: 100px;
            margin-right: 10px;
        }

        .report-details {
            margin-top: 20px;
            color: #fff;
        }

        .report-details p {
            margin: 0;
        }

        .report-details img {
            max-width: 100px;
            margin-right: 10px;
            cursor: pointer; /* Add cursor pointer to indicate clickable images */
        }

        .card {
            background-color: #37474F;
            border: none;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px; /* Menambahkan jarak antar kartu */
        }

        .card-body {
            padding: 1.5rem;
        }

        .text-muted {
            font-size: 0.875rem;
        }

        .badge {
            font-size: 1rem;
            padding: 0.5em 1em;
            background-color: #198754;
            color: #fff;
        }

        .report-details p {
            margin-bottom: 0.5rem;
        }

        .img-thumbnail {
            border: 1px solid #ddd;
            max-width: 150px;
            margin-right: 10px;
            cursor: pointer; /* Add cursor pointer to indicate clickable images */
        }

        .vertical-divider {
            border-left: 1px solid #757575;
            height: 100%;
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

        .vote-buttons {
            display: flex;
            align-items: center;
            margin-top: 10px;
        }

        .vote-buttons button {
            background-color: #198754;
            border: none;
            color: #fff;
            padding: 10px;
            border-radius: 5px;
            margin-right: 10px;
            cursor: pointer;
        }

        .vote-buttons button.downvote {
            background-color: #d32f2f;
        }

        .forum-images {
            display: flex;
            flex-direction: column;
            align-items: start;
        }

        .forum-images img {
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
    <?php include 'Components/main/navbar.php'; ?>

    <div class="container">
        <?php if ($forum): ?>
            <div class="report-card">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="report-title"><?= htmlspecialchars($forum['title']) ?></div>
                        <div class="report-id"><?= htmlspecialchars($forum['tags']) ?></div>
                    </div>
                    <div class="vote-buttons">
                        <form method="post" style="display:inline;">
                            <input type="hidden" name="action" value="like">
                            <button type="submit" class="upvote"><i class="fa fa-arrow-up"></i>  <?= htmlspecialchars($forum['likes_count']) ?></button>
                        </form>
                        <form method="post" style="display:inline;">
                            <input type="hidden" name="action" value="dislike">
                            <button type="submit" class="downvote"><i class="fa fa-arrow-down"></i>  <?= htmlspecialchars($forum['dislikes_count']) ?></button>
                        </form>
                        <?php if ($forum['writer']['id'] == $response_data['id']): ?>
                            <form method="post" style="display:inline;">
                                <input type="hidden" name="action" value="delete_forum">
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="divider"></div>
                <div class="report-author mt-3">
                    <img src="http://143.198.218.9/backend/storage/profileimg/<?= htmlspecialchars($forum['writer']['profileimg'] ?? 'path/to/default/image.jpg') ?>" alt="Author Image">
                    <div class="report-author-info">
                        <div>By <?= htmlspecialchars($forum['writer']['username']) ?></div>
                        <div><?= time_elapsed_string($forum['created_at']) ?> Ago</div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <!-- Detail Pemilik Forum -->
    <div class="container">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 text-center">
                        <img src="http://143.198.218.9/backend/storage/profileimg/<?= htmlspecialchars($forum['writer']['profileimg'] ?? 'path/to/default/image.jpg') ?>" class="rounded-circle mb-2" alt="avatar" style="width: 80px; height: 80px; object-fit: cover; aspect-ratio: 1 / 1;">
                        <h5 class="mb-1"><?= htmlspecialchars($forum['writer']['username']) ?></h5>
                        <small class="text-muted">Posted <?= htmlspecialchars($forum['created_at']) ?></small>
                        <?php if ($forum['writer']['role'] === 'superadmin') : ?>
                            <div class="badge mt-2" style="background-color: #dc3545; color: white;">Administrator</div>
                        <?php elseif ($forum['writer']['role'] === 'user') : ?>
                            <div class="badge mt-2" style="background-color: #198754; color: white;">Verified Member</div>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-8">
                        <div class="report-details">
                            <p><?= nl2br(htmlspecialchars($forum['content'])) ?></p>
                            <button class="btn btn-secondary mb-2" type="button" data-toggle="collapse" data-target="#forumImages" aria-expanded="false" aria-controls="forumImages">
                                Show/Hide Images
                            </button>
                            <div class="collapse" id="forumImages">
                                <div class="forum-images">
                                    <?php
                                    $images = json_decode($forum['images'], true);
                                    if ($images && is_array($images)) {
                                        foreach ($images as $image) {
                                            echo '<img src="http://143.198.218.9/backend/storage/forum/' . htmlspecialchars($image) . '" class="img-thumbnail mb-2" alt="Forum Image" data-toggle="modal" data-target="#imageModal" data-image="http://143.198.218.9/backend/storage/forum/' . htmlspecialchars($image) . '">';
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="add-comment">
            <h5>Add Comment</h5>
            <form method="post">
                <input type="hidden" name="action" value="add_comment">
                <div class="mb-3">
                    <textarea class="form-control" name="comment_content" rows="3" placeholder="Add your comment here..."></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Add Comment</button>
            </form>
        </div>
    </div>

    <!-- Comment Section -->
    <div class="container" id="comment-section">
        <!-- Komentar akan dimuat di sini oleh JavaScript -->
    </div>

    <!-- Modal for Image -->
    <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="imageModalLabel">Image</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img id="modalImage" src="" alt="Forum Image" class="img-fluid">
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
    $(document).ready(function() {
        var comments = <?= json_encode($forum['comments']) ?>;
        var commentsPerPage = 5;
        var currentPage = 1;

        function loadComments(page) {
            var start = (page - 1) * commentsPerPage;
            var end = start + commentsPerPage;
            var paginatedComments = comments.slice(start, end);

            paginatedComments.forEach(function(comment) {
                var badgeHtml = '';
                if (comment.commentator.role === 'superadmin') {
                    badgeHtml = '<div class="badge  mt-2"style="background-color: #dc3545; color: white;">Administrator</div>';
                } else if (comment.commentator.role === 'user') {
                    badgeHtml = '<div class="badge mt-2"style="background-color: #198754; color: white;">Verified Member</div>';
                }

                var commentHtml = `
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3 text-center">
                                    <img src="http://143.198.218.9/backend/storage/profileimg/${comment.commentator.profileimg}" class="rounded-circle mb-2" alt="avatar" style="width: 80px; height: 80px; object-fit: cover; aspect-ratio: 1 / 1;">
                                    <h5 class="mb-1">${comment.commentator.username}</h5>
                                    <small class="text-muted">Posted ${comment.created_at}</small>
                                    ${badgeHtml}
                                </div>
                                <div class="col-md-8">
                                    <div class="report-details">
                                        <p>${comment.comments_content}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                               `;
                $('#comment-section').append(commentHtml);
            });
        }

        // Load initial comments
        loadComments(currentPage);

        // Load more comments on scroll
        $(window).scroll(function() {
            if ($(window).scrollTop() + $(window).height() >= $(document).height() - 100) {
                currentPage++;
                loadComments(currentPage);
            }
        });

        // Handle image click to show in modal
        $('.forum-images img').on('click', function() {
            var imageUrl = $(this).data('image');
            $('#modalImage').attr('src', imageUrl);
            $('#imageModal').modal('show');
        });
    });
    </script>

    <?php include 'Components/main/footer.php'; ?>
</body>

</html>