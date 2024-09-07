<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // تثبيت إيميل وكلمة مرور معينة
    $fixed_email = "admin@gmail.com";
    $fixed_password = "1234"; // تأكد من أن كلمة المرور مشفرة عند الحفظ

    // التحقق من الإيميل وكلمة المرور الثابتة
    if ($email === $fixed_email && $password === $fixed_password) {
        // إذا كانت البيانات صحيحة، إعادة توجيه المستخدم
        header('Location: admin_dashboard.php');
    } else {
        // التحقق من البيانات في قاعدة البيانات
        $sql = "SELECT * FROM users WHERE email='$email'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                if ($user['role'] == 'admin') {
                    header('Location: admin_dashboard.php');
                } else {
                    header('Location: supervisor_dashboard.php');
                }
            } else {
                echo "<div class='alert alert-danger'>كلمة المرور غير صحيحة</div>";
            }
        } else {
            echo "<div class='alert alert-danger'>البريد الإلكتروني غير مسجل</div>";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>صفحة تسجيل الدخول</title>

    <style>
        body{
            direction: rtl;
        }
    </style>

</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">صفحة تسجيل الدخول</h2>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <form method="POST" action="">
                            <div class="mb-3">
                                <label for="email" class="form-label">البريد الإلكتروني</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="البريد الإلكتروني" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">كلمة المرور</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="كلمة المرور" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">تسجيل الدخول</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
