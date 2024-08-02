<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include_once "fetch_data.php"; // Pastikan ini diubah sesuai dengan struktur file Anda

$error_message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    $login = isset($_POST['login']) ? $_POST['login'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    if (empty($login) || empty($password)) {
        $error_message = 'Please enter both username and password.';
    } else {
        // URL API Login
        $api_url = 'http://143.198.9/backend/api/login'; // Ganti dengan URL API login kamu

        // Data yang akan dikirim ke API
        $data = array(
            'login' => $login,
            'password' => $password
        );

        // Menggunakan cURL untuk mengirim data
        $curl = curl_init($api_url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, false); // Matikan otomatis redirect
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));

        $response = curl_exec($curl);
        $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE); // Mendapatkan kode status HTTP

        if (curl_errno($curl)) {
            $error_message = 'Request Error:' . curl_error($curl);
        } else {
            // Menguraikan respons JSON
            $json_response = json_decode($response, true);

            if ($http_code == 200) {
                // Jika kode status HTTP adalah 200 (OK)
                // Menyimpan token dan role dari respons
                $token = $json_response['token'];
                $role = $json_response['role'];

                // Menyimpan Bearer token dan role ke session jika login berhasil
                $_SESSION['token'] = $token;
                $_SESSION['role'] = $role;
                header('Location: index.php');
                exit();
            } else { 
                if (isset($json_response['message']) && $json_response['message'] === "The provided credentials are incorrect.") {
                    // Jika kode status HTTP adalah 422 (Unprocessable Entity) dan kesalahan credential
                    $error_message = 'Username atau Password tidak valid';
                } else {
                    $error_message = 'Login gagal. Silakan coba lagi.';
                }
            }
        }
        curl_close($curl);
    }
}
?>

<script>
    var errorMessage = <?php echo json_encode($error_message); ?>;
</script>

<nav class="navbar navbar-expand-lg navbar-light sticky-top" style="background-color: rgba(238, 139, 0, 0.8); margin-bottom: 0; backdrop-filter: blur(10px);">
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
                <button class="btn btn-success d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#loginModal">Login <span class="ms-2"></span></button>
            <?php endif; ?>
        </div>
    </div>
</nav>

<!-- Modal -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="loginModalLabel">Login</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="loginError" class="alert alert-danger" style="display: none;"></div> <!-- Elemen untuk pesan kesalahan -->
                <form action="" method="post">
                    <div class="mb-3">
                        <input type="text" class="form-control" placeholder="Username" name="login">
                    </div>
                    <div class="mb-3">
                        <input type="password" class="form-control" placeholder="Your password..." name="password">
                    </div>
                    <button type="submit" class="btn btn-warning w-100">Login</button>
                    <div class="text-center mt-3">
                        <p>Not a member yet? <a href="#" id="signupLink">Sign Up</a>.</p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Bootstrap 4 -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<!-- Font Awesome -->
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
<script>
$(document).ready(function() {
    $('#signupLink').on('click', function(e) {
        e.preventDefault();
        $('#loginModal').modal('hide');
        setTimeout(function() {
            $('#signupModal').modal('show');
        }, 500); // Delay untuk memastikan modal login benar-benar tertutup
    });

    // Pastikan modal "Sign Up" ditutup dengan benar
    $('#signupModal').on('hidden.bs.modal', function () {
        $('body').removeClass('modal-open');
        $('.modal-backdrop').remove();
    });

    // Tampilkan pesan kesalahan jika ada
    if (errorMessage) {
        $('#loginError').text(errorMessage).show();
        $('#loginModal').modal('show');
    }
});
</script>
</body>
</html>