
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CSRF 개념</title>
    <link rel="stylesheet" type="text/css" href="assets/css/styles_csrf_intro.css">
</head>
<body>
    <header class="header-title">
        <h1>CSRF</h1>
    </header>

    <div class="container">
        <main>
            <h2>CSRF 개념</h2>
            <p>CSRF란 Cross Site Request Forgery의 약자로, 사이트 간 요청 위조를 뜻합니다.
            웹 보안 취약점 중 하나로 사용자가 자신의 의지와 무관하게 공격자가 의도한 행동을 하여 
            특정 웹페이지를 보안에 취약하게 하거나 수정, 삭제 등의 작업을 하게 만드는 공격입니다.</p> 
</section> 
            <h2>공격 시나리오</h2>
            <ol>
                <li>관리자가 웹 애플리케이션에 로그인하여 인증 세션을 유지합니다.</li>
                <li>공격자가 악성 웹사이트를 만들고, 관리자 계정을 변경하는 요청을 자동으로 생성합니다.</li>
                <li>관리자가 악성 웹사이트를 방문하여 악성 요청을 자동으로 전송합니다.</li>
                <li>관리자의 브라우저가 세션 쿠키를 포함하여 요청을 보내고, 서버는 이를 정상적인 관리자 요청으로 처리합니다.</li>
                <li>서버는 요청에 따라 관리자의 비밀번호를 변경합니다.</li>
            </ol>
            
            <h2>위협</h2>
            <ul>
                <li>불법적인 데이터 조작</li>
                <li>계정 탈취</li>
                <li>정보 유출</li>
                <li>악성 코드 실행</li>
                <li>무단 권한 상승</li>
            </ul>

            <h2>대응 방안</h2>
            <ol>
                <li><strong>CSRF 토큰 사용</strong>
                    <p>사용자 세션에 임의의 값을 저장해 모든 POST 요청마다 해당 값을 포함하여 전송하도록 합니다.
                    서버에서 요청을 받을 때마다, 세션에 저장된 값과 요청으로 전송된 값의 일치 여부를 검증하여 방어하는 방법입니다.</p>
                </li>
                <li><strong>Referer Header 확인</strong>
                    <p>Referer Header란 요청이 어디서 왔는지 확인하는 헤더입니다. 일반적인 상황에서 비밀번호 변경 요청은 마이페이지에서 일어나지만 csrf 공격이 발생한 경우 게시판에서 일어날 수 있습니다. 이렇게 뜬금없는 곳에서 발생하는 요청을 막기위해 Referer 검증을 실시합니다.</p>
                </li>
                <li><strong>SameSite 쿠키 속성 사용</strong>
                    <p>SameSite 속성은 브라우저가 쿠키를 어떤 상황에서 전송하는지를 제어하는 속성입니다. SameSite 속성을 'strict'나 'Lax'로 설정하면, 외부 도메인에서의 요청 시 쿠키를 전송하지 않도록 할 수 있습니다.</p>
                </li>
                <li><strong>추가 인증 수단 사용</strong>
                    <p>비밀번호 변경과 같은 중요한 작업에 대해 추가적인 인증 절차를 요구할 수 있습니다. 예를 들어, 사용자가 비밀번호를 변경하기 전에 현재 비밀번호를 입력하거나 2단계 인증을 요구할 수 있습니다.</p>
                </li>
            </ol>

            <h2>실습</h2>
            <p>아래 버튼을 클릭하여 CSRF 실습 페이지로 이동하세요.</p>
    	    <form action="/csrf/csrf_index.php" method="get">
                    <button type="submit">CSRF practice</button>
           </form>
           
           <form action="../index.php" method="get">
                    <button type="submit">HOME</button>
           </form>
        </main>
	</div>
        <footer>
            <p>Web Vulnerability Practice © 2024</p>
        </footer>
    
</body>
</html>


