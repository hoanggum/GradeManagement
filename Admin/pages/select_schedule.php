<?php
require_once '../Model/ExamSchedule.php';

$examScheduleObj = new ExamSchedule();
$examSchedules = $examScheduleObj->getAllExamSchedules();
?>
<style>
    .container {
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
}

#examScheduleFormContainer {
    margin-bottom: 20px;
}

#examScheduleForm {
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
    background-color: #f9f9f9;
}

#schedule {
    width: 100%;
    padding: 10px;
    border-radius: 5px;
    border: 1px solid #ccc;
}

#viewExamRoomsBtn {
    margin-top: 10px;
}

#examRoomListContainer {
    border: 1px solid #ccc;
    border-radius: 5px;
    padding: 20px;
    background-color: #f9f9f9;
}
</style>
<div class="container">
    <h2 class="mt-5">Chọn lịch thi</h2>
    <div id="examScheduleFormContainer"> <!-- Wrap the form in a div with an id -->
        <form id="examScheduleForm" action="view_exam_room_list.php" method="GET">
            <div class="mb-3">
                <label for="schedule" class="form-label">Lịch thi:</label>
                <select name="exam_id" id="schedule" class="form-select">
                    <?php foreach ($examSchedules as $schedule) : ?>
                        <option value="<?php echo $schedule['Exam_ID']; ?>">
                            <?php echo "Ngày thi: ".$schedule['ExamDate'] . " - Lần thi: " . $schedule['ExamRound'] . " - Giờ thi:" . $schedule['ExamTime'].'h' . " - Thời lượng: " . $schedule['Duration']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="button" id="viewExamRoomsBtn" class="btn btn-primary">Xem danh sách phòng thi</button>
        </form>
    </div>
    <div id="examRoomListContainer"></div> <!-- Container to display the exam room list -->
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('viewExamRoomsBtn').addEventListener('click', function (event) {
        event.preventDefault(); // Prevent default button behavior
        
        // Get the selected exam_id
        var examId = document.getElementById('schedule').value;

        // Send AJAX request
        var xhr = new XMLHttpRequest();
        xhr.open('GET', '?page=get_exam_rooms&exam_id=' + examId, true);
        xhr.onreadystatechange = function () {
            if (xhr.readyState == XMLHttpRequest.DONE) {
                if (xhr.status == 200) {
                    document.getElementById('examRoomListContainer').innerHTML = xhr.responseText;
                } else {
                    console.error('Error:', xhr.statusText);
                }
            }
        };
        xhr.send();
    });
});
</script>
