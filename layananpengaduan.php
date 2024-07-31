<?php
include "fetch_data.php";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $url = 'http://143.198.218.9/backend/api/layanan-pengaduan';
    $data = [
        'judullaporan' => $_POST['judullaporan'],
        'isilaporan' => $_POST['isilaporan'],
        'tanggalkejadian' => $_POST['tanggalkejadian'],
        'instansiterlapor' => $_POST['instansiterlapor'],
        'lampiran' => new CURLFile($_FILES['lampiran']['tmp_name'], $_FILES['lampiran']['type'], $_FILES['lampiran']['name'])
    ];

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpcode == 201) {
        echo "<script>alert('Laporan berhasil terkirim!');</script>";
    } else {
        echo "<script>alert('Terjadi kesalahan: ' + $response);</script>";
    }
}

// Cek apakah user terverifikasi
$isVerified = isset($response_data['verified']) && $response_data['verified'] === 'Yes';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Layanan Aspirasi dan Pengaduan Online Rakyat</title>
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
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        main {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            padding: 50px;
        }
        .form-container {
            display: flex;
            background: rgba(255, 255, 255, 0.1);
            padding: 30px;
            border-radius: 15px;
            max-width: 1400px; /* Perlebar kontainer */
            width: 100%;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .form-title {
            flex: 1;
            margin-left: 20px;
        }
        .form-title input, .form-title button, .form-title textarea {
            margin-bottom: 15px;
        }
        .form-group {
            flex: 1;
            color: white;
            font-size: 1.2rem; /* Perbesar teks */
        }
        .form-label {
            text-align: left;
            display: block;
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
        .page-header {
            background-image: url('https://th.bing.com/th/id/R.96525332caecb290910d28ebe289e5fe?rik=1IsDNYAEaEoumA&riu=http%3a%2f%2fwww.origiin.com%2fbin2017%2fwp-content%2fuploads%2f2018%2f09%2flaw-colleges-banner.jpg&ehk=P%2fKdeZUaDvgaOCO2PUHBgWlX5GI7BP4vHvPn4IcCXeY%3d&risl=&pid=ImgRaw&r=0');
            background-size: cover;
            background-position: center;
            padding: 60px 20px;
            text-align: center;
            color: white;
            margin-bottom: 30px;
        }
        .page-header h2 {
            font-size: 2.5rem;
            margin-bottom: 10px;
        }
        .page-header p {
            font-size: 1.2rem;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <?php include 'Components/main/navbar.php'; ?>
    <div class="page-header">
        <h2>Layanan Aspirasi dan Pengaduan Online Rakyat</h2>
        <p>Diskusi dan Pengaduan</p>
    </div>
    <main>
        <div class="form-container text-white">
            <div class="form-title">
                <h2>Pilih Klasifikasi Laporan</h2>
                <form class="text-start" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="judulLaporan" class="form-label">Ketik Judul Laporan Anda *</label>
                        <input type="text" id="judulLaporan" name="judullaporan" class="form-control" placeholder="Ketik Judul Laporan Anda" required>
                    </div>
                    <div class="mb-3">
                        <label for="isiLaporan" class="form-label">Ketik Isi Laporan Anda *</label>
                        <textarea id="isiLaporan" name="isilaporan" class="form-control" placeholder="Ketik Isi Laporan Anda" rows="5" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="tanggalKejadian" class="form-label">Pilih Tanggal Kejadian *</label>
                        <input type="date" id="tanggalKejadian" name="tanggalkejadian" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="instansiterlapor" class="form-label">Ketik Instansi Tujuan</label>
                        <input type="text" id="instansiterlapor" name="instansiterlapor" class="form-control" placeholder="Ketik Instansi Tujuan">
                    </div>
                    <div class="mb-3">
                        <label for="uploadLampiran" class="form-label">Upload Lampiran</label>
                        <input type="file" id="uploadLampiran" name="lampiran" class="form-control-file">
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <?php if ($isVerified) { ?>
                            <button type="submit" class="btn btn-danger">LAPOR!</button>
                        <?php } else { ?>
                            <p class="text-warning">Your account is not verified. Please verify your account to submit a report.</p>
                        <?php } ?>
                        <span class="ml-2">Laporan yang terkirim secara Anonim dan Rahasia.</span>
                    </div>
                </form>
            </div>
        </div>
    </main>
    <?php include 'Components/main/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>