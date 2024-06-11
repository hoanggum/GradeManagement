<!DOCTYPE html>
<html>
<head>
    <title>Tạo Lớp Học Phần</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
    <div class="container mt-5">
        <h1 style="text-align: center;">Tạo Lớp Học Phần</h1>
        <div id="message"></div>
        <table class="table table-bordered" id="subjectTable">
            <thead>
                <tr>
                    <th>Mã Môn Học</th>
                    <th>Tên Môn Học</th>
                    <th>Hành Động</th>
                </tr>
            </thead>
            <tbody>
                <!-- Bảng hiển thị danh sách các môn học -->
            </tbody>
        </table>
    </div>

    <!-- Modal để thêm lớp học phần -->
    <div class="modal fade" id="addSectionModal" tabindex="-1" aria-labelledby="addSectionModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addSectionModalLabel">Thêm Lớp Học Phần</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                        <form id="addSectionForm" action="?page=add_section" enctype="multipart/form-data" method="post">
                            <input type="hidden" id="subjectID" name="subjectID">
                            <div class="mb-3">
                                <label for="startDate" class="form-label">Ngày Bắt Đầu</label>
                                <input type="date" class="form-control" name="startDate" id="startDate" required>
                            </div>
                            <div class="mb-3">
                                <label for="endDate" class="form-label">Ngày Kết Thúc</label>
                                <input type="date" class="form-control" name="endDate" id="endDate" required>
                            </div>
                            <div class="mb-3">
                                <label for="schedule" class="form-label">Lịch Học</label>
                                <input type="text" class="form-control" name="schedule" id="schedule" required>
                            </div>
                            <div class="mb-3">
                                <label for="semester" class="form-label">Học Kỳ</label>
                                <input type="text" class="form-control" name="semester" id="semester" required>
                            </div>
                            <button type="submit" name="submit" class="btn btn-primary">Tạo Học Phần</button>
                        </form>
                        <tbody id="sectionList">
                            <!-- Danh sách các lớp học phần sẽ được thêm vào đây -->
                        </tbody>
                </div>
            </div>
        </div>
    </div>

    < <script>
        $(document).ready(function(){
            var selectedSubjectID; // Biến để lưu trữ subjectID được chọn

            loadSubjects();

            // Hàm để load danh sách các môn học
            function loadSubjects() {
                $.ajax({
                    url: '../Admin/pages/get_subjects.php',
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        $('#subjectTable tbody').empty();
                        $.each(response, function(index, subject) {
                            var row = '<tr>' +
                                '<td>' + subject.SubjectID + '</td>' +
                                '<td>' + subject.SubjectName + '</td>' +
                                '<td><button class="btn btn-primary add-section-btn" data-subjectid="' + subject.SubjectID + '">Thêm Lớp Học Phần</button></td>' +
                                '</tr>';
                            $('#subjectTable tbody').append(row);
                        });

                        // Gắn sự kiện click cho nút thêm lớp học phần
                        $('.add-section-btn').click(function(){
                            selectedSubjectID = $(this).data('subjectid');
                            $('#subjectID').val(selectedSubjectID);
                            $('#addSectionModal').modal('show');
                            
                            loadSections(selectedSubjectID);
                             // Gọi hàm để tải danh sách lớp học phần
                        });
                    }
                });
            }

            // Hàm để load danh sách các lớp học phần
          // Hàm để load danh sách các lớp học phần
            function loadSections(subjectID) {
                $.ajax({
                    url: '?page=get_sections.php', // Đường dẫn tới file xử lý AJAX để lấy danh sách các lớp học phần
                    type: 'GET',
                    data: { subjectId: subjectID },
                    dataType: 'json',
                    success: function(response) {
                        $('#sectionList').empty(); // Xóa danh sách cũ
                        $.each(response, function(index, section) {
                            var row = '<tr>' +
                                '<td>' + section.SectionName + '</td>' +
                                '<td>' + section.StartDate + '</td>' +
                                '<td>' + section.EndDate + '</td>' +
                                '<td>' + section.Schedule + '</td>' +
                                '<td>' + section.Semester + '</td>' +
                                '</tr>';
                            $('#sectionList').append(row); // Thêm lớp học phần vào danh sách
                        });
                    }
                });
            }


            // Hàm xử lý khi form thêm lớp học phần được submit
            $('#addSectionForm').submit(function(e){
                // e.preventDefault();
                var sectionName = $('#sectionName').val();
                var startDate = $('#startDate').val();
                var endDate = $('#endDate').val();
                var schedule = $('#schedule').val();
                var semester = $('#semester').val();

                // Lấy giá trị subjectID được lưu từ trước
                var subjectID = selectedSubjectID;
                
                // Gửi yêu cầu AJAX để thêm lớp học phần
                $.ajax({
                    url: '?page=add_section.php',
                    type: 'POST',
                    data: {
                        sectionName: sectionName,
                        startDate: startDate,
                        endDate: endDate,
                        schedule: schedule,
                        subjectID: subjectID,
                        semester: semester
                    },
                    dataType: 'json',
                    success: function(response) {
                        if(response.success) {
                            $('#message').html('<div class="alert alert-success">' + response.message + '</div>');
                            $('#addSectionModal').modal('hide');
                            loadSubjects();
                        } else {
                            $('#message').html('<div class="alert alert-danger">' + response.message + '</div>');
                        }
                        alert('hi');
                    }
                });
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
