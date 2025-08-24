<?php
include_once 'db_conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];

    $sql = "INSERT INTO blogs (title, content) VALUES (:title, :content)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':content', $content);

    if ($stmt->execute()) {
        header("Content-Type: application/json");
        echo json_encode([
            'status' => 'success',
            'message' => 'เพิ่มกระทู้สำเร็จ'
        ]);
        exit();
    } else {
        header("Content-Type: application/json");
        echo json_encode([
            'status' => 'error',
            'message' => 'เกิดข้อผิดพลาดในการเพิ่มกระทู้'
        ]);
        exit();
    }
}