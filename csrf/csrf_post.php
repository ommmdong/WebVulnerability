<?php
session_start();
$conn = new mysqli('localhost', 'root', '1111', 'db_csrf');

if (!isset($_SESSION['username'])) {
    header("Location: csrf_login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $author = $_SESSION['username'];
    $content = $conn->real_escape_string($_POST['content']);
    $conn->query("INSERT INTO posts (author, content) VALUES ('$author', '$content')");
    header("Location: csrf_index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>글 작성</title>
    <link rel="stylesheet" href="assets/css/styles_csrf.css">  
</head>
<body>
    <h1>글 작성</h1>
    <form method="POST" action="">
        <textarea name="content" rows="5" cols="40"></textarea><br>
        <button type="submit">글 올리기</button>
    </form>
    <footer>
        	<p>Web Vulnerability Practice © 2024</p>
    </footer>
</body>
</html>

