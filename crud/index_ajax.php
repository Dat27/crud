<?php
/**
 * crud/index_ajax.php
 * Liệt kê sp bằng cơ chế ajax - tương tác với CSDL mà k làm tải lại trang
 * - Ajax: Asynchronous Javascript And XML - Cơ chế không đồng bộ
 * - PHP: Cơ chế đồng bộ -> Chức năng code sau phải chờ chức năng trước đó chạy xong thì mới
 * đến lượt -> giống với cơ chế ngăn xếp - First in first Out
 * - Không đồng bộ: ko cần chờ chức năng trước chạy xong
 * - Ajax tạo ra website có tính trải nghiệm người dùng cao
 * -> Xử lý tốn công sức hơn so với PHP thuần
 * -> Để đơn giản nên dùng jQuery khi gọi Ajax
 * - Demo chức năng liệt kê sản phẩm bằng Ajax
 */
?>
<a href="#" id="click-ajax">Click để hiển thị danh sách sản phẩm</a><br>
<div id="result">
    <!--    Nơi hiển thị kết quả trả về của Ajax    -->
</div>
<script src="js/jquery-3.5.1.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        // alert('wedding');
        // Click vào thẻ a sẽ gọi ajax
        $('#click-ajax').click(function () {
            // Tạo 1 đối tượng ajax
            var obj_ajax = {
                // url PHP gửi data từ ajax lên
                url:'get_product_ajax.php',
                // Phương thức truyền dữ liệu: post/get
                method: 'POST',
                //data gửi lên PHP, Với chức năng liệt kê sp thì ko cần data truyền
                // ->demo
                data:{
                    name: 'Quyen',
                    age: 19,
                    address: 'HB'
                },
                // Hàm chứa kết quả trả về từ PHP
                // Tham số data(đặt tên tùy ý)
                success: function (data) {
                    console.log(data);
                    // Xử lý kết quả trả về từ PHP thông qua tham số data
                    // Hiển thị nội dung vào selector
                    $('#result').html(data);
                }

            };
            // Cách debug ajax inspectHTML->Network
            // Gọi Ajax theo cú pháp của jQuery
            $.ajax(obj_ajax);
        });
    })
</script>