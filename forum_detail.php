<?php include 'fetch_data.php'; ?>
<?php
// Ambil ID dari query string
$id = $_GET['id'] ?? null;

// Fungsi untuk mengirim permintaan ke API
function sendApiRequest($url, $method = 'POST', $token = null, $data = null)
{
    $headers = "Content-type: application/x-www-form-urlencoded\r\n";
    if ($token) {
        $headers .= "Authorization: Bearer $token\r\n";
    }
    $options = [
        'http' => [
            'header'  => $headers,
            'method'  => $method,
            'content' => $data,
        ],
    ];
    $context  = stream_context_create($options);
    $result = @file_get_contents($url, false, $context); // Gunakan @ untuk menekan warning
    if ($result === FALSE) {
        $error = error_get_last();
        
        return null; // Kembalikan null jika permintaan gagal
    }
    return json_decode($result, true);
}

// Debug: Tampilkan session untuk memastikan token ada


// Ambil informasi pengguna menggunakan token
$user_id = null;
if (isset($_SESSION['token'])) {
    $token = $_SESSION['token'];
    $user_info_url = "http://143.198.218.9:30000/api/me"; // URL API untuk mendapatkan informasi pengguna
    $user_info = sendApiRequest($user_info_url, 'GET', $token);

    // Debug: Tampilkan informasi pengguna yang diambil
    

    if ($user_info && isset($user_info['id'])) {
        $user_id = $user_info['id'];
    } else {
        echo "Gagal mengambil informasi pengguna.\n";
    }
} else {
    echo "Token tidak ditemukan di session.\n";
}

// Debug: Tampilkan user_id untuk memastikan sudah diatur


// Proses form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($user_id) {
        $action = $_POST['action'] ?? null;
        if ($action === 'like' || $action === 'dislike') {
            $api_url = "http://143.198.218.9:30000/api/forums/$id/$action";

            // Debug: Tampilkan URL yang digunakan
            

            $response = sendApiRequest($api_url, 'POST', $token);

            // Debug: Tampilkan respons dari API
           

            if ($response && isset($response['message'])) {
                $success_message = $response['message'];
                // Muat ulang halaman untuk menampilkan status terbaru
                header("Location: forum_detail.php?id=$id");
                exit();
            } else {
                // Tampilkan pesan error yang lebih rinci
                $error_message = $response['message'] ?? 'Terjadi kesalahan saat mengirim permintaan.';
                if ($response === null) {
                    $error_message = 'Gagal menghubungi API. Periksa URL dan koneksi jaringan Anda.';
                }
            }
        } elseif ($action === 'add_comment') {
            $comment_content = $_POST['comment_content'] ?? '';
            if (!empty($comment_content)) {
                $api_url = "http://143.198.218.9:30000/api/forums/comment";
                $data = http_build_query(['forums_id' => $id, 'comments_content' => $comment_content]);
                $response = sendApiRequest($api_url, 'POST', $token, $data);

                // Debug: Tampilkan respons dari API
                

                if ($response && isset($response['message'])) {
                    $success_message = $response['message'];
                    // Muat ulang halaman untuk menampilkan status terbaru
                    header("Location: forum_detail.php?id=$id");
                    exit();
                } else {
                    $error_message = $response['message'] ?? 'Terjadi kesalahan saat mengirim komentar.';
                    if ($response === null) {
                        $error_message = 'Gagal menghubungi API. Periksa URL dan koneksi jaringan Anda.';
                    }
                }
            } else {
                $error_message = 'Komentar tidak boleh kosong.';
            }
        }
    } else {
        $error_message = 'Anda harus login terlebih dahulu untuk memberikan like, dislike, atau komentar.';
    }
}

// Ambil data dari API
$api_url = 'http://143.198.218.9:30000/api/forums/' . $id; // URL API kamu
$response = file_get_contents($api_url);
$data = json_decode($response, true);
$forum = $data['data'] ?? [];
$user_liked = $forum['user_liked'] ?? null;
$user_disliked = $forum['user_disliked'] ?? null;
$comments = $forum['comments'] ?? [];

