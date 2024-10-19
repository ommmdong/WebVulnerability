<?php
// 기본 세션 ID 사용을 막음
ini_set('session.use_cookies', 0);        // 쿠키 기반 세션 사용 막기
ini_set('session.use_only_cookies', 0);   // 쿠키로만 세션 ID 전달 막기
ini_set('session.use_trans_sid', 1);      // URL로 세션 ID 전달 허용

// 기존 세션 및 쿠키 초기화
if (session_id()) {
    session_unset();
    session_destroy();
    setcookie(session_name(), '', time() - 3600, '/');
}

// 커스텀 세션 ID 생성
$customSessionID = base64_encode(base64_encode('.secret'));
session_id($customSessionID);

session_start();

setcookie("SESSIONID", $customSessionID, 0, '/');

$uploadDir = './.uploads/';

// 파일 저장 처리
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['content'])) {
    $content = $_POST['content'];
    $fileCount = count(glob($uploadDir . '*.txt'));
    $filename = $uploadDir . $fileCount . '.txt';
    file_put_contents($filename, $content);
    header('Location: realxss.php');
    exit();
}

// 파일 삭제 처리
if (isset($_POST['delete_files'])) {
    array_map('unlink', glob("$uploadDir/*.txt"));
    header('Location: realxss.php');
    exit();
}

// 업로드된 파일 목록 불러오기
$fileList = array_diff(scandir($uploadDir), array('..', '.'));

// 플래그 확인 처리
$flagFilePath = '.secret/flag.txt';
$flag = trim(file_get_contents($flagFilePath));
$flagCorrect = false; // 기본값을 false로 초기화

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['flag'])) {
    $flagEntered = $_POST['flag'];
    if ($flagEntered === $flag) {
        $flagCorrect = true;
    } else {
        $errorMessage = "Try Again!";
    }
}

?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stored XSS Challenge</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
    <script>
        // Base64 디코딩 함수
        function decodeSessionID() {
            var input = document.getElementById('sessionInput').value;
            try {
		    var decoded = atob(input);                  
		    document.getElementById('sessionInput').value = decoded;
            } catch (e) {
                alert('Invalid input. Please enter a valid Base64 encoded string.');
            }
	}

	// move to Location function
	function goToLocation() {
		var locationInput = document.getElementById('locationInput').value;
		window.location.href=locationInput;
	}
    </script>
</head>
<body>
    <div class="wrapper">
        <header>
            <div class="container">
                <h1>Stored XSS Challenge</h1>
                <ul>
                    <li><a href="../../index.php">Home</a></li>
                </ul>
            </div>
        </header>

        <div class="container">
            <!-- 1. textarea와 submit -->
            <form method="POST" action="realxss.php">
                <textarea name="content" rows="4" cols="50" placeholder="Enter your content here..."></textarea><br>
                <button type="submit">Submit</button>
            </form>

            <!-- 2. 업로드된 파일 목록 -->
            <h2>Uploaded Files:</h2>
            <ul>
                <?php foreach ($fileList as $file): ?>
                    <li><a href="realxss.php?file=<?php echo $file; ?>"><?php echo htmlspecialchars($file); ?></a></li>
                <?php endforeach; ?>
            </ul>
            
            <!-- 3. 선택된 파일 내용 표시 -->
            <?php
            if (isset($_GET['file']) && in_array($_GET['file'], $fileList)) {
                $selectedFile = $uploadDir . $_GET['file'];
                $content = file_get_contents($selectedFile);
                echo '<div class="comment-section">';
                echo '<h3>File Content:</h3>';
                echo '<div style="border: 1px solid #ccc; padding: 10px;">' . $content . '</div>';
                echo '</div>';
            }
            ?>

            <!-- 4. 파일 삭제 버튼 -->
            <form method="POST" action="realxss.php">
                <button type="submit" name="delete_files">Delete All Files</button>
            </form>

            <!-- 5. 힌트 표시 -->
            <p>Hint: Stored XSS를 이용해 쿠키값을 얻는 문제입니다. <br>쿠키 값을 얻어 플래그가 숨겨진 위치를 찾아내세요</p>

            <!-- 6. 세션ID 입력란과 Decode 버튼 -->
            <input type="text" id="sessionInput" placeholder="Enter the Session ID"><br>
            <button onclick="decodeSessionID()">Decode</button><br>

	    <!-- 6.1 Move to Location and Button -->
	    <input type="text" id="locationInput" placeholder="Enter the Decoded Path"><br>
	    <button onclick="goToLocation()">Go</button><br>


            <!-- 7. 플래그 입력란과 Submit 버튼 -->
	<div>    
	    <form method="POST" action="realxss.php">
                <input type="text" name="flag" placeholder="Enter the flag" required><br>
                <button type="submit">Submit Flag</button>
            </form>
	</div>

            <?php if ($flagCorrect): ?>
		<p class="flag-section">Great Job! You Did it!</p>
		<div class="xss-type" onclick="toggleDescription('Stored-xss')">Stored XSS</div>
			<div id="Stored-xss" class="xss-description">
				<p>Stored XSS를 간략하게 표현한 문제로, 실제로는 alert을 통해 표시된 sessionID가 <br>공격자의 C&C서버로 전송되는 방식이 대표적이다.<br>이 외에도 stored XSS는 여러 기법을 통해 실행된다.</p>
			</div>
	
            <?php else: ?>
                <?php if (isset($errorMessage)): ?>
                    <p class="flag-section"><?php echo $errorMessage; ?></p>
                <?php endif; ?>
            <?php endif; ?>
        </div>

        <footer>
            <p>Web Vulnerability Practice &copy; 2024</p>
        </footer>
    </div>
</body>
</html>

