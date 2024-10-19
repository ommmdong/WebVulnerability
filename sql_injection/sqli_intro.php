<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SQL Injection 개념</title>
    <link rel="stylesheet" href="assets/css/styles_sqli_intro.css">
</head>
<body>
	    <!-- 배경색이 있는 헤더 섹션 추가 -->
    <header class="header-title">
        <h1>SQL Injection</h1>
    </header>
	
    <div class="container">
        <!-- 개념 -->
        <section>
            <h2>개념</h2>
            <p>SQL Injection은 사용자의 입력 값으로 웹 사이트 SQL 쿼리가 완성되는 약점을 이용하여, 입력 값을 변조하여 비정상적인 SQL 쿼리를 조합하거나 실행하는 공격 기법입니다. 이를 통해 공격자는 데이터베이스에서 민감한 정보를 유출하거나 데이터를 조작할 수 있습니다.</p>
        </section>
        
        <!-- 위협 -->
        <section>
            <h2>위협</h2>
            <p>SQL Injection이 존재하는 경우, 공격자는 비정상적인 SQL 쿼리를 실행하여 데이터베이스 관리 시스템(DBMS) 및 데이터(DATA)를 열람하거나 조작할 수 있습니다. 이러한 공격은 데이터 유출, 데이터 무결성 훼손, 서비스 중단 등의 심각한 위협을 초래할 수 있습니다.</p>
        </section>
        
        <!-- 공격 유형 -->
        <section>
            <h2>공격 유형</h2>
            <p>SQL Injection 공격은 여러 가지 유형으로 나눌 수 있으며, 각 유형은 공격자가 SQL 쿼리를 어떻게 조작하는지에 따라 다릅니다:</p>
            <h3>1. In-band SQL Injection</h3>
            <p>In-band SQL Injection은 공격자가 데이터베이스의 에러 메시지를 활용하거나, UNION 키워드를 사용하여 SQL 쿼리의 결과를 직접 확인할 수 있는 공격 기법입니다.</p>
            <ul>
                <li><strong>Error-Based SQL Injection:</strong> 데이터베이스에서 에러 메시지를 활용하여 정보 획득합니다. 특수문자(예: '  , "  , ;)를 입력하여 SQL 에러를 유발하고, 이를 통해 데이터베이스 구조에 대한 정보를 수집합니다.</li>
                <li><strong>Union-Based SQL Injection:</strong> UNION 키워드를 사용하여 두 개 이상의 쿼리를 결합해 정보를 얻는 공격입니다. UNION은 합집합 연산자이기 때문에, 원래의 SQL 쿼리문이 조회하는 SELECT 문의 칼럼 개수와 일치해야 합니다.</li>
            </ul>

            <h3>2. Blind SQL Injection</h3>
            <p>Blind SQL Injection은 데이터베이스의 에러 메시지나 직접적인 쿼리 결과가 노출되지 않는 상황에서 사용하는 공격 기법입니다. 공격자는 참/거짓 결과를 통해 데이터베이스 구조를 추론할 수 있습니다.</p>
            <ul>
                <li><strong>Boolean-Based SQL Injection:</strong> 참/거짓 결과를 통해 데이터베이스의 상태를 파악합니다. 조건이 참일 때와 거짓일 때의 웹 페이지 응답을 비교하여 정보를 얻습니다.</li>
                <li><strong>Time-Based SQL Injection:</strong> SQL 쿼리의 실행 시간을 이용해 참/거짓을 구분합니다. 쿼리 실행 시간의 변화를 통해 데이터베이스의 상태를 추론합니다.</li>
            </ul>
        </section>

        <!-- 방어 기법 -->
        <section>
            <h2>방어 기법</h2>
            <h3>(1) Prepared Statement 사용하기</h3>
            <p>Prepared Statement는 구문 분석(parse) 과정을 최초 1회만 수행하여 생성된 결과를 메모리에 저장해 필요할 때마다 사용하는 방법입니다. 이 방법을 사용하면 SQL 문법에 영향을 미치는 특수문자나 구문이 입력되더라도, SQL Injection 공격을 효과적으로 방어할 수 있습니다.</p>

            <h3>(2) 화이트 리스트 기반 필터링</h3>
            <p>Prepared Statement를 사용할 수 없는 경우, 화이트 리스트 기반 필터링을 사용해 SQL Injection을 방어할 수 있습니다. 안전한 문자열을 미리 정의하고, 이를 허용하는 방식으로 동작하며, 정규식을 이용해 패턴화된 필터링을 적용하는 것이 유용합니다.</p>

            <h3>(3) 웹 애플리케이션 방화벽(WAF) 사용하기</h3>
            <p>웹 애플리케이션 방화벽(WAF)은 SQL Injection과 같은 공격을 탐지하고 차단할 수 있는 규칙 기반의 필터링을 제공합니다. WAF를 통해 실시간으로 웹 애플리케이션의 보안을 강화할 수 있습니다.</p>

            <h3>(4) 정기적인 보안 테스트</h3>
            <p>SQL Injection과 같은 보안 취약점을 사전에 발견하고 수정하기 위해, 정기적인 보안 검토와 침투 테스트를 실시하는 것이 필수적입니다. 이를 통해 보안 위험을 최소화할 수 있습니다.</p>
        </section>
        
        <!-- 버튼 섹션 -->
        <section class="button-section">
            <h2>SQL Injection 실습</h2>
            <p>SQL 인젝션의 위험성을 이해하기 위해, 아래 버튼을 눌러 실습 페이지로 이동해보세요.</p>
            <div class="button-container">

                <form action="inband_sqli.php" method="get">
                    <button type="submit">In-band SQL Injection 연습하기</button>
                </form>
                <form action="blind_sqli.php" method="get">
                    <button type="submit">Blind SQL Injection 연습하기</button>
                </form>
		<form action="sqli_quiz.php" method="get">
                    <button type="submit">Quiz</button>
                </form>
                <!-- index.php로 돌아가는 버튼 추가 -->
                <form action="../index.php" method="get">
                    <button type="submit">HOME</button>
                </form>
                
            </div>
        </section>
    </div>
    <footer>
        	<p>Web Vulnerability Practice © 2024</p>
    </footer>
</body>
</html>

