<?php 
// 1. Nhúng các file khung xương bạn đã làm
include 'config/database.php'; 
include 'includes/header.php'; 
?>

<div class="p-5 mb-4 bg-light rounded-3 text-center" style="background-image: url('assets/img/hotel-banner.jpg'); background-size: cover;">
    <div class="container-fluid py-5">
        <h1 class="display-5 fw-bold">Chào mừng đến với Luxury Hotel</h1>
        <p class="fs-4">Trải nghiệm dịch vụ nghỉ dưỡng đẳng cấp 5 sao ngay tại trung tâm thành phố.</p>
        <a href="#room-list" class="btn btn-primary btn-lg">Đặt phòng ngay</a>
    </div>
</div>

<div class="container" id="room-list">
    <h2 class="text-center mb-4">Các loại phòng nghỉ</h2>
    <div class="row">
        <?php
        // Truy vấn lấy danh sách phòng
        $sql = "SELECT * FROM rooms";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        <img src="assets/img/rooms/<?php echo $row['img'] ? $row['img'] : 'default-room.jpg'; ?>" class="card-img-top" alt="Room Image">
                        
                        <div class="card-body">
                            <h5 class="card-title">Phòng <?php echo $row['room_number']; ?></h5>
                            <p class="card-text text-muted">Loại: <?php echo $row['room_type']; ?></p>
                            <p class="card-text"><strong>Giá: <?php echo number_format($row['price']); ?> VNĐ/đêm</strong></p>
                            
                            <?php if($row['status'] == 'available'): ?>
                                <span class="badge bg-success mb-3">Còn trống</span>
                                <br>
                                <a href="booking.php?id=<?php echo $row['room_id']; ?>" class="btn btn-outline-primary w-100">Đặt ngay</a>
                            <?php else: ?>
                                <span class="badge bg-danger mb-3">Đã đặt</span>
                                <button class="btn btn-secondary w-100" disabled>Hết phòng</button>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php
            }
        } else {
            echo "<p class='text-center'>Hiện chưa có phòng nào được cập nhật.</p>";
        }
        ?>
    </div>
</div>

<?php 
// 4. Nhúng chân trang
include 'includes/footer.php'; 
?>