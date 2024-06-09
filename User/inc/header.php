
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../img/sheep.png" type="image/png">
    <title>Novelnest</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./css/main.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.0/dist/chart.min.js"></script>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand me-auto" href="?page=Home" style="text-transform: uppercase;text-shadow: 1px 0px 1px rgba(0,0,0,0.5);">Novelnest</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon" style="color: black;"><i class="fa-solid fa-bars"></i></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="?page=Home">Trang chủ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="?page=grade_entry">Quản lí điểm</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="?page=academic_outcomes">Kết quả học tập</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="?page=Mysalary">Lương - Bảo hiểm </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="?page=leave-request">Xin nghỉ phép</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="https://huit.edu.vn/vien-chuc/tin-tuc-to-chuc-nhan-su.html">Tin Tức</a>
                    </li>
                </ul>
                <div class="avt-img">
                    <a href="#" data-bs-toggle="offcanvas" data-bs-target="#account-display" aria-controls="account-display">
                        <img src="../img/<?php echo $employee[0]['ImageURL']; ?>" alt="User Name" style="width: 40px;height: 40px;border-radius: 50%;">
                    </a>             
                </div>
            </div>
        </div>
    </nav>
    <div class="offcanvas offcanvas-end" tabindex="-1" id="account-display" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasRightLabel">User Name</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>     
    </div>
    <div class="offcanvas-body">
        <div class="modal-avt-img">
            <a href="#"> <!-- Link to My Account -->

                <img src="./Img/Dinkaru.jpg" alt="User Name" style="border-radius: 50%;">
            </a>
        </div>
        <div class="modal-body-content d-flex flex-column">
            <a href="#">Go to Main</a>
            <a href="?page=profile">My Account</a>
            <a href="../logout.php">Log out</a>
        </div>
    </div>
</div>
