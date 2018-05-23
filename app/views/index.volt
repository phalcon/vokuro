<!DOCTYPE html>
<html>
	<head>
		<title>Welcome to Vökuró</title>
                <meta charset="utf-8">
                 <!-- Viewport Meta Tag -->
                <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
                <!-- Bootstrap 4.1.1 -->
		{{ stylesheet_link('css/bootstrap.min.css') }}
                <!-- Open-iconic fonts for bootstrap -->
                {{ stylesheet_link('css/open-iconic-bootstrap.css') }}
                {{ stylesheet_link('css/style.css') }}
	</head>
	<body>
		{{ content() }}
                {{ javascript_include('js/jquery-3.3.1.min.js') }}
                {{ javascript_include('js/bootstrap.bundle.min.js') }}
	</body>
</html>