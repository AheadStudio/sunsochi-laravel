@extends("layouts.app")

@section("content")
	<div class="page-inner page-inner--w1">
		<div class="blog">
			<div class="page-text">
				<h1>{{ $pageTitle }}</h1>
			</div>
			<div class="blog-search">
				<form method="post" action="#" class="form">
					<div class="form-row">
						<div class="form-row-100">
							<div class="form-holder">
								<input type="text" placeholder="Поиск по блогу" data-autocomplete="true" data-autocomplete-url="http://localhost:8000/api/blog" class="form-item form-item--text">
								<button type="button" class="form-filter-search">
									<span class="form-filter-search-icon">
										<?php include("svg/loupe.svg"); ?>
									</span>
								</button>
							</div>
						</div>
					</div>
				</form>
			</div>
			<div class="blog-info">
				<div class="blog-container">
					<div class="blog-holder">
						@if (isset($blogMaxViews->preview_picture) || $blogMaxViews->preview_picture != "")
							<img src="{{ $blogMaxViews->preview_picture }}" class="blog-img">
						@endif
					</div>
					<div class="blog-title">{{ $blogMaxViews->name }}</div>
					<div class="blog-group">
						<div class="blog-data">{{ $blogMaxViews->date }}</div>
						<div class="blog-views {{ $blogMaxViews->views > 0 ? 'active' :'' }}">
							<span class="blog-views-icon">
								<?php include("svg/views.svg"); ?>
							</span>
							<span class="blog-views-count">{{ $blogMaxViews->views }}</span>
						</div>
						@php
							/*#component vue path:resources/assets/js/components/RatingComponent >
							<rating-component :rating='{"read" : false, "value" : "{{$blogMaxViews->rating}}", "voted" : "{{ $blogMaxViews->voted }}", "summ" : "{{ $blogMaxViews->summ_rating }}", "code": "{{ $blogMaxViews->code }}"}'></rating-component>
							< component vue#*/
						@endphp
						<div data-rating data-rating-value="{{$blogMaxViews->rating}}" data-rating-read="false" data-rating-params='{"voted" : "{{ $blogMaxViews->voted }}", "summ" : "{{ $blogMaxViews->summ_rating }}", "code": "{{ $blogMaxViews->code }}"}' class="blog-rating"></div>

					</div>
					<div class="blog-text">{!! $blogMaxViews->detail_text !!}</div>
					<div class="blog-tags">
						<a href="#" class="link link--opacity blog-tag">Налоги</a>
						<a href="#" class="link link--opacity blog-tag">Пенсионеры</a>
					</div>
				</div>
				<div class="blog-topics">
					<div data-sticky data-sticky-offset-top="100">
						<div class="blog-topics-title">Популярные темы</div>
						@foreach ($blogPopular as $valBlogPopular)
							<p>
								<a href="{{ route("BlogShow", $valBlogPopular->code) }}" class="link link-blue link--showdow-blue blog-topics-item">{{ $valBlogPopular->name }}</a>
							</p>
						@endforeach
					</div>
				</div>
			</div>
			<div id="blog-list-load" class="blog-list">
				@foreach ($blogList as $keyBlogList => $valBlogList)
					<div class="blog-item">
						<a href="{{ route("BlogShow", $valBlogList->code) }}" class="link link-black blog-link">
							<div class="link blog-holder"><img src="{{ $valBlogList->preview_picture }}" class="blog-img"></div>
							<div class="link link-black link--orange blog-title">{{ $valBlogList->name }}</div>
						</a>
						<div class="blog-group">
							<div class="blog-data">{{ $valBlogList->date }}</div>
							<div class="blog-views {{ $valBlogList->views > 0 ? 'active' :'' }}">
								<span class="blog-views-icon">
									<?php include("svg/views.svg"); ?>
								</span>
								<span class="blog-views-count">{{ $valBlogList->views }}</span>
							</div>

							@php
								/*#component vue path:resources/assets/js/components/RatingComponent
									<keep-alive>
										<rating-component :rating='{"read" : "true", "value" : "{{$valBlogList->rating}}"}'></rating-component>
									</keep-alive>
								 component vue#*/
							@endphp
							<div data-rating data-rating-value="{{$valBlogList->rating}}" data-rating-read="true" class="blog-rating"></div>

						</div>
						<div class="blog-text">{{ $valBlogList->preview_text }}</div>
						<div class="blog-tags">
							<a href="#" class="link link--opacity blog-tag">Кредит</a>
							<a href="#" class="link link--opacity blog-tag">Индивидуальный предприниматель</a>
						</div>
					</div>
				@endforeach
			</div>

			@php
			/*#component vue path:resources/assets/js/components/PaginationComponent
			<pagination-component :pagination='{"setting" : {{$blogPagination}}, "paginationClass" : "blog-more", "paginationContainer" : "#blog-list-load", paginationItem : ".blog-item" }'></pagination-component>
			 component vue#*/
			@endphp

			@include("pagination.default", [
				"paginator" => $blogList,
				"class" 	=> "blog-more",
				"container" => "#blog-list-load",
				"item" 		=> ".blog-item",
			])

		</div>
	</div>

	<div style="background:#009ecc" class="page-inner page-inner--max">
		<div class="page-inner page-inner--w1">
			<div class="order-sub">
				<div class="page-text">
					<h2>Быть в курсе – просто. <br>Подпишитесь!</h2>
				</div>
				<form class="form form-order-sub">
					<div class="form-row form-row--100">
						<input type="email" id="name" name="name" required data-error="Укажите Ваш e-mail" aria-required="true" placeholder="Укажите e-mail" class="form-item form-item--text">
					</div>
					<div class="form-row form-row--100">
						<div class="order-call-privacy">Нажимая на кнопку "Отправить заявку", вы даете&nbsp;
							<a href="#" class="link link-white link--opacity">&ensp;согласие на обработку своих персональных данных</a>
						</div>
					</div>
					<div class="form-row form-row--100">
						<button type="submit" class="button button--orange-flood send-order">Подписаться на блог</button>
					</div>
				</form>
			</div>
		</div>
	</div>
@endsection
