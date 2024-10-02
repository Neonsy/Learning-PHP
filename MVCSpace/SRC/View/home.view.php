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
		<!-- Navbar -->
		<nav class="container mx-auto flex items-center justify-between p-6">
			<div class="text-2xl font-bold">NoteSpace</div>
			<div>
				<a href="/login" class="bg-blue-500 px-4 py-2 rounded mr-4 hover:bg-blue-600">Login</a>
				<a href="/register" class="bg-green-500 px-4 py-2 rounded hover:bg-green-600">Sign Up</a>
			</div>
		</nav>

		<!-- Hero Section -->
		<section class="container mx-auto text-center">
			<div
					class="mx-6 bg-gray-800 py-12 shadow-lg hover:shadow-sky-900/10 hover:shadow-xl transition-shadow duration-300">
				<h1 class="text-5xl font-bold mb-10">Welcome to NoteSpace</h1>
				<p class="text-xl mb-4">This website serves as a demo for a note-taking application.</p>
				<p class="text-xl mb-4">It is powered by the corresponding mvc framework for this course.</p>
				<p class="text-xl mb-4">It's meant for educational purposes only.</p>
				<a href="/register" class="inline-block bg-blue-500 px-6 py-3 mt-8 rounded text-xl hover:bg-blue-600">
					Get Started
				</a>
			</div>
		</section>

		<!-- Feature Cards -->
		<section class="container mx-auto py-12 px-4 flex flex-col items-center">
			<div class="grid grid-cols-1 md:grid-cols-2 gap-8">
				<div
						class="bg-gray-800 text-center p-6 rounded-lg shadow-lg hover:shadow-sky-900/10 hover:shadow-xl transition-shadow duration-300 md:-translate-y-3">
					<div class="mb-4">
						<img src="/icons/add.png" alt="Desc" class="w-8 inline-block"/>
					</div>
					<h2 class="text-2xl font-bold mb-4">Create Notes</h2>
					<p>Easily create notes with our user-friendly interface.</p>
				</div>

				<div
						class="bg-gray-800 text-center p-6 rounded-lg shadow-lg hover:shadow-sky-900/10 hover:shadow-xl transition-shadow duration-300 md:translate-y-5">
					<div class="mb-4">
						<img src="/icons/edit.png" alt="Desc" class="w-8 inline-block"/>
					</div>
					<h2 class="text-2xl font-bold mb-4">Edit Notes</h2>
					<p>Edit your notes to keep them up-to-date and accurate.</p>
				</div>

				<div
						class="bg-gray-800 text-center p-6 rounded-lg shadow-lg hover:shadow-sky-900/10 hover:shadow-xl transition-shadow duration-300 md:-translate-y-3">
					<div class="mb-4">
						<img src="/icons/delete.png" alt="Desc" class="w-8 inline-block"/>
					</div>
					<h2 class="text-2xl font-bold mb-4">Delete Notes</h2>
					<p>Remove notes that you no longer need with a single click.</p>
				</div>

				<div
						class="bg-gray-800 text-center p-6 rounded-lg shadow-lg hover:shadow-sky-900/10 hover:shadow-xl transition-shadow duration-300 md:translate-y-5">
					<div class="mb-4">
						<img src="/icons/account.png" alt="Desc" class="w-8 inline-block"/>
					</div>
					<h2 class="text-2xl font-bold mb-4">Account Management</h2>
					<p>You can view, edit, and delete your account information.</p>
				</div>
			</div>
		</section>
	</body>
</html>
