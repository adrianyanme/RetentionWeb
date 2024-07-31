<?php
include 'fetch_data.php';

// Ambil data dari API
$api_url = 'http://143.198.218.9/backend/api/forums'; // URL API kamu
$response = file_get_contents($api_url);
$data = json_decode($response, true);

// Panggil endpoint 'me' untuk mendapatkan data user
$user = null;
if (isset($_SESSION['token'])) {
    $token = $_SESSION['token'];
    $me_url = 'http://143.198.218.9/backend/api/me'; // URL API untuk endpoint 'me'
    $options = [
        'http' => [
            'header'  => "Authorization: Bearer $token\r\n",
            'method'  => 'GET',
        ],
    ];
    $context  = stream_context_create($options);
    $response = file_get_contents($me_url, false, $context);
    $user = json_decode($response, true);
}

// Tangani pengiriman form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $tags = $_POST['tags'];
    $file = isset($_FILES['file']) ? $_FILES['file'] : null;

    $postData = [
        'title' => $title,
        'content' => $content,
        'tags' => $tags,
    ];

    $boundary = uniqid();
    $delimiter = '-------------' . $boundary;

    $postDataString = '';
    foreach ($postData as $name => $value) {
        $postDataString .= "--" . $delimiter . "\r\n";
        $postDataString .= 'Content-Disposition: form-data; name="' . $name . "\"\r\n\r\n" . $value . "\r\n";
    }

    if ($file && $file['error'] === UPLOAD_ERR_OK) {
        $fileContents = file_get_contents($file['tmp_name']);
        $postDataString .= "--" . $delimiter . "\r\n";
        $postDataString .= 'Content-Disposition: form-data; name="file"; filename="' . $file['name'] . "\"\r\n";
        $postDataString .= 'Content-Type: ' . $file['type'] . "\r\n\r\n";
        $postDataString .= $fileContents . "\r\n";
    }

    $postDataString .= "--" . $delimiter . "--\r\n";

    $options = [
        'http' => [
            'header'  => "Content-Type: multipart/form-data; boundary=" . $delimiter . "\r\n" .
                         "Authorization: Bearer $token\r\n",
            'method'  => 'POST',
            'content' => $postDataString,
        ],
    ];
    $context  = stream_context_create($options);
    $result = file_get_contents($api_url, false, $context);
    $response = json_decode($result, true);

    if ($response && isset($response['success']) && $response['success']) {
        header('Location: forum.php');
        exit;
    } else {
        $error = 'Failed to post forum.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Retention</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="dist/font-awesome/css/font-awesome.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Syne:regular,600,700" media="all">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        @keyframes fadeOut {
            from { opacity: 1; }
            to { opacity: 0; }
        }
        .fade-out {
            animation: fadeOut 3s forwards;
        }
        /* Tambahkan CSS untuk mengubah warna teks pada table head dan isinya */
        .table thead th, .table tbody td {
            color: white;
        }
        body {
            font-family: 'Fira Code', monospace;
        }
        
    </style>
    </style>
</head>
<body style="background-color: #010314;">
    <?php include 'Components/main/navbar.php'; ?>
    

    <?php include 'Components/forum/forumcomponent.php'; ?>
    

    <?php include 'Components/main/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                document.querySelector('.alert').classList.add('fade-out');
            }, 3000);

            const searchButton = document.getElementById('search-button');
            const searchInput = document.getElementById('search-input');
            const tableBody = document.getElementById('forum-table-body');

            searchButton.addEventListener('click', function() {
                const query = searchInput.value.toLowerCase();
                const rows = tableBody.getElementsByTagName('tr');

                for (let i = 0; i < rows.length; i++) {
                    const title = rows[i].getElementsByTagName('td')[0].innerText.toLowerCase();
                    if (title.includes(query)) {
                        rows[i].style.display = '';
                    } else {
                        rows[i].style.display = 'none';
                    }
                }
            });

            searchInput.addEventListener('keyup', function(event) {
                if (event.key === 'Enter') {
                    searchButton.click();
                }
            });
        });
    </script>
</body>
</html>