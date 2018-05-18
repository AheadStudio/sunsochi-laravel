<nav itemscope="itemscope" itemtype="http://schema.org/SiteNavigationElement" class="footer-top">
	<ul class="footer-next-inner">
		@foreach($items as $item)
			@php
				$isItemActive = (stripos(url()->current(), substr(substr($item->link(), 1), 0, -1)) != false ) ? "active" : "";
			@endphp
			<li class="footer-next-item-holder">
				<a href="{{ $item->link() }}" title="" itemprop="url" class="footer-next-item link link-white link-white--bottom-reverse {{ $isItemActive }}">
					<span itemprop="name" class="footer-next-item-name">{{ $item->title }}</span>
				</a>
			</li>
		@endforeach
	</ul>
</nav>
