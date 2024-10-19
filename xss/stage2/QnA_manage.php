<?php
$uploadDir = './.uploads/'; // 게시글이 저장될 디렉터리
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true); // 디렉터리 생성
}

// 업로드된 파일 목록 불러오기
$fileList = array_diff(scandir($uploadDir), array('..', '.'));

// 게시글 삭제 처리
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_post'])) {
    $fileToDelete = $uploadDir . $_POST['delete_post'];
    if (file_exists($fileToDelete)) {
        unlink($fileToDelete); // 게시글 삭제
        header("Location: QnA_manage.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Q&A Management Page</title>
    <link rel="stylesheet" href="../../assets/css/styles.css">
</head>
<body>
    <div class="wrapper">
        <header>
            <div class="container">
                <h1>Q&A Management</h1>
                <ul>
                    <li><a href="Complex_xss.php">Back to User Page</a></li>
                </ul>
            </div>
        </header>

        <div class="container">
            <h2>Uploaded Files</h2>
            <ul>
                <?php foreach ($fileList as $file): ?>
                    <li>
                        <!-- URL 인코딩을 하지 않고 출력 (스크립트를 허용) -->
                        <a href="QnA_manage.php?file=<?php echo $file; ?>"><?php echo $file; ?></a>
                        <!-- 게시글 삭제 버튼 추가 --> 
                        <form method="POST" action="QnA_manage.php" style="display:inline;">
                            <input type="hidden" name="delete_post" value="<?php echo $file; ?>">
                            <button type="submit">Delete Post</button>
                        </form>
                    </li>
                <?php endforeach; ?>
            </ul>

            <!-- 선택한 파일 내용 표시 -->
            <?php
            if (isset($_GET['file']) && in_array($_GET['file'], $fileList)) {
                $selectedFile = $uploadDir . $_GET['file'];
                $content = file_get_contents($selectedFile); // 파일 내용 읽기

                // 파일 내용에서 스크립트 태그가 동작하도록 그대로 출력 (보안 위험 있음)
                echo '<div class="comment-section">';
                echo '<h3>File Content:</h3>';
                // 스크립트를 허용하기 위해 HTML로 출력
                echo '<div style="border: 1px solid #ccc; padding: 10px;">' . $content . '</div>';
                echo '</div>';
            }
	if (isset($_GET['reflected_input'])) {
		$reflectedInput = $_GET['reflected_input'];
		echo '<p>Reflected Input: ' . $reflectedInput . '</p>'; }


?>
        </div>

        <footer>
            <p>Web Vulnerability Practice &copy; 2024</p>
        </footer>
    </div>
</body>
</html>

