<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Chi Tiết Đặt Phòng - Luxury Hotel</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: Arial, sans-serif; }
        body { background-color: #F7F7F7; color: #000; font-size: 15px; line-height: 1.6; }
        
        header { display: flex; justify-content: space-between; align-items: center; background-color: #E6E6E6; padding: 20px 40px; }
        header h1 { font-size: 30px; font-weight: bold; }
        .btn-home { background-color: #6399F7; color: white; padding: 10px 15px; text-decoration: none; border-radius: 5px; font-weight: bold; }

        .container { max-width: 900px; margin: 40px auto; background-color: #FFFFFF; border: 2px solid #AACBFA; border-radius: 10px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
        
        h2 { font-size: 40px; text-align: center; color: #000; padding: 25px 0 10px 0; font-weight: bold; }
        
        /* Layout chia hai cột: Trái ảnh phòng, Phải thông tin đặt */
        .booking-layout { display: flex; flex-wrap: wrap; }
        .room-preview { flex: 1; min-width: 350px; padding: 25px; }
        .room-preview img { width: 100%; height: 280px; object-fit: cover; border-radius: 8px; border: 1px solid #AACBFA; }
        
        .booking-form-section { flex: 1; min-width: 350px; padding: 25px; background-color: #EFF6FFF; border-left: 1px solid #AACBFA; }
        
        .room-meta { margin-bottom: 20px; padding-bottom: 15px; border-bottom: 1px dashed #6399F7; }
        .room-name { font-size: 20px; font-weight: bold; margin-bottom: 5px; }
        .room-price-label { color: #6399F7; font-weight: bold; font-size: 16px; }
        
        /* Định dạng form */
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; font-weight: bold; margin-bottom: 5px; font-size: 14px; }
        .form-group input { width: 100%; padding: 10px; border: 1px solid #AACBFA; border-radius: 5px; font-size: 15px; background-color: #FFFFFF; }
        
        /* Khu vực hiển thị tạm tính tiền */
        .total-summary { background-color: #FFFFFF; border: 1px solid #6399F7; padding: 15px; border-radius: 5px; margin-top: 20px; }
        
        .btn-submit-booking { display: block; width: 100%; padding: 12px; background-color: #6399F7; color: #FFFFFF; border: none; border-radius: 5px; font-size: 15px; font-weight: bold; cursor: pointer; text-align: center; margin-top: 20px; transition: 0.3s; }
        .btn-submit-booking:hover { background-color: #AACBFA; color: #000; }
    </style>
</head>
<body>
    <header>
        <h1>LUXURY HOTEL</h1>
        <a href="index.php" class="btn-home">Hủy bỏ & Quay lại</a>
    </header>

    <div class="container">
        <h2>THÔNG TIN ĐẶT PHÒNG</h2>
        
        <div class="booking-layout">
            <div class="room-preview">
                <img src="<?= htmlspecialchars($room['img']) ?>" alt="Ảnh phòng">
                <div style="margin-top: 15px; font-size: 14px; color: #555;">
                    <p><b>Quy định phòng:</b> Nhận phòng sau 14:00, Trả phòng trước 12:00 trưa ngày kế tiếp. Nghiêm cấm mang theo vật nuôi và chất gây cháy nổ.</p>
                </div>
            </div>
            
            <div class="booking-form-section">
                <div class="room-meta">
                    <div class="room-name">Phòng <?= htmlspecialchars($room['room_number']) ?></div>
                    <div class="room-type">Loại phòng: <b><?= htmlspecialchars($room['room_type']) ?></b></div>
                    <div class="room-price-label">Đơn giá: <span id="room-price" data-price="<?= $room['price'] ?>"><?= number_format($room['price']) ?></span> VNĐ / Đêm</div>
                </div>

                <form action="process_booking.php" method="POST">
                    <input type="hidden" name="room_id" value="<?= $room['id'] ?>">
                    <input type="hidden" name="price_per_night" value="<?= $room['price'] ?>">

                    <div class="form-group">
                        <label>Tên khách hàng đặt phòng</label>
                        <input type="text" value="<?= htmlspecialchars($_SESSION['fullname']) ?>" disabled style="background-color: #E6E6E6; cursor: not-allowed;">
                    </div>

                    <div class="form-group">
                        <label>Ngày nhận phòng (Check-in)</label>
                        <input type="date" name="check_in" id="check_in" min="<?= date('Y-m-to-d'); ?>" required>
                    </div>

                    <div class="form-group">
                        <label>Ngày trả phòng (Check-out)</label>
                        <input type="date" name="check_out" id="check_out" required>
                    </div>

                    <div class="total-summary">
                        <div style="font-size: 14px;">Số ngày ở dự kiến: <strong id="lbl-days" style="color:#000;">0 ngày</strong></div>
                        <div style="font-size: 16px; margin-top: 5px;">Tổng tiền tạm tính: <strong id="lbl-total" style="color: #6399F7; font-size: 18px;">0 VNĐ</strong></div>
                    </div>

                    <button type="submit" class="btn-submit-booking">Xác Nhận Đặt Phòng</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        const txtCheckIn = document.getElementById('check_in');
        const txtCheckOut = document.getElementById('check_out');
        const lblDays = document.getElementById('lbl-days');
        const lblTotal = document.getElementById('lbl-total');
        const pricePerNight = parseFloat(document.getElementById('room-price').getAttribute('data-price'));

        function calculateTotalPrice() {
            const date1Str = txtCheckIn.value;
            const date2Str = txtCheckOut.value;

            if (date1Str && date2Str) {
                const d1 = new Date(date1Str);
                const d2 = new Date(date2Str);

                // Tính khoảng cách mili-giây và đổi ra số ngày
                const timeDiff = d2.getTime() - d1.getTime();
                const days = Math.ceil(timeDiff / (1000 * 3600 * 24));

                if (days > 0) {
                    const total = days * pricePerNight;
                    lblDays.innerText = days + ' đêm';
                    lblTotal.innerText = total.toLocaleString('vi-VN') + ' VNĐ';
                } else {
                    lblDays.innerText = '0 đêm';
                    lblTotal.innerText = '0 VNĐ (Ngày trả phải sau ngày nhận)';
                }
            }
        }

        // Bắt sự kiện thay đổi ngày để tính tiền luôn
        txtCheckIn.addEventListener('change', () => {
            txtCheckOut.min = txtCheckIn.value; // Ràng buộc ngày trả không được nhỏ hơn ngày nhận
            calculateTotalPrice();
        });
        txtCheckOut.addEventListener('change', calculateTotalPrice);
    </script>
</body>
</html>