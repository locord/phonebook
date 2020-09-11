<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"/>
	<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
	<title>PhoneBook</title>
	<meta name="viewport" content="width=device-width, initial-scale=1"/>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
		  integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<style>
		body {
			padding-top: 70px;
		}

		h1 {
			margin-top: 0
		}

		.app {
			display: flex;
			min-height: 100vh;
			flex-direction: column;
		}

		.app-content {
			flex: 1;
		}

		.app-footer {
			padding-bottom: 1em;
		}
	</style>
</head>
<body class="app">
<header class="app-header">
	<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
		<div class="container">
			<div class="navbar-header">
				<a class="navbar-brand" href="/">
					Main
				</a>
			</div>
		</div>
	</nav>
</header>

<div class="app-content">
	<main class="container">
		<ul class="breadcrumb">
			<li><a href="/" class="active">Home</a></li>
			<li><a href="#">Profile</a></li>
		</ul>
		<h1>Home page</h1>
	</main>
</div>

<footer class="app-footer">
	<div class="container">
		<hr/>
		<p>&copy; 2020 - PhoneBook.</p>
	</div>
</footer>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"
		integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
		crossorigin="anonymous">
</script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</body>
</html>