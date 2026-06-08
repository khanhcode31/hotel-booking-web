<?php
// controllers/BookingController.php

class BookingController {
    private $pdo;

    // Hàm khởi tạo nhận kết nối database
    public function __construct($dbConnection) {
        $this->pdo = $dbConnection;
    }

    // Hàm lấy chi tiết một phòng theo ID
    public function getRoomDetail($roomId) {
        try {
            // Lệnh SQL lấy thông tin phòng + loại phòng
            $sql = "SELECT r.RoomID, r.RoomNumber, r.ImageURL, rt.TypeName, rt.PricePerNight, rt.Capacity, rt.Description 
                    FROM ROOM r
                    JOIN ROOM_TYPE rt ON r.RoomTypeID = rt.RoomTypeID
                    WHERE r.RoomID = :id AND r.Status = 'Available'";
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':id', $roomId, PDO::PARAM_INT);
            $stmt->execute();
            
            // Trả về dữ liệu của 1 phòng duy nhất
            return $stmt->fetch(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            error_log("Lỗi truy vấn phòng: " . $e->getMessage());
            return false;
        }
    }
}
?>  