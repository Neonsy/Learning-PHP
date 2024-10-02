<?php
/**@var string $title */
/**@var array $notes */
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

	<body class="h-dvh bg-slate-900 bg-gradient-to-br from-gray-900 to-zinc-950 text-white select-none">
		<!-- All Notes Section -->
		<section class="py-20 px-4 flex flex-col items-center w-full h-full overflow-auto scroll-smooth">
			<div class="container mx-auto relative">
				<div class="flex flex-col items-center">
					<a href="/account" class="absolute -top-20 right-36 mt-4 mr-4 text-white hover:text-gray-400"
					   id="top">
						<img src="/icons/account.svg" alt="Desc" class="w-12"/>
					</a>
					<a href="/note/create" class="absolute -top-20 right-20 mt-4 mr-4 text-white hover:text-gray-400"
					   id="top">
						<img src="/icons/add.png" alt="Desc" class="w-12"/>
					</a>
                    <?php foreach ($notes as $note): ?>
						<div
								class="bg-gray-800 mb-8 p-6 rounded-lg shadow-md shadow-sky-900/10 focus-within:shadow-sky-800/15 focus-within:shadow-lg hover:shadow-sky-800/15 hover:shadow-lg transition-shadow duration-300 h-40 w-8/12">
							<h2 class="text-2xl font-bold mb-4"><?= $note['title'] ?></h2>
							<p class="mb-4 truncate">
                                <?= $note['content'] ?>
							</p>
							<a href="/note/<?= $note['id'] ?>" class="text-blue-500 hover:underline">Read Full Note</a>
						</div>
                    <?php endforeach; ?>
				</div>
			</div>
		</section>
		<a href="#top" class="absolute top-[95vh] right-[20rem]" tabindex="-1">
			<img src="/icons/up.svg" alt="Desc" class="w-12"/>
		</a>
	</body>
</html>
