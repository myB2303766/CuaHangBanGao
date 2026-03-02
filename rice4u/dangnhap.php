<?php
session_start();
require 'db.php';
$thong_bao = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ten_dang_nhap = $_POST['ten_dang_nhap'];
    $mat_khau_nhap = $_POST['mat_khau'];

    $stmt = $pdo->prepare("SELECT * FROM TAI_KHOAN WHERE ten_dang_nhap = ?");
    $stmt->execute([$ten_dang_nhap]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Kiểm tra mật khẩu mã hóa
    if ($user && password_verify($mat_khau_nhap, $user['mat_khau'])) {
        // Lưu session
        $_SESSION['ma_tk'] = $user['ma_tk'];
        $_SESSION['vai_tro'] = $user['vai_tro'];

        // Phân quyền 
        if ($user['vai_tro'] == 'admin') {
            header("Location: admin.php");
        } else {
            header("Location: index.php"); // Trang chủ khách hàng
        }
        exit();
    } else {
        $thong_bao = "Tài khoản hoặc mật khẩu không đúng!";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập - Cửa Hàng Gạo Rice4U</title>
    <link href="./asset/css/header.css" rel="stylesheet">
    <link href="./asset/css/footer.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        /* ================== MAIN CSS ================== */
        * {
            font-family: 'Nunito', Arial, Helvetica, sans-serif;
            box-sizing: border-box;
        }
        body {
            margin: 0 auto;
            width: 100%;
            min-height: 100vh;
            display: grid;
            grid-template-rows: auto 1fr auto;
            grid-template-areas:
                "header"
                "main"
                "footer";
            
             font-family: 'Nunito', Arial, Helvetica, sans-serif;
        }
        main {
            grid-area: main;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 3em 1em;
            overflow: hidden;
        }

        main::before {
            content: "";
            position: absolute;
            top: -20px;
            left: -20px;
            right: -20px;
            bottom: -20px;
            background: url('bgr.jpg') no-repeat center center;
            background-size: cover;
            filter: blur(6px);
            z-index: -2;
        }

        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.4);
            z-index: -1;
        }

        .login-container {
            position: relative;
            z-index: 1;
            background-color: #ffffff;
            box-sizing: border-box;
            font-size: 1.1vw;
            width: 38em;
            padding: 3.5em;
            border-radius: 1em;
            box-shadow: 0 1.5em 4em rgba(0, 0, 0, 0.2);
        }

        .login-container h2 {
            text-align: center;
            color: #519A66;
            margin-top: 0;
            margin-bottom: 0.5em;
            font-size: 2.8em;
        }

        .subtitle {
            text-align: center;
            color: #666;
            margin-bottom: 2.5em;
            font-size: 1.2em;
        }

        .form-group {
            margin-bottom: 1.5em;
            position: relative;
        }

        .form-group input {
            width: 100%;
            font-family: 'Nunito', sans-serif;
            box-sizing: border-box;
            transition: all 0.3s ease;
            font-size: 1.2em;
            padding: 1.2em 1.5em;
            border: 0.1em solid #ddd;
            border-radius: 0.8em;
        }

        .form-group input.password-toggle {
            padding-right: 3.5em;
        }

        .form-group input:focus {
            border-color: #519A66;
            outline: none;
            box-shadow: 0 0 0.8em rgba(46, 125, 50, 0.2);
        }

        .eye-icon {
            position: absolute;
            top: 50%;
            right: 1.2em;
            transform: translateY(-50%);
            cursor: pointer;
            color: #888;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: color 0.3s;
        }

        .eye-icon:hover {
            color: #519A66;
        }

        .eye-icon svg {
            width: 1.8em;
            height: 1.8em;
        }

        .btn-submit {
            width: 100%;
            background-color: #519A66;
            color: white;
            border: none;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s;
            font-size: 1.3em;
            padding: 1.2em;
            border-radius: 0.8em;
            margin-top: 1em;
        }

        .btn-submit:hover {
            background-color: #237227;
        }

        .thong-bao {
            color: #c0392b;
            text-align: center;
            font-weight: bold;
            font-size: 1.2em;
            margin-bottom: 1.5em;
        }

        @media (max-width: 800px) {
            .login-container {
                font-size: 14px;
                width: 95%;
                max-width: 450px;
                padding: 30px;
                border-radius: 12px;
            }

            header {
                flex-direction: column;
                height: auto;
                padding: 10px;
            }

            footer {
                flex-direction: column;
                align-items: center;
                text-align: center;
            }
        }
    </style>
