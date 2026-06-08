<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng ký - Luxury Hotel</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: Arial, sans-serif; }
        body { background-color: #FFFFFF; color: #000; font-size: 15px; }
        .top-header { background-color: #E6E6E6; padding: 20px 40px; font-size: 24px; font-weight: bold; letter-spacing: 2px; }
        .split-layout { display: flex; max-width: 1200px; margin: 0 auto; min-height: 80vh; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
        .left-img { flex: 6; background: url('https://images.unsplash.com/photo-1542314831-c53cd4b85af0?auto=format&fit=crop&w=800&q=80') center/cover no-repeat; }
        .right-form { flex: 4; background-color: #EFF6FFF; padding: 30px 40px; display: flex; flex-direction: column; justify-content: center; }
        .right-form h2 { text-align: center; margin-bottom: 20px; font-size: 24px; font-weight: bold; color: #000; }
        .input-group { margin-bottom: 15px; }
        .input-group input { width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 8px; font-size: 15px; text-align: center; }
        
        .btn-group { display: flex; gap: 15px; margin-top: 20px; }
        .btn-group a, .btn-group button { flex: 1; padding: 12px; text-align: center; border-radius: 20px; font-size: 15px; font-weight: bold; cursor: pointer; text-decoration: none; transition: 0.3s; border: none; }
        .btn-login-link { background-color: #AACBFA; color: #FFFFFF; }
        .btn-login-link:hover { background-color: #6399F7; }
        .btn-register-submit { background-color: #6399F7; color: #FFFFFF; }
        .btn-register-submit:hover { background-color: #AACBFA; color: #000; }
        
        .msg { text-align: center; margin-bottom: 15px; padding: 10px; border-radius: 5px; }
        .msg.error { background-color: #ffcccc; color: red; }
    </style>
</head>
<body>
    <div class="top-header">LUXURY HOTEL</div>
    
    <div class="split-layout">
        <div class="left-img"></div>
        <div class="right-form">
            <h2>ĐĂNG KÝ</h2>

            <?php if (!empty($error)): ?>
                <div class="msg error"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <form action="register.php" method="POST">
                <div class="input-group">
                    <input type="text" name="fullname" placeholder="Họ và tên" required>
                </div>
                <div class="input-group">
                    <input type="email" name="email" placeholder="Email" required>
                </div>
                <div class="input-group">
                    <input type="text" name="sdt" placeholder="Số điện thoại" required>
                </div>
                <div class="input-group">
                    <input type="text" name="address" placeholder="Địa chỉ" required>
                </div>
                <div class="input-group">
                    <input type="password" name="password" placeholder="Mật khẩu" required>
                </div>

                <div class="btn-group">
                    <a href="login.php" class="btn-login-link">ĐĂNG NHẬP</a>
                    <button type="submit" class="btn-register-submit">ĐĂNG KÝ</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>