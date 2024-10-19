<!DOCTYPE html>
<html lang="ko">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Directory Indexing Introduction</title>
	<link rel="stylesheet" href="assets/css/styles.css">
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
	</style>
</head>
<body>
	<header>
		<div class="container">
			<h1>Directory Indexing Introduction</h1>
		</div>
	</header>

	<div class="container">
		<div class="description">
			<h1>Directory Indexing 설명</h1>
        <p>
            <strong>Directory Indexing</strong>은 웹 서버의 기능 중 하나로, 특정 인덱스 파일(<i>index.html</i> 또는 <i>index.php</i> 등)이 존재하지 않을 때 디렉터리의 내용을 나열하여 보여주는 것입니다. 이 기능은 개발 중에 유용할 수 있지만, 프로덕션 서버에서 활성화된 상태로 남아있으면 민감한 파일 및 디렉터리가 무단 사용자에게 노출될 위험이 있습니다.
        </p>
        <h2>Directory Indexing의 작동 방식</h2>
        <p>
            사용자가 웹 서버에서 디렉터리를 요청하면, 서버는 일반적으로 기본 페이지로 사용할 인덱스 파일(<i>index.html</i> 등)을 찾습니다. 만약 인덱스 파일이 없고 <b>Directory Indexing</b>이 활성화되어 있다면, 서버는 요청된 디렉터리 내의 모든 파일과 하위 디렉터리 목록을 생성하여 사용자의 브라우저에 표시합니다.
</p>
        <h2>Directory Indexing의 보안 위험</h2>
        <p>
            <b>Directory Indexing</b>이 활성화된 웹 서버는 다음과 같은 보안 위험을 초래할 수 있습니다:
        </p>
        <ul>
            <li><strong>민감한 파일 노출:</strong> 설정 파일, 백업 파일, 데이터베이스 덤프 등 민감한 파일이 무단 사용자에게 노출될 수 있습니다.</li>
            <li><strong>디렉터리 트래버설 공격:</strong> 공격자가 디렉터리 목록을 통해 서버의 파일 시스템을 탐색하고, 잠재적인 취약점을 찾아낼 수 있습니다.</li>
            <li><strong>정보 유출:</strong> 디렉터리 목록을 통해 서버의 구조, 설치된 애플리케이션 등의 정보가 노출될 수 있으며, 이는 추가적인 공격의 발판이 될 수 있습니다.</li>
        </ul>
        <h2>Directory Indexing 방지 방법</h2>
        <p>
            <b>Directory Indexing</b>을 방지하기 위해 다음과 같은 조치를 취할 수 있습니다:
        </p>
        <ul>
    <li><strong>Directory Indexing 비활성화:</strong><br>서버 설정 파일(Apache의 경우 httpd.conf)에서 관련 디렉터리에 대해 <b>Options Indexes</b>를 설정하여 <b>Directory Indexing</b>을 비활성화합니다.
<br>- path) <br>CentOS : /etc/httpd/conf/httpd.conf<br>Ubuntu : /etc/apache2/apache2.conf
<pre><code>&lt;Directory /var/www/html/&gt;<br>
        Options +Indexes<br>
        <del>DirectoryIndex Disabled</del><br>
&lt;/Directory&gt;</code></pre>
	    </li>
            <li><strong>인덱스 파일 생성:</strong> 각 디렉터리에 기본적으로 제공할 인덱스 파일(index.html 등)을 생성합니다.</li>
	    <li><strong>접근 제한:</strong> <b>.htaccess</b> 파일과 같은 접근 제어 메커니즘을 사용하여 민감한 디렉터리에 대한 접근을 제한합니다.<br>
<pre><code>Options +Indexes<br><del>DirectoryIndex disabled</del></code></pre>	
	</li>
        </ul>
        <h2>결론</h2>
        <p>
            Directory Indexing은 프로덕션 환경에서 주의 깊게 관리해야 할 기능입니다. Directory Indexing을 비활성화하고 디렉터리를 안전하게 보호함으로써, 민감한 파일에 대한 무단 접근 위험을 줄이고 웹 서버의 전반적인 보안을 강화할 수 있습니다.
        </p>
		</div>

		<a href="../../../.." class="button">Let's me see the Directory Indexing!</a>
		<div class="problem-list">
			<a href="../index.php" class="button">Home</a>
		</div>
	</div>

	<footer>
		<p>Web Vulnerability Practice &copy; 2024</p>
	</footer>
</body>
</html>
