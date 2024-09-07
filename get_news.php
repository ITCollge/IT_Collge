<?php
include 'db.php';

$id = intval($_GET['id']);
$query = "SELECT * FROM news WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$news = $result->fetch_assoc();

header('Content-Type: application/json');
echo json_encode($news);
?>
