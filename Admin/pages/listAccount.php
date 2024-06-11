<?php
// Include các file cần thiết
include_once '../Model/User.php';

$userController = new User();
$employees = $userController->getAllUsers();

// Kiểm tra nếu $employees là một mảng hợp lệ trước khi sử dụng nó
if(is_array($employees) && !empty($employees)) {
?>
<style>
        .container {
            position: relative;
        }
        .working {
            background-color: #d4edda; 
            padding: 2px 5px; 
            border-radius: 3px; 
        }
        .resigned {
            background-color: #f8d7da; 
            padding: 2px 5px;
            border-radius: 3px;
        }
        .back-btn {
            position: absolute;
            top: 30px;
            left: 15px;
            font-size: 24px;
            color: #007bff;
            cursor: pointer;
        }
        .next-btn {
            position: absolute;
            top: 30px;
            right: 15px;
            font-size: 24px;
            color: #007bff;
            cursor: pointer;
        }

        .back-btn:hover {
            color: #0056b3;
        }
        .card-body {
            text-align: center; 
        }

        .card-title {
            color: #007bff; 
        }
        .employee-image {
            width: 90px; 
            height: auto; 
            float: right; 
        }
        .table td {
            font-size: 14px; 
        }
        .search-container {
            margin-bottom: 20px;
            /* Sử dụng flexbox để căn chỉnh thành phần */
            display: flex;
        }
        #searchInput{
            background-color:floralwhite ;
        }
        .search-container input[type=text] {
            padding: 10px; /* Đặt kích thước đệm */
            margin-top: 8px;
            font-size: 17px;
            border: none;
            border-radius: 5px; /* Bo tròn góc */
            /* Sử dụng flex-grow để kéo dài ra */
            flex-grow: 1;
        }
        .search-container button {
            padding: 10px 15px; /* Đặt kích thước đệm */
            margin-top: 8px;
            margin-left: 5px;
            background:black;
            font-size: 17px;
            border: none;
            border-radius: 5px; /* Bo tròn góc */
            cursor: pointer;
            color: white;
        }
        .search-container button:hover {
            background: gray;
        }
</style>

<div class="container">
        <div class="search-container">
            <input type="text" id="searchInput" placeholder="Tìm kiếm...">
            <button type="button" onclick="search()">Tìm kiếm</button>
        </div>
        <h1>Danh sách tài khoản</h1>

        <div class="table-responsive">

        <table class="table" id="accountTable">
            <thead class="table-dark">
                <tr>
                    <th scope="col">STT</th>
                    <th scope="col">Họ và tên</th>
                    <th scope="col">Email</th>
                    <th scope="col">Số điện thoại</th>
                    <th scope="col">Tài khoản</th>
                    <th scope="col" style="text-align: center;">Trạng thái</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($employees as $key => $employee): ?>
                <tr>
                    <th scope="row"><?php echo $key + 1; ?></th>
                    <td><?php echo $employee['FullName']; ?></td>
                    <td><?php echo $employee['Email']; ?></td>
                    <td><?php echo $employee['Phone']; ?></td>
                    <td><?php echo $employee['Username']; ?></td>
                    <td style="text-align: center;">
                        <?php
                            if ($employee['Status'] != 'Đã nghỉ việc') {
                                echo '<span class="working">Đang hoạt động</span>';

                            } else {
                                echo '<span class="resigned">Ngừng hoạt động</span>';
                            }
                        ?>
                    </td>

                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        </div>
</div>
<?php
} else {
    echo "Không có nhân viên nào được tìm thấy.";
}
?>

<script>
        new DataTable('#accountTable');

        function search() {
            var input, filter, table, tr, td, i, j, txtValue;
            input = document.getElementById("searchInput");
            filter = input.value.toUpperCase();
            table = document.getElementById("employeeTable");
            tr = table.getElementsByTagName("tr");

            for (i = 0; i < tr.length; i++) {
                var display = "none";

                for (j = 0; j < tr[i].cells.length; j++) {
                    td = tr[i].cells[j];
                    if (td) {
                        txtValue = td.textContent || td.innerText;
                        if (txtValue.toUpperCase().indexOf(filter) > -1) {
                            display = "";
                            break;
                        }
                    }
                }
                tr[i].style.display = display;
            }
        }
</script>
