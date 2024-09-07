<?php
include 'db.php';

$subject_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($subject_id == 0) {
    echo json_encode(['error' => 'معرف المادة غير صالح.']);
    exit;
}

$result = $conn->query("SELECT * FROM subjects WHERE id = $subject_id");

if ($result && $result->num_rows > 0) {
    $subject = $result->fetch_assoc();
    echo json_encode($subject);
} else {
    echo json_encode(['error' => 'لم يتم العثور على المادة الدراسية.']);
}
?>
