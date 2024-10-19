<?php
include 'config.php';  // 화이트리스트 

$allowed_extensions = ['jpg', 'jpeg', 'png', 'gif', 'pdf', 'doc', 'docx', 'xls', 'xlsx', 'txt'];
$upload_dir = '/var/www/html/file_upload/uploads4/';

$file_uploaded = false;
$error_message = '';

if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0755, true);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['file'])) {
    if ($_FILES['file']['error'] === UPLOAD_ERR_OK) {
        $file_tmp_path = $_FILES['file']['tmp_name'];
        $file_name = $_FILES['file']['name'];
        $file_size = $_FILES['file']['size'];
        $file_type = $_FILES['file']['type'];
        $file_extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        $destination = $upload_dir . basename($file_name);

        if (!in_array($file_extension, $allowed_extensions)) {
            $error_message = 'Invalid file extension. Please upload a valid file.';
        } else {
            if (move_uploaded_file($file_tmp_path, $destination)) {
                $file_uploaded = true;

                // DB에 파일 정보 저장
                $stmt = $pdo->prepare("INSERT INTO uploads4 (file_name, file_path, mime_type, original_name) VALUES (?, ?, ?, ?)");
                $stmt->execute([$file_name, $destination, $file_type, $file_name]);

                $uploaded_file_info = [
                    'file_name' => $file_name,
                    'file_size' => $file_size,
                    'file_type' => $file_type,
                    'file_path' => $destination,
                ];
            } else {
                $error_message = '파일 업로드 실패!';
            }
        }
    } else {
        $error_message = '파일 업로드 오류 발생!';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Test Level4 </title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>Upload Test Level 4</h1>
        </div>
    </header>

    <div class="container">
        <h2>Upload a File</h2>
        <form action="upload_test4.php" method="post" enctype="multipart/form-data">
            <label for="file">Choose file to upload:</label>
            <input type="file" name="file" id="file">
            <input type="submit" value="Upload File">
        </form>

        <?php if ($file_uploaded): ?>
            <div class="file-info">
                <h3>File Uploaded Successfully!</h3>
                <p><strong>File Name:</strong> <?php echo htmlspecialchars($uploaded_file_info['file_name']); ?></p>
                <p><strong>File Size:</strong> <?php echo htmlspecialchars($uploaded_file_info['file_size']); ?> bytes</p>
                <p><strong>File Type:</strong> <?php echo htmlspecialchars($uploaded_file_info['file_type']); ?></p>
                <p><strong>File Path:</strong> <?php echo htmlspecialchars($uploaded_file_info['file_path']); ?></p>
            </div>
        <?php elseif ($error_message): ?>
            <div class="error-message">
                <h3><?php echo htmlspecialchars($error_message); ?></h3>
            </div>
        <?php endif; ?>

        <!-- 취약 코드 토글 버튼 -->
        <div class="action">
            <button class="toggle-button" onclick="toggleCode()">Show Vulnerable Code</button>
        </div>

        <!-- 취약 코드 섹션 -->
        <div class="vulnerable-code" id="vulnerable-code" style="display: none;">
            <pre>
&lt;?php
//확장자 기반 화이트리스트
<span style="color:red;">$allowed_extensions = ['jpg', 'jpeg', 'png', 'gif', 'pdf', 'doc', 'docx', 'xls', 'xlsx', 'txt'];</span>

if (!in_array($file_extension, $allowed_extensions)) {
    $error_message = 'Invalid file extension. Please upload a valid file.';
} else {
    move_uploaded_file($file_tmp_path, $destination);
}
?&gt;
            </pre>
        </div>
    </div>

    <footer>
        <p>Web Vulnerability Practice &copy; 2024</p>
    </footer>

    <script>
        function toggleCode() {
            var codeBlock = document.getElementById("vulnerable-code");
            var button = document.querySelector(".toggle-button");
            if (codeBlock.style.display === "none") {
                codeBlock.style.display = "block";
                button.textContent = "Hide Vulnerable Code";
            } else {
                codeBlock.style.display = "none";
                button.textContent = "Show Vulnerable Code";
            }
        }
    </script>
</body>
</html>
