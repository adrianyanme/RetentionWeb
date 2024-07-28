<?php include 'fetch_data.php'; ?>

<?php
// Mengambil data dari API
$api_url = 'http://143.198.218.9:8000/api/streaming';
$response = file_get_contents($api_url);
$data = json_decode($response, true);
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
        .header {
            background-image: url('https://th.bing.com/th/id/R.96525332caecb290910d28ebe289e5fe?rik=1IsDNYAEaEoumA&riu=http%3a%2f%2fwww.origiin.com%2fbin2017%2fwp-content%2fuploads%2f2018%2f09%2flaw-colleges-banner.jpg&ehk=P%2fKdeZUaDvgaOCO2PUHBgWlX5GI7BP4vHvPn4IcCXeY%3d&risl=&pid=ImgRaw&r=0'); /* Ganti dengan path gambar latar belakang Anda */
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
        .search-bar {
            max-width: 600px;
            margin: 0 auto;
        }
        .video-list {
            margin-top: 2rem;
            background-color: #263238; /* Warna background yang lebih gelap */
            padding: 20px;
            border-radius: 10px;
        }
        .video-item {
            background-color: #37474F; /* Warna background item video */
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            cursor: pointer;
        }
        .video-item img {
            max-width: 150px;
            margin-right: 20px;
            border-radius: 10px;
        }
        .video-item .content {
            flex-grow: 1;
        }
        .video-item .tags {
            margin-top: 10px;
        }
        .video-item .tags .badge {
            margin-right: 5px;
        }
        .video-item .stats {
            display: flex;
            align-items: center;
            margin-top: 10px;
        }
        .video-item .stats .stat {
            margin-right: 15px;
            display: flex;
            align-items: center;
        }
        .video-item .stats .stat i {
            margin-right: 5px;
        }
        .video-item .time {
            text-align: right;
            color: gray;
        }
        @media (max-width: 768px) {
            .header h1 {
                font-size: 2rem;
            }
            .header p {
                font-size: 1rem;
            }
            .video-item {
                flex-direction: column;
                text-align: center;
            }
            .video-item img {
                margin-bottom: 10px;
            }
            .video-item .time {
                text-align: center;
                margin-top: 10px;
            }
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            var data = <?= json_encode($data['data']) ?>;

            function renderVideos(videos) {
                var videoList = $('.video-list');
                videoList.empty();

                // Pisahkan video berdasarkan status
                var onAirVideos = videos.filter(video => video.status_stream === 'On Air');
                var offAirVideos = videos.filter(video => video.status_stream === 'Off Air');

                // Gabungkan kembali dengan On Air di atas
                var sortedVideos = [...onAirVideos, ...offAirVideos];

                sortedVideos.forEach(function(video) {
                    var badgeClass = video.status_stream === 'On Air' ? 'bg-danger' : 'bg-secondary';
                    var videoItem = `
                        <div class="video-item" data-id="${video.id}">
                            <img src="http://127.0.0.1:8000/storage/thumbnails/${video.thumbnail}" alt="Video Thumbnail">
                            <div class="content">
                                <h5>${video.judul_streaming}</h5>
                                <div class="stats">
                                    <div class="stat">${video.deskribsi}</div>
                                </div>
                            </div>
                            <div class="tags">
                                <span class="badge ${badgeClass}">${video.status_stream}</span>
                            </div>
                        </div>
                    `;
                    videoList.append(videoItem);
                });
            }

            renderVideos(data);

            $('#search-button').click(function() {
                var searchQuery = $('#search-input').val().toLowerCase();
                var filteredData = data.filter(function(item) {
                    return item.judul_streaming.toLowerCase().includes(searchQuery) || item.deskribsi.toLowerCase().includes(searchQuery);
                });
                renderVideos(filteredData);
            });

            $(document).on('click', '.video-item', function() {
                var videoId = $(this).data('id');
                window.location.href = 'detail_stream.php?id=' + videoId;
            });
        });
    </script>
</head>

<body>
<?php include 'Components/main/navbar.php'; ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="header">
                    <h1 class="text-warning">Stream</h1>
                    <p>Watch and Learn</p>
                    <div class="search-bar">
                        <div class="input-group">
                            <input type="text" id="search-input" class="form-control" placeholder="Cari..">
                            <button class="btn btn-primary" id="search-button" type="button">Search</button>
                        </div>
                    </div>
                </div>
                <div class="video-list">
                    <!-- Video items will be appended here by jQuery -->
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
<?php include 'Components/main/footer.php'; ?>

</html>