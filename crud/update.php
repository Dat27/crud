<?php
session_start();
require_once "database.php";
/**
 * crud/update.php
 * Form cập nhật sản phẩm
 * Thường form cập nhật sản phẩm giống hệt form thêm mới, chỉ khác ở dữ liệu mặc định đó
 * ra form -> copy html
 * Thêm mới -> paste sang form cập nhật
 *
 * Lấy dữ liệu từ bản ghi tương ứng để đổ ra form
 * Url:update.php?id=2
 *
*/
// - Validate tham số id trên url
if (!isset($_GET['id']) || !is_numeric($_GET['id'])){
    $_SESSION['error'] = 'id không hợp lệ';
    header('Location: index.php');
    exit();
}
$id = $_GET['id'];
// - Lấy dữ liệu của bản ghi đổ ra form
// - Viết truy vấn:
$sql_select_one = "SELECT * FROM products WHERE id = $id";
// - Thực thi truy vấn, với SELECT sẽ trả về obj trung gian:
$obj_result_one = mysqli_query($connection, $sql_select_one);
// - Trả về mảng kết hợp 1 chiều
$product = mysqli_fetch_assoc($obj_result_one);

// - Quay lại xử lý submit form, tương tự như thêm mới
// - Debug
//echo "<pre>";
//print_r($_POST);
//print_r($_FILES);
//echo "</pre>";
//  + Tạo biến chứa lỗi
$error = '';
//  + Nếu submit form thì mới xử lý
if (isset($_POST['submit'])){
    // + Tạo biến trung gian
    $name = $_POST['name'];
    $price = $_POST['price'];
    $avatar_arr = $_FILES['avatar'];
    // + Validate form: giống như thêm mới

    // + Xử lý upload file nếu có và cập nhật dữ liệu chỉ khi không có lỗi
    if (isset($_POST['submit'])){
        $name = $_POST['name'];
        $price = $_POST['price'];
        $avt_arr = $_FILES['avatar'];
        if (empty($name)|| empty($price)){
            $error = 'Nhập tên hoặc giá';
        }elseif ($avt_arr['error'] == 0){
            // + Validate file phải là ảnh
            $extention = pathinfo($avt_arr['name'], PATHINFO_EXTENSION);//Lấy đuôi file từ tên file
            // + Chuyển về chữ thường
            $extention = strtolower($extention);
            // + Tạo mảng các đuôi file ảnh hợp lệ
            $allowed = ['jpg','jpeg','png','gif'];
            // + Kiểm tra trong mảng
            if (!in_array($extention, $allowed)){
                $error = 'File upload phải là ảnh';
            }
            // + Validate file update dung lượng <= 2MB
            $size_mb = $avt_arr['size'] / 1024/1024;
            $size_mb = round($size_mb,2);
            if ($size_mb > 2) {
                $error ='File upload dung lượng phải không quá 2MB';
            }
        }
        if (empty($error)){
            // Xử lý upload file nếu có
            // Khởi tạo biến chứa tên file đang có của sản phẩm
            $avatar = $product['avatar'];
            if ($avatar_arr['error'] == 0) {
                // Xóa ảnh cũ đi tránh rác hệ thống, ký tự @ hack ko báo lỗi nếu xóa 1 file mà không tồn tại
                @unlink('upload/' . $avatar);
                // + Bỏ qua bước tạo thư mục uploads vì đã tồn tại khi xử lý thêm mới
                // Sinh file mang tính duy nhất
                $avatar = time() . "-" . $avatar_arr ['name'];
                move_uploaded_file($avatar_arr['tmp_name'], "uploads/$avatar");
            }
            // + Tương tác với CSDL đễ update dữ liệu
            //  + Viết truy vấn:
            $sql_update = "UPDATE products SET name='$name', price = $price, avatar = '$avatar' 
            WHERE id = $id";
            //  + Thực thi truy vấn
            $is_update = mysqli_query($connection, $sql_update);
            var_dump($is_update);
            if ($is_update){
                $_SESSION['success'] = "update thành công";
                header("Location: index.php");
                exit();
            }else{
                $error = 'Update thất bại';
            }
        }

    }
}
?>
<h3 style="color: red"><?php echo $error ?></h3>
<h1>Form cập nhật sản phẩm</h1>
<form action="" method="post" enctype="multipart/form-data">
    Tên sp: <input type="text" name="name" value="<?php echo $product['name'] ?>"><br>
    Giá sp: <input type="number" name="price" value="<?php echo $product['price'] ?>"><br>

    Ảnh sản phẩm: <input type="file" name="avatar"><br>
    <img src="uploads/<?php echo $product['avatar'] ?>" height="80px"/><br>
    <input type="submit" name="submit" value="Cập nhật"><br>
    <a href="index.php">Quay lại trang trước</a>
</form>

