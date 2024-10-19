<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DOM-Based XSS Simulation</title>
    <link rel="stylesheet" href="../../assets/css/styles.css">
    <script>
	window.onload = function() {
		var urlParams = new URLSearchParams(window.location.search);
		var reflectedInput = urlParams.get('reflected_input');
    
		if (reflectedInput) {
        // innerHTML을 그대로 사용하여 HTML 태그가 실행되도록 함
			document.getElementById("output").innerHTML = reflectedInput;
	    }
	};

    </script>
</head>
<body>
    <div class="wrapper">
        <header>
            <div class="container">
                <h1>DOM-Based XSS Simulation</h1>
                <ul>
                    <li><a href="Complex_xss.php">Back to User Page</a></li>
                </ul>
            </div>
        </header>

        <div class="container">
            <h2>Dynamic Content</h2>
            <p id="output">No content loaded yet.</p> <!-- 여기에서 해시 값이 실행됨 -->
        </div>

        <footer>
            <p>Web Vulnerability Practice &copy; 2024</p>
        </footer>
    </div>
</body>
</html>

