CREATE DATABASE IF NOT EXISTS dat_phong_ks;
USE dat_phong_ks;

-- 1. Bảng lưu mã OTP (Dựa trên logic Next.js/Mongoose bạn đang tìm hiểu)
CREATE TABLE otp_verifications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL,
    otp_code VARCHAR(6) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    expires_at TIMESTAMP NOT NULL, -- Thời hạn 5-15 phút
    verified BOOLEAN DEFAULT FALSE,
    attempts INT DEFAULT 0, -- Để chặn nếu nhập sai quá nhiều lần
    INDEX (email)
);

-- 2. Bảng Users (Thêm trạng thái xác thực)
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    fullname VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    sdt VARCHAR(20) NOT NULL,
    address VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    is_verified BOOLEAN DEFAULT FALSE, -- Chỉ cho đăng nhập khi đã xác thực OTP
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 3. Bảng Rooms (Cập nhật logic "Ẩn phòng" thay vì "Xóa")
CREATE TABLE rooms (
    id INT AUTO_INCREMENT PRIMARY KEY,
    room_number VARCHAR(50) NOT NULL UNIQUE,
    room_type VARCHAR(50) NOT NULL,
    price DECIMAL(20,2) NOT NULL,
    img VARCHAR(255), -- Lưu đường dẫn ảnh phòng
    -- 'hidden' dùng để ẩn phòng khỏi khách hàng (Ngừng kinh doanh) mà không làm mất data cũ
    status ENUM('available', 'booked', 'using', 'hidden') DEFAULT 'available'
);

-- 4. Bảng Bookings (Giữ nguyên theo flowchart đã vẽ)
CREATE TABLE bookings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    room_id INT NOT NULL,
    check_in DATE NOT NULL,
    check_out DATE NOT NULL,
    -- pending: chờ duyệt, confirmed: đã thanh toán/xác nhận, cancelled: đã hủy
    status ENUM('pending', 'confirmed', 'cancelled') DEFAULT 'pending',
    total_price DECIMAL(20,2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY(user_id) REFERENCES users(id),
    FOREIGN KEY(room_id) REFERENCES rooms(id)
);

-- 5. Bảng Bills (Bổ sung để khớp với luồng Thanh toán QR)
CREATE TABLE bills (
    id INT AUTO_INCREMENT PRIMARY KEY,
    booking_id INT NOT NULL,
    payment_method ENUM('cash', 'bank_transfer') DEFAULT 'bank_transfer',
    amount DECIMAL(20,2) NOT NULL,
    content TEXT, -- Lưu nội dung chuyển khoản (VD: Mã đơn hàng)
    payment_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY(booking_id) REFERENCES bookings(id)
);