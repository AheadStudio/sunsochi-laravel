@extends("layouts.app")

@section("content")
	<div class="page-inner page-inner--w1">
		<div class="employees">
			<div class="page-text">
				<h1>{{ $pageTitle }}</h1>
			</div>
			@foreach ($teamList as $keySection => $valSection)
				<div class="employees-section">{{ $keySection }}</div>
				<div class="employees-list">
					@foreach ($valSection as $valTeam)
						<div class="employees-item">
							@if (isset($valTeam["photo"]))
								<div class="employees-container">
									<img src="{{ $valTeam["photo"]}}" class="employees-img">
								</div>
							@endif
							<div class="employees-info">
								<div class="employees-name">{{ $valTeam["name"] }}</div>
								<div class="employees-position">{{ $valTeam["post"] }}</div>
								<a href="tel:{{ $valTeam["mobile"] }}" class="link link-black link--orange employees-contact">{{ $valTeam["mobile"] }}</a>
								<a href="mailto:{{ $valTeam["email"] }}" class="link link-black link--orange link-orange--bottom employees-contact">{{ $valTeam["email"] }}</a>
							</div>
						</div>
					@endforeach
				</div>
			@endforeach
		</div>
	</div>
@endsection
