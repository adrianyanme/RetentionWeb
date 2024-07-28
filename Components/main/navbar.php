<nav class="navbar navbar-expand-lg navbar-light sticky-top" style="background-color: rgba(38, 50, 56, 0.5); margin-bottom: 0; backdrop-filter: blur(10px);">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold d-flex align-items-center" href="#">
            <span class="text-warning">Retention</span>
            <div class="vr mx-2 text-white"></div>
            <div class="d-flex flex-column text-secondary">
                <span class="text-white">Digital</span>
                <span class="text-white">Pengadilan</span>
            </div>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav ms-auto me-2 mb-2 mb-lg-0">
                <li class="nav-item active">
                    <a class="nav-link active text-white" href="./index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="./newforum.php">Forum</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="./newstreaming.php">Streaming</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="./jdh.php">Jaringan Dokumentasi Hukum</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-white" href="javascript:void(0)" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Permohonan dan Laporan
                    </a>
                    <ul class="dropdown-menu " aria-labelledby="navbarDropdownMenuLink" style="background-color:#424242">
                        <li><a class="dropdown-item text-white" href="./posbakum.php">Pos Bantuan Hukum</a></li>
                        <li><a class="dropdown-item text-white" href="./layananpengaduan.php">Layanan Pengaduan Online</a></li>
                        <li><a class="dropdown-item text-white" href="./gugatansederhana.php">Gugatan Sederhana Langsung</a></li>
                        <li><a class="dropdown-item text-white" href="./salinanputusan.php">Permohonan Salinan Putusan</a></li>
                    </ul>
                </li>
            </ul>
            <?php if (isset($_SESSION['token']) && isset($response_data['username'])): ?>
                <span class="navbar-text text-warning me-3">Hello, <?php echo htmlspecialchars($response_data['username']); ?></span>
                <a href="logout.php" class="btn btn-danger d-flex align-items-center">Logout <span class="ms-2"></span></a>
            <?php else: ?>
                <a href="login.php" class="btn btn-success d-flex align-items-center">Login <span class="ms-2"></span></a>
            <?php endif; ?>
        </div>
    </div>
</nav>