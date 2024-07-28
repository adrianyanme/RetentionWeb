<?php include 'fetch_data.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Retention</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="dist/font-awesome/css/font-awesome.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Fira+Code:wght@400;600;700&display=swap" media="all">
    <style>
        body {
            font-family: 'Fira Code', monospace;
            background-color: #263238;
            color: white;
        }
        .search-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-image: url('assets/img/header.jpeg'); /* Ganti dengan path gambar background */
            background-size: cover;
            background-position: center;
            padding: 20px;
        }
        .search-box {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 20px;
            border-radius: 5px;
            display: flex;
            align-items: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 1000px; /* Atur lebar maksimum */
        }
        .search-box input {
            border: none;
            padding: 10px;
            border-radius: 5px 0 0 5px;
            flex: 1;
        }
        .search-box button {
            border: none;
            padding: 10px 20px;
            background-color: #d4af37;
            color: white;
            border-radius: 0 5px 5px 0;
            flex-shrink: 0;
        }
        @media (max-width: 768px) {
            .search-box {
                flex-direction: column;
                align-items: stretch;
            }
            .search-box input, .search-box button {
                border-radius: 5px;
                margin: 5px 0;
            }
            .search-box button {
                border-radius: 5px;
            }
        }
    </style>
</head>
<body>
    <?php include 'Components/main/navbar.php'; ?>
    <main>
        <div class="search-container">
            <div class="text-center">
                <h1>JARINGAN DOKUMENTASI DAN INFORMASI HUKUM</h1>
                <h2>MAHKAMAH AGUNG RI</h2>
                <div class="search-box mt-4">
                    <form method="GET" action="resultjdh.php" style="display: flex; width: 100%;">
                        <input type="text" name="keyword" class="form-control" placeholder="Cari produk hukum?">
                        <button type="submit" class="btn-warning">Cari</button>
                    </form>
                </div>
            </div>
        </div>
    </main>
    <?php include 'Components/main/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/bold-and-dark.js"></script>
</body>
</html>