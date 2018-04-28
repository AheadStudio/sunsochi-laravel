@extends("layouts.app")

@section("content")
	<div class="page-inner page-inner--w1">
		<div class="partners">
			<div class="page-text">
				<h1>{{ $pageTitle }}</h1>
			</div>
				<div class="partners-list">
					@foreach ($partnersList as $valPartnersList)
						<div class="partners-item">
							@if (isset($valPartnersList->logo) && $valPartnersList->logo !="")
								<div class="partners-holder"><img src="{{ $valPartnersList->logo }}" class="partners-img"></div>
							@endif
							<div class="partners-title">{{ $valPartnersList->name }}</div>
							<div class="partners-text">{{ $valPartnersList->text }}</div>
						</div>
					@endforeach
				</div>
			</div>
		</div>
	</div>
@endsection
