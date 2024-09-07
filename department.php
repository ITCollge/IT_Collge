<?php
// الاتصال بقاعدة البيانات
include 'db.php'; // تأكد من أن هذا الملف يحتوي على تفاصيل الاتصال بقاعدة البيانات

// استرجاع معرف القسم من URL
$department_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($department_id == 0) {
    die("القسم غير موجود.");
}

// جلب معلومات القسم
$department_result = $conn->query("SELECT * FROM departments WHERE id = $department_id");

if ($department_result && $department_result->num_rows > 0) {
    $department = $department_result->fetch_assoc();
} else {
    die("القسم غير موجود.");
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <title><?php echo htmlspecialchars($department['name']); ?></title>
    <style>
        body {
            direction: rtl;
            font-family: "Changa", sans-serif;
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
                    <a class="nav-link" href="#news-dep">الأخبار</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#contact-us">تواصل معنا</a>
                </li>
           
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-5">
    <div class="department-info mb-4">
        <h2><?php echo htmlspecialchars($department['name']); ?></h2>
        <p><?php echo htmlspecialchars($department['description']); ?></p>
    </div>

    <div class="subjects mt-4">
        <h3>المواد الدراسية</h3>
        <div class="row">
        <?php
        // استعلام لجلب المواد بناءً على $department_id
        $subjects_result = $conn->query("SELECT * FROM subjects WHERE department_id = $department_id ORDER BY id DESC");

        if ($subjects_result) {
            if ($subjects_result->num_rows > 0) {
                while ($subject = $subjects_result->fetch_assoc()) {
                    echo "<div class='col-lg-4 col-md-6 mb-4'>";
                    echo "<div class='card h-100'>";
                    echo "<div class='card-body'>";
                    echo "<h5 class='card-title'>" . htmlspecialchars($subject['name']) . "</h5>";
                    echo "<p class='card-text'>الوحدات: " . htmlspecialchars($subject['units']) . "</p>";
                    echo "</div>";
                    echo "</div>";
                    echo "</div>";
                }
            } else {
                echo "<p>لم يتم العثور على مواد.</p>";
            }
        } else {
            echo "<p>حدث خطأ في جلب المواد: " . $conn->error . "</p>";
        }
        ?>
        </div>
    </div>

    <div class="professors mt-4">
        <h3>الدكاترة</h3>
        <div class="row">
        <?php
        // استعلام لجلب الدكاترة بناءً على $department_id
        $professors_result = $conn->query("SELECT * FROM professors WHERE department_id = $department_id ORDER BY id DESC");

        if ($professors_result) {
            if ($professors_result->num_rows > 0) {
                while ($professor = $professors_result->fetch_assoc()) {
                    echo "<div class='col-lg-4 col-md-6 mb-4'>";
                    echo "<div class='card h-100'>";
                    echo "<div class='card-body'>";
                    echo "<h5 class='card-title'>" . htmlspecialchars($professor['name']) . "</h5>";
                    echo "<p class='card-text'>المادة: " . htmlspecialchars($professor['subject']) . "</p>";
                    echo "<button class='btn btn-info' onclick='fetchProfessorDetails(" . $professor['id'] . ")'>عرض التفاصيل</button>";
                    echo "</div>";
                    echo "</div>";
                    echo "</div>";
                }
            } else {
                echo "<p>لم يتم العثور على دكاترة.</p>";
            }
        } else {
            echo "<p>حدث خطأ في جلب الدكاترة: " . $conn->error . "</p>";
        }
        ?>
        </div>
    </div>

    <div class="news mt-4" id="news-dep">
        <h3>الأخبار</h3>
        <div class="row">
            <?php
            $news_result = $conn->query("SELECT * FROM news ORDER BY id DESC");

            if ($news_result) {
                if ($news_result->num_rows > 0) {
                    while ($news = $news_result->fetch_assoc()) {
                        echo "<div class='col-lg-4 col-md-6 mb-4'>";
                        echo "<div class='news-item'>";
                        echo "<h5>" . htmlspecialchars($news['title']) . "</h5>";
                        echo "<p>" . htmlspecialchars(substr($news['content'], 0, 100)) . "...</p>";
                        echo "<button class='btn btn-primary more-btn' data-id='" . $news['id'] . "'>عرض المزيد</button>";
                        echo "</div>";
                        echo "</div>";
                    }
                } else {
                    echo "<p>لم يتم العثور على أخبار.</p>";
                }
            } else {
                echo "<p>حدث خطأ في جلب الأخبار: " . $conn->error . "</p>";
            }
            ?>
        </div>
    </div>

</div>

<!-- Modal لعرض التفاصيل -->
<div class="modal fade" id="detailsModal" tabindex="-1" aria-labelledby="detailsModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailsModalLabel">التفاصيل</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="modal-content">
                <!-- سيتم إدراج التفاصيل هنا -->
            </div>
        </div>
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
// وظيفة لجلب تفاصيل المادة
function fetchSubjectDetails(id) {
    fetch('subject.php?id=' + id)
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                document.getElementById('modal-content').innerHTML = '<p>' + data.error + '</p>';
            } else {
                document.getElementById('modal-content').innerHTML = '<h5>' + data.name + '</h5><p>الوحدات: ' + data.units + '</p><p>الوصف: ' + data.description + '</p>';
            }
            var myModal = new bootstrap.Modal(document.getElementById('detailsModal'), {});
            myModal.show();
        })
        .catch(error => console.error('Error fetching subject details:', error));
}

// وظيفة لجلب تفاصيل الدكتور
function fetchProfessorDetails(id) {
    fetch('professor.php?id=' + id)
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                document.getElementById('modal-content').innerHTML = '<p>' + data.error + '</p>';
            } else {
                document.getElementById('modal-content').innerHTML = '<h5>' + data.name + '</h5><p>المادة: ' + data.subject + '</p><img src="' + data.image + '" alt="' + data.name + '" class="img-fluid">';
            }
            var myModal = new bootstrap.Modal(document.getElementById('detailsModal'), {});
            myModal.show();
        })
        .catch(error => console.error('Error fetching professor details:', error));
}

</script>
</body>
</html>
