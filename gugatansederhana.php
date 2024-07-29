<?php
include "fetch_data.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $url = 'http://143.198.218.9:30000/api/gugatansederhana';
    $token = $_SESSION['token']; // Ambil token dari session

    $data = [
        'email' => $_POST['email'],
        'nohp' => $_POST['nohp'],
        'nama_pengugat' => $_POST['nama_pengugat'],
        'nama_tergugat' => $_POST['nama_tergugat'],
        'penjelasan' => $_POST['penjelasan'],
        'tuntutan_pengugat' => $_POST['tuntutan_pengugat'],
        'lampiran' => new CURLFile($_FILES['lampiran']['tmp_name'], $_FILES['lampiran']['type'], $_FILES['lampiran']['name'])
    ];

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer ' . $token,
        'Content-Type: multipart/form-data'
    ]);

    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($http_code == 200) {
        echo "<script>alert('Form berhasil dikirim!');</script>";
    } else {
        echo "<script>alert('Terjadi kesalahan: ' . $response);</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gugatan Sederhana</title>
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
        .register-container {
            display: flex;
            background: rgba(255, 255, 255, 0.1);
            padding: 30px;
            border-radius: 15px;
            max-width: 1400px; /* Perlebar kontainer */
            width: 100%;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .posbakum-form {
            flex: 1;
            margin-left: 20px;
        }
        .posbakum-form input, .posbakum-form button, .posbakum-form textarea {
            margin-bottom: 15px;
        }
        .requirements {
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
        <h2>Gugatan Sederhana</h2>
        <p>Formulir Pengajuan Gugatan Sederhana</p>
    </div>
    <main>
        <div class="register-container text-white">
            <div class="requirements">
                <p class="mt-3 text-start">
                    KETENTUAN UMUM
                    <ul>
                        <li>Berdasarkan Peraturan Mahkamah Agung Republik Indonesia Nomor 2 Tahun 2015 Tentang Tata Cara Penyelesaian Gugatan Sederhana yang telah dirubah dengan Peraturan Mahkamah Agung Republik Indonesia Nomor 4 Tahun 2019, yang dimaksud dengan Penyelesaian Gugatan Sederhana adalah tata cara pemeriksaan di persidangan terhadap gugatan perdata dengan nilai gugatan materil paling banyak Rp. 500.000.000,00 (lima ratus juta rupiah) yang diselesaikan dengan tata cara dan pembuktiannya sederhana. Gugatan sederhana diajukan terhadap perkara cidera janji dan/atau perbuatan melawan hukum dengan waktu penyelesaian gugatan sederhana paling lama 25 (dua puluh lima) hari sejak hari sidang pertama. Adapun yang tidak termasuk dalam gugatan sederhana ini adalah </li>
                        <li>Perkara yang penyelesaian sengketanya dilakukan melalui pengadilan khusus sebagaimana diatur di dalam peraturan perundang-undangan; atau sengketa hak atas tanah.</li>
                    </ul>
                    Berikut adalah ketentuan bagi para pihak gugatan sederhana :
                    <ul>
                        <li>Para pihak dalam gugatan sederhana terdiri dari penggugat dan tergugat yang masing-masing tidak boleh lebih dari satu, kecuali memiliki kepentingan hukum yang sama.</li>
                        <li>Terhadap tergugat yang tidak diketahui tempat tinggalnya, tidak dapat diajukan gugatan sederhana.</li>
                        <li>Penggugat dan tergugat dalam gugatan sederhana berdomisili di daerah hukum Pengadilan yang sama</li>
                        <li>Penggugat dan tergugat wajib menghadiri secara langsung setiap persidangan dengan atau tanpa didampingi oleh kuasa hukum</li>
                    </ul>
                    Adapun yang harus di siapkan :
                    <ul>
                        <li>Identitas penggugat dan tergugat;</li>
                        <li>Penjelasan ringkas duduk perkara; dan</li>
                        <li>Tuntutan penggugat</li>
                    </ul>
                </p>
            </div>
            <div class="posbakum-form text-center">
                <h2>Gugatan Sederhana Langsung</h2>
                <form class="text-start" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="text" id="email" name="email" class="form-control" placeholder="Email" required>
                    </div>
                    <div class="mb-3">
                        <label for="no-handphone" class="form-label">No Handphone (Whatsapp Active)</label>
                        <input type="text" id="no-handphone" name="nohp" class="form-control" placeholder="No Handphone (Whatsapp Active)" required>
                    </div>
                    <div class="mb-3">
                        <label for="nama-pengugat" class="form-label">Nama Pengugat</label>
                        <input type="text" id="nama-pengugat" name="nama_pengugat" class="form-control" placeholder="Nama Pengugat" required>
                    </div>
                    <div class="mb-3">
                        <label for="nama-tergugat" class="form-label">Nama Tergugat</label>
                        <input type="text" id="nama-tergugat" name="nama_tergugat" class="form-control" placeholder="Nama Tergugat" required>
                    </div>
                    <div class="mb-3">
                        <label for="penjelasan" class="form-label">Penjelasan</label>
                        <textarea id="penjelasan" name="penjelasan" class="form-control" placeholder="Penjelasan" rows="5" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="tuntutan-pengugat" class="form-label">Tuntutan Pengugat</label>
                        <input type="text" id="tuntutan-pengugat" name="tuntutan_pengugat" class="form-control" placeholder="Tuntutan Pengugat" required>
                    </div>
                    <!-- File picker input -->
                    <div class="mb-3">
                        <label for="lampiran" class="form-label">Lampiran</label>
                        <input type="file" id="lampiran" name="lampiran" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-warning w-100">SUBMIT</button>
                </form>
            </div>
        </div>
    </main>
    <?php include 'Components/main/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>