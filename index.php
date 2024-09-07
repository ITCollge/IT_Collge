<?php include 'db.php'; ?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <title>كلية تقنية المعلومات</title>

    <style>
        body {
            direction: rtl;
            font-family: "Changa";
        }
        .news-item {
            border: 1px solid #ddd;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            padding: 15px;
            margin-bottom: 20px;
            position: relative;
        }
        .news-item .more-btn {
            position: absolute;
            bottom: 15px;
            right: 15px;
        }
        .news-modal {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
            width: 80%;
            max-width: 800px;
            padding: 20px;
            z-index: 1000;
        }
        .news-modal.active {
            display: block;
        }
        .modal-content {
            margin-bottom: 20px;
        }
        .close-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            cursor: pointer;
        }
        .modal-background {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            display: none;
            z-index: 999;
        }
        .modal-background.active {
            display: block;
        }

        .navbar-brand{
            display: flex;
        }

        .logo-h1{
            font-size: 20px;
            margin-right: 20px;
            padding-top: 10px;
        }

        .contact-form {
            background-color: #f8f9fa;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.1);
        }
        .form-control {
            border-radius: 20px;
        }
        .btn-primary {
            background-color: rgb(13, 153, 247);
            border: none;
            border-radius: 20px;
        }


        
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
    <a class="navbar-brand" href="#">
            <img src="./3.png" alt="كلية تقنية المعلومات" height="50">
            <h1 class="logo-h1">كلية تقنية المعلومات</h1>

        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" href="index.php">الصفحة الرئيسية</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        الأقسام العلمية
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <?php
                        $result = $conn->query("SELECT * FROM departments");
                        while ($row = $result->fetch_assoc()) {
                            echo "<li><a class='dropdown-item' href='department.php?id=" . $row['id'] . "'>" . $row['name'] . "</a></li>";
                        }
                        ?>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#news-ma">الأخبار</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#contact-us">تواصل معنا</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="login.php">التسجيل</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
  <div class="carousel-indicators">
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
  </div>
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="./1.jpg" class="d-block w-100" alt="...">
    </div>
    <div class="carousel-item">
      <img src="2.jpg" class="d-block w-100" alt="...">
    </div>
    <div class="carousel-item">
      <img src="./4.jpg" class="d-block w-100" alt="...">
    </div>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>

<div class="container mt-5">
    <h1>الاقسام العلمية</h1>
    <div class="row">
        <?php
        $result = $conn->query("SELECT * FROM departments");
        while ($row = $result->fetch_assoc()) {
            echo "<div class='col-lg-4 col-md-6 mb-4'>";
            echo "<div class='card h-100'>";
            echo "<div class='card-body'>";
            echo "<h5 class='card-title'>" . $row['name'] . "</h5>";
            echo "<p class='card-text'>" . $row['description'] . "</p>";
            echo "<a href='department.php?id=" . $row['id'] . "' class='btn btn-primary'>المزيد</a>";
            echo "</div>";
            echo "</div>";
            echo "</div>";
        }
        ?>
    </div>
</div>

<div class="container mt-5" id="news-ma">
<h1>الاخبار</h1>

    <div class="row">
        <?php
$result = $conn->query("SELECT * FROM news ORDER BY id DESC");
while ($row = $result->fetch_assoc()) {
            echo "<div class='col-lg-4 col-md-6 mb-2 '>";
            echo "<div class='news-item h-100'>";
            echo "<h5>" . $row['title'] . "</h5>";
            echo "<p>" . substr($row['content'], 0, 100) . "...</p>";
            echo "<button class='btn btn-primary more-btn ' data-id='" . $row['id'] . "'>عرض المزيد</button>";
            echo "</div>";
            echo "</div>";
        }
        ?>
    </div>
</div>

<div class="modal-background"></div>
<div class="news-modal">
    <span class="close-btn">&times;</span>
    <div class="modal-content">
        <h5 id="modal-title"></h5>
        <p id="modal-content"></p>
    </div>
</div>


<div class="container mt-5" id="contact-us">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="contact-form">
                <h2 class="text-center mb-4">تواصل معنا</h2>
                <form action="process_contact.php" method="POST">
                    <div class="mb-3">
                        <label for="name" class="form-label">الاسم</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="registration_number" class="form-label">رقم القيد</label>
                        <input type="text" class="form-control" id="registration_number" name="registration_number" required>
                    </div>
                    <div class="mb-3">
                        <label for="department" class="form-label">القسم</label>
                        <select class="form-select" id="department" name="department" required>
                        <?php
            // جلب الأقسام من قاعدة البيانات
            $departments_result = $conn->query("SELECT id, name FROM departments");
            while ($department = $departments_result->fetch_assoc()) {
                echo "<option value='" . $department['id'] . "'>" . htmlspecialchars($department['name']) . "</option>";
            }
            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="message" class="form-label">الرسالة</label>
                        <textarea class="form-control" id="message" name="message" rows="4" required></textarea>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary btn-block">إرسال</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<footer class="bg-dark text-white mt-5">
    <div class="container py-4">
        <div class="row">
            <!-- قسم التعريف -->
            <div class="col-md-4 text-end">
                <h5>كلية تقنية المعلومات</h5>
                <p>
                    نحن نسعى لتقديم أفضل التعليم في مجال تقنية المعلومات، وتخريج طلاب قادرين على مواجهة تحديات المستقبل.
                </p>
            </div>
            
            <!-- قسم الروابط الرئيسية -->
            <div class="col-md-4 text-end">
                <h5>روابط مهمة</h5>
                <ul class="list-unstyled">
                    <li><a href="#" class="text-white">الصفحة الرئيسية</a></li>
                    <li><a href="#" class="text-white">الأقسام العلمية</a></li>
                    <li><a href="#" class="text-white">الأخبار</a></li>
                    <li><a href="#" class="text-white">تواصل معنا</a></li>
                    <li><a href="#" class="text-white">التسجيل</a></li>
                </ul>
            </div>

            <!-- قسم التواصل الاجتماعي -->
            <div class="col-md-4 text-end">
                <h5>تابعنا</h5>
                <ul class="list-unstyled">
                    <li><a href="#" class="text-white">فيسبوك</a></li>
                    <li><a href="#" class="text-white">تويتر</a></li>
                    <li><a href="#" class="text-white">لينكدإن</a></li>
                    <li><a href="#" class="text-white">انستجرام</a></li>
                </ul>
            </div>
        </div>
        <div class="text-center mt-3">
            <p>© 2024 كلية تقنية المعلومات. جميع الحقوق محفوظة.</p>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const moreButtons = document.querySelectorAll('.more-btn');
        const modal = document.querySelector('.news-modal');
        const modalContent = document.querySelector('#modal-content');
        const modalTitle = document.querySelector('#modal-title');
        const closeModal = document.querySelector('.close-btn');
        const modalBackground = document.querySelector('.modal-background');

        moreButtons.forEach(button => {
            button.addEventListener('click', function () {
                const newsId = this.getAttribute('data-id');
                fetch(`get_news.php?id=${newsId}`)
                    .then(response => response.json())
                    .then(data => {
                        modalTitle.textContent = data.title;
                        modalContent.textContent = data.content;
                        modal.classList.add('active');
                        modalBackground.classList.add('active');
                    });
            });
        });

        closeModal.addEventListener('click', function () {
            modal.classList.remove('active');
            modalBackground.classList.remove('active');
        });

        modalBackground.addEventListener('click', function () {
            modal.classList.remove('active');
            modalBackground.classList.remove('active');
        });
    });
</script>

</body>
</html>
