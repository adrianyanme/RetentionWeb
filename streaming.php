<?php
include 'fetch_data.php';
// Ambil data dari API
$apiUrl = "http://143.198.218.9:30000/api/streaming";
$response = file_get_contents($apiUrl);
$data = json_decode($response, true);
$streams = $data['data'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Streaming Page</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="dist/font-awesome/css/font-awesome.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;400;600&display=swap" rel="stylesheet">
    <style>
        .stream-item {
            display: flex;
            align-items: flex-start; /* Ubah dari center ke flex-start */
            margin-bottom: 20px;
            text-decoration: none;
            color: inherit;
        }
        .stream-item img {
            width: 25%;
            height: 25%;
            object-fit: cover;
            margin-right: 20px;
            border-radius: 10px;
        }
        .stream-info {
            display: flex;
            flex-direction: column;
        }
        .stream-title {
            font-size: 1.2em;
            font-weight: bold;
        }
        .stream-status {
            font-size: 1em;
        }
        .stream-status.on-air {
            color: red;
        }
        .stream-status.off-air {
            color: green;
        }
        .stream-description { /* Tambahkan style untuk deskripsi */
            font-size: 0.9em;
            color: #555;
        }
        .container-custom {
            margin-left: 5%;
            /* padding-left: 10%; */
        }
        body {
            font-family: 'Fira Code', monospace;
        }
    </style>
</head>
<body style="background-color: #010314;">
<?php include 'Components/main/navbar.php'; ?>
<div class="container mt-5">
    <div class="mb-4">
        <input type="text" id="searchInput" class="form-control" placeholder="Cari streaming...">
    </div>
</div>
<div class="container mt-5 container-custom">
    <!-- Tambahkan input pencarian -->
    
    <div id="streamList">
        <?php 
        $onAirStreams = array_filter($streams, function($stream) {
            return $stream['status_stream'] == 'On Air';
        });
        $offAirStreams = array_filter($streams, function($stream) {
            return $stream['status_stream'] != 'On Air';
        });
        ?>

        <?php foreach ($onAirStreams as $stream) { 
            $statusClass = 'on-air';
        ?>
            <a href="detail_stream.php?id=<?= $stream['id'] ?>" class="stream-item">
                <img src="http://127.0.0.1:8000/storage/thumbnails/<?= $stream['thumbnail'] ?>" alt="Stream Image">
                <div class="stream-info">
                    <div class="stream-title text-white"><?= $stream['judul_streaming'] ?></div>
                    <div class="stream-status <?= $statusClass ?>"><?= $stream['status_stream'] ?></div>
                    <div class="stream-description text-white"><?= $stream['deskribsi'] ?></div>
                </div>
            </a>
        <?php } ?>

        <hr style="border-top: 2px solid #fff;">

        <?php foreach ($offAirStreams as $stream) { 
            $statusClass = 'off-air';
        ?>
            <a href="detail_stream.php?id=<?= $stream['id'] ?>" class="stream-item">
                <img src="http://127.0.0.1:8000/storage/thumbnails/<?= $stream['thumbnail'] ?>" alt="Stream Image">
                <div class="stream-info">
                    <div class="stream-title text-white"><?= $stream['judul_streaming'] ?></div>
                    <div class="stream-status <?= $statusClass ?>"><?= $stream['status_stream'] ?></div>
                    <div class="stream-description text-white"><?= $stream['deskribsi'] ?></div>
                </div>
            </a>
        <?php } ?>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script>
    $(document).ready(function() {
        $('#searchInput').on('keyup', function() {
            var value = $(this).val().toLowerCase();
            $('#streamList .stream-item').filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });
</script>
</body>
</html>