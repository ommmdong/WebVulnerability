csrf_login

<?php
session_start();
$conn = new mysqli('localhost', 'root', '1111', 'db_csrf');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $conn->real_escape_string($_POST['username']);
    $password = $conn->real_escape_string($_POST['password']);

    $result = $conn->query("SELECT * FROM users WHERE username = '$username' AND password = '$password'");
    if ($result->num_rows > 0) {
        $_SESSION['username'] = $username;
        header("Location: csrf_index.php");
        exit();
    } else {
        echo "로그인 실패!";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>로그인</title>
    <link rel="stylesheet" href="assets/css/styles_csrf.css"> 
</head>
<body>
    <h1>로그인</h1>
    <form method="POST" action="">
        <label for="username">사용자 이름:</label>
        <input type="text" id="username" name="username"><br>
        <label for="password">비밀번호:</label>
        <input type="password" id="password" name="password"><br>
        <button type="submit">로그인</button>
    </form>
    <footer>
        	<p>Web Vulnerability Practice © 2024</p>
    </footer>
</body>
</html>


