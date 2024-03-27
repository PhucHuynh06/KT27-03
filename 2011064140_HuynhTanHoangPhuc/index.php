<?php
session_start();
include "connect.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}



if (isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit();
}

function getGenderImage($gender)
{
    return ($gender == "NAM") ? "Nam.png" : (($gender == "NU") ? "Nu.png" : "unknown.jpg");
}

$records_per_page = 5;
$current_page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$start_from = ($current_page - 1) * $records_per_page;

$sql = "SELECT nhanvien.*, phongban.Ten_Phong 
        FROM nhanvien 
        INNER JOIN phongban ON nhanvien.Ma_Phong = phongban.Ma_Phong 
        LIMIT $start_from, $records_per_page";
$result = $conn->query($sql);

echo "<h2 style='text-align: center;'>2011064140_HuynhTanHoangPhuc</h2>";
echo "<h3 style='text-align: center; color: blue;'>Thông Tin Nhân Viên</h3>";

echo "<table border='1' cellpadding='5' style='margin: auto;'>";
echo "<tr><th class='red-text'>Mã Nhân Viên</th><th class='red-text'>Tên Nhân Viên</th><th class='red-text'>Giới tính</th><th class='red-text'>Nơi Sinh</th><th class='red-text'>Tên Phòng</th><th class='red-text'>Lương</th></tr>";

while ($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td class='red-text'>" . $row["Ma_NV"] . "</td>";
    echo "<td class='red-text'>" . $row["Ten_NV"] . "</td>";
    echo "<td class='red-text'><img src='" . getGenderImage($row["Phai"]) . "' alt='" . $row["Phai"] . "' width='20' height='20'></td>";
    echo "<td class='red-text'>" . $row["Noi_Sinh"] . "</td>";
    echo "<td class='red-text'>" . $row["Ten_Phong"] . "</td>"; // Hiển thị tên phòng thay vì mã phòng
    echo "<td class='red-text'>" . $row["Luong"] . "</td>";
    echo "</tr>";
}

echo "</table>";

$total_records = $conn->query("SELECT COUNT(*) AS total FROM nhanvien")->fetch_assoc()['total'];
$total_pages = ceil($total_records / $records_per_page);

echo "<div style='text-align:center;margin-top:20px;'>";
for ($i = 1; $i <= $total_pages; $i++) {
    $class = ($current_page == $i) ? 'style="background-color: #4CAF50; color: white;"' : 'style="background-color: #f2f2f2;"';
    $mouseover = "onmouseover='this.style.backgroundColor=\"#ddd\"'";
    $mouseout = "onmouseout='this.style.backgroundColor=\"#f2f2f2\"'";
    echo "<a href='?page=$i' $class $mouseover $mouseout>$i</a> ";
}
echo "</div>";

if ($_SESSION['role'] === 'admin') {
    echo "<form action='add_employee.php' method='GET' style='text-align: center; margin-top: 20px;'>";
    echo "<input type='submit' value='Thêm nhân viên'>";
    echo "</form>";
}

echo "<form action='' method='POST' style='text-align: center; margin-top: 20px;'>";
echo "<input type='submit' name='logout' value='Thoát'>";
echo "</form>";

$conn->close();
