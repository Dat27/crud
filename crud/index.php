<?php
/**
 * cruv/index.php
 */
session_start();
require_once 'database.php';
?>

<?php
//session dạng flash
if (isset($_SESSION['success'])) {
    echo $_SESSION['success'];
    unset($_SESSION['success']);
}
// Session dạng flash, hiển thị lỗi nếu có
if (isset($_SESSION['error'])) {
    echo $_SESSION['error'];
    unset($_SESSION['error']);
}
// Xử lý lấy dữ liệu từ bảng products
//      + Viết truy vấn: Theo thứ tự giảm dần của ngày tạo
$sql_select_all = "SELECT * FROM products ORDER BY created_at DESC";
//  + Thực thi truy vấn
$obj_result_all = mysqli_query($connection, $sql_select_all);
//  + Lấy dữ liệu trả về dưới dạng mảng kết hợp
$products = mysqli_fetch_all($obj_result_all, MYSQLI_ASSOC);
//echo "<pre>";
//print_r($products);
//echo "</pre>";
?>


<a href="create.php">Thêm mới sản phẩm</a>
<table border="1" cellspacing="0" cellpadding="8">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Price</th>
        <th>Avatar</th>
        <th>Created_at</th>
        <th></th>
    </tr>
    <?php foreach ($products AS $product): ?>
        <tr>
            <td><?php echo $product['id']; ?></td>
            <td><?php echo $product['name']; ?></td>
            <td>
                <?php echo number_format($product['price']);?>
            </td>
            <td><img src="uploads/<?php echo $product['avatar'] ?>" height="80px"></td>
            <td>

            <?php
            $created_at = date('d-M-Y H:i:s', strtotime($product['created_at']));
            echo $created_at;
            ?>
            </td>
            <td>
                <?php
                $url_detail = "detail.php?id=" . $product['id'];
                $url_update = "update.php?id=" . $product['id'];
                $url_delete = "delete.php?id=" . $product['id'];
                ?>
                <a href="<?php echo $url_detail;?>">Chi tiết</a>
                <a href="<?php echo $url_update;?>">Sửa</a>
                <a href="<?php echo $url_delete;?>" onclick="return confirm('Xóa dữ liệu?')">Xóa
            </td>
        </tr>
    <?php endforeach; ?>
</table>
