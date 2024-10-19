<?php
include 'config.php'; 

$allowed_extensions = ['jpg', 'jpeg', 'png', 'gif', 'pdf', 'doc', 'docx', 'xls', 'xlsx', 'txt'];
$upload_dir = 'uploads/';

if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0755, true);
}

if ($_FILES['file']['error'] === UPLOAD_ERR_OK) {
    $file_tmp_path = $_FILES['file']['tmp_name'];
    $file_name = $_FILES['file']['name'];
    $file_size = $_FILES['file']['size'];
    $file_type = $_FILES['file']['type'];
    $file_extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
    $destination = $upload_dir . basename($file_name);

    if (!in_array($file_extension, $allowed_extensions)) {
        echo "<script>alert('Invalid file extension. Please upload a valid file.'); window.history.back();</script>";
    } else {
        if (move_uploaded_file($file_tmp_path, $destination)) {
            echo "<script>alert('파일 업로드 성공!');</script>";

            // DB에 파일 정보 저장
            $stmt = $pdo->prepare("INSERT INTO uploads (file_name, file_path, mime_type, original_name) VALUES (?, ?, ?, ?)");
            $stmt->execute([$file_name, $destination, $file_type, $file_name]);

            echo "<p>File Name: $file_name</p>";
            echo "<p>File Size: $file_size bytes</p>";
            echo "<p>File Type: $file_type</p>";
            echo "<p>File Path: $destination</p>";
        } else {
            echo "<script>alert('파일 업로드 실패!');</script>";
        }
    }
} else {
    echo "<script>alert('파일 업로드 오류 발생!');</script>";
}
?>
