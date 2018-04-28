<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
	<head>
		<!--Meta-->
		<meta charset="utf-8"/>
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
		<meta name="description" content="Солнечный Сочи"/>
		<meta name="robots" content="index, follow"/>
		<!--//Meta-->

		<!--Open graph-->
		<meta property="og:type" content="website"/>
		<meta property="og:title" content="Солнечный Сочи"/>
		<meta property="og:site_name" content="Sun Sochi"/>
		<meta property="og:description" content="Вся жилая и коммерческая недвижимость в Сочи с помощью в выборе и оформлении"/>
		<meta property="og:url" content=""/>
		<meta property="og:image" content=""/>
		<!--//Open graph-->

		<!--Icons-->
		<link href="{{ asset("i/favicon.ico") }}" rel="shortcut icon" type="image/x-icon"/>
		<link href="{{ asset("i/favicon.ico") }}" rel="icon" type="image/x-icon"/>
		<link href="../i/icons/apple-touch-icon.jpg" rel="apple-touch-icon"/>
		<link href="../i/icons/apple-touch-icon-76.jpg" rel="apple-touch-icon" sizes="76x76"/>
		<link href="../i/icons/apple-touch-icon-140.jpg" rel="apple-touch-icon" sizes="140x140"/>
		<link href="../i/icons/apple-touch-icon-152.jpg" rel="apple-touch-icon" sizes="152x152"/>
		<!--//Icons-->

		<title></title>

		<!-- CSRF Token -->
		<meta name="csrf-token" content="{{ csrf_token() }}">

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
		<!--//Sripts-->

	</body>

</html>
