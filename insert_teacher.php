<?php
// إعدادات الاتصال بقاعدة البيانات
$servername = "localhost";
$username = "root";
$password = ""; // أو كلمة المرور الخاصة بك
$dbname = "it_college";

// إنشاء اتصال بقاعدة البيانات
$conn = new mysqli($servername, $username, $password, $dbname);

// التحقق من الاتصال
if ($conn->connect_error) {
    die("فشل الاتصال بقاعدة البيانات: " . $conn->connect_error);
}

// معالجة طلب إدراج دكتور
if (isset($_POST['action']) && $_POST['action'] === 'add_teacher') {
    $name = $_POST['teacher_name'];
    $subject = $_POST['teacher_subject'];
    $department_id = $_POST['teacher_department'];

    // إدراج البيانات في قاعدة البيانات
    $sql = "INSERT INTO professors (name, subject, department_id) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $name, $subject, $department_id);

    if ($stmt->execute()) {
        // إعادة توجيه إلى صفحة عرض الدكاترة بعد الإدراج الناجح
        header("Location: manage_teachers.php");
        exit();
    } else {
        echo "فشل إضافة الدكتور: " . $stmt->error;
    }

    $stmt->close();
}

// إغلاق الاتصال
$conn->close();