// Tambahkan path ke gambar
if (!empty($forum['image'])) {
    $forum['image'] = 'http://143.198.218.9:30000/storage/forum/' . $forum['image'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forum Detail</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="dist/font-awesome/css/font-awesome.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <style>
        .forum-detail {
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .comment {
            border-top: 1px solid #ddd;
            padding-top: 15px;
            margin-top: 15px;
        }

        .comment:first-child {
            border-top: none;
            padding-top: 0;
            margin-top: 0;
        }

        .comment .user-info {
            display: flex;
            align-items: center;
        }

        .comment .user-info img {
            border-radius: 50%;
            margin-right: 10px;
        }

        .comment .user-info strong {
            margin-right: 5px;
        }

        .add-comment {
            margin-top: 20px;
        }

        .btn-liked {
            font-weight: bold;
            color: white;
            background-color: green;
        }

        .btn-disliked {
            font-weight: bold;
            color: white;
            background-color: red;
        }

        .btn-neutral {
            font-weight: bold;
            color: white;
            background-color: gray;
        }

        .loading {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <?php include 'Components/main/navbar.php'; ?>
    <main class="container mt-3">
        <div class="row">
            <div class="col-12">
                <div class="forum-detail">
                    <h2><?= $forum['title'] ?? 'Title not found' ?></h2>
                    <p class="mt-3"><?= $forum['content'] ?? 'Content not found' ?></p>
                    <?php if (!empty($forum['image'])) : ?>
                        <!-- Jika ada gambar di forum, tampilkan gambar tersebut -->
                        <img src="<?= $forum['image'] ?>" alt="">
                    <?php endif; ?>
                    <div></div>
                    <div class="user-info mt-2">
                        <img src="https://via.placeholder.com/40" alt="User">
                        <div>
                            <strong><?= $forum['writer']['username'] ?? 'Unknown' ?></strong><br>
                            <small><?= $forum['created_at'] ?? 'Unknown date' ?></small>
                        </div>
                    </div>
                    <div class="actions mt-3">
                        <form method="post" style="display:inline;">
                            <input type="hidden" name="action" value="like">
                            <button type="submit" class="btn btn-sm <?= $user_liked ? 'btn-liked' : 'btn-neutral' ?>">
                                <i class="fa fa-thumbs-up"></i> Like
                                <span class="badge bg-success"><?= $forum['likes_count'] ?? 0 ?></span>
                            </button>
                        </form>
                        <form method="post" style="display:inline;">
                            <input type="hidden" name="action" value="dislike">
                            <button type="submit" class="btn btn-sm <?= $user_disliked ? 'btn-disliked' : 'btn-neutral' ?>">
                                <i class="fa fa-thumbs-down"></i> Dislike
                                <span class="badge bg-danger"><?= $forum['dislikes_count'] ?? 0 ?></span>
                            </button>
                        </form>
                    </div>
                    <div>
                        <span><?= $forum['likes_count'] ?? 0 ?> likes</span> | <span><?= $forum['dislikes_count'] ?? 0 ?> dislikes</span>
                    </div>
                    <?php if (isset($success_message)) : ?>
                        <div class="alert alert-success mt-3"><?= $success_message ?></div>
                    <?php endif; ?>
                    <?php if (isset($error_message)) : ?>
                        <div class="alert alert-danger mt-3"><?= $error_message ?></div>
                    <?php endif; ?>
                </div>
                <?php if ($user_id): ?>
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
                <?php endif; ?>
                <div class="comments">
                    <h3>Comments (<?= $forum['comment_total'] ?? 0 ?>)</h3>
                    <button id="sort-button" class="btn btn-secondary mb-3">Sort by Newest</button>
                    <div id="comment-list">
                    <?php foreach ($comments as $comment) { ?>
                            <div class="comment">
                                <div class="user-info">
                                    <img src="https://via.placeholder.com/40" alt="User">
                                    <div>
                                        <strong><?= $comment['commentator']['username'] ?? 'Unknown' ?></strong><br>
                                        <small><?= $comment['created_at'] ?? 'Unknown date' ?></small>
                                    </div>
                                </div>
                                <p><?= $comment['comments_content'] ?? 'No content' ?></p>
                            </div>
                            <?php } ?>
                    </div>
                    <div class="loading" id="loading" style="display: none;">
                        <img src="loading.gif" alt="Loading...">
                    </div>
                </div>
                
            </div>
        </div>
    </main>
    <?php include 'Components/main/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
       
    </script>
</body>

</html>