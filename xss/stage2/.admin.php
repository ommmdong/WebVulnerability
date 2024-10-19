<?php
// php 기본 세션 관리 비활성화
ini_set('session.use_cookies', 0);
ini_set('session.use_only_cookies', 0);
ini_set('session.use_trans_sid', 0);

// 세션 값 확인: 커스텀 세션 ID가 'nimda'여야만 접근 가능
if (isset($_COOKIE['AnagramSession']) && $_COOKIE['AnagramSession'] === 'nimda') {
    // 플래그 파일 경로
    $flagFilePath = './.secret/flag.txt';

    // 플래그 파일이 존재하면 내용을 출력
    if (file_exists($flagFilePath)) {
        $flagContent = file_get_contents($flagFilePath);
    } else {
        $flagContent = 'Flag file not found.';
    }
} else {
    // 세션 값이 'nimda'가 아니라면 접근 거부
    header('HTTP/1.1 403 Forbidden');
    echo "You do not have permission to access this page.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
    <link rel="stylesheet" href="../../assets/css/styles.css">
</head>
<body>
    <div class="wrapper">
        <header>
            <div class="container">
                <h1>Admin Page - Flag</h1>
                <ul>
                    <li><a href="Complex_xss.php">Back to User Page</a></li>
                </ul>
            </div>
        </header>

        <div class="container">
            <h2>Flag Content</h2>
            <!-- 플래그 내용 출력 -->
            <div style="border: 1px solid #ccc; padding: 20px; background-color: #f9f9f9;">
                <pre><?php echo htmlspecialchars($flagContent); ?></pre>
            </div>
        </div>

        <footer>
            <p>Web Vulnerability Practice &copy; 2024</p>
        </footer>
    </div>
</body>
</html>

