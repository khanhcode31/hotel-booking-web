<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản Lý Phòng - Admin Luxury Hotel</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: Arial, sans-serif; }
        body { background-color: #F7F7F7; color: #000; font-size: 15px; }
        
        .admin-header { background-color: #E6E6E6; padding: 20px 40px; display: flex; justify-content: space-between; align-items: center; }
        .admin-header h1 { font-size: 30px; font-weight: bold; }
        .btn-nav { background-color: #6399F7; color: white; padding: 10px 15px; text-decoration: none; border-radius: 5px; font-weight: bold; margin-left: 10px; }
        
        .container { padding: 30px 20px; max-width: 1200px; margin: 0 auto; }
        
        /* Form thêm phòng */
        .add-room-card { background-color: #FFFFFF; border: 2px solid #AACBFA; border-radius: 8px; padding: 20px; margin-bottom: 30px; box-shadow: 0 4px 10px rgba(0,0,0,0.05); }
        .add-room-card h3 { margin-bottom: 15px; color: #6399F7; }
        .form-group-row { display: flex; gap: 15px; margin-bottom: 15px; }
        .form-group-row input { flex: 1; padding: 10px; border: 1px solid #ccc; border-radius: 5px; font-size: 14px; }
        .btn-submit { background-color: #28A745; color: white; border: none; padding: 10px 20px; font-size: 15px; font-weight: bold; border-radius: 5px; cursor: pointer; }
        
        /* Bảng danh sách phòng */
        table { width: 100%; border-collapse: collapse; background-color: #FFFFFF; border: 2px solid #AACBFA; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 10px rgba(0,0,0,0.05); }
        th, td { padding: 12px 15px; text-align: left; border-bottom: 1px solid #E6E6E6; vertical-align: middle; }
        th { background-color: #EFF6FFF; font-weight: bold; border-bottom: 2px solid #AACBFA; }
        .room-img { width: 80px; height: 50px; object-fit: cover; border-radius: 4px; }
        
        /* Nút thao tác */
        .btn-action { padding: 6px 12px; border: none; border-radius: 4px; font-size: 13px; font-weight: bold; cursor: pointer; text-decoration: none; display: inline-block; color: white; }
        .btn-hide { background-color: #DC3545; }
        .btn-show { background-color: #FFC107; color: #000; }
        .badge { padding: 4px 8px; border-radius: 12px; font-size: 12px; font-weight: bold; }
    </style>
</head>
<body>
    <div class="admin-header">
        <h1>QUẢN LÝ PHÒNG</h1>
        <div>
            <a href="admin_bookings.php" class="btn-nav">Quản lý Đặt Phòng</a>
            <a href="index.php" class="btn-nav" style="background-color: #AACBFA; color: #000;">Trang Chủ</a>
        </div>
    </div>

    <div class="container">
        <div class="add-room-card">
            <h3>+ Thêm Phòng Mới</h3>
            <form action="process_room.php" method="POST">
                <div class="form-group-row">
                    <input type="text" name="room_number" placeholder="Số phòng (VD: 401)" required>
                    <input type="text" name="room_type" placeholder="Loại phòng (VD: VIP)" required>
                    <input type="number" name="price" placeholder="Giá tiền/Đêm" required>
                    <input type="text" name="img" placeholder="Link ảnh phòng (URL)" required>
                </div>
                <button type="submit" name="action" value="add" class="btn-submit">Lưu Phòng Mới</button>
            </form>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Hình Ảnh</th>
                    <th>Số Phòng</th>
                    <th>Loại Phòng</th>
                    <th>Giá Tiền</th>
                    <th>Trạng Thái</th>
                    <th>Hành Động</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($rooms as $r): ?>
                    <tr>
                        <td><img src="<?= htmlspecialchars($r['img']) ?>" class="room-img" alt="Ảnh phòng"></td>
                        <td><strong><?= htmlspecialchars($r['room_number']) ?></strong></td>
                        <td><?= htmlspecialchars($r['room_type']) ?></td>
                        <td style="color: #6399F7; font-weight: bold;"><?= number_format($r['price']) ?> VNĐ</td>
                        <td>
                            <?php if ($r['status'] === 'available'): ?>
                                <span class="badge" style="background-color: #D4EDDA; color: #155724;">Sẵn sàng</span>
                            <?php elseif ($r['status'] === 'booked' || $r['status'] === 'using'): ?>
                                <span class="badge" style="background-color: #FFE6CC; color: #FF8000;">Đang có khách</span>
                            <?php elseif ($r['status'] === 'hidden'): ?>
                                <span class="badge" style="background-color: #E2E3E5; color: #383D41;">Đang Ẩn</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ($r['status'] === 'available'): ?>
                                <a href="process_room.php?action=hide&id=<?= $r['id'] ?>" class="btn-action btn-hide" onclick="return confirm('Bạn muốn tạm ngưng kinh doanh phòng này?')">Ẩn Phòng</a>
                            <?php elseif ($r['status'] === 'hidden'): ?>
                                <a href="process_room.php?action=show&id=<?= $r['id'] ?>" class="btn-action btn-show">Mở Lại</a>
                            <?php else: ?>
                                <span style="font-size: 12px; color: #999;">Không thể thao tác</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>