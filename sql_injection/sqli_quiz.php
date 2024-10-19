<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>SQL Injection 실습 - 로그인</title>
    <link rel="stylesheet" href="assets/css/styles_sqli_quiz.css">
</head>
<body>
    <div class="container">
        <h1>SQL Injection Quiz</h1>
        
        <h3>Quiz1: admin 사용자의 password를 가져오시오.</h3>
        <h3>Quiz2: SQL injection 코드를 입력하여 user table과 user_profiles table이 합쳐진 테이블을 출력하시오.</h3>
        
        <form method="POST" action="">
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" required>
            <br><br>
            <label for="password">Password:</label>
            <input type="text" name="password" id="password" required>
            <br><br>
            <input type="submit" value="Login">
        </form>
        <form action="sqli_intro.php" method="get">
            <button type="submit">Back</button>
	</form>
        
        <?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // config.php 파일을 포함하여 데이터베이스 연결 설정 가져오기
    include 'sqli_config.php'; 

    // 사용자 입력 받기
    $username = $_POST['username'];
    $password = $_POST['password'];

    // 취약한 SQL 쿼리 (SQL Injection 가능)
    $sql = "SELECT id, username, password FROM users WHERE username = '$username' AND password = '$password'";
    $result = $pdo->query($sql);

    echo "<h2>실제 PHP 코드에서 처리 방식:</h2>";
    echo "<pre>";
    echo htmlspecialchars($sql);
    echo "</pre>";

    // 기본 결과 처리
    if ($result && $result->rowCount() > 0) {
        echo "<p><strong>로그인 성공!</strong> 사용자가 존재합니다.</p>";
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            echo "<p>Username: " . htmlspecialchars($row['username']) . " - Password: " . htmlspecialchars($row['password']) . "</p>";
        }
    } else {
        echo "<p><strong>로그인 실패!</strong> 사용자 이름 또는 비밀번호가 잘못되었습니다.</p>";
    }

    // Error-based SQL Injection 처리
    if (stripos($username, "'") !== false) {
        $error_sql = "SELECT COUNT(*) FROM users WHERE username = '$username'";
        $result_error = $pdo->query($error_sql);

        if (!$result_error) {
        }
    }

    // Union-based SQL Injection 처리
    if (stripos($username, 'UNION') !== false) {
        // 사용자 입력을 통한 UNION SQL Injection 시도
        $union_sql = "SELECT id, username, password FROM users WHERE username = '' OR 1=1 $username --"; // 기존 SQL 쿼리에 사용자 입력 추가
        $result_union = $pdo->query($union_sql);

        if ($result_union && $result_union->rowCount() > 0) {
            echo "<h3>Union-based SQL Injection 결과:</h3>";
            echo '<div class="results">';
            while ($row = $result_union->fetch(PDO::FETCH_ASSOC)) {
                echo "<p>ID: " . htmlspecialchars($row['id']) . " - Data: " . htmlspecialchars($row['username']) . " - Additional: " . htmlspecialchars($row['password']) . "</p>";
            }
            echo '</div>';
            $result_union->closeCursor();
        } 
    }
}
?>
    </div>
    <footer class="bottom">
        	<p>Web Vulnerability Practice © 2024</p>
    </footer>

</body>
</html>

