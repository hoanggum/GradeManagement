<?php
require_once '../Model/Subject.php';
// $userId = $_SESSION['UserID'];
// Instantiate the Semester class
$SubjectObj = new Subject();
$subjects = $SubjectObj->getAllSubjects();
?>

<div class="container mt-5">
    <h2 class="text-center">Tạo lịch thi</h2>
    <form id="examForm">
        <div class="form-group">
            <label for="subject">Môn học</label>
            <select class="form-control" id="subject" onchange="loadSections(this.value)">
                <option value="">Chọn môn học</option>
                <?php foreach ($subjects as $subject): ?>
                    <option value="<?php echo $subject['SubjectID'] ?>"><?php echo $subject['SubjectName'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="section">Học phần</label>
            <select class="form-control" id="section" required>
                <option value="">Chọn học phần</option>
                <!-- Danh sách các học phần sẽ được nạp động từ cơ sở dữ liệu sau khi chọn môn học -->
            </select>
        </div>
        <div class="form-group">
            <label for="examDate">Ngày thi</label>
            <input type="date" class="form-control" id="examDate" required>
        </div>
        <div class="form-group">
            <label for="examRound">Vòng thi</label>
            <input type="number" class="form-control" id="examRound" required>
        </div>
        <div class="form-group">
            <label for="examTime">Giờ thi</label>
            <input type="time" class="form-control" id="examTime" required>
        </div>
        <div class="form-group">
            <label for="duration">Thời lượng (phút)</label>
            <input type="number" class="form-control" id="duration" required>
        </div>
        <button type="button" class="btn btn-primary" onclick="createExam()">Tạo lịch thi</button>
    </form>
</div>

<script>
    function loadSections(subjectId) {
        if (subjectId === "") {
            $('#section').html('<option value="">Chọn học phần</option>');
            return;
        }

        $.ajax({
            url: '?page=get_sections',
            method: 'GET',
            data: { subjectId: subjectId },
            success: function(data) {
                var sections = JSON.parse(data);
                $('#section').html('<option value="">Chọn học phần</option>');
                for (var i = 0; i < sections.length; i++) {
                    $('#section').append('<option value="' + sections[i].id + '">' + sections[i].name + '</option>');
                }
            },
            error: function(xhr, status, error) {
                console.error('Lỗi khi tải danh sách học phần:', error);
                alert('Lỗi khi tải danh sách học phần. Vui lòng thử lại sau.');
            }
        });
    }

    function createExam() {
        var subjectId = $('#subject').val();
        var sectionId = $('#section').val();
        var examDate = $('#examDate').val();
        var examRound = $('#examRound').val();
        var examTime = $('#examTime').val();
        var duration = $('#duration').val();

        $.ajax({
            url: 'create_exam.php',
            method: 'POST',
            data: {
                subjectId: subjectId,
                sectionId: sectionId,
                examDate: examDate,
                examRound: examRound,
                examTime: examTime,
                duration: duration
            },
            success: function(response) {
                var result = JSON.parse(response);
                if (result.success) {
                    alert('Lịch thi và phân chia học sinh vào phòng thi đã được tạo thành công!');
                } else {
                    alert('Đã tạo lịch thi nhưng gặp lỗi khi phân chia học sinh vào phòng thi.');
                }
            },
            error: function(xhr, status, error) {
                console.error('Lỗi khi tạo lịch thi:', error);
                alert('Lỗi khi tạo lịch thi. Vui lòng thử lại sau.');
            }
        });
    }
</script>
