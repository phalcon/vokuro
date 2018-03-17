<!DOCTYPE html>
<html>
	<head>
		<title>Welcome to Vökuró</title>
		<link href="//netdna.bootstrapcdn.com/bootswatch/2.3.1/united/bootstrap.min.css" rel="stylesheet">
		{{ stylesheet_link('css/style.css') }}
        {{ stylesheet_link('/css/bootstrap-tagsinput-v0.8.0.css') }}
	</head>
	<body>
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

		{{ content() }}

		<script src="/js/bootstrap-v2.3.1.min.js"></script>
		<script src="/js/bootstrap-tagsinput-v0.8.0.js"></script>
	</body>
</html>