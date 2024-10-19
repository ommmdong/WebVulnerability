<?php
session_start();
$conn = new mysqli('localhost', 'root', '1111', 'db_csrf');

if (!isset($_SESSION['username']) || $_SESSION['username'] != 'admin') {
    die("관리자만 접근 가능합니다.");
}

if (!isset($_GET['id'])) {
    die("글 ID가 지정되지 않았습니다.");
}

$post_id = $conn->real_escape_string($_GET['id']);
$result = $conn->query("SELECT * FROM posts WHERE id = '$post_id'");
$post = $result->fetch_assoc();

if (!$post) {
    die("글을 찾을 수 없습니다.");
}

// 비밀번호 변경 메시지 변수
$update_message = '';

// CSRF 공격: 글을 읽는 순간 비밀번호 변경
if ($_SESSION['username'] == 'admin') {
    // 비밀번호 변경 쿼리 실행
    $update_result = $conn->query("UPDATE users SET password = 'hack123' WHERE username = 'admin'");
    
    // 비밀번호 변경 성공 여부 확인
    if ($update_result && $conn->affected_rows > 0) {
        $update_message = "관리자 비밀번호가 'hack123'로 변경되었습니다.";
    } else {
        $update_message = "비밀번호 변경에 실패했습니다.";
    }
}

// 비밀번호를 조회하는 쿼리 (데모 목적으로만 사용)
$pass_result = $conn->query("SELECT password FROM users WHERE username = 'admin'");
$pass_row = $pass_result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>글 확인</title>
</head>
<body>
    <h1>글 내용</h1>
    <p><?php echo htmlspecialchars($post['content']); ?></p>
     <h2>관리자 비밀번호</h2>
    <p>현재 관리자 비밀번호: <?php echo htmlspecialchars($pass_row['password']); ?></p>
    <?php if (!empty($update_message)): ?>
        <p><?php echo htmlspecialchars($update_message); ?></p>
    <?php endif; ?>
    <!-- 돌아가기 버튼 -->
    <a href="csrf_index.php">
        <button class="practice-button">돌아가기</button>
    </a>
</body>
</html>

