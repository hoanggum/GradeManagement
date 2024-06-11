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
                    <form id="addSectionForm">
                        <div class="mb-3">
                            <label for="className" class="form-label">Tên Lớp</label>
                            <input type="text" class="form-control" id="className" required>
                        </div>
                        <div class="mb-3">
                            <label for="semester" class="form-label">Học Kỳ</label>
                            <input type="text" class="form-control" id="semester" required>
                        </div>
                        <div class="mb-3">
                            <label for="studentCount" class="form-label">Sỉ Số</label>
                            <input type="number" class="form-control" id="studentCount" min="30" max="120" required>
                        </div>
                        <input type="hidden" id="subjectId">
                        <button type="submit" class="btn btn-primary">Thêm</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
    $(document).ready(function(){
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
                        var subjectId = $(this).data('subjectid');
                        $('#subjectId').val(subjectId);
                        $('#addSectionModal').modal('show');
                    });
                }
            });
        }

        // Hàm xử lý khi form thêm lớp học phần được submit
        $('#addSectionForm').submit(function(e){
            e.preventDefault();
            var className = $('#className').val();
            var semester = $('#semester').val();
            var studentCount = $('#studentCount').val();
            var subjectId = $('#subjectId').val();

            // Gửi yêu cầu AJAX để thêm lớp học phần
            $.ajax({
                url: '../Admin/pages/add_section.php',
                type: 'POST',
                data: {
                    className: className,
                    semester: semester,
                    studentCount: studentCount,
                    subjectId: subjectId
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
                }
            });
        });
    });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
