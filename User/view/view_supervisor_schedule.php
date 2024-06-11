<!DOCTYPE html>
<html>
<head>
    <title>Lịch Gác Thi Của Tôi</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
    <div class="container mt-5">
        <h1 style="text-align: center;">Lịch Gác Thi Của Tôi</h1>
        <div id="message"></div>
        <table class="table table-bordered" id="scheduleTable">
            <thead>
                <tr>
                    <th>Mã thi</th>
                    <th>Ngày thi</th>
                    <th>Ca thi</th>
                    <th>Giờ thi</th>
                    <th>Thời gian</th>
                    <th>Môn học</th>
                    <th>Phòng</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <!-- Bảng hiển thị danh sách các ca thi -->
            </tbody>
        </table>
    </div>

    <script>
    $(document).ready(function(){
        // Hàm xử lý khi click vào button huỷ đăng ký
        $('body').on('click', '.cancel-btn', function(e){
            e.preventDefault();
            var examId = $(this).data('examid');

            // Gửi yêu cầu AJAX
            $.ajax({
                url: '../User/view/cancel_supervision.php', // chỉnh sửa đường dẫn tới cancel_supervision.php
                type: 'POST',
                data: {exam_id: examId},
                dataType: 'json',
                success: function(response) {
                    if(response.success) {
                        // Hiển thị thông báo thành công
                        $('#message').html('<div class="alert alert-success">' + response.message + '</div>');

                        // Xóa và cập nhật lại dữ liệu trong bảng
                        $('#scheduleTable tbody').empty();
                        $.each(response.data, function(index, schedule) {
                            var row = '<tr>' +
                                '<td>' + schedule.Exam_ID + '</td>' +
                                '<td>' + schedule.ExamDate + '</td>' +
                                '<td>' + schedule.ExamRound + '</td>' +
                                '<td>' + schedule.ExamTime + '</td>' +
                                '<td>' + schedule.Duration + ' phút</td>' +
                                '<td>' + schedule.SubjectName + '</td>' +
                                '<td>' + schedule.room_name + '</td>' +
                                '<td><button class="cancel-btn" data-examid="' + schedule.Exam_ID + '">Huỷ</button></td>' +
                                '</tr>';
                            $('#scheduleTable tbody').append(row);
                        });
                    } else {
                        // Hiển thị thông báo lỗi
                        $('#message').html('<div class="alert alert-danger">' + response.message + '</div>');
                    }
                }
            });
        });

        // Load danh sách các ca thi khi trang được tải
        loadSchedule();
    });

    // Hàm để load lại danh sách các ca thi
    function loadSchedule() {
        $.ajax({
            url: '../User/view/load_schedule.php', // chỉnh sửa đường dẫn tới load_schedule.php
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                console.log(response); // In ra dữ liệu trả về trong Console
                $('#scheduleTable tbody').empty(); // Xóa dữ liệu cũ trước khi load dữ liệu mới
                $.each(response, function(index, schedule) {
                    var row = '<tr>' +
                        '<td>' + schedule.Exam_ID + '</td>' +
                        '<td>' + schedule.ExamDate + '</td>' +
                        '<td>' + schedule.ExamRound + '</td>' +
                        '<td>' + schedule.ExamTime + '</td>' +
                        '<td>' + schedule.Duration + ' phút</td>' +
                        '<td>' + schedule.SubjectName + '</td>' +
                        '<td>' + schedule.room_name + '</td>' +
                        '<td><button class="cancel-btn" data-examid="' + schedule.Exam_ID + '">Huỷ</button></td>' +
                        '</tr>';
                    $('#scheduleTable tbody').append(row);
                });
            }
        });
    }
    </script>

</body>
</html>
