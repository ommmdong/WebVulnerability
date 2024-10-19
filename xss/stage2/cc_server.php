<?php

$message = "";

// 전달된 세션값(쿠키)이 존재하면 새로운 파일을 생성하여 기록
if (isset($_GET['cookie'])) {
    $cookie = $_GET['cookie'];

    // 고유한 파일명 생성 (현재 시간 기반 또는 랜덤값 사용)
    $filename = './logs/session_' . time() . '_' . rand(1000, 9999) . '.txt';

    // 세션값을 새 파일에 기록
    file_put_contents($filename, $cookie);

    // 쿠키 값을 화면에 출력 (선택사항)
    $message = "Cookie received and logged in file: " . htmlspecialchars($filename) . "<br>";
}
    
// 학습자가 쿠키 값을 'nimda'로 변경했는지 확인
if (isset($_COOKIE['AnagramSession'])) {
    $sessionCookie = $_COOKIE['AnagramSession'];

    // 쿠키 값이 'nimda'인 경우에만 admin.php로 이동하는 버튼 생성
    if ($sessionCookie === 'nimda') {
        $message .= '<br><a href=".admin.php"><button>Go to Admin Page</button></a>';
    } else {
        $message .= "";
    }
} else {
    $message = "No session cookie received.";
}

// logs 디렉터리에서 모든 파일을 읽어와서 출력 (로그 파일 목록 확인)
$logDir = './logs/';
$logFiles = array_diff(scandir($logDir), array('..', '.'));

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>C&C Server</title>
    <link rel="stylesheet" href="../../assets/css/styles.css">
</head>
<body>
    <div class="wrapper">
        <header>
            <div class="container">
                <h1>C&C Server</h1>
                <ul>
                    <li><a href="Complex_xss.php">Back to User Page</a></li>
                </ul>
            </div>
        </header>

        <div class="container">
            <h2>Log Files</h2>
            <p>Each session cookie is stored in a new .txt file in the <code>logs</code> directory:</p>
	    <!-- 쿠키 전달 메시지 출력 -->
            <p><?php echo $message; ?></p>
            <!-- 로그 파일 목록 출력 -->
            <ul>
                <?php foreach ($logFiles as $file): ?>
                    <li><a href="<?php echo $logDir . $file; ?>" target="_blank"><?php echo $file; ?></a></li>
                <?php endforeach; ?>
            </ul>

            <p>This page mimics an attacker's server receiving session information.</p>
        </div>
        <footer>
            <p>Web Vulnerability Practice &copy; 2024</p>
        </footer>
    </div>
</body>
</html>

