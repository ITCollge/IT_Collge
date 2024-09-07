<?php
include 'db.php';
// التحقق من صلاحيات المشرف
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>لوحة تحكم المشرف</title>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">مشرف</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item">

                                    <a class="nav-link" href="index.php">الصفحة الرئيسية</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">تسجيل الخروج</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-5">
    <h2 class="mb-4">إدارة الأخبار</h2>
    <div class="row">
        <?php
        $result = $conn->query("SELECT * FROM news");
        while ($row = $result->fetch_assoc()) {
            echo "<div class='col-lg-4 col-md-6 mb-4'>";
            echo "<div class='card h-100'>";
            echo "<div class='card-body'>";
            echo "<h5 class='card-title'>" . $row['title'] . "</h5>";
            echo "<p class='card-text'>" . substr($row['content'], 0, 100) . "...</p>";
            echo "<a href='edit_news.php?id=" . $row['id'] . "' class='btn btn-warning'>تعديل</a> ";
            echo "<a href='delete_news.php?id=" . $row['id'] . "' class='btn btn-danger'>حذف</a>";
            echo "</div>";
            echo "</div>";
            echo "</div>";
        }
        ?>
    </div>
    <a href="add_news.php" class="btn btn-primary mt-3">إضافة خبر جديد</a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

