<nav>
	@foreach($items as $item)
		@php
			$isItemActive = (url($item->link()) == url()->current()) ? true : false;
		@endphp
		@if ($isItemActive)
			<span>{{ $item->title }}</span>
		@else
			<a href="{{ $item->link() }}">{{ $item->title }}</a>
		@endif
	@endforeach
</nav>