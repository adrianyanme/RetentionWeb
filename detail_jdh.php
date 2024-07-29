<?php
// Ambil ID dari URL
$id = isset($_GET['id']) ? $_GET['id'] : null;

if ($id) {
    // Panggil API untuk mendapatkan detail data berdasarkan ID
    $apiUrl = 'http://143.198.218.9:30000/api/jdh/' . $id;
    $jsonData = file_get_contents($apiUrl);
    $data = json_decode($jsonData, true)['data'];
} else {
    echo "ID tidak ditemukan.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Dokumen</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@100..900&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto Slab', monospace;
            background-color: #263238;
            color: #fff;
        }
        .pdf {
        width: 100%;
        aspect-ratio: 4 / 3;
    }

    .pdf,
    html,
    body {
        height: 100%;
        margin: 0;
        padding: 0;
    }

        .container {
            margin-top: 20px;
        }

        .card-header {
            background-color: #592DD1;
            color: #fff;
            font-weight: bold;
            text-align: center;
            padding: 10px;
        }

        .card-body {
            background-color: rgba(255, 255, 255, 0.1);
            padding: 20px;
        }

        .card-body p {
            background-color: rgba(255, 255, 255, 0.1);
            margin: 0;
        }

        .card-body .row {
            margin-bottom: 10px;
        }

        .btn-download {
            background-color: #592DD1;
            color: #fff;
            border: none;
            padding: 10px 20px;
            text-align: center;
            display: inline-block;
            font-size: 16px;
            margin-top: 20px;
            cursor: pointer;
        }

        .btn-download:hover {
            background-color: #c39b2e;
        }

        .table {
            width: 100%;
            margin-bottom: 1rem;
            background-color: rgba(255, 255, 255, 0.1); /* Ubah warna tabel menjadi hitam */
        }

        .table th,
        .table td {
            padding: 0.75rem;
            vertical-align: top;
            border-top: 1px solid #dee2e6;
            color: #fff; /* Ubah warna teks menjadi putih agar terlihat di latar belakang hitam */
            background-color: #010314; /* Ubah warna latar belakang sel menjadi hitam */
        }

        .table thead th {
            vertical-align: bottom;
            border-bottom: 2px solid #dee2e6;
            color: #fff; /* Ubah warna teks menjadi putih agar terlihat di latar belakang hitam */
            background-color: #010314; /* Ubah warna latar belakang header menjadi hitam */
        }

        .table tbody+tbody {
            border-top: 2px solid #dee2e6;
            background-color: #010314; /* Ubah warna tabel menjadi hitam */
        }

        .table .table {
            background-color: #010314; /* Ubah warna tabel menjadi hitam */
        }

        .table-bordered {
            border: 1px solid #dee2e6;
        }

        .table-bordered th,
        .table-bordered td {
            border: 1px solid #dee2e6;
        }

        .table-bordered thead th,
        .table-bordered thead td {
            border-bottom-width: 2px;
        }

        .preview-file {
            text-align: center;
            margin-top: 20px;
        }

        .preview-file img {
            max-width: 100%;
            height: auto;
        }

        .related-docs {
            margin-top: 20px;
        }

        .related-docs h5 {
            background-color: #d4af37;
            color: #fff;
            padding: 10px;
            text-align: center;
        }

        .related-docs p {
            text-align: center;
            margin-top: 10px;
        }
    </style>
</head>

<body>
<?php include 'Components/main/navbar.php'; ?>
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="card" style="background-color: #010314;">
                    <div class="card-header">
                        <?php echo htmlspecialchars($data['judul']); ?>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th>Deskripsi</th>
                                    <td><?php echo htmlspecialchars($data['deskripsi']); ?></td>
                                </tr>
                                <tr>
                                    <th>Nomor</th>
                                    <td><?php echo htmlspecialchars($data['nomor']); ?></td>
                                </tr>
                                <tr>
                                    <th>Tahun</th>
                                    <td><?php echo htmlspecialchars($data['tahun']); ?></td>
                                </tr>
                                <tr>
                                    <th>Kategori Dokumen</th>
                                    <td><?php echo htmlspecialchars($data['kategoridokumen']); ?></td>
                                </tr>
                                <tr>
                                    <th>Jenis</th>
                                    <td><?php echo htmlspecialchars($data['jenis']); ?></td>
                                </tr>
                                <tr>
                                    <th>Tanggal Ditetapkan</th>
                                    <td><?php echo htmlspecialchars($data['tanggalditetapkan']); ?></td>
                                </tr>
                                <tr>
                                    <th>Tanggal Diundangkan</th>
                                    <td><?php echo htmlspecialchars($data['tanggaldiundangkan']); ?></td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td><?php echo htmlspecialchars($data['status']); ?></td>
                                </tr>
                                <tr>
                                    <th>Sumber</th>
                                    <td><?php echo htmlspecialchars($data['sumber']); ?></td>
                                </tr>
                                <tr>
                                    <th>Keterangan</th>
                                    <td><?php echo htmlspecialchars($data['keterangan']); ?></td>
                                </tr>
                            </tbody>
                        </table>
                        <a href="http://143.198.218.9:30000/storage/jdh/<?php echo htmlspecialchars($data['lampiran']); ?>" class="btn-download" download>Download</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="preview-file">
                    <h5>Preview File</h5>
                    <embed class="pdf" src="http://143.198.218.9:30000/storage/jdh/<?php echo htmlspecialchars($data['lampiran']); ?>" width="800" height="500">
                   
                <div class="related-docs">
                    <h5>Produk Hukum Terkait</h5>
                    <p>Tidak ada produk hukum terkait</p>
                </div>
            </div>
        </div>
    </div>
</body>

</html>