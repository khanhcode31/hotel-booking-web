<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thanh Toán Đặt Phòng - Luxury Hotel</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: Arial, sans-serif; }
        body { background-color: #F7F7F7; color: #000; font-size: 15px; line-height: 1.6; }
        
        .top-header { background-color: #E6E6E6; padding: 20px 40px; font-size: 24px; font-weight: bold; letter-spacing: 2px; text-align: center; }
        
        .payment-container { max-width: 700px; margin: 40px auto; background-color: #FFFFFF; border: 2px solid #AACBFA; border-radius: 10px; padding: 30px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
        
        h2 { font-size: 40px; text-align: center; color: #000; margin-bottom: 25px; font-weight: bold; }
        
        /* Khu vực hiển thị mã QR tĩnh - Nền #EFF6FFF, Viền #6399F7 */
        .qr-section { background-color: #EFF6FFF; border: 2px solid #6399F7; border-radius: 8px; padding: 25px; text-align: center; margin-bottom: 25px; }
        .qr-code-img { max-width: 230px; margin-bottom: 15px; border: 1px solid #ccc; background-color: #fff; padding: 5px; }
        
        .bank-details { text-align: left; display: inline-block; width: 100%; max-width: 450px; margin-top: 15px; }
        .bank-details li { margin-bottom: 8px; font-size: 15px; list-style: none; border-bottom: 1px dashed #AACBFA; padding-bottom: 5px; }
        
        .highlight-text { color: #6399F7; font-weight: bold; font-size: 18px; }
        .syntax-box { background-color: #E6E6E6; padding: 3px 8px; font-family: monospace; font-weight: bold; font-size: 16px; border-radius: 4px; border: 1px solid #ccc; }
        
        .btn-confirm { display: block; width: 100%; padding: 12px; background-color: #6399F7; color: #FFFFFF; border: none; border-radius: 5px; font-size: 15px; font-weight: bold; cursor: pointer; text-align: center; text-decoration: none; margin-top: 20px; transition: 0.3s; }
        .btn-confirm:hover { background-color: #AACBFA; color: #000; }
    </style>
</head>
<body>
    <div class="top-header">LUXURY HOTEL</div>
    
    <div class="payment-container">
        <h2>THANH TOÁN QR</h2>
        
        <p style="text-align: center; margin-bottom: 20px;">
            Hệ thống đã ghi nhận đơn đặt phòng của bạn. Vui lòng quét mã QR hoặc thực hiện chuyển khoản để hoàn tất giao dịch.
        </p>

        <div class="qr-section">
            <img src="https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=Vietcombank-1234567890-LUXURYHOTEL" alt="Mã QR Thanh Toán" class="qr-code-img">
            
            <div class="bank-details">
                <ul>
                    <li><strong>Ngân hàng hàng chỉ định:</strong> Vietcombank (VCB)</li>
                    <li><strong>Số tài khoản:</strong> 1234567890</li>
                    <li><strong>Chủ tài khoản:</strong> LUXURY HOTEL</li>
                    <li><strong>Số phòng đặt:</strong> Phòng <?= htmlspecialchars($booking['room_number']) ?></li>
                    <li><strong>Số tiền cần chuyển:</strong> <span class="highlight-text"><?= number_format($booking['total_price']) ?> VNĐ</span></li>
                    <li><strong>Nội dung chuyển khoản chuẩn:</strong> <span class="syntax-box">LUXURY<?= htmlspecialchars($booking['id']) ?></span></li>
                </ul>
            </div>
            <p style="color: red; font-size: 13px; margin-top: 15px; font-style: italic;">
                *Chú ý: Bạn cần điền chính xác nội dung chuyển khoản phía trên để quản trị viên đối chiếu duyệt phòng nhanh nhất.
            </p>
        </div>

        <form action="confirm_payment.php" method="POST">
            <input type="hidden" name="booking_id" value="<?= $booking['id'] ?>">
            <input type="hidden" name="amount" value="<?= $booking['total_price'] ?>">
            <input type="hidden" name="content" value="LUXURY<?= $booking['id'] ?>">
            <button type="submit" class="btn-confirm">Tôi đã chuyển khoản thành công</button>
        </form>
    </div>
</body>
</html>