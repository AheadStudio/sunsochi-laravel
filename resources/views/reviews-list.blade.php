@extends("layouts.app")

@section("content")
	<div class="page-inner page-inner--w1">
		<div class="reviews">
			<div class="page-text">
				<h1>{{ $pageTitle }}</h1>
			</div>
		</div>
	</div>
	<div class="page-inner page-inner--w1">
		<div id="reviews-list-load" class="reviews-list">
			@foreach ($reviewList as $keyReview => $valReview)
				<div class="reviews-item">
					<div class="reviews-video">
						<div style="background-image: url({{ $valReview->preview_video }})" class="fake-preview">
							@if (stristr($valReview->video, 'youtube') === FALSE)
								<a href="{{ $valReview->video }}" data-mfp-type="image" data-mfp-bcg="rgba(0, 158, 204, 0.9)" data-mfp-closeinside="false" data-mfp-closeonbcg="true" class="link fake-preview-link mfp-modal"></a>
								<span class="fake-preview-icon fake-preview-icon--image">
									<?php include("svg/loupe.svg"); ?>
								</span>
							@else
								<a href="{{ $valReview->video }}" data-mfp-type="iframe" data-mfp-bcg="rgba(0, 158, 204, 0.9)" data-mfp-closeinside="false" data-mfp-closeonbcg="true" class="link fake-preview-link mfp-modal"></a>
								<span class="fake-preview-icon">
									<?php include("svg/play_youtube.svg"); ?>
								</span>
							@endif
						</div>
						<!--iframe(frameborder="0", height="100%", width="100%", src="https://www.youtube.com/embed/WiJGohGIs14?rel=0&amp;controls=0&amp;showinfo=0", allow="autoplay; encrypted-media", allowfullscreen)-->
					</div>
					<div class="reviews-container">
						<div class="reviews-icon">
							<?php include("svg/quotes.svg"); ?>
						</div>
						<div class="reviews-name"><span class="reviews-name-lastname">{{ $valReview->autor }}</div>
						<div class="reviews-text">{!!html_entity_decode($valReview->text)!!}
							<span data-toggle="moreinfo" class="toggle-container">{!!html_entity_decode($valReview->textOther)!!}</span>
						</div>
						<a href="reviews.html" data-toggle-link="moreinfo" data-toggle-text="Свернуть" class="link link-orange link-orange--bottom-reverse reviews-more toggle">Далее</a>
					</div>
				</div>
			@endforeach
		</div>
		@include("pagination.default", [
			"paginator" => $reviewList,
			"class" 	=> "reviews-more",
			"container" => "#reviews-list-load",
			"item" 		=> ".reviews-item",
		])
	</div>
@endsection
