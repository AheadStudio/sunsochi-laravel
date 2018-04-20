@extends("layouts.app")

@section("content")
	<div class="page-inner page-inner--w1">
		<div class="developers">
			<div class="page-text">
				<h1>{{ $pageTitle }}</h1>
				<div class="page-subtitle">{{ $pageSubtitle }}</div>
			</div>
		<div class="developers-list">
			@foreach ($builderList as $keyBuilderList => $valBuilderList)
				<div class="developers-item">
					<div class="developers-letter">{{ $keyBuilderList }}</div>
					<div class="developers-company">
						@foreach ($valBuilderList as $valBuilder)
							<a href="{{ route("BuildersShow", $valBuilder["code"]) }}" class="link link--showdow-black-blue developers-link">{{$valBuilder["name"]}}</a>
						@endforeach
					</div>
				</div>
			@endforeach
		</div>
	</div>
@endsection
