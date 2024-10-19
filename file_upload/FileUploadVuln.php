<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Upload Vulnerability</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>File Upload Vulnerability</h1>
            <ul>
                <li><a href="../../index.php">Home</a></li>
                <li><a href="../sql_injection/sqli_intro.php">SQL Injection</a></li>
                <li><a href="../xss/xss_intro.php">XSS</a></li>
                <li><a href="../csrf/csrf_intro.php">CSRF</a></li>
                <li><a href="../DirIndexing/DirIndexing.php">Directory Indexing</a></li>
            </ul>
        </div>
    </header>

    <div class="container">
        <h2>File Upload Vulnerability</h2>
        

        <!-- 설명 부분 -->
        <div class="explanation-container">
            <h2>파일 업로드 취약점 개요</h2>
            <p>파일 업로드 취약점은 웹 애플리케이션에서 사용자가 서버에 파일을 업로드할 수 있는 기능이 있을 때 발생할 수 있는 보안 취약점입니다. 이 취약점은 악의적인 사용자가 서버에 악성 코드를 포함한 파일을 업로드하고, 이를 실행시킴으로써 서버에 권한을 획득하거나 다른 공격을 시도할 수 있게 합니다.</p>

            <h3>취약점의 주요 요소</h3>
            <ul>
                <li><strong>확장자 검증 부족:</strong> 파일의 확장자를 제대로 검증하지 않으면, 공격자는 스크립트 파일(예: .php, .jsp)을 이미지 파일(예: .jpg)처럼 위장하여 업로드할 수 있습니다. 이로 인해 서버는 해당 파일을 실행하게 될 수 있습니다.</li>
                <li><strong>MIME 타입 검증 부족:</strong> 클라이언트가 전송하는 MIME 타입을 신뢰하여 검증을 소홀히 할 경우, 악의적인 파일이 안전한 파일로 위장될 수 있습니다. 예를 들어, .php 파일이 image/jpeg MIME 타입으로 전송되어 이미지로 인식되도록 할 수 있습니다.</li>
                <li><strong>파일 이름 변조:</strong> 파일 이름에 특수 문자를 포함시켜 우회 공격을 시도할 수 있습니다. 예를 들어, shell.php.jpg와 같은 파일 이름을 사용하여 서버가 이를 이미지로 인식하게 하는 것입니다.</li>
                <li><strong>실행 권한 관리 부족:</strong> 업로드된 파일에 실행 권한을 부여할 경우, 공격자는 악성 코드를 실행하여 서버를 장악할 수 있습니다.</li>
                <li><strong>PUT 메소드를 통한 파일 업로드:</strong> 웹 서버가 HTTP PUT 메소드를 통해 파일 업로드를 허용하는 경우, 이는 보안 취약점이 될 수 있습니다. 공격자는 이를 이용해 서버에 임의의 파일을 업로드할 수 있습니다.</li>
            </ul>

            <h3>취약점이 발생할 수 있는 시나리오</h3>
            <ul>
                <li><strong>웹셸 업로드:</strong> 공격자는 웹셸 파일(예: .php 파일)을 업로드하여, 서버에서 원격 명령을 실행할 수 있게 됩니다.</li>
                <li><strong>확장자 우회:</strong> 서버에서 특정 확장자만 허용할 때, 공격자는 우회 방법을 통해 악성 파일을 업로드할 수 있습니다. 예를 들어, image.php.gif와 같은 파일이 있습니다.</li>
                <li><strong>MIME 타입 우회:</strong> 서버가 MIME 타입을 검증하지 않거나 부정확하게 검증할 때, 공격자는 악성 파일을 안전한 파일로 위장하여 업로드할 수 있습니다.</li>
            </ul>

            <h3>방지 방법</h3>
            <ul>
                <li><strong>확장자 화이트리스트:</strong> 허용된 확장자만 서버에 업로드할 수 있도록 설정합니다.</li>
                <li><strong>MIME 타입 검증:</strong> 서버 측에서 MIME 타입을 정확하게 검증합니다.</li>
                <li><strong>파일 이름 변조 방지:</strong> 특수 문자가 포함된 파일 이름을 필터링합니다.</li>
                <li><strong>업로드 디렉토리 설정:</strong> 업로드된 파일이 저장되는 디렉토리에 실행 권한을 제거합니다.</li>
                <li><strong>HTTP 메소드 제한:</strong> PUT 메소드를 통한 파일 업로드를 비활성화합니다.</li>
            </ul>
        </div>

        <!-- Test Now 버튼 중앙 정렬 -->
        <div class="action">
            <a href="upload_test.php" class="attack-button">Test Level 1</a>
        </div>

        <!-- Test Level 2 버튼 추가 -->
        <div class="action">
            <a href="upload_test2.php" class="attack-button">Test Level 2</a>
        </div>

        <!-- Test Level 3 버튼 추가 -->
        <div class="action">
            <a href="upload_test3.php" class="attack-button">Test Level 3</a>
        </div>
        
        <!-- Test Level 4 버튼 추가 -->
        <div class="action">
            <a href="upload_test4.php" class="attack-button">Test Level 4</a>
        </div>
        
    </div>

    <footer>
        <p>Web Vulnerability Practice &copy; 2024</p>
    </footer>
</body>
</html>
