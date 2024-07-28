<?php
include "fetch_data.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $url = 'http://143.198.218.9:8000/api/persalinan';
    $token = $_SESSION['token']; // Ambil token dari session

    $data = [
        'email' => $_POST['email'],
        'jenissalinan' => $_POST['jenissalinan'],
        'putusanyangdiminta' => $_POST['putusanyangdiminta'],
        'namapemohon' => $_POST['namapemohon'],
        'nohp' => $_POST['nohp'],
        'statuspemohon' => $_POST['statuspemohon'],
        'noperkara' => $_POST['noperkara'],
        'namaparapihak' => $_POST['namaparapihak'],
        'catatanpemohon' => $_POST['catatanpemohon']
    ];

    // Handle file uploads
    $files = [
        'ktppemohon' => new CURLFile($_FILES['ktppemohon']['tmp_name'], $_FILES['ktppemohon']['type'], $_FILES['ktppemohon']['name']),
        'kkpemohon' => new CURLFile($_FILES['kkpemohon']['tmp_name'], $_FILES['kkpemohon']['type'], $_FILES['kkpemohon']['name']),
        'relaaspemberitahuanputusan' => new CURLFile($_FILES['relaaspemberitahuanputusan']['tmp_name'], $_FILES['relaaspemberitahuanputusan']['type'], $_FILES['relaaspemberitahuanputusan']['name'])
    ];

    $postData = array_merge($data, $files);

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
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
    <title>Permohonan Salinan Putusan</title>
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
            margin-bottom: 50px;
        }

        .container {
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            display: flex;
            max-width: 900px;
            width: 100%;
            overflow: hidden;
            margin: auto;
            margin-bottom: 50px;
        }

        .sidebar {
            background-color: #263238;
            padding: 30px;
            width: 250px;
            border-radius: 10px;
        }

        .sidebar .step {
            margin-bottom: 20px;
        }

        .sidebar .step.active {
            font-weight: bold;
        }

        .sidebar .step span {
            display: block;
            font-size: 1.2rem;
        }

        .form-container {
            padding: 30px;
            flex: 1;
        }

        .form-container h2 {
            margin-bottom: 20px;
            font-size: 1.5rem;
            color: #4834d4;
        }

        .form-container p {
            margin-bottom: 30px;
            color: #666;
        }

        .form-container .form-group {
            margin-bottom: 20px;
        }

        .form-container .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
        }

        .form-container .form-group input,
        .form-container .form-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .form-container .form-group input:focus,
        .form-container .form-group select:focus {
            border-color: #4834d4;
            outline: none;
        }

        .form-container .btn {
            background-color: #4834d4;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .form-container .btn:hover {
            background-color: #341f97;
        }

        .form-container .btn:disabled {
            background-color: #ccc;
            cursor: not-allowed;
        }

        .step {
            display: none;
        }

        .step.active {
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

        .custom-footer {
            background-color: #4834d4;
            color: white;
            text-align: center;
            padding: 10px 0;
            position: relative;
            bottom: 0;
            width: 100%;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <?php include 'Components/main/navbar.php'; ?>
    <div class="page-header">
        <h2>Permohonan Salinan Putusan</h2>
        <p>Formulir Permohonan Salinan Putusan</p>
    </div>
    <div class="container">
        <div class="sidebar">
            <div class="step step-1 active">
                <span>STEP 1</span>
                Formulir Perdata
            </div>
            <div class="step step-2">
                <span>STEP 2</span>
                Identitas Pemohon
            </div>
            <div class="step step-3">
                <span>STEP 3</span>
                Dokument Persyaratan
            </div>
            <div class="step step-4">
                <span>STEP 4</span>
                TAHAPAN TERAKHIR
            </div>
        </div>
        <div class="form-container">

            <form method="POST" enctype="multipart/form-data">
                <div class="step step-1 active">
                    <h2 class="text-warning">Formulir Perdata</h2>
                    <p class="text-white">Layanan ini merupakan inovasi dalam meningkatkan kualitas dan mutu pelayanan kepada Masyarakat Pencari Keadilan. Di era Pandemi Covid-19 kami membantu pemerintah untuk memutus mata rantai penyebaran, untuk itu layanan digital sangat diperlukan dalam menghindari kontak fisik dan mengurangi mobilitas Pengguna layanan. </p>
                    <div class="form-group">
                        <label for="email" class="text-warning">Email Address</label>
                        <p class="text-white">Pastikan menggunakan email aktif, pemberitahuan akan di kirimkan melalui E-Mail anda</p>
                        <input type="email" id="email" name="email" placeholder="e.g. stephenking@lorem.com" required>
                    </div>

                    <div class="form-group">
                        <label for="jenissalinan" class="text-warning">Jenis Salinan</label>
                        <p class="text-white">Salinan Putusan yang dapat diterbitkan melalui layanan ini adalah Perkara yang dalam proses persidangan tidak menggunakan layanan e-Litigasi.</p>
                        <select id="jenissalinan" name="jenissalinan" class="form-select" required>
                            <option value="" disabled selected>Pilih Jenis Salinan</option>
                            <option value="Putusan Perdata Gugatan">Putusan Perdata Gugatan</option>
                            <option value="Putusan Perdata Gugatan Sederhana">Putusan Perdata Gugatan Sederhana</option>
                            <option value="Putusan Perdata Permohonan">Putusan Perdata Permohonan</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="putusanyangdiminta" class="text-warning">Putusan Yang Diminta</label>
                        <p class="text-white">Salinan Putusan yang dapat diterbitkan melalui layanan ini adalah Perkara yang dalam proses persidangan tidak menggunakan layanan e-Litigasi.</p>
                        <select id="putusanyangdiminta" name="putusanyangdiminta" class="form-select" required>
                            <option value="" disabled selected>Pilih Jenis Putusan</option>
                            <option value="Tingkat Pertama (PN)">Tingkat Pertama (PN)</option>
                            <option value="Keberatan">Keberatan</option>
                            <option value="Banding">Banding</option>
                            <option value="Kasasi">Kasasi</option>
                            <option value="Peninjauan Kembali">Peninjauan Kembali</option>
                        </select>
                    </div>
                </div>
                <div class="step step-2">
                    <h2 class="text-warning">Identitas Pemohon</h2>
                    <p class="text-white">Isikan data secara benar, segala sesuatu pengisian yang tidak berdasar dapat dikenai sanksi hukum sesuai peraturan Perundang - undangan.</p>
                    <div class="form-group">
                        <label for="namapemohon" class="text-warning">Nama Pemohon</label>
                        <input type="text" id="namapemohon" name="namapemohon" placeholder="e.g. Stephen King" required>
                    </div>
                    <div class="form-group">
                        <label for="nohp" class="text-warning">Nomor Handphone</label>
                        <p class="text-white">awali dengan +62 sebagai pengganti angka 0</p>
                        <input type="text" id="nohp" name="nohp" placeholder="e.g. +1 234 567 890" required>
                    </div>
                    <div class="form-group">
                        <label for="statuspemohon" class="text-warning">Status Pemohon</label>
                        <select id="statuspemohon" name="statuspemohon" class="form-select" required>
                            <option value="" disabled selected>Pilih Status Pemohon</option>
                            <option value="Pengugat/Pemohon/Pelawan">Pengugat/Pemohon/Pelawan</option>
                            <option value="Tergugat/Termohon/Terlawan">Tergugat/Termohon/Terlawan</option>
                            <option value="Kuasa Penggugat/Pemohon/Pelawan">Kuasa Penggugat/Pemohon/Pelawan</option>
                            <option value="Kuasa tergugat/Termohon/Terlawan">Kuasa tergugat/Termohon/Terlawan</option>
                            <option value="Turut Tergugat/ Turut Termohon/Turut Terlawan">Turut Tergugat/ Turut Termohon/Turut Terlawan</option>
                            <option value="Kuasa Turut tergugat">Kuasa Turut Tergugat</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="noperkara" class="text-warning">Nomor Perkara</label>
                        <p class="text-white">Contoh : 1/Pdt.G/2021/PN Sby (untuk putusan perkara PN) | 1/Pdt.G/2021/PN Sby Jo 1/PDT/2021/PT SBY (untuk putusan perkara banding) | 1/Pdt.G/2021/PN Sby Jo 1/PDT/2021/PT SBY Jo 1 K/PDT/2021 (untuk putusan perkara kasasi) dst</p>
                        <input type="text" id="noperkara" name="noperkara" placeholder="Nomor Perkara" required>
                    </div>
                    <div class="form-group">
                        <label for="namaparapihak" class="text-warning">Nama Para Pihak</label>
                        <p class="text-white">Contoh : Indra Ari Melawan Wahyu Putra</p>
                        <input type="text" id="namaparapihak" name="namaparapihak" placeholder="Nama Para Pihak" required>
                    </div>

                </div>
                <div class="step step-3">
                    <h2 class="text-warning">UPLOAD DOKUMEN PERSYARATAN</h2>
                    <p class="text-white">Dokumen Persyaratan Bagi Prinsipal</p>
                    <div class="form-group">
                        <label for="ktppemohon" class="text-warning">Upload Kartu Tanda Penduduk (KTP)</label>
                        <p class="text-white">Dokumen dapat berupa file .pdf atau Foto</p>
                        <input type="file" id="ktppemohon" name="ktppemohon" accept=".pdf,.png,.jpg,.jpeg" required>
                    </div>
                    <div class="form-group">
                        <label for="kkpemohon" class="text-warning">Kartu Keluarga (kk)</label>
                        <p class="text-white">Dokumen dapat berupa file .pdf atau Foto</p>
                        <input type="file" id="kkpemohon" name="kkpemohon" accept=".pdf,.png,.jpg,.jpeg" required>
                    </div>
                    <div class="form-group">
                        <label for="relaaspemberitahuanputusan" class="text-warning">Relaas Pemberitahuan Putusan</label>
                        <p class="text-white">Persyaratan ini hanya berlaku untuk permohonan salinan putusan banding/kasasi/PK. Dokumen dapat berupa file .pdf atau Foto</p>
                        <input type="file" id="relaaspemberitahuanputusan" name="relaaspemberitahuanputusan" accept=".pdf,.png,.jpg,.jpeg" required>
                    </div>


                </div>
                <div class="step step-4">
                    <h2 class="text-warning">TAHAPAN TERAKHIR</h2>
                    <p class="text-white">Pastikan data anda telah terekam dengan benar pada form ini.</p>
                    <div class="form-group">
                        <label for="catatanpemohon" class="text-warning">Catatan Pemohon</label>
                        <textarea id="catatanpemohon" name="catatanpemohon" placeholder="Catatan Pemohon" rows="5" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;" required></textarea>
                    </div>
                </div>
                <div class="step-buttons">
                    <button type="button" class="btn prev-step" disabled>Previous</button>
                    <button type="button" class="btn next-step">Next Step</button>
                    <button type="submit" class="btn submit-form" style="display: none;">Submit</button>
                </div>
            </form>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            let currentStep = 1;
            const totalSteps = 4;

            function showStep(step) {
                $('.step').removeClass('active');
                $('.step-' + step).addClass('active');
                $('.sidebar .step').removeClass('active');
                $('.sidebar .step-' + step).addClass('active');
                if (step === 1) {
                    $('.prev-step').attr('disabled', true);
                } else {
                    $('.prev-step').attr('disabled', false);
                }
                if (step === totalSteps) {
                    $('.next-step').hide();
                    $('.submit-form').show();
                } else {
                    $('.next-step').show();
                    $('.submit-form').hide();
                }
            }

            $('.next-step').click(function() {
                if (currentStep < totalSteps) {
                    currentStep++;
                    showStep(currentStep);
                }
            });

            $('.prev-step').click(function() {
                if (currentStep > 1) {
                    currentStep--;
                    showStep(currentStep);
                }
            });

            showStep(currentStep);
        });
    </script>
</body>

</html>