
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.7/css/dataTables.dataTables.min.css">
    <link rel="stylesheet" href="./css/admin_site.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.7/js/dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.0/dist/chart.min.js"></script>

    <title>Trang Admin</title>
</head>
<header>
    <div class="fixed-header position-fixed">
        <div class="row justify-content-center">
            <div class="header-left col-2">
                <button class="btn" id="sidebar-toggle" type="button">
                    <i class="fa-solid fa-bars"></i>
                </button>
            </div>
            <div class="header-center col-8">
                <h2 class="header-title">HUIT</h2>
            </div>
            <div class="header-right col-2">
                <div class="avt-img">
                    <a href="#" data-bs-toggle="offcanvas" data-bs-target="#account-display" aria-controls="account-display">
                        <img src="" alt="User Name">
                    </a>
                    <div class="offcanvas offcanvas-end" tabindex="-1" id="account-display" aria-labelledby="offcanvasRightLabel">
                        <div class="offcanvas-header">
                            <button type="button" class="btn-inform text-reset"><i class="fa-regular fa-bell"></i></button>
                            <h5 id="offcanvasRightLabel">User Name</h5>
                            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                        </div>
                        <div class="offcanvas-body">
                            <div class="modal-avt-img">
                                <a href="#"> <!-- Link to My Account -->
                                    <img src="" alt="User Name">
                                </a>
                            </div>
                            <div class="modal-body-content d-flex flex-column">
                                <a href="#">Go to Main</a>
                                <a href="?page=profile">My Account</a>
                                <a href="../logout.php">Log out</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>