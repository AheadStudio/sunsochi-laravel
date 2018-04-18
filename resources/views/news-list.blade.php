@extends("layouts.app")

@section("content")
	<div class="page-inner page-inner--w1">
		<div class="news">
			<div class="page-text">
				<h1>{{ $pageTitle }}</h1>
			</div>
		</div>
	</div>
	<div class="page-inner page-inner--w1">
		<div id="news-list-load" class="news-list">
			@foreach ($newsList as $keyNews => $valNews)
				<div class="news-item">
					<a href="{{ url(url()->current(). "/" . $valNews->code) }}" class="link news-holder">
						<img src="{{ $valNews->preview_picture }}" class="news-img">
					</a>
					<div class="news-info">
						<div class="news-date">28 июля 2017</div>
						<a href="{{ url(url()->current(). "/" . $valNews->code) }}" class="link link-black link-black--bottom-inverse news-title">{{ $valNews->name }}</a>
						<div class="news-text">{{ $valNews->preview_text }}</div>
					</div>
				</div>
			@endforeach
		</div>
		@include("pagination.default", [
			"paginator" => $newsList,
			"class" 	=> "news-more",
			"container" => "#news-list-load",
			"item" 		=> ".news-item",
		])
	</div>
@endsection
