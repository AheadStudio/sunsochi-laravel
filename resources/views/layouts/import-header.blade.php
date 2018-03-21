<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />

		<title></title>
	</head>
	<body>
		<header>
			<?php echo menu("top", "menus.top"); ?>
			<div class="logo">
				<div class="logo-img"></div>
				<div class="logo-description">Вся жилая и коммерческая недвижимость в Сочи с помощью выбора и оформления</div>
			</div>
			<div class="phone"><?php echo setting("site.phone"); ?></div>

			<?php echo menu("main", "menus.main"); ?>
			<link href="{{ asset("css/bootstrap.min.css") }}" rel="stylesheet">
		</header>
		<main>
			@component("components.heading", ["title" => "TEST"])
			@endcomponent

			@yield("content")
		</main>
		<footer>
			<?php echo menu("main", "menus.footer"); ?>
			<?php echo menu("top", "menus.footer"); ?>
		</footer>
	</body>
</html>
