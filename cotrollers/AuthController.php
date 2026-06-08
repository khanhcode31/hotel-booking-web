<?php
// cotrollers/AuthController.php

class AuthController {
    private $pdo;

    public function __construct($dbConnection) {
        $this->pdo = $dbConnection;
    }

// 1. XỬ LÝ ĐĂNG KÝ
    public function register($fullname, $email, $sdt, $address, $password) {
        try {
            $checkSql = "SELECT id FROM users WHERE email = :email";
            $checkStmt = $this->pdo->prepare($checkSql);
            $checkStmt->execute([':email' => $email]);
            if ($checkStmt->fetch()) {
                return "Email này đã được sử dụng bởi tài khoản khác!";
            }

            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

            $sql = "INSERT INTO users (fullname, email, sdt, address, password, is_verified) 
                    VALUES (:fullname, :email, :sdt, :address, :password, 0)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                ':fullname' => $fullname,
                ':email' => $email,
                ':sdt' => $sdt,
                ':address' => $address,
                ':password' => $hashedPassword
            ]);

            // Sinh mã OTP ngẫu nhiên gồm 6 chữ số
            $otp = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
            
            // ĐÃ SỬA: Bắt MySQL tự lấy giờ hiện tại của nó cộng thêm 10 phút (Khắc phục lỗi lệch múi giờ)
            $otpSql = "INSERT INTO otp_verifications (email, otp_code, expires_at) 
                       VALUES (:email, :otp, DATE_ADD(NOW(), INTERVAL 10 MINUTE))";
            $otpStmt = $this->pdo->prepare($otpSql);
            
            // Chỉ truyền 2 biến, không cần truyền thời gian từ PHP nữa
            $otpStmt->execute([
                ':email' => $email,
                ':otp' => $otp
            ]);

            return ['status' => 'success', 'otp' => $otp, 'email' => $email];

        } catch (PDOException $e) {
            return "LỖI SQL: " . $e->getMessage();
        }
    }
    // Các hàm verifyOtp và login giữ nguyên...
    public function verifyOtp($email, $otpInput) {
        try {
            $sql = "SELECT * FROM otp_verifications 
                    WHERE email = :email AND otp_code = :otp AND verified = 0 AND expires_at > NOW() 
                    ORDER BY id DESC LIMIT 1";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':email' => $email, ':otp' => $otpInput]);
            $otpData = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($otpData) {
                $updateOtp = "UPDATE otp_verifications SET verified = 1 WHERE id = :id";
                $this->pdo->prepare($updateOtp)->execute([':id' => $otpData['id']]);

                $updateUser = "UPDATE users SET is_verified = 1 WHERE email = :email";
                $this->pdo->prepare($updateUser)->execute([':email' => $email]);

                return true;
            }
            return false;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function login($email, $password) {
        try {
            $sql = "SELECT * FROM users WHERE email = :email LIMIT 1";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':email' => $email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

           if (password_verify($password, $user['password'])) {
                    if (session_status() == PHP_SESSION_NONE) { session_start(); }
                    
                    // Lưu thông tin vào phiên làm việc (Session)
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['fullname'] = $user['fullname'];
                    $_SESSION['email'] = $user['email'];
                    
                    // THÊM DÒNG NÀY ĐỂ LƯU QUYỀN TRUY CẬP
                    $_SESSION['role'] = $user['role']; 
                    
                    return ['status' => 'success'];
                }
            return "Email hoặc mật khẩu không chính xác.";
        } catch (PDOException $e) {
            return "Hệ thống gặp lỗi.";
        }
    }
}
?>