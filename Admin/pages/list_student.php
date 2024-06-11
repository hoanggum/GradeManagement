<!DOCTYPE html>
<html>
<head>
    <title>Danh Sách Sinh Viên</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body style="font-family: Arial, sans-serif;">
    <div style="margin-top: 20px; max-width: 800px; margin-left: auto; margin-right: auto;">
        <h1 style="text-align: center;">Danh Sách Sinh Viên</h1>
        <div style="display: flex; margin-bottom: 15px;">
            <div style="flex: 1; padding-right: 10px;">
                <label for="departmentSelect">Khoa:</label>
                <select id="departmentSelect" class="form-select" style="width: 100%;">
                    <option value="">----</option>
                </select>
            </div>
            <div style="flex: 1; padding-left: 10px; padding-right: 10px;">
                <label for="classSelect">Lớp:</label>
                <select id="classSelect" class="form-select" style="width: 100%;">
                    <option value="">----</option>
                </select>
            </div>
            <div style="flex: 1; padding-left: 10px;">
                <input type="text" id="searchInput" class="form-control" style="width: 100%;" placeholder="Tên hoặc mã số sinh viên">
            </div>
            <div style="padding-left: 10px;">
                <button id="searchButton" class="btn btn-primary">Tìm kiếm</button>
            </div>
        </div>
        <div id="studentTableContainer">
            <!-- Bảng hiển thị danh sách sinh viên -->
        </div>
        <div style="display: flex; justify-content: center;">
            <nav>
                <ul class="pagination">
                    <!-- Phân trang sẽ được thêm ở đây -->
                </ul>
            </nav>
        </div>
    </div>

    <script>
    $(document).ready(function(){
        loadStudents(); // Load toàn bộ sinh viên khi trang được tải

        // Hàm để load danh sách các khoa
        function loadDepartments() {
            $.ajax({
                url: '../Admin/pages/get_departments.php',
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    $('#departmentSelect').append(response.map(department => 
                        `<option value="${department.DepartmentID}">${department.DepartmentName}</option>`
                    ));
                }
            });
        }

        // Hàm để load danh sách các lớp thuộc khoa
        $('#departmentSelect').change(function() {
            const departmentId = $(this).val();
            if(departmentId) {
                $.ajax({
                    url: '../Admin/pages/get_classes.php',
                    type: 'GET',
                    data: { departmentId: departmentId },
                    dataType: 'json',
                    success: function(response) {
                        $('#classSelect').empty().append('<option value="">----</option>');
                        $('#classSelect').append(response.map(cls => 
                            `<option value="${cls.ClassID}">${cls.className}</option>`
                        ));
                    }
                });
            } else {
                $('#classSelect').empty().append('<option value="">----</option>');
            }
            loadStudents();
        });

        // Hàm để load danh sách sinh viên
        function loadStudents(page = 1) {
            const departmentId = $('#departmentSelect').val();
            const classId = $('#classSelect').val();
            const search = $('#searchInput').val();

            $.ajax({
                url: '../Admin/pages/get_students.php',
                type: 'GET',
                data: { 
                    departmentId: departmentId, 
                    classId: classId, 
                    search: search, 
                    page: page 
                },
                dataType: 'json',
                success: function(response) {
                    $('#studentTableContainer').html(generateStudentTable(response.students));
                    generatePagination(response.totalPages, page);
                }
            });
        }

        // Hàm để tạo bảng hiển thị danh sách sinh viên
        function generateStudentTable(students) {
            let tableHtml = `<table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr>
                        <th style="border: 1px solid #ddd; padding: 8px;">Mã Sinh Viên</th>
                        <th style="border: 1px solid #ddd; padding: 8px;">Tên Sinh Viên</th>
                        <th style="border: 1px solid #ddd; padding: 8px;">Lớp</th>
                        <th style="border: 1px solid #ddd; padding: 8px;">Khoa</th>
                    </tr>
                </thead>
                <tbody>`;
            students.forEach(student => {
                tableHtml += `<tr>
                    <td style="border: 1px solid #ddd; padding: 8px;">${student.StudentID}</td>
                    <td style="border: 1px solid #ddd; padding: 8px;">${student.FullName}</td>
                    <td style="border: 1px solid #ddd; padding: 8px;">${student.className}</td>
                    <td style="border: 1px solid #ddd; padding: 8px;">${student.DepartmentName}</td>
                </tr>`;
            });
            tableHtml += `</tbody></table>`;
            return tableHtml;
        }

        // Hàm để tạo phân trang
        function generatePagination(totalPages, currentPage) {
            let paginationHtml = '';
            for (let i = 1; i <= totalPages; i++) {
                paginationHtml += `<li class="page-item ${i === currentPage ? 'active' : ''}">
                    <a class="page-link" href="#">${i}</a>
                </li>`;
            }
            $('.pagination').html(paginationHtml);

            $('.page-link').click(function(e) {
                e.preventDefault();
                loadStudents($(this).text());
            });
        }

        // Load danh sách sinh viên khi thay đổi lớp hoặc tìm kiếm
        $('#classSelect').change(loadStudents);
        $('#searchInput').keyup(loadStudents);

        // Tìm kiếm khi click nút
        $('#searchButton').click(function() {
            loadStudents();
        });
    });
    </script>
</body>
</html>
