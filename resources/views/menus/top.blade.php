<nav itemscope="itemscope" itemtype="http://schema.org/SiteNavigationElement" class="header-top">
	<ul class="header-top-inner">
		@foreach($items as $item)
			@php
				$isItemActive = (stripos(url()->current(), substr(substr($item->link(), 1), 0, -1)) != false ) ? "active" : "";
			@endphp
			<li class="header-top-item-holder">
				<a href="{{ $item->link() }}" title="" itemprop="url" class="header-top-item link link-white link--orange {{ $isItemActive }}">
					<span itemprop="name" class="header-top-item-name ">{{ $item->title }}</span>
				</a>
			</li>
		@endforeach
	</ul>
</nav>
