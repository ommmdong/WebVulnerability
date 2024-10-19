<?php
session_start();
$conn = new mysqli('localhost', 'root', '1111', 'db_csrf');

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

$result = $conn->query("SELECT * FROM posts ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>게시판</title>
    <link rel="stylesheet" href="assets/css/styles_csrf.css"> 
</head>

<body>
	<h1>실습 환경 설명</h1>
	    <p>이 페이지는 CSRF 공격과 방어 방법을 배우기 위한 실습 환경입니다.</p>
	    <ul>
		<strong>게시판 (csrf_index.php)</strong>: 게시물 열람 및 작성, 로그인 하는 페이지입니다.<br> 사용자 로그인(user1/user1password, user2/user2password) 후 글을 작성합니다.</p>
		<strong>글 작성 (csrf_post.php)</strong>: 현재 로그인한 사용자가 새로운 게시물을 작성할 수 있는 페이지입니다.</p>
		<strong>글 확인 (csrf_admin.php)</strong>: 게시물을 확인하는 페이지입니다.<br> 
		관리자 권한이 필요한 페이지로, 관리자 로그인(admin/password)후 게시물 조회와 동시에 관리자 비밀번호가 변경됩니다.</p>
	    </ul>

    <a href="csrf_login.php">
        <button class="practice-button">로그인</button>
    </a>
    <a href="csrf_post.php">
        <button class="practice-button">글 작성</button>
    </a>
    
    <h1>게시판</h1>
    <table border="1">
        <tr>
            <th>작성자</th>
            <th>내용</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo htmlspecialchars($row['author']); ?></td>
            <td><a href="csrf_admin.php?id=<?php echo $row['id']; ?>"><?php echo htmlspecialchars($row['content']); ?></a></td>
        </tr>
        <?php endwhile; ?>
    </table>
    <footer>
        	<p>Web Vulnerability Practice © 2024</p>
    </footer>
</body>
</html>

