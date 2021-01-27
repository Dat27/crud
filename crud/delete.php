<?php
session_start();
require_once 'database.php';
/**
 * crud/delete.php
 * Xóa sản phẩm theo id
 */
// - Lấy id từ url, validate id giống hệt updat/detail
if (!isset($_GET['id']) || !is_numeric($_GET['id'])){
    $_SESSION['error'] = 'id không hợp lệ';
    header('Location: index.php');
    exit();
}
$id = $_GET['id'];
// - Tương tác CSDL để xóa bản ghi theo id
// - Viết truy vấn
$sql_delete = "DELETE FROM products WHERE id = $id";
// Thực thi truy vấn
$is_delete = mysqli_query($connection, $sql_delete);
if ($is_delete){
    $_SESSION['success'] = "Xóa dữ liệu thành công";
}else{
    $_SESSION['error'] = "Xóa thất bại";
}
header("Location: index.php");
exit();
?>