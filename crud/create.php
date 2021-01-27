<?php
require_once 'database.php';
session_start();
/**
 * crud/create.php C - Create
 *  -Là chức năng dựng đầu tiên  của CRUD, tạo dữ liệu cho các chức năng còn lại sử dụng
 *  -Form thêm mới sp:
 * products: id, name, price, avatar, created_at
 * Chỉ cho phép nhập name, price, avtar (thêm thủ công)
 */
?>
<?php
// Xử lý submit form
//  + Debug: $_POST, $_FILES
//  + Tạo biến chứa lỗi
//  + Nếu submit form thì mới xử lý
//  + Gán biến
//  + Validate

//    echo "<pre>";
//    print_r($_POST);
//    print_r($_FILES);
//    echo "</pre>";

    $error = '';

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

        // + Lưu vào DB, xử lý upload file nếu có chỉ khi không có lỗi gì xảy ra
        if (empty($error)){
            // Tạo biến chứa tên file
            $avt = '';
            // Xử lý upload file nếu có
            if ($avt_arr['error']==0){
                // Tạo thư mục chứa file sẽ upload vào
                $dir_upload = 'uploads';
                //  +Luôn check nếu chưa tồn tại thư mục thì mới tạo
                if (!file_exists($dir_upload)){
                    mkdir($dir_upload);
                }
                //  +Sinh tên file mang tính duy nhất trước khi upload để tránh ghi đè file
                $avt = time() . "-" . $avt_arr['name'];
                //  +Upload file: chuyển file từ thư mục tạm của XAMPP đến đường dẫn đích
                move_uploaded_file($avt_arr['tmp_name'],"$dir_upload/$avt");
            }
            // -Xử lý lưu vào bảng products
            //  + Viết truy vấn
            $sql_insert = "INSERT INTO products(name , price, avatar)VALUES ('$name', $price, '$avt')";
            //  + Thực thi truy vấn:
            $is_insert = mysqli_query($connection, $sql_insert);
//            var_dump($is_insert);
            if ($is_insert){
                $_SESSION['success']='Thêm mới sp thành công';
                header('Location:index.php');
                exit();
            }else{
                $error = 'Thêm thất bại';
            }
        }
    }

?>
<h3 style="color: red"><?php echo $error ?></h3>

<h1>Form thêm mới sản phẩm</h1>

<form action="" method="post" enctype="multipart/form-data">
    Nhập tên: <input type="text" name="name" value=""><br>
    Nhập giá: <input type="number" name="price" value=""><br>
    Ảnh sản phẩm: <input type="file" name="avatar"><br>
    <input type="submit" name="submit" value="Lưu"><br>
    <a href="index.php">Quay lại trang trước</a>
</form>
