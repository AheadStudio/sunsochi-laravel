<nav itemscope="itemscope" itemtype="http://schema.org/SiteNavigationElement" class="header-bottom">
	<ul class="header-bottom-inner">
		@foreach($items as $item)
			@php
				$isItemActive = (stripos(url()->current(), substr(substr($item->link(), 1), 0, -1)) != false ) ? "active" : "";
			@endphp
			<li class="header-bottom-item-holder">
				<a href="{{ $item->link() }}" title="" itemprop="url" class="header-bottom-item link link-black link--orange {{ $isItemActive }}">
					<span itemprop="name" class="header-bottom-item-name ">{{ $item->title }}</span>
				</a>
			</li>
		@endforeach
	</ul>
</nav>
