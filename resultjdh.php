<?php include 'fetch_data.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Pencarian</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="dist/font-awesome/css/font-awesome.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Fira+Code:wght@400;600;700&display=swap" media="all">
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@100..900&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto Slab', monospace;
            background-color: #263238;
            color: #fff; /* Ubah warna teks menjadi putih */
        }
        .results-container {
            margin-top: 20px;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.1);
            color: #fff; /* Ubah warna teks menjadi putih */
            border-radius: 5px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 800px;
            margin-left: auto;
            margin-right: auto;
        }
        .result-item {
            margin-bottom: 20px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            color: #fff; /* Ubah warna teks menjadi putih */
            cursor: pointer; /* Tambahkan cursor pointer */
        }
        .result-item:hover {
            background-color: rgba(255, 255, 255, 0.2); /* Tambahkan efek hover */
        }
        .filter-container {
            margin-top: 20px;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.1);
            color: #fff; /* Ubah warna teks menjadi putih */
            border-radius: 5px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 300px;
            margin-left: auto;
            margin-right: auto;
        }
    </style>
</head>
<body>
    <?php include 'Components/main/navbar.php'; ?>
    <main class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="results-container">
                    <?php
                    if (isset($_GET['keyword'])) {
                        $keyword = strtolower($_GET['keyword']);
                        $apiUrl = 'http://143.198.218.9/backend/api/jdh';
                        $jsonData = file_get_contents($apiUrl);
                        $data = json_decode($jsonData, true)['data'];

                        $filteredData = array_filter($data, function($item) use ($keyword) {
                            return strpos(strtolower($item['judul']), $keyword) !== false || strpos(strtolower($item['deskripsi']), $keyword) !== false;
                        });

                        if (count($filteredData) > 0) {
                            echo '<p>Ditemukan ' . count($filteredData) . ' data</p>';
                            echo '<p>Hasil dari penelusuran : ' . htmlspecialchars($_GET['keyword']) . '</p>';
                            foreach ($filteredData as $item) {
                                echo '<div class="result-item" data-id="' . $item['id'] . '">';
                                echo '<h3>' . $item['judul'] . '</h3>';
                                echo '<p>' . $item['deskripsi'] . '</p>';
                                echo '<p><small>Created at: ' . date('d-m-Y', strtotime($item['created_at'])) . '</small></p>';
                                echo '</div>';
                            }
                        } else {
                            echo '<p>Tidak ada hasil yang ditemukan.</p>';
                        }
                    }
                    ?>
                </div>
            </div>
            <div class="col-md-4">
                <div class="filter-container">
                    <h5>Filter</h5>
                    <form>
                        <div class="mb-3">
                            <label for="keyword" class="form-label">Teks</label>
                            <input type="text" class="form-control" id="keyword" name="keyword" value="<?php echo isset($_GET['keyword']) ? htmlspecialchars($_GET['keyword']) : ''; ?>">
                        </div>
                        <div class="mb-3">
                            <label for="kategori" class="form-label">Kategori dokumen</label>
                            <div>
                                <input type="checkbox" id="kategori1" name="kategori[]" value="Produk Hukum di Mahkamah Agung">
                                <label for="kategori1">Produk Hukum di Mahkamah Agung</label>
                            </div>
                            <div>
                                <input type="checkbox" id="kategori2" name="kategori[]" value="Produk Hukum di Pengadilan">
                                <label for="kategori2">Produk Hukum di Pengadilan</label>
                            </div>
                            <div>
                                <input type="checkbox" id="kategori3" name="kategori[]" value="Artikel Hukum">
                                <label for="kategori3">Artikel Hukum</label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="jenis" class="form-label">Jenis dokumen</label>
                            <div>
                                <input type="checkbox" id="jenis1" name="jenis[]" value="Surat Keputusan Ketua Pengadilan">
                                <label for="jenis1">Surat Keputusan Ketua Pengadilan</label>
                            </div>
                            <div>
                                <input type="checkbox" id="jenis2" name="jenis[]" value="Putusan">
                                <label for="jenis2">Putusan</label>
                            </div>
                            <div>
                                <input type="checkbox" id="jenis3" name="jenis[]" value="Artikel Hukum">
                                <label for="jenis3">Artikel Hukum</label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="tahun" class="form-label">Tahun</label>
                            <div>
                                <input type="checkbox" id="tahun1" name="tahun[]" value="2024">
                                <label for="tahun1">2024</label>
                            </div>
                            <div>
                                <input type="checkbox" id="tahun2" name="tahun[]" value="2023">
                                <label for="tahun2">2023</label>
                            </div>
                            <div>
                                <input type="checkbox" id="tahun3" name="tahun[]" value="2022">
                                <label for="tahun3">2022</label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <div>
                                <input type="checkbox" id="status1" name="status[]" value="Aktif">
                                <label for="status1">Aktif</label>
                            </div>
                            <div>
                                <input type="checkbox" id="status2" name="status[]" value="Tidak Aktif">
                                <label for="status2">Tidak Aktif</label>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Filter</button>
                        <button type="reset" class="btn btn-secondary">Reset</button>
                    </form>
                </div>
            </div>
        </div>
    </main>
    <?php include 'Components/main/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.querySelectorAll('.result-item').forEach(item => {
            item.addEventListener('click', () => {
                const id = item.getAttribute('data-id');
                window.location.href = `detail_jdh.php?id=${id}`;
            });
        });
    </script>
</body>
</html>