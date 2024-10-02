<?php
/**@var string $title */
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8"/>
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
		<title><?= $title ?> | NoteSpace</title>
		<link rel="stylesheet" href="/css/style.css"/>
		<link rel="shortcut icon" href="/icons/fav.png"/>
	</head>

	<body class="min-h-dvh bg-slate-900 bg-gradient-to-br from-gray-900 to-zinc-950 text-white select-none">
		<!-- Login Section -->
		<section class="flex items-center justify-center min-h-screen py-12 px-4">
			<div class="max-w-md w-full bg-gray-800 p-8 rounded-lg shadow-lg">
				<h2 class="text-3xl font-bold text-center mb-6">Login to Your Account</h2>
				<form action="/login" method="post">
					<div class="mb-4">
						<label for="email" class="block text-sm font-medium mb-2">Email</label>
						<input
								type="email"
								id="email"
								name="email"
								class="w-full px-4 py-2 bg-gray-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
								required/>
					</div>
					<div class="mb-6">
						<label for="password" class="block text-sm font-medium mb-2">Password</label>
						<input
								type="password"
								id="password"
								name="password"
								class="w-full px-4 py-2 bg-gray-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
								required/>
					</div>
					<button type="submit" class="w-full bg-blue-500 px-4 py-2 rounded-lg hover:bg-blue-600">Login
					</button>
				</form>
				<p class="mt-6 text-center">
					Don't have an account?
					<a href="/register" class="text-green-500 hover:underline">Sign Up</a>
				</p>
			</div>
		</section>
	</body>
</html>