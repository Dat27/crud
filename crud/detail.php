<?php
session_start();
require_once 'database.php';
/**
 * crud/detail.php
 * Chi tiết sản phẩm
 */

// -lấy giá trị của id từ url, giống hệt update
// -Validate id ...
if (!isset($_GET['id']) || !is_numeric($_GET['id'])){
    $_SESSION['error'] = 'id không hợp lệ';
    header('Location: index.php');
    exit();
}
$id = $_GET['id'];
// - Lấy bản ghi theo id, giống hệt update
// - Lấy dữ liệu của bản ghi đổ ra form
// - Viết truy vấn:
$sql_select_one = "SELECT * FROM products WHERE id = $id";
// - Thực thi truy vấn, với SELECT sẽ trả về obj trung gian:
$obj_result_one = mysqli_query($connection, $sql_select_one);
// - Trả về mảng kết hợp 1 chiều
$product = mysqli_fetch_assoc($obj_result_one);

//echo "<pre>";
//print_r($product);
//echo "</pre>";
?>
ID: <?php echo $product['id'] ?><br>
name: <?php echo $product['name'] ?><br>
price: <?php echo $product['price'] ?><br>
Ảnh: <img src="uploads/<?php echo $product['avatar'] ?>" height=160px"/><br>
<a href="index.php">Back</a>

