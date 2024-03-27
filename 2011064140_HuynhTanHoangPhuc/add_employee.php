<?php
session_start();
include "connect.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SESSION['role'] !== 'admin') {
    echo "Bạn không có quyền truy cập tính năng này.";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $maNV = $_POST["ma_nv"];
    $tenNV = $_POST["ten_nv"];
    $phai = $_POST["phai"];
    $noiSinh = $_POST["noi_sinh"];
    $maPhong = $_POST["ma_phong"];
    $luong = $_POST["luong"];

    $sql = "INSERT INTO nhanvien (Ma_NV, Ten_NV, Phai, Noi_Sinh, Ma_Phong, Luong) 
            VALUES ('$maNV', '$tenNV', '$phai', '$noiSinh', '$maPhong', '$luong')";
    
    if ($conn->query($sql) === TRUE) {
        header("Location: index.php");
        exit();
    } else {
        echo "Lỗi: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Thêm Nhân Viên Mới</title>
    <script>
        function showSuccessAlert() {
            alert("Đã thêm nhân viên thành công!");
        }
    </script>
</head>
<body>

<h2 style="text-align: center;">Thêm Nhân Viên Mới</h2>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" onsubmit="showSuccessAlert()" style="text-align: center;">
    Mã Nhân Viên: <input type="text" name="ma_nv"><br><br>
    Tên Nhân Viên: <input type="text" name="ten_nv"><br><br>
    Giới tính:
    <select name="phai">
        <option value="NAM">Nam</option>
        <option value="NU">Nữ</option>
    </select><br><br>
    Nơi Sinh: <input type="text" name="noi_sinh"><br><br>
    Mã Phòng:
    <select name="ma_phong">
        <option value="KT">Kế Toán</option>
        <option value="QT">Quản Trị</option>
        <option value="TC">Tài Chính</option>
    </select><br><br>
    Lương: <input type="text" name="luong"><br><br>
    <input type="submit" value="Thêm Nhân Viên">
</form>

</body>
</html>
