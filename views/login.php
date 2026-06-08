<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng nhập - Luxury Hotel</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: Arial, sans-serif; }
        body { background-color: #FFFFFF; color: #000; font-size: 15px; }
        
        /* Header ngang */
        .top-header { background-color: #E6E6E6; padding: 20px 40px; font-size: 24px; font-weight: bold; letter-spacing: 2px; }
        
        /* Layout chia đôi màn hình */
        .split-layout { display: flex; max-width: 1200px; margin: 0 auto; min-height: 80vh; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
        
        /* Cột trái: Hình ảnh */
        .left-img { flex: 6; background: url('https://images.unsplash.com/photo-1542314831-c53cd4b85af0?auto=format&fit=crop&w=800&q=80') center/cover no-repeat; }
        
        /* Cột phải: Form nhập liệu */
        .right-form { flex: 4; background-color: #EFF6FFF; padding: 50px 40px; display: flex; flex-direction: column; justify-content: center; }
        
        .right-form h2 { text-align: center; margin-bottom: 30px; font-size: 24px; font-weight: bold; color: #000; }
        
        .input-group { margin-bottom: 15px; }
        .input-group input { width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 8px; font-size: 15px; text-align: center; }
        
        .forgot-pass { text-align: right; margin-bottom: 25px; }
        .forgot-pass a { color: #6399F7; text-decoration: none; font-size: 14px; }
        
        /* Chứa 2 nút bấm */
        .btn-group { display: flex; gap: 15px; }
        .btn-group a, .btn-group button { flex: 1; padding: 12px; text-align: center; border-radius: 20px; font-size: 15px; font-weight: bold; cursor: pointer; text-decoration: none; transition: 0.3s; border: none; }
        
        /* Nút Đăng ký (Outline mờ) */
        .btn-register { background-color: #AACBFA; color: #FFFFFF; }
        .btn-register:hover { background-color: #6399F7; }
        
        /* Nút Đăng nhập (Màu chính) */
        .btn-login { background-color: #6399F7; color: #FFFFFF; }
        .btn-login:hover { background-color: #AACBFA; color: #000; }

        /* Thông báo */
        .msg { text-align: center; margin-bottom: 15px; padding: 10px; border-radius: 5px; }
        .msg.error { background-color: #ffcccc; color: red; }
        .msg.success { background-color: #ccffcc; color: green; }
    </style>
</head>
<body>
    <div class="top-header">LUXURY HOTEL</div>
    
    <div class="split-layout">
        <div class="left-img"></div>
        <div class="right-form">
            <h2>ĐĂNG NHẬP</h2>

            <?php if (isset($_GET['msg']) && $_GET['msg'] === 'activated'): ?>
                <div class="msg success">Tài khoản đã kích hoạt! Vui lòng đăng nhập.</div>
            <?php endif; ?>
            <?php if (!empty($error)): ?>
                <div class="msg error"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <form action="login.php" method="POST">
                <div class="input-group">
                    <input type="email" name="email" placeholder="Email" required>
                </div>
                <div class="input-group">
                    <input type="password" name="password" placeholder="Mật khẩu" required>
                </div>
                
                <div class="forgot-pass">
                    <a href="forgot.php">Quên mật khẩu</a>
                </div>

                <div class="btn-group">
                    <a href="register.php" class="btn-register">ĐĂNG KÝ</a>
                    <button type="submit" class="btn-login">ĐĂNG NHẬP</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>