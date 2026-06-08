<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Luxury Hotel - Đặt phòng</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: Arial, sans-serif; }
        body { background-color: #F7F7F7; color: #000; font-size: 15px; }
        
        /* Header ngang */
        header { display: flex; justify-content: space-between; align-items: center; background-color: #E6E6E6; padding: 20px 40px; }
        h1 { font-size: 30px; font-weight: bold; letter-spacing: 2px; margin: 0; }
        
        .user-actions { display: flex; align-items: center; gap: 15px; }
        .btn-nav { background-color: #6399F7; color: #FFFFFF; padding: 10px 20px; text-decoration: none; border-radius: 5px; font-weight: bold; transition: 0.3s; }
        .btn-nav.secondary { background-color: #AACBFA; color: #000; }
        .btn-logout { background-color: #ffcccc; color: red; padding: 10px 20px; text-decoration: none; border-radius: 5px; font-weight: bold; border: 1px solid red; }

        /* Main layout */
        main { padding: 30px 20px; max-width: 1200px; margin: 0 auto; }
        
        /* Thanh Tìm Kiếm Phòng (MhTKP) */
        .search-wrapper { background-color: #EFF6FFF; border: 2px solid #6399F7; border-radius: 8px; padding: 20px; margin-bottom: 40px; }
        .search-form { display: flex; flex-wrap: wrap; gap: 15px; align-items: flex-end; justify-content: center; }
        .form-group { display: flex; flex-direction: column; gap: 5px; }
        .form-group label { font-weight: bold; font-size: 14px; }
        .form-group input, .form-group select { padding: 10px; border: 1px solid #AACBFA; border-radius: 5px; font-size: 15px; background-color: #FFFFFF; min-width: 180px; }
        .btn-search { background-color: #6399F7; color: white; border: none; padding: 11px 25px; font-size: 15px; font-weight: bold; border-radius: 5px; cursor: pointer; transition: 0.3s; }
        .btn-search:hover { background-color: #AACBFA; color: #000; }

        /* Danh sách phòng */
        .room-container { display: flex; flex-wrap: wrap; gap: 25px; justify-content: center; }
        .room-card { background-color: #FFFFFF; border: 2px solid #AACBFA; border-radius: 10px; width: 320px; overflow: hidden; box-shadow: 0 4px 10px rgba(0,0,0,0.05); transition: transform 0.3s ease; }
        .room-card:hover { transform: translateY(-5px); }
        .room-card img { width: 100%; height: 220px; object-fit: cover; }
        
        .room-info { padding: 20px; background-color: #EFF6FFF; }
        .room-title { font-size: 18px; font-weight: bold; margin-bottom: 10px; }
        .room-price { color: #6399F7; font-weight: bold; margin-bottom: 20px; font-size: 16px; }
        
        .btn-book { display: block; text-align: center; background-color: #6399F7; color: #FFFFFF; text-decoration: none; padding: 12px; border-radius: 5px; font-weight: bold; }
        .btn-book:hover { background-color: #AACBFA; color: #000; }
    </style>
</head>
<body>
    <header>
        <h1>LUXURY HOTEL</h1>
        <div class="user-actions">
            <?php if (isset($_SESSION['fullname'])): ?>
                <span style="font-weight: bold;">Xin chào, <?= htmlspecialchars($_SESSION['fullname'], ENT_QUOTES, 'UTF-8') ?></span>
                
                <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                    <a href="admin_bookings.php" style="background-color: #333333; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; font-weight: bold; margin-left: 15px; transition: 0.3s;">
                        Quản trị Admin
                    </a>
                <?php endif; ?>

                <a href="booking_history.php" class="btn-nav">Lịch sử đặt phòng</a>
                <a href="logout.php" class="btn-logout">Đăng xuất</a>
            <?php else: ?>
                <a href="login.php" class="btn-nav">Đăng nhập</a>
                <a href="register.php" class="btn-nav secondary">Đăng ký</a>
            <?php endif; ?>
        </div>
    </header>

    <main>
        <div class="search-wrapper">
            <form action="index.php" method="GET" class="search-form">
                <div class="form-group">
                    <label>Ngày nhận phòng</label>
                    <input type="date" name="check_in" value="<?= isset($_GET['check_in']) ? htmlspecialchars($_GET['check_in']) : '' ?>">
                </div>
                <div class="form-group">
                    <label>Ngày trả phòng</label>
                    <input type="date" name="check_out" value="<?= isset($_GET['check_out']) ? htmlspecialchars($_GET['check_out']) : '' ?>">
                </div>
                <div class="form-group">
                    <label>Loại phòng</label>
                    <select name="room_type">
                        <option value="">-- Tất cả loại phòng --</option>
                        <?php foreach ($roomTypes as $type): ?>
                            <option value="<?= htmlspecialchars($type) ?>" <?= (isset($_GET['room_type']) && $_GET['room_type'] === $type) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($type) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button type="submit" class="btn-search">Tìm phòng trống</button>
            </form>
        </div>

        <h2 style="text-align: center; margin-bottom: 30px; color: #6399F7;">Kết quả tìm kiếm phòng</h2>
        
        <div class="room-container">
            <?php if (!empty($rooms)): ?>
                <?php foreach ($rooms as $room): ?>
                    <div class="room-card">
                        <img src="<?= htmlspecialchars($room['img'], ENT_QUOTES, 'UTF-8') ?>" alt="Phòng">
                        <div class="room-info">
                            <div class="room-title">Phòng <?= htmlspecialchars($room['room_number']) ?> (<?= htmlspecialchars($room['room_type']) ?>)</div>
                            <div class="room-price">Giá: <?= number_format($room['price']) ?> VNĐ / Đêm</div>
                            <a href="booking.php?id=<?= htmlspecialchars($room['id'], ENT_QUOTES, 'UTF-8') ?>" class="btn-book">
                                Đặt phòng ngay
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p style="text-align: center; font-size: 18px; color: #6399F7; width: 100%;">Không tìm thấy phòng trống nào phù hợp với điều kiện lọc của bạn!</p>
            <?php endif; ?>
        </div>
    </main>
</body>
</html>