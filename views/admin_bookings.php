<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản Lý Đặt Phòng - Admin Luxury Hotel</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: Arial, sans-serif; }
        body { background-color: #F7F7F7; color: #000; font-size: 15px; }
        
        .admin-header { background-color: #E6E6E6; padding: 20px 40px; display: flex; justify-content: space-between; align-items: center; }
        .admin-header h1 { font-size: 30px; font-weight: bold; }
        .btn-back { background-color: #6399F7; color: white; padding: 10px 15px; text-decoration: none; border-radius: 5px; font-weight: bold; }
        
        .container { padding: 30px 20px; max-width: 1300px; margin: 0 auto; }
        h2 { font-size: 40px; text-align: center; margin-bottom: 30px; font-weight: bold; }
        
        table { width: 100%; border-collapse: collapse; background-color: #FFFFFF; border: 2px solid #AACBFA; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 10px rgba(0,0,0,0.05); }
        th, td { padding: 12px 15px; text-align: left; border-bottom: 1px solid #E6E6E6; }
        th { background-color: #EFF6FFF; font-weight: bold; color: #000; border-bottom: 2px solid #AACBFA; }
        
        .status-badge { padding: 5px 10px; border-radius: 20px; font-size: 13px; font-weight: bold; display: inline-block; }
        .status-pending { background-color: #FFE6CC; color: #FF8000; }
        .status-confirmed { background-color: #D4EDDA; color: #155724; }
        .status-cancelled { background-color: #F8D7DA; color: #721C24; }
        
        .btn-action { padding: 6px 12px; border: none; border-radius: 4px; font-size: 13px; font-weight: bold; cursor: pointer; text-decoration: none; display: inline-block; margin-right: 5px; color: white; }
        .btn-approve { background-color: #28A745; }
        .btn-cancel { background-color: #DC3545; }
        .syntax-text { background-color: #E6E6E6; padding: 2px 6px; font-family: monospace; border-radius: 4px; font-weight: bold; }
    </style>
</head>
<body>
    <div class="admin-header">
        <h1>BÀN QUẢN TRỊ ADMIN</h1>
        <div>
            <a href="admin_bookings.php" class="btn-back">Đơn đặt phòng</a>
            <a href="admin_rooms.php" class="btn-back" style="background-color: #28A745;">Quản lý phòng</a>
            <a href="index.php" class="btn-back" style="background-color: #333;">Trang Chủ</a>
        </div>
    </div>

    <div class="container">
        <h2>DANH SÁCH ĐẶT PHÒNG</h2>
        
        <table>
            <thead>
                <tr>
                    <th>Mã Đơn</th>
                    <th>Khách Hàng</th>
                    <th>Thông Tin Phòng</th>
                    <th>Thời Gian Ở</th>
                    <th>Tổng Tiền</th>
                    <th>Nội Dung QR</th>
                    <th>Trạng Thái</th>
                    <th>Hành Động</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($bookings)): ?>
                    <?php foreach ($bookings as $b): ?>
                        <tr>
                            <td><strong>#<?= htmlspecialchars($b['id']) ?></strong></td>
                            <td>
                                <strong><?= htmlspecialchars($b['fullname'] ?? 'N/A') ?></strong><br>
                                <span style="font-size: 13px; color: #555;"><?= htmlspecialchars($b['sdt'] ?? 'N/A') ?></span>
                            </td>
                            <td>
                                Phòng <?= htmlspecialchars($b['room_number'] ?? 'N/A') ?><br>
                                <span style="font-size: 13px; color: #6399F7; font-weight: bold;"><?= htmlspecialchars($b['room_type'] ?? 'N/A') ?></span>
                            </td>
                            <td>
                                <span style="font-size: 13px;">Từ: <?= htmlspecialchars($b['check_in']) ?></span><br>
                                <span style="font-size: 13px;">Đến: <?= htmlspecialchars($b['check_out']) ?></span>
                            </td>
                            <td style="font-weight: bold; color: #000;"><?= number_format($b['total_price']) ?> VNĐ</td>
                            <td>
                                <?php if (!empty($b['bill_content'])): ?>
                                    <span class="syntax-text"><?= htmlspecialchars($b['bill_content']) ?></span>
                                <?php else: ?>
                                    <span style="color: #999; font-size: 12px;">Chưa xác nhận</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php 
                                    $status = $b['status'] ?? 'pending';
                                    if ($status === 'pending') echo '<span class="status-badge status-pending">Chờ Duyệt</span>';
                                    elseif ($status === 'confirmed') echo '<span class="status-badge status-confirmed">Thành Công</span>';
                                    else echo '<span class="status-badge status-cancelled">Đã Hủy</span>';
                                ?>
                            </td>
                            <td>
                                <?php if ($status === 'pending'): ?>
                                    <a href="process_verify_booking.php?action=approve&booking_id=<?= $b['id'] ?>" class="btn-action btn-approve">Duyệt</a>
                                    <a href="process_verify_booking.php?action=cancel&booking_id=<?= $b['id'] ?>" class="btn-action btn-cancel">Hủy</a>
                                <?php else: ?>
                                    <span style="color: #666; font-size: 13px;">Đã xong</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="8" style="text-align: center; padding: 30px;">Chưa có đơn đặt phòng nào.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>