<?php
include 'db.php';

$professor_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($professor_id == 0) {
    echo json_encode(['error' => 'معرف الدكتور غير صالح.']);
    exit;
}

$result = $conn->query("SELECT * FROM professors WHERE id = $professor_id");

if ($result && $result->num_rows > 0) {
    $professor = $result->fetch_assoc();
    echo json_encode($professor);
} else {
    echo json_encode(['error' => 'لم يتم العثور على الدكتور.']);
}
?>
