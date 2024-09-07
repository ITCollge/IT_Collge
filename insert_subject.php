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

// التحقق من وجود عملية الإضافة
if (isset($_POST['action']) && $_POST['action'] === 'add_subject') {
    // استلام البيانات من النموذج
    $name = $_POST['subject_name'];
    $units = $_POST['subject_units'];
    $department_id = $_POST['subject_department'];

    // استعلام لإدخال البيانات في الجدول
    $sql = "INSERT INTO subjects (name, units, department_id) VALUES (?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sii", $name, $units, $department_id);

    if ($stmt->execute()) {
        echo "تم إدخال المادة بنجاح.";
    } else {
        echo "خطأ في الإدخال: " . $stmt->error;
    }

    // إغلاق الاتصال
    $stmt->close();
}

$conn->close();
?>
