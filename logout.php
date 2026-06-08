<?php
// logout.php
session_start();
session_unset();    // Xóa tất cả biến session
session_destroy();  // Hủy hoàn toàn phiên làm việc

// Đẩy người dùng về lại trang chủ
header("Location: index.php");
exit();
?>