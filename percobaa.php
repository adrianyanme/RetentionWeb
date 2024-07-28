<?php
include "fetch_data.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $url = 'http://127.0.0.1:8000/api/persalinan';
    $token = $_SESSION['token']; // Ambil token dari session

    $data = [
        'email' => $_POST['email'],
        'jenissalinan' => $_POST['jenissalinan'],
        'putusanyangdiminta' => $_POST['putusanyangdiminta'],
        'namapemohon' => $_POST['namapemohon'],
        'nohp' => $_POST['nohp'],
        'statuspemohon' => $_POST['statuspemohon'],
        'noperkara' => $_POST['noperkara'],
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
            font-family: 'Roboto', sans-serif;
            background-color: #f0f4f8;
            color: #333;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            margin: 0;
        }
        
        .container {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            display: flex;
            max-width: 900px;
            width: 100%;
            overflow: hidden;
            margin: auto;
        }
        .sidebar {
            background-color: #4834d4;
            color: #fff;
            padding: 30px;
            width: 250px;
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
        .form-container .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .form-container .form-group input:focus {
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
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<?php include 'Components/main/navbar.php'; ?>
    <div class="container">
        <div class="sidebar">
            <div class="step step-1 active">
                <span>STEP 1</span>
                YOUR INFO
            </div>
            <div class="step step-2">
                <span>STEP 2</span>
                SELECT PLAN
            </div>
            <div class="step step-3">
                <span>STEP 3</span>
                ADD-ONS
            </div>
            <div class="step step-4">
                <span>STEP 4</span>
                SUMMARY
            </div>
        </div>
        <div class="form-container">
            <h2>Personal info</h2>
            <p>Please provide your name, email address, and phone number.</p>
            <form method="POST" enctype="multipart/form-data">
                <div class="step step-1 active">
                    <div class="form-group">
                        <label for="namapemohon">Name</label>
                        <input type="text" id="namapemohon" name="namapemohon" placeholder="e.g. Stephen King" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" id="email" name="email" placeholder="e.g. stephenking@lorem.com" required>
                    </div>
                    <div class="form-group">
                        <label for="nohp">Phone Number</label>
                        <input type="text" id="nohp" name="nohp" placeholder="e.g. +1 234 567 890" required>
                    </div>
                </div>
                <div class="step step-2">
                    <div class="form-group">
                        <label for="jenissalinan">Jenis Salinan</label>
                        <input type="text" id="jenissalinan" name="jenissalinan" placeholder="Jenis Salinan" required>
                    </div>
                </div>
                <div class="step step-3">
                    <div class="form-group">
                        <label for="putusanyangdiminta">Putusan Yang Diminta</label>
                        <input type="text" id="putusanyangdiminta" name="putusanyangdiminta" placeholder="Putusan Yang Diminta" required>
                    </div>
                </div>
                <div class="step step-4">
                    <div class="form-group">
                        <label for="statuspemohon">Status Pemohon</label>
                        <input type="text" id="statuspemohon" name="statuspemohon" placeholder="Status Pemohon" required>
                    </div>
                    <div class="form-group">
                        <label for="noperkara">Nomor Perkara</label>
                        <input type="text" id="noperkara" name="noperkara" placeholder="Nomor Perkara" required>
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
    <?php include 'Components/main/footer.php'; ?>
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