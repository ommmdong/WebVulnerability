<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>In-band SQL Injection</title>
    <link rel="stylesheet" href="assets/css/styles_sqli.css"> 
</head>

<body class="flex-container"> <!-- Flexbox 레이아웃을 적용한 클래스 추가 -->
    <h1>In-band SQL Injection 연습</h1>
    <p class="description">In-Band SQL Injection 웹 취약점을 학습할 수 있는 공간입니다.<br>
    Error-Based SQL Injection과 Union-Based SQL Injection을 연습할 수 있도록 다양한 공격 코드를 입력하세요!!</p>
    
     <button onclick="toggleLearningGoal()" class="learning-goal-button">학습 목표</button>
     
    <!-- 학습 목표 내용 -->
    <div id="learning_goal" class="learning-goal" style="display:none;">
	<p>
	각 기법을 사용하여 데이터베이스의 구조와 데이터를 탐색하는 방법을 학습<br><br>
	1.Error-Based SQL Injection<br>학습 내용: 모든 사용자의 데이터 탈취<br><br> 
	2. Union-Based SQL Injection<br>학습 내용: information_schema를 이용하여 데이터베이스 정보 추출<br>
	</p>
        
    </div>
    
    <div class="container">
        <h1>사용자 정보 검색</h1>
        <form method="GET" action="">
            <label for="user_id">User ID:</label>
            <input type="text" name="user_id" id="user_id" required>
            <input type="submit" value="Search">
        </form>

        <?php
        $is_injection_detected = false;

        // config.php 파일을 포함하여 데이터베이스 연결 설정 가져오기
        include 'sqli_config.php'; 

        if (isset($_GET['user_id'])) {
            $user_id = $_GET['user_id'];

            // SQL 쿼리 실행
            $sql = "SELECT username, password FROM users WHERE id = '$user_id'";
            $result = $pdo->query($sql); // PDO 객체 $pdo 사용

            // SQL Injection 감지
            if (strpos($user_id, 'OR') !== false || $result->rowCount() > 1) {
                $is_injection_detected = true;
            }

            echo '<div class="results">';
            if ($result->rowCount() > 0) {
                while($row = $result->fetch(PDO::FETCH_ASSOC)) {
                    echo "<p>Username: " . $row["username"] . "</p>";
                    echo "<p>Password: " . $row["password"] . "</p>";
                }
            } else {
                echo "<p>No user found.</p>";
            }
            echo '</div>';
        }

 if ($is_injection_detected) {
            echo '<button onclick="document.getElementById(\'source_code\').style.display=\'block\'">View Source</button>';
            
            // PHP 코드 문자열 정의
            $php_code = '<?php
$user_id = $_GET["user_id"];
$sql = "SELECT username, password FROM users WHERE id = \'$user_id\'";
$result = $pdo->query($sql);
?>';

            echo '<pre id="source_code" style="display:none;">';

            // 출력을 버퍼에 저장하고, 하이라이트된 코드를 출력
            ob_start();
            highlight_string($php_code);
            $highlighted_code = ob_get_clean();
            echo $highlighted_code;

            echo '</pre>';
        }
        ?>
    </div>

    <!-- Back 버튼을 컨테이너 밖으로 이동 -->
    <form action="sqli_intro.php" method="get">
        <button type="submit">Back</button>
    </form>

    <!-- 푸터 -->
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

