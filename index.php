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
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Fira+Code:wght@400;600;700&display=swap" media="all">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@100..900&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto Slab', monospace;
        }

        .table thead th,
        .table tbody td .table tbody tr .table tbody td {
            color: white;
            /* Menambahkan warna putih untuk teks di dalam tabel */
        }
    </style>
    <!-- <link rel="stylesheet" href="styles.css"> -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body style="background-color: #263238;">
    <?php include 'Components/main/navbar.php'; ?>
    <header class="bg-dark">
        <div class="container pt-4 pt-xl-5">
            <div class="carousel slide" data-bs-ride="carousel" id="carousel-1" style="height: 600px;">
                <div class="carousel-inner h-100">
                    <div class="carousel-item active h-100"><img class="w-100 d-block position-absolute h-100 fit-cover" src="" alt="Slide Image" style="z-index: -1;">
                        <div class="container d-flex flex-column justify-content-center h-100">
                            <div class="row">
                                <div class="col-md-6 col-xl-4 offset-md-2">
                                    <div style="max-width: 350px;">
                                        <h1 class="text-uppercase fw-bold">REtention<br>Digital pengadilan</h1>
                                        <p class="my-3">Forum, Streaming, Request and Report</p><a class="btn btn-lg me-2 btn-warning" role="button" href="#">Login</a><a class="btn btn-lg btn-outline-warning" role="button" href="#">Sign Up</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item active h-100"><img class="w-100 d-block position-absolute h-100 fit-cover" src="/assets/img/header.jpeg" alt="Slide Image" style="z-index: -1;">
                        <div class="container d-flex flex-column justify-content-center h-100">
                            <div class="row">
                                <div class="col-md-6 col-xl-4 offset-md-2">
                                    <div style="max-width: 350px;">
                                        <h1 class="text-uppercase fw-bold">REtention<br>Digital pengadilan</h1>
                                        <p class="my-3">Forum, Streaming, Request and Report</p><a class="btn btn-lg me-2 btn-warning" role="button" href="#">Login</a><a class="btn btn-lg btn-outline-warning" role="button" href="#">Sign Up</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item active h-100"><img class="w-100 d-block position-absolute h-100 fit-cover" src="/assets/img/header.jpeg" alt="Slide Image" style="z-index: -1;">
                        <div class="container d-flex flex-column justify-content-center h-100">
                            <div class="row">
                                <div class="col-md-6 col-xl-4 offset-md-2">
                                    <div style="max-width: 350px;">
                                        <h1 class="text-uppercase fw-bold">REtention<br>Digital pengadilan</h1>
                                        <p class="my-3">Forum, Streaming, Request and Report</p><a class="btn btn-lg me-2 btn-warning" role="button" href="#">Login</a><a class="btn btn-lg btn-outline-warning" role="button" href="#">Sign Up</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div><a class="carousel-control-prev" href="#carousel-1" role="button" data-bs-slide="prev"><span class="carousel-control-prev-icon"></span><span class="visually-hidden">Previous</span></a><a class="carousel-control-next" href="#carousel-1" role="button" data-bs-slide="next"><span class="carousel-control-next-icon"></span><span class="visually-hidden">Next</span></a></div>
                <div class="carousel-indicators"><button type="button" data-bs-target="#carousel-1" data-bs-slide-to="0" class="active"></button> <button type="button" data-bs-target="#carousel-1" data-bs-slide-to="1"></button> <button type="button" data-bs-target="#carousel-1" data-bs-slide-to="2"></button></div>
            </div>
        </div>
    </header>
    <section class="py-5">
        <!-- <div class="container text-center py-5">
            <p class="mb-4" style="font-size: 1.6rem;">Used by <span class="text-warning"><strong>2400+</strong></span>&nbsp;of the best companies in the world.</p><a href="#"> <img class="m-3" src="assets/img/brands/google.png"></a><a href="#"> <img class="m-3" src="assets/img/brands/microsoft.png"></a><a href="#"> <img class="m-3" src="assets/img/brands/apple.png"></a><a href="#"> <img class="m-3" src="assets/img/brands/facebook.png"></a><a href="#"> <img class="m-3" src="assets/img/brands/twitter.png"></a>
        </div> -->
    </section>
    <section>
        <div class="container bg-dark py-5">
            <div class="row">
                <div class="col-md-8 col-xl-6 text-center mx-auto">
                    <p class="fw-bold text-warning mb-2">Schedule</p>
                    <h3 class="fw-bold">Jadwal hari ini</h3>
                </div>
            </div>
            <div class="py-5 p-lg-5">
                <div class="row justify-content-center">
                    <div class="col-xl-10 col-xxl-9">
                        <div class="card shadow-lg border-warning">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>Hearing Number</th>
                                                <th>Schedule</th>
                                                <th>Hearing Time</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if ($paginated_data) : ?>
                                                <?php foreach ($paginated_data as $schedule) : ?>
                                                    <tr>
                                                        <td class="text-truncate text-white" style="max-width: 200px;"><?php echo htmlspecialchars($schedule['hearing_number']); ?></td>
                                                        <td class="text-truncate text-white" style="max-width: 200px;"><?php echo htmlspecialchars($schedule['agenda']); ?></td>
                                                        <td class="text-white"><?php echo htmlspecialchars(date('H:i d-m-Y', strtotime($schedule['hearing_time']))); ?></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else : ?>
                                                <tr>
                                                    <td colspan="3"><?php echo htmlspecialchars($schedules_error_message ?? 'No schedules available.'); ?></td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="card-footer">
                                <nav>
                                    <ul class="pagination pagination-sm mb-0 justify-content-center">
                                        <li class="page-item <?php if ($current_page <= 1) echo 'disabled'; ?>">
                                            <a class="page-link text-warning" href="?page=<?php echo $current_page - 1; ?>">Previous</a>
                                        </li>
                                        <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
                                            <li class="page-item <?php if ($i == $current_page) echo 'active'; ?>">
                                                <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                            </li>
                                        <?php endfor; ?>
                                        <li class="page-item <?php if ($current_page >= $total_pages) echo 'disabled'; ?>">
                                            <a class="page-link text-warning" href="?page=<?php echo $current_page + 1; ?>">Next</a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section>
        <div class="container py-5">
            <div class="mx-auto" style="max-width: 900px;">
                <div class="row row-cols-1 row-cols-md-2 d-flex justify-content-center">
                    <div class="col mb-4">
                        <div class="card bg-primary-light">
                            <div class="card-body text-center px-4 py-5 px-md-5">
                                <p class="fw-bold text-primary card-text mb-2">Forum</p>
                                <h5 class="fw-bold card-title mb-3">Pembahasan, Sharing&nbsp;Diskusi dan lainnya</h5><button class="btn btn-primary btn-sm" type="button">Learn more</button>
                            </div>
                        </div>
                    </div>
                    <div class="col mb-4">
                        <div class="card bg-secondary-light">
                            <div class="card-body text-center px-4 py-5 px-md-5">
                                <p class="fw-bold text-secondary card-text mb-2">Streaming</p>
                                <h5 class="fw-bold card-title mb-3">Menonton&nbsp;,Menyimak, Diskusi dan Transparansi</h5><button class="btn btn-secondary btn-sm" type="button">Learn more</button>
                            </div>
                        </div>
                    </div>
                    <div class="col mb-4">
                        <div class="card bg-info-light">
                            <div class="card-body text-center px-4 py-5 px-md-5">
                                <p class="fw-bold text-info card-text mb-2">Request dan Report</p>
                                <h5 class="fw-bold card-title mb-3">Kebutuhan Pendukung&nbsp;</h5><button class="btn btn-info btn-sm" type="button">Learn more</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <?php include 'Components/main/footer.php'; ?>
    
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/bold-and-dark.js"></script>
</body>

</html>