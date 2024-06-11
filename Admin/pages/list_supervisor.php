<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh Sách Giảng Viên Gác Thi</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body style="font-family: Arial, sans-serif;">
    <div style="margin-top: 20px; max-width: 800px; margin-left: auto; margin-right: auto;">
        <h1 style="text-align: center;">Danh Sách Giảng Viên Gác Thi</h1>
        <div style="display: flex; margin-bottom: 15px;">
            <div style="flex: 1; padding-right: 10px;">
                <label for="fromDate">Từ ngày:</label>
                <input type="date" id="fromDate" class="form-control" style="width: 100%;">
            </div>
            <div style="flex: 1; padding-left: 10px;">
                <label for="toDate">Đến ngày:</label>
                <input type="date" id="toDate" class="form-control" style="width: 100%;">
            </div>
            <div style="padding-left: 10px;">
                <input type="text" id="searchInput" class="form-control" style="width: 100%;" placeholder="Tên hoặc mã giáo viên">
            </div>
            <div style="padding-left: 10px;">
                <button id="searchButton" class="btn btn-primary">Tìm kiếm</button>
            </div>
        </div>
        <div id="supervisorTableContainer">
            <!-- Bảng hiển thị danh sách giảng viên gác thi sẽ được tạo bằng JavaScript -->
        </div>
    </div>

    <script>
    $(document).ready(function(){
        // Load danh sách giảng viên gác thi khi trang được tải
        loadSupervisors();

        // Xử lý khi người dùng thay đổi ngày bắt đầu hoặc ngày kết thúc
        $('#fromDate, #toDate, #searchInput').change(function() {
            loadSupervisors();
        });

        // Xử lý khi người dùng click vào nút "Tìm kiếm"
        $('#searchButton').click(function() {
            loadSupervisors();
        });

        function loadSupervisors() {
            const fromDate = $('#fromDate').val();
            const toDate = $('#toDate').val();
            const searchKeyword = $('#searchInput').val();

            $.ajax({
                url: 'get_supervisors.php', // Đường dẫn đến file PHP để lấy dữ liệu giáo viên gác thi
                type: 'GET',
                data: { fromDate: fromDate, toDate: toDate, searchKeyword: searchKeyword },
                dataType: 'json',
                success: function(response) {
                    if (response.supervisors.length) {
                        $('#supervisorTableContainer').html(generateSupervisorTable(response.supervisors));
                    } else {
                        $('#supervisorTableContainer').html('<p>No supervisors found</p>');
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Failed to load supervisors:", status, error);
                }
            });
        }

        function generateSupervisorTable(supervisors) {
            let tableHtml = `<table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Exam ID</th>
                        <th>Teacher ID</th>
                        <th>Full Name</th>
                        <th>Exam Date</th>
                        <th>Subject Name</th>
                        <th>Room Name</th>
                    </tr>
                </thead>
                <tbody>`;
            supervisors.forEach(supervisor => {
                tableHtml += `<tr>
                    <td>${supervisor.Exam_ID}</td>
                    <td>${supervisor.TeacherID}</td>
                    <td>${supervisor.FullName}</td>
                    <td>${supervisor.ExamDate}</td>
                    <td>${supervisor.SubjectName}</td>
                    <td>${supervisor.room_name}</td>
                </tr>`;
            });
            tableHtml += `</tbody></table>`;
            return tableHtml;
        }
    });

    </script>
</body>
</html>
