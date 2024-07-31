<?php
session_start();

if (isset($_SESSION['token'])) {
    header('Location: index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $login = isset($_POST['login']) ? $_POST['login'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    if (empty($login) || empty($password)) {
        $error_message = 'Please enter both username and password.';
    } else {
        // URL API Login
        $api_url = 'http://143.198.218.9/backend/api/login'; // Ganti dengan URL API login kamu

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
                // Menyimpan token langsung ke variabel
                $token = $response;

                // Menyimpan Bearer token ke session jika login berhasil
                $_SESSION['token'] = $token;
                header('Location: index.php');
                exit();
            } else { 
                (isset($json_response['message']) && $json_response['message'] === "The provided credentials are incorrect.");
                // Jika kode status HTTP adalah 422 (Unprocessable Entity) dan kesalahan credential
                $error_message = 'Username atau Password tidak valid';
            }
        }
        curl_close($curl);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin Retention</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <!-- /.login-logo -->
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <a href="index2.html" class="h1"><b>Admin</b>LTE</a>
    </div>
    <div class="card-body">
      <p class="login-box-msg">Sign in to start your session</p>
      <?php
                if (isset($error_message)) {
                    echo '<p style="color:red;">' . htmlspecialchars($error_message) . '</p>';
                }
                ?>
      <form action="login.php" method="post">
        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="Email" name="login">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Password" name="password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="remember">
              <label for="remember">
                Remember Me
              </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
</body>
</html>
