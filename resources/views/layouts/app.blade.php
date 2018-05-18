<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
	<head>
		<!--Meta-->
		<meta charset="utf-8"/>
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
		<meta name="robots" content="index, follow"/>
		<!--//Meta-->

		<!-- SEO -->
		{!! SEO::generate() !!}
		<!-- //SEO -->

		<!--Icons-->
		<link href="{{ asset("i/favicon.ico") }}" rel="shortcut icon" type="image/x-icon"/>
		<link href="{{ asset("i/favicon.ico") }}" rel="icon" type="image/x-icon"/>
		<link href="../i/icons/apple-touch-icon.jpg" rel="apple-touch-icon"/>
		<link href="../i/icons/apple-touch-icon-76.jpg" rel="apple-touch-icon" sizes="76x76"/>
		<link href="../i/icons/apple-touch-icon-140.jpg" rel="apple-touch-icon" sizes="140x140"/>
		<link href="../i/icons/apple-touch-icon-152.jpg" rel="apple-touch-icon" sizes="152x152"/>
		<!--//Icons-->

		<!-- CSRF Token -->
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<!-- //CSRF Token -->

		<!--CSS-->
		<link rel="stylesheet" type="text/css" media="screen" href="{{ asset("css/plugins/magnific-popup.css") }}"/>
		<link rel="stylesheet" type="text/css" media="screen" href="{{ asset("css/plugins/owl.carousel.min.css") }}"/>
		<link rel="stylesheet" type="text/css" media="screen" href="{{ asset("css/plugins/lightslider.min.css") }}"/>
		<link rel="stylesheet" type="text/css" media="screen" href="{{ asset("css/plugins/tooltipster.bundle.min.css") }}"/>
		<link rel="stylesheet" type="text/css" media="screen" href="{{ asset("css/sunsochi.css") }}"/>
		<link rel="stylesheet" type="text/css" media="screen" href="{{ asset("css/sunsochi.responsive.css") }}"/>
		<link rel="stylesheet" type="text/css" media="print" href="{{ asset("css/sunsochi.print.css") }}"/>
		<!--//CSS-->

	</head>

	<body itemscope itemtype="http://schema.org/WebPage">
		<div class="page">

			<!--header-->
			<header itemscope itemtype="http://schema.org/WPHeader" class="page-header">
				<div class="header-row header-row--top">
					<div class="page-inner page-inner--w1">
						<?php echo menu("top", "menus.top"); ?>
					</div>
				</div>

				<div class="header-row header-row--middle">
					<div class="page-inner page-inner--w1">
						<div class="header-row-items">
							<div class="header-logo">
								<a href="/" class="link header-logo-img">
									<?php include("svg/logo.svg"); ?>
								</a>
								<span class="header-logo-title">Вся жилая и коммерческая недвижимость в Сочи с помощью выбора и оформления</span>
							</div>

							<div class="header-mobile">
								<span class="header-mobile-title">Звоните нам бесплатно по РФ</span>
								<a href="tel:+78007075523" class="link link--orange header-mobile-item">8-800-707-55-23</a>
							</div>
							<a href="form-call.html" data-mfp-type="ajax" data-mfp-ajaxcontent="#form-call" data-mfp-bcg="#009ecc" data-mfp-closeinside="false" class="link button button--orange header-call mfp-modal">Заказать звонок</a>
							@php
									$active = "";
									$count = 0;
									if (!empty(json_decode(Cookie::get('sunsochi-favorite')))) {
										$count = count(json_decode(Cookie::get('sunsochi-favorite')));
										$active = "active";
									}
							@endphp
							<div class="header-mobile-elements">
								<div class="header-favorites mobile-favorites">

									<a href="/catalog/favorites/" class="link header-favorites-holder {{ $active }}">
										<?php include("svg/star.svg"); ?>
									</a>
									<span data-favorite="0" class="header-favorites-count">{{ $count }}</span>
								</div>
								<div class="header-burger"><span class="header-burger-inner"></span></div>
							</div>
						</div>
					</div>
				</div>
				<div class="header-row header-row--bottom">
					<div class="page-inner page-inner--w1">
						<div class="header-row-items">
							<div class="header-logo header-logo--mini">
								<a href="/" class="link header-logo-img">
									<?php include("svg/logo-mini.svg"); ?>
								</a>
							</div>

							<?php echo menu("main", "menus.top-next"); ?>

							<div class="header-favorites">
								<a href="/catalog/favorites/" class="link header-favorites-holder {{ $active }}">
									<?php include("svg/star.svg"); ?>
								</a>
								<span data-favorite="0" class="header-favorites-count">{{ $count }}</span>
							</div>

						</div>
					</div>
		        </div>

			</header>
			<!--//header-->

			<!--main-->
			<main class="page-content">
				@yield("content")
			</main>
			<!--//main-->

		</div>

		<!--preloader-->
		<div class="body-preloader">
			<div class="preloader-container">
				<img src="/svg/logo-mini_preload.svg" class="preloader-img">
			</div>
		</div>
		<!--//preloader-->

		<!--footer-->
		<footer itemscope itemtype="http://schema.org/WPFooter" class="page-footer">
			<div class="page-inner page-inner--w1">
				<div class="footer-row footer-row--top">
					<?php echo menu("main", "menus.footer"); ?>
				</div>
				<div class="footer-row footer-row--top">
					<?php echo menu("top", "menus.footer-next"); ?>
				</div>

				<div class="footer-row footer-row--bottom">
					<div class="footer-info">
						<a href="/pdf/policy.pdf" target="_blank" class="link link-bottom-orange footer-info-private">Политика обработки персональных данных</a>
						<div class="footer-info-name">SunSochi.com - Недвижимость в Сочи</div>
						<a href="http://aheadstudio.ru" target="_blank," class="link footer-creators">
							<span class="footer-creators-title">Поддержка сайта</span>
							<span class="footer-creators-name">Aheadstudio</span>
						</a>
					</div>
					<div class="footer-social">
						<a href="https://vk.com/sunsochi_realty" target="_blank" class="link footer-social-item">
							<?php include("svg/vk.svg"); ?>
						</a>
						<a href="https://www.facebook.com/%D0%A1%D0%BE%D0%BB%D0%BD%D0%B5%D1%87%D0%BD%D1%8B%D0%B9-%D0%A1%D0%BE%D1%87%D0%B8-175668546203847/" class="link footer-social-item">
							<?php include("svg/fb.svg"); ?>
						</a>
						<a href="https://www.instagram.com/sunsochi_realty/" target="_blank" class="link footer-social-item">
							<?php include("svg/instagram.svg"); ?>
						</a>
						<a href="https://www.youtube.com/channel/UCx7OHybth-mBGI2csx9C9_A" target="_blank" class="link footer-social-item">
							<?php include("svg/youtube.svg"); ?>
						</a>
					</div>
				</div>
			</div>
		</footer>
		<!--//footer-->

		<!--Scripts-->
		<script type="text/javascript" src="{{ asset("js/jquery-3.2.1.min.js") }}"></script>
		<script type="text/javascript" src="{{ asset("js/plugins/touchSwipe.js") }}"></script>
		<script type="text/javascript" src="{{ asset("js/plugins/jcf.js") }}"></script>
		<script type="text/javascript" src="{{ asset("js/plugins/jcf.checkbox.js") }}"></script>
		<script type="text/javascript" src="{{ asset("js/plugins/jcf.range.js") }}"></script>
		<script type="text/javascript" src="{{ asset("js/plugins/jcf.select.js") }}"></script>
		<script type="text/javascript" src="{{ asset("js/plugins/jquery.magnific-popup.min.js") }}"></script>
		<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDOtcx9Sm_hunFMGzh4eqe_XRkFUYMWIao&amp;sensor=true"></script>
		<script type="text/javascript" src="http://api-maps.yandex.ru/2.0/?load=package.full&amp;lang=ru-RU"></script>
		<script type="text/javascript" src="{{ asset("js/plugins/owl.carousel.min.js") }}"></script>
		<script type="text/javascript" src="{{ asset("js/plugins/jquery.mask.min.js") }}"></script>
		<script type="text/javascript" src="{{ asset("js/plugins/lightslider.min.js") }}"></script>
		<script type="text/javascript" src="{{ asset("js/plugins/jquery.table-sorter.js") }}"></script>
		<script type="text/javascript" src="{{ asset("js/plugins/tooltipster.bundle.min.js") }}"></script>
		<script type="text/javascript" src="{{ asset("js/plugins/jquery.raty.js") }}"></script>
		<script type="text/javascript" src="{{ asset("js/plugins/jquery.validate.min.js") }}"></script>
		<script type="text/javascript" src="{{ asset("js/plugins/sticky-kit.js") }}"></script>
		<script type="text/javascript" src="{{ asset("js/plugins/jquery.autocomplete.js") }}"></script>
		<script type="text/javascript" src="{{ asset("js/plugins/jquery.cookie.js") }}"></script>
		<script type="text/javascript" src="{{ asset("js/plugins/jquery.number.js") }}"></script>
		<script type="text/javascript" src="{{ asset("js/plugins/ssm.min.js") }}"></script>
		<script type="text/javascript" src="{{ asset("js/sunsochi.js") }}"></script>
		<script type="text/javascript" src="{{ asset("js/sunsochi-filter.js") }}"></script>
		<script type="text/javascript" src="{{ asset("js/app.js") }}"></script>
		<!--//Sripts-->

	</body>

</html>
