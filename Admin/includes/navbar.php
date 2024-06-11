<div class="taskbar">
    <div class="logo header-item">
        <a href="#">
            <svg id="logo-nike" viewBox="0 0 24 24" width="60px" height="60px">
                <path d="M 7 6 L 9 6 L 11 9 L 11 11 L 9 14 L 7 14 L 10 10 L 10 
                      10 L 7 6 m 11 1 L 20 7 L 20 6 L 18 6 C 13 6 13 14 18 14 
                      L 20 14 L 20 13 L 18 13 C 15 12 15 8 18 7 M 21 13 C 21 
                      13 21 12 22 13 C 19 10 19 15 23 14 C 24 13 22 12 22 11 C 
                      22 11 24 12 23 12 C 24 12 23 11 21 10 C 24 14 21 14 21 13 
                      M 11 9 L 13 6 L 15 6 L 12 10 L 12 10 L 15 14 L 13 14 L 11 11">
                </path>
            </svg>
        </a>
    </div>
    <ul class="list-group" id="taskbar-list">
        <li class="nav-item">
            <a href="" title="" class="nav-link nav-toggle">
                <span class="fa-solid fa-house"></span>
                <span class="title">Tổng quan</span>
            </a>
            <ul class="sub-menu">
                <li class="nav-item">
                    <a href="?page=overview" title="" class="nav-link">Thống kê</a>
                </li>
                <li class="nav-item">
                    <a href="?page=ListTypicalEmployees" title="" class="nav-link">Danh sách nhân viên tiêu biểu</a>
                </li>
                
            </ul>
        </li>
        <li class="nav-item">
            <a href="" title="" class="nav-link nav-toggle">
                <span class="fa-solid fa-school"></span>
                <span class="title">Quản lí điểm</span>
            </a>
            <ul class="sub-menu">
                <li class="nav-item">
                    <a href="?page=addDept" title="" class="nav-link">Thêm mới</a>
                </li>
                <li class="nav-item">
                    <a href="?page=listDept" title="" class="nav-link">Danh sách điểm các lớp</a>
                </li>
            </ul>
        </li>
        <li class="nav-item">
            <a href="" title="" class="nav-link nav-toggle">
                <span class="fa-solid fa-people-group"></span>
                <span class="title">Tổ chức thi</span>
            </a>
            <ul class="sub-menu">
                
                <li class="nav-item">
                    <a href="?page=listExamRoom" title="" class="nav-link">Phòng thi</a>
                </li>
                <li class="nav-item">
                    <a href="?page=managerLeaveApplicationSheet" title="" class="nav-link">Phân bố phòng thi</a>
                </li>
                <li class="nav-item">
                    <a href="?page=create_exam" title="" class="nav-link">Sắp xếp lịch thi</a>
                </li>
                <li class="nav-item">
                    <a href="?page=managerLeaveApplicationSheet" title="" class="nav-link">Phân công lịch thi</a>
                </li>
                <li class="nav-item">
                    <a href="?page=managerLeaveApplicationSheet" title="" class="nav-link">Quản lí cán bộ coi thi</a>
                </li>
            </ul>
        </li>
        <li class="nav-item">
            <a href="" title="" class="nav-link nav-toggle">
                <span class="fa-solid fa-money-bill"></span>
                <span class="title">Quản lý môn học</span>
            </a>
            <ul class="sub-menu">
                <li class="nav-item">
                    <a href="?page=listSalary" title="" class="nav-link">Danh sách môn học</a>
                </li>
                <li class="nav-item">
                    <a href="?page=listSalary" title="" class="nav-link">Danh sách học phần</a>
                </li>
            </ul>
        </li>
        <li class="nav-item">
            <a href="" title="" class="nav-link nav-toggle">
                <span class="fa-solid fa-calendar-days"></span>
                <span class="title">Phân công sinh viên</span>
            </a>
            <ul class="sub-menu">
                <li class="nav-item">
                    <a href="?page=createSchedule" title="" class="nav-link">Danh sách sinh viên</a>
                </li>
            </ul>
        </li>
        <li class="nav-item">
            <a href="" title="" class="nav-link nav-toggle">
                <span class="fa fa-pencil-square-o"></span>
                <span class="title">Quản lý phân quyền</span>
            </a>
            <ul class="sub-menu">
                <li class="nav-item">
                    <a href="?page=role" title="" class="nav-link">Tạo nhóm quyền</a>
                </li>
                <li class="nav-item">
                    <a href="?page=role" title="" class="nav-link">Quản lí nhóm quyền</a>
                </li>
            </ul>
        </li>
        <li class="nav-item">
            <a href="" title="" class="nav-link nav-toggle">
                <span class="fa-solid fa-user"></span>
                <span class="title">Tài khoản</span>
            </a>
            <ul class="sub-menu">
                <li class="nav-item">
                    <a href="?page=profile" title="" class="nav-link">Xem thông tin</a>
                </li>
                <li class="nav-item">
                    <a href="?page=listAccount" title="" class="nav-link">Danh sách tài khoản</a>
                </li>
            </ul>
        </li>   
    </ul>
    <div class="go-up-box clearfix">
        <a href="#" class="btn">Go up <i class="fa-solid fa-arrow-up"></i></a>
    </div>
</div>
<script>
    var statusValue = "";

    var TaskbarAdmin = document.querySelector('.taskbar');   
    var ListGroupItem = document.querySelectorAll('.list-group-item');
    ListGroupItem.forEach(function (btn) {
        if (btn.textContent.trim() === statusValue) {
            btn.classList.add('list-group-item-selected');
        }
    });
</script>
