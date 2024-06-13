
<!DOCTYPE html>
<html>
<head>
    <title>Lịch Gác Thi Của Tôi</title>
</head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

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
        // Load danh sách các ca thi khi trang được tải
        loadSchedule();
    });
    
    // Hàm để load lại danh sách các ca thi
    function loadSchedule() {
        $.ajax({
            url: '?page=load_schedule', // chỉnh sửa đường dẫn tới load_schedule.php
            type: 'GET',
            dataType: 'json',
            success: function(response) {
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
                        '<td><button class="cancel-btn btn btn-danger" data-examid="' + schedule.Exam_ID + '" data-roomid="' + schedule.Room_ID + '" data-teacherid="' + schedule.Teacher_ID + '" onclick="cancelSupervision(' + schedule.room_id + ', ' + schedule.Teacher_ID + ', ' + schedule.Exam_ID + ')">Huỷ</button></td>' +
                        '</tr>';
                    $('#scheduleTable tbody').append(row);
                });
            },
            error: function(xhr, status, error) {
                // Hiển thị thông báo lỗi nếu có lỗi trong yêu cầu AJAX
                $('#message').html('<div class="alert alert-danger">Có lỗi xảy ra khi tải lịch: ' + error + '</div>');
            }
        });
    }
    
    function cancelSupervision(roomId, teacherId, examId){
        var confirmCancel = confirm("Bạn có chắc chắn muốn huỷ đăng ký ca thi này không?");
        if (!confirmCancel) {
            return; // Nếu người dùng chọn "Không", không làm gì cả
        }
        console.log(roomId,teacherId,examId);
        // Gửi yêu cầu AJAX
        $.ajax({
            url: '../User/view/cancel_supervision.php', // Đường dẫn đến file xử lý hủy đăng ký gác thi
            type: 'POST',
            data: { room_id: roomId, teacher_id: teacherId, exam_id: examId },

            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    // Hiển thị thông báo thành công
                    $('#message').html('<div class="alert alert-success">' + response.message + '</div>');

                    // Load lại danh sách các ca thi sau khi huỷ thành công
                    loadSchedule();
                } else {
                    // Hiển thị thông báo lỗi
                    $('#message').html('<div class="alert alert-danger">' + response.message + '</div>');
                }
            },
            error: function(xhr, status, error) {
                // Hiển thị thông báo lỗi nếu có lỗi trong yêu cầu AJAX
                console.error('Lỗi khi gửi yêu cầu AJAX:', error);
                $('#message').html('<div class="alert alert-danger">Có lỗi xảy ra: ' + error + '</div>');
            }
        });
    }
    </script>

</body>
</html>
