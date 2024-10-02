<?php
/**@var string $title */
/**@var array $note */
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

	<body
			class="min-h-screen bg-slate-900 bg-gradient-to-br from-gray-900 to-zinc-950 text-white flex items-center justify-center overflow-hidden">
		<!-- Note Section -->
		<section class="py-20 px-4 flex flex-col items-center justify-center w-full">
			<div class="container mx-auto relative flex flex-col items-center justify-center">
				<div class="bg-gray-800 p-6 rounded-lg shadow-lg w-10/12 lg:w-8/12 h-[57dvh] mx-auto shadow-blue-500/10">
					<h1 class="text-3xl font-bold mb-4 truncate"><?= $note['title'] ?></h1>
					<div class="flex justify-around">
						<a href="/notes" class="text-blue-500 hover:underline flex items-center mb-8 select-none w-16">Back</a>
						<a
								href="/note/edit/<?= $note['id'] ?>"
								class="text-blue-500 hover:underline flex items-center mb-8 select-none w-16">
							Edit
						</a>
						<a
								hx-delete="/note/delete/<?= $note['id'] ?>"
								hx-swap="none"
								hx-confirm="Are you sure you want to delete this note?"
								class="text-blue-500 hover:underline flex items-center mb-8 select-none w-16 cursor-pointer">
							Delete
						</a>
					</div>
					<div class="overflow-y-auto h-4/5">
						<p class="prose prose-invert max-w-none prose-lg px-6"><?= $note['content'] ?></p>
					</div>
				</div>
			</div>
		</section>
	</body>
</html>
