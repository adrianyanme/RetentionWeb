<?php
include "fetch_data.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $url = 'http://143.198.218.9:8000/api/posbakum';
    $token = $_SESSION['token']; // Ambil token dari session

    $data = [
        'namalengkap' => $_POST['namalengkap'],
        'nohp' => $_POST['nohp'],
        'email' => $_POST['email'],
        'deskribsi' => $_POST['deskribsi'],
        'suratgugatan' => new CURLFile($_FILES['suratgugatan']['tmp_name'], $_FILES['suratgugatan']['type'], $_FILES['suratgugatan']['name']),
        'suratketerangantidakmampu' => new CURLFile($_FILES['suratketerangantidakmampu']['tmp_name'], $_FILES['suratketerangantidakmampu']['type'], $_FILES['suratketerangantidakmampu']['name'])
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
    <title>Pos Bantuan Hukum</title>
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
            background-image: url('assets/img/header.jpeg');
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
        <h2>Pos Bantuan Hukum</h2>
        <p>Bantuan Hukum Digital</p>
    </div>
    <main>
        <div class="register-container text-white">
            <div class="requirements">
                <p class="mt-3 text-start">
                    Lengkapi Syaratnya, lampirkan:
                    <ul>
                        <li>Surat Gugatan / Surat Permohonan</li>
                        <li>Surat Keterangan Tidak Mampu (SKTM) dari Lurah / Kepala Desa, atau Surat Keterangan Tunjungan Sosial lainnya seperti Kartu Keluarga Miskin (KKM), Kartu Jaminan Kesehatan Masyarakat (JAMKESMAS), Kartu Program Keluarga Harapan (PKH), Kartu Bantuan Langsung Tunai (BLT) atau</li>
                        <li>Surat Pernyataan tidak mampu yang ditandatangani Pemohon dan Ketua Pengadilan Negeri</li>
                    </ul>
                    Dapatkan layanan-layanannya:
                    <ul>
                        <li>Konsultasi hukum untuk berbagai perkara</li>
                        <li>Penulisan dokumen hukum (misalnya: gugatan)</li>
                        <li>Bantuan untuk memperoleh layanan pengacara / advokat (untuk mewakili, mendampingi, membela, dan melakukan tindakan hukum lain sesuai kepentingan pemohon bantuan hukum)</li>
                        <li>Bantuan untuk memperoleh pembebasan biaya perkara</li>
                    </ul>
                </p>
            </div>
            <div class="posbakum-form text-center">
                <h2>Pos Bantuan Hukum</h2>
                <form class="text-start" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="nama-lengkap" class="form-label">Nama Lengkap</label>
                        <input type="text" id="nama-lengkap" name="namalengkap" class="form-control" placeholder="Nama Lengkap" required>
                    </div>
                    <div class="mb-3">
                        <label for="no-handphone" class="form-label">No Handphone (Whatsapp Active)</label>
                        <input type="text" id="no-handphone" name="nohp" class="form-control" placeholder="No Handphone (Whatsapp Active)" required>
                    </div>
                    <div class="mb-3">
                        <label for="alamat-email" class="form-label">Alamat Email</label>
                        <input type="email" id="alamat-email" name="email" class="form-control" placeholder="Alamat Email" required>
                    </div>
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <textarea id="deskripsi" name="deskribsi" class="form-control" placeholder="Deskripsi" rows="5" required></textarea>
                    </div>
                    <!-- File picker input -->
                    <div class="mb-3">
                        <label for="surat-gugatan" class="form-label">Surat Gugatan</label>
                        <input type="file" id="surat-gugatan" name="suratgugatan" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="surat-keterangan" class="form-label">Surat Keterangan Tidak Mampu</label>
                        <input type="file" id="surat-keterangan" name="suratketerangantidakmampu" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">SUBMIT</button>
                </form>
            </div>
        </div>
    </main>
    <?php include 'Components/main/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>