</head>

<body>
    <header>
        <div class="logo-navi">
            <a href="./trangchu.html"><img class="logo" src="./asset/img/logo.png" alt="Logo"></a>
            <nav>
                <ul class="dieu-huong">
                    <li><a href="./trangchu.html">Trang Chủ</a></li>
                    <li><a href="./sanpham.html">Sản Phẩm</a></li>
                    <li><a href="./lienhe.html">Liên Hệ</a></li>
                </ul>
            </nav>
            <div class="search-box">
                <input type="text" placeholder="Nhập loại gạo bạn muốn tìm">
                <button class="search">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>

            </div>
        </div>
        <div class="user">
            <button class="login-button"><a href="./dangnhap.php">Đăng Nhập</a></button>
            <button class="signup-button"><a href="./dangky.php">Đăng Ký</a></button>
            <div class="icon">
                <a href="./giohang.html">
                    <i class="fa-solid fa-cart-shopping"><span class="soluong">0</span></i>
                </a>
                <div class="user-icon">
                    <a href="./dangnhap.php"><i class="fa-solid fa-user"></i></a>
                    <div class="log-out">
                        <a href="./profile.html">Thông tin cá nhân</a>
                        <button class="logout-button">Đăng xuất</button>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <main>
        <div class="overlay"></div>
        <div class="login-container">
            <h2>Đăng Nhập</h2>
            <p class="subtitle">Chào mừng trở lại Cửa Hàng Gạo Rice4U</p>

            <?php if (!empty($thong_bao)) echo "<div class='thong-bao'>$thong_bao</div>"; ?>

            <form method="POST" action="dangnhap.php">
                <div class="form-group">
                    <input type="text" name="ten_dang_nhap" placeholder="Tên đăng nhập" required>
                </div>
                <div class="form-group">
                    <input type="password" id="mat-khau-input" class="password-toggle" name="mat_khau" placeholder="Mật khẩu" required>

                    <span class="eye-icon" onclick="togglePassword()">
                        <svg id="eye-svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path>
                            <line x1="1" y1="1" x2="23" y2="23"></line>
                        </svg>
                    </span>
                </div>

                <div style="text-align: right; margin-top: -1em; margin-bottom: 1.5em;">
                    <a href="quenmk.php" style="color: #519A66; text-decoration: none; font-size: 1.1em; font-weight: bold;">Quên mật khẩu?</a>
                </div>

                <button type="submit" class="btn-submit">Đăng nhập ngay</button>
            </form>

            <div class="footer-link">
                Chưa có tài khoản? <a href="dangky.php">Đăng ký ngay</a>
            </div>
        </div>
    </main>

    <footer>
        <div class="footer-column">
            <img class="logo" src="./asset/img/logo.png" alt="Logo">
        </div>
        <div class="footer-column">
            <h3>Về chúng tôi</h3>
            <ul>
                <li><a href="#">Giới thiệu</a></li>
                <li><a href="#">Tuyển dụng</a></li>
                <li><a href="#">Liên hệ</a></li>
                <li><a href="#">Câu hỏi thường gặp</a></li>
            </ul>
        </div>
        <div class="footer-column">
            <h3>Chính sách</h3>
            <ul>
                <li><a href="#">Chính sách bảo mật</a></li>
                <li><a href="#">Điều khoản dịch vụ</a></li>
                <li><a href="#">Chính sách đổi trả</a></li>
            </ul>
        </div>
        <div class="media">
            <h3>Liên hệ</h3>
            <p><i class="fas fa-map-marker-alt"></i> Đường 3/2, phường Ninh Kiều, TPCT</p>
            <p><i class="fas fa-phone"></i> (000) 0000 0000</p>
            <p><i class="fas fa-envelope"></i> CT299@ctu.edu.vn</p>
            <p>Giờ làm việc: T2 - CN, 9:00 - 19:00</p>
            <p style=" font-weight: bold;">&copy; 2026 Bản quyền thuộc về Rice4U.</p>
        </div>
    </footer>

    <script>
        function togglePassword() {
            var input = document.getElementById("mat-khau-input");
            var iconSvg = document.getElementById("eye-svg");
            var eyeOpen = `<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle>`;
            var eyeClosed = `<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line>`;

            if (input.type === "password") {
                input.type = "text";
                iconSvg.innerHTML = eyeOpen;
            } else {
                input.type = "password";
                iconSvg.innerHTML = eyeClosed;
            }
        }
    </script>
</body>

</html>