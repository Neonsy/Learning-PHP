<?php
/**@var string $title */
/**@var string $username */
/**@var string $email */
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8"/>
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
		<title><?= $title ?> | NoteSpace</title>
		<link rel="stylesheet" href="/css/style.css"/>
		<link rel="shortcut icon" href="/icons/fav.png"/>
		<script
				src="https://unpkg.com/htmx.org@1.9.12"
				integrity="sha384-ujb1lZYygJmzgSwoxRggbCHcjc0rB2XoQrxeTUQyRjrOnlCoYta87iKBWq3EsdM2"
				crossorigin="anonymous"></script>
	</head>

	<body class="min-h-screen bg-slate-900 bg-gradient-to-br from-gray-900 to-zinc-950 text-white">
		<!-- Account Section -->
		<section class="flex flex-col items-center justify-center min-h-screen py-20 px-4">
			<div
					class="container mx-auto max-w-6xl bg-gradient-to-br from-gray-900 to-gray-900 p-10 rounded-2xl shadow-2xl relative">
				<a href="/notes" class="absolute top-4 left-4 text-blue-500 hover:underline flex items-center">
					<img src="/icons/chevron.svg" alt="Desc" class="w-8"/>
					Back
				</a>
				<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-8">
					<div class="lg:col-span-1 bg-gray-800 rounded-xl p-6 shadow-lg flex flex-col justify-center items-start">
						<h2 class="text-3xl font-bold mb-4">Account Overview</h2>
						<p class="text-gray-400 mb-2">Username:</p>
						<p class="text-white text-lg mb-4 capitalize"><?= $username ?></p>
						<p class="text-gray-400 mb-2">Email:</p>
						<p class="text-white text-lg mb-4"><?= $email ?></p>
					</div>
					<div class="lg:col-span-2 bg-gray-800 rounded-xl p-6 shadow-lg">
						<h3 class="text-2xl font-bold mb-6 text-center md:text-left">Update Profile</h3>
						<a href="/logout"
						   class="absolute bottom-16 left-72 text-blue-500 hover:underline flex items-center">
							Sign Out
						</a>
						<form hx-put="/account" hx-trigger="submit" hx-swap="none">
							<div class="mb-4">
								<label for="email" class="block text-sm font-medium mb-2">New Email</label>
								<input
										type="email"
										id="email"
										name="email"
										class="w-full px-4 py-2 bg-gray-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"/>
							</div>
							<div class="mb-4">
								<label for="new-password" class="block text-sm font-medium mb-2">New Password</label>
								<input
										type="password"
										id="new-password"
										name="newpw"
										class="w-full px-4 py-2 bg-gray-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"/>
							</div>
							<button type="submit" class="w-full bg-blue-500 px-4 py-2 rounded-lg hover:bg-blue-600">
								Update Profile
							</button>
						</form>
						<button
								class="w-full bg-red-500 px-4 py-2 mt-8 rounded-lg hover:bg-red-600 text-white font-bold text-lg shadow-lg"
								hx-delete="/account"
								hx-trigger="click"
								hx-swap="none"
								hx-confirm="Are you sure you want to delete your account?">
							Delete Account
						</button>
					</div>
				</div>
			</div>
		</section>
	</body>
</html>
