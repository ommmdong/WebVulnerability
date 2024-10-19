<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Blind SQL Injection</title>
    <link rel="stylesheet" href="assets/css/styles_sqli.css"> 
</head>
<body>
    <h1>Blind SQL Injection 연습</h1>
    <p class="description">Blind SQL Injection 웹 취약점을 학습할 수 있는 공간입니다.<br>
    Boolean-Based SQL Injection과 Time-Based SQL Injection을 연습할 수 있도록 다양한 공격 코드를 입력하세요!!</p>
    
    <button onclick="toggleLearningGoal()" class="learning-goal-button">학습 목표</button>
     
    <!-- 학습 목표 내용 -->
    <div id="learning_goal" class="learning-goal" style="display:none;">
	<p>
	 쿼리의 결과가 참(True)인지 거짓(False)인지에 따라 다른 응답을 얻어내는 방식을 학습<br><br>
	1.Boolean-Based SQL Injection<br>학습 내용: id가 1인 사용자의 username의 첫 글자가 'a'인지 여부를 확인하여 데이터베이스에서 정보를 추출<br>
	<br> 
	2.Time-Based SQL Injection<br>학습 내용: 3초 동안 서버가 응답하지 않도록 의도적으로 지연을 발생시키고, 지연 시간이 나타나는지 여부를 통해 SQL 쿼리가 성공했는지 판단<br>
	</p>
        
    </div>
    
    <div class="container">
        <h1>사용자 정보 확인</h1>
        <form method="POST" action="">
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" required>
            <input type="submit" value="Check">
        </form>

        <?php
        // config.php 파일을 포함하여 데이터베이스 연결 설정 가져오기
        include 'sqli_config.php'; 

        if (isset($_POST['username'])) {
            // 사용자 입력 받기
            $username = $_POST['username'];

            // SQL 쿼리 준비 및 실행
            $sql = "SELECT username FROM users WHERE username = '$username'";

            try {
                // 쿼리 준비
                $stmt = $pdo->query($sql);

                // 결과 확인
                if ($stmt->rowCount() > 0) {
                    echo '<div class="results">';
                    echo "<p>Username $username exists.</p>";
                    echo '<button onclick="document.getElementById(\'source-code\').style.display=\'block\'">View Source</button>';
                    echo '</div>';
                } else {
                    echo '<div class="results">';
                    echo "<p>Username $username does not exist.</p>";
                    echo '<button onclick="document.getElementById(\'source-code\').style.display=\'block\'">View Source</button>';
                    echo '</div>';
                }
            } catch (PDOException $e) {
                echo '<div class="results">';        
                echo "<p>Something went wrong with the query: " . htmlspecialchars($e->getMessage()) . "</p>";
                echo '<button onclick="document.getElementById(\'source-code\').style.display=\'block\'">View Source</button>';
                echo '</div>';
            }
        }
        ?>

        <!-- 취약한 코드가 포함된 소스 코드 블록 -->
        <div id="source-code" style="display:none;">
            <h2>취약한 소스 코드:</h2>
            <pre>
$sql = "SELECT username FROM users WHERE username= '$username'";
$stmt = $pdo->query($sql);
            </pre>
        </div>
    </div>
    	<form action="sqli_intro.php" method="get">
            <button type="submit">Back</button>
	</form>
    <footer>
        	<p>Web Vulnerability Practice © 2024</p>
    </footer>
    
    <script>
        function toggleLearningGoal() {
            var goalDiv = document.getElementById('learning_goal');
            if (goalDiv.style.display === 'none') {
                goalDiv.style.display = 'block';
            } else {
                goalDiv.style.display = 'none';
            }
        }
    </script>
</body>
</html>

