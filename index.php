<?php
session_start();
$logged_in = isset($_SESSION['user_id']);
if (!$logged_in) {
    header('Location: login.php');
    exit();
} else {
    header('Location: dashboard.php');
    exit();
}
$page_title = 'Welcome to Village Register System';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="assets/favicon.png">
    <style>
        body {
            background: url('assets/village-bg.jpg') no-repeat center center fixed;
            background-size: cover;
            min-height: 100vh;
            position: relative;
        }
        .homepage-overlay {
            background: rgba(44, 62, 80, 0.7);
            min-height: 100vh;
            width: 100vw;
            position: absolute;
            top: 0; left: 0;
            z-index: 1;
        }
        .homepage-content {
            position: relative;
            z-index: 2;
            color: #fff;
            padding-top: 80px;
            padding-bottom: 40px;
        }
        .animated-img {
            width: 120px;
            margin: 20px;
            border-radius: 20px;
            box-shadow: 0 4px 24px rgba(0,0,0,0.2);
            transition: transform 0.5s;
        }
        .animated-img:hover {
            transform: scale(1.1) rotate(-3deg);
        }
        .feature-icon {
            font-size: 2.5rem;
            margin-bottom: 10px;
        }
        .cta-btn {
            font-size: 1.2rem;
            padding: 12px 32px;
            margin: 10px;
        }
    </style>
</head>
<body>
    <div class="homepage-overlay"></div>
    <div class="container homepage-content text-center">
        <h1 class="display-4 fw-bold mb-4"><i class="fas fa-clipboard-list"></i> Village Birth & Death Register System</h1>
        <p class="lead mb-5">A modern, secure, and user-friendly platform for managing vital records in your community.<br>Built with PHP, MySQL, JavaScript, and Bootstrap.</p>
        <div class="row justify-content-center mb-5">
            <div class="col-md-3">
                <div class="mb-4">
                    <i class="fas fa-user-shield feature-icon text-warning"></i>
                    <h5>Secure Authentication</h5>
                    <p>Role-based access for Admins and Officers. All data is protected and private.</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="mb-4">
                    <i class="fas fa-baby feature-icon text-info"></i>
                    <h5>Birth & Death Records</h5>
                    <p>Register, search, and manage vital records with ease and accuracy.</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="mb-4">
                    <i class="fas fa-file-pdf feature-icon text-danger"></i>
                    <h5>PDF Certificates</h5>
                    <p>Generate professional, print-ready certificates for official use.</p>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-center flex-wrap mb-5">
            <img src="assets/birth.png" class="animated-img" id="img1" alt="Birth Registration">
            <img src="assets/death.png" class="animated-img" id="img2" alt="Death Registration">
            <img src="assets/certificate.png" class="animated-img" id="img3" alt="Certificate">
        </div>
        <div class="mb-4">
            <a href="login.php" class="btn btn-primary cta-btn"><i class="fas fa-sign-in-alt"></i> Login</a>
            <a href="register_birth.php" class="btn btn-success cta-btn"><i class="fas fa-baby"></i> Register Birth</a>
            <a href="register_death.php" class="btn btn-danger cta-btn"><i class="fas fa-cross"></i> Register Death</a>
        </div>
        <div class="mt-5">
            <h4>How It Works</h4>
            <ul class="list-unstyled text-start mx-auto" style="max-width: 600px;">
                <li><i class="fas fa-check-circle text-success"></i> Login as Admin or Officer to access the dashboard.</li>
                <li><i class="fas fa-check-circle text-success"></i> Register new births and deaths using simple forms.</li>
                <li><i class="fas fa-check-circle text-success"></i> Search, view, and manage all records securely.</li>
                <li><i class="fas fa-check-circle text-success"></i> Generate and print official certificates as needed.</li>
            </ul>
        </div>
    </div>
    <script>

        document.addEventListener('DOMContentLoaded', function() {
            const imgs = [document.getElementById('img1'), document.getElementById('img2'), document.getElementById('img3')];
            let angle = 0;
            setInterval(() => {
                angle += 2;
                imgs.forEach((img, i) => {
                    img.style.transform = `scale(1.05) rotate(${Math.sin(angle/20 + i)*8}deg)`;
                });
            }, 50);
        });
    </script>
</body>
</html>
