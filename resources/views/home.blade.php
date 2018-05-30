@extends("layouts.app")

@section("content")
	<div class="page-inner page-inner--max">
		<div class="intro"><img src="../dummy/sochi.jpg" class="intro-img">
			<div class="intro-text">Выберите жилье вашей мечты из каталога проверенных объектов и получите цену от застройщика</div>
		</div>
	</div>
	<div class="page-inner page-inner--w1">
		<div class="page-text">
			<h2>Поиск по объектам</h2>
		</div>
		<div class="filter">
			<a href="#" class="link filter-clear">Очистить все</a>
			<div class="filter-tabs">
				<div data-filter-tab="filter_1" class="filter-tab active">Новостройки</div>
				<div data-filter-tab="filter_2" class="filter-tab">Квартиры</div>
				<div data-filter-tab="filter_3" class="filter-tab">Дома</div>
				<div data-filter-tab="filter_4" class="filter-tab">Участки</div>
				<div data-filter-tab="filter_5" class="filter-tab">Коммерческие</div>
			</div>
			<div class="filter-list">
				<div data-filter-item="filter_1" class="filter-item">
					@component("components.filter-newbuildings", ["homePage" => "Y", "district" => $district, "predestination" => ""])@endcomponent
				</div>

				<div data-filter-item="filter_2" class="filter-item">
					@component("components.filter-apartments", ["homePage" => "Y", "district" => $district, "predestination" => ""])@endcomponent
				</div>

				<div data-filter-item="filter_3" class="filter-item">
					@component("components.filter-houses", ["homePage" => "Y", "district" => $district, "predestination" => ""])@endcomponent
				</div>

				<div data-filter-item="filter_4" class="filter-item">
					@component("components.filter-areas", ["homePage" => "Y", "district" => $district, "predestination" => ""])@endcomponent
				</div>

				<div data-filter-item="filter_5" class="filter-item">
					@component("components.filter-commercial", ["homePage" => "Y", "district" => $district, "predestination" => $predestination])@endcomponent
				</div>
			</div>
		</div>
	</div>
	<div class="page-inner page-inner--max">
		<div class="section-shadow">
			<div class="page-inner page-inner--w1">
				<div class="page-text">
					<h2>Выгодные предложения</h2>
				</div>
				@if (isset($profitOffers))
					@component("components.offers", ["offersList" => $profitOffers[0], "showFind" => $showFind, "countOffers" => $countProfitOffers])@endcomponent
				@endif
			</div>
			@if (!empty($bigCard))
				<div class="section">
					<div class="section-item">
						<div class="section-container">
							<div class="section-container-mark">Квартиры по акции</div>
							<img src="{{ $bigCard["photo"] }}" alt="" class="section-container-img">
						</div>
					</div>
					<div class="section-item">
						<div class="section-information">
							<div class="section-information-container">
								<div class="page-text">
									<div class="section-name">{{ $bigCard["name"] }}</div>
									<div class="section-developer">{{ $bigCard["builders_name"] }}</div>
									<div class="section-district">{{ $bigCard["district"] }}</div>
									<div class="section-area">Площадь от {{ $bigCard["area_ap_min"] }} м<sup>2</sup></div>
									<div class="section-price">Цена от {{  number_format(round($bigCard["price_ap_min"]), 0, '', ' ') }}<span class="rub">i</span></div>
									<dl>
										@foreach ($bigCard["apartments"] as $key => $value)
											<dt>{{ $key }} комн.</dt>
											<dd>от {{ number_format(round($value), 0, '', ' ') }} <span class="rub">i</span></dd>
										@endforeach
									</dl>
									<a href="{{ $bigCard["path"] }}" target="_blank" class="link button button--white section-more">Подробнее</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			@endif
			<div class="page-inner page-inner--w1">
				@if (isset($profitOffers))
					@component("components.offers", ["offersList" => $profitOffers[0], "showFind" => $showFind, "countOffers" => $countProfitOffers])@endcomponent
				@endif
			</div>
		</div>
	</div>
	@component("components.form-specialorder")@endcomponent
	<div class="page-inner page-inner--max">
		<div class="feature">
			<div class="page-inner page-inner--w1">
				<div class="page-text">
					<h2>Наши клиенты выбрали нас за:</h2>
				</div>
				<div class="feature-list">
					<div class="feature-item">
						<div class="feature-container"><img src="../i/service.png" class="feature-container-img"></div>
						<div class="feature-title">Первоклассный сервис</div>
						<div class="feature-text">Мы владеем полной информацией по всем объектам. Следуя нашим рекомендациям, вы не попадете на долгострой и несогласованные объекты. Чеcтная информация о всей недвижимости.</div>
					</div>
					<div class="feature-item">
						<div class="feature-container"><img src="../i/guarantee.png" class="feature-container-img"></div>
						<div class="feature-title">Гарантия первой цены</div>
						<div class="feature-text">Часто возможность cэкономить ближе, чем кажется. У нас всегда самые актуальные данные о специальных предложениях и промо-акциях застройщиков. Экономия до 23% от стоимости.</div>
					</div>
					<div class="feature-item">
						<div class="feature-container"><img src="../i/portfolio.png" class="feature-container-img"></div>
						<div class="feature-title">Настоящая экспертность</div>
						<div class="feature-text">Вы определенно можете изучить все объекты сами, но мы можем облегчить вашу задачу и ужать ее от нескольких недель до 30 минут. Проверьте - это действительно удобно.</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div style="background:#f7f8fb" class="page-inner page-inner--max">
		<div class="about-home">
			<div class="page-inner page-inner--w1">
				<div class="page-text">
					<h2>О нас за 100 секунд</h2>
				</div>
				<div class="about-video">
					<div style="background-image: url(../dummy/youtube/preview_youtube.png)" class="fake-preview">
						<a href="https://www.youtube.com/watch?v=4zGIoURvzsQ" data-mfp-type="iframe" data-mfp-bcg="rgba(0, 158, 204, 0.9)" data-mfp-closeinside="false" data-mfp-closeonbcg="true" class="link fake-preview-link mfp-modal"></a>
						<span class="fake-preview-icon">
							<?php include("svg/play_youtube.svg")?>
						</span>
					</div>
					<!--iframe(frameborder="0", height="100%", width="100%", src="https://www.youtube.com/embed/4zGIoURvzsQ?rel=0&controls=0&showinfo=0", allow="autoplay; encrypted-media", allowfullscreen)-->
				</div>
			</div>
		</div>
	</div>
	<div class="page-inner page-inner--max">
		<div class="map-container">
			<!--div(class="map",id="mapGoogle", data-lat="43.60405218", data-lng="39.73541935", data-zoom="16", data-icon="../svg/point_map.svg")-->
			<div id="mapYandex" data-center="[43.60405218, 39.73541935]" data-zoom="18" data-points="[{name:&quot;1&quot;, position: &quot;43.604412115253794,39.73532647212506&quot;, icon: &quot;/svg/point_map.svg&quot;, iconW: 55, iconH: 85, description:&quot;Сочи, ул. Пластунская, 81, 3 этаж, офис 17&quot;}]" class="map"></div>
			<div class="map-contacts">
				<div class="map-contacts-title">Контакты</div>
				<div class="map-contacts-street">Сочи, ул. Пластунская, 81,</div>
				<div class="map-contacts-floor">3 этаж, офис 17</div>
				<div class="map-contacts-hotline order-call-hotline"><span class="order-call-hotline-text">Бесплатная горячая линия</span><a href="tel:+78007075523" class="link link-white link--opacity order-call-hotline-mobile">8-800-707-55-23</a><span class="order-call-hotline-text">операторы доступны</span><span class="order-call-hotline-text">с 8:00 до 22:00 МСК</span></div>
			</div>
		</div>
	</div>
	@if (!empty($reviewList))
		<div class="page-inner page-inner--max">
			<div class="reviews-home">
				<div class="page-inner page-inner--w1">
					<div class="page-text">
						<h2>Уже оценили нашу работу</h2>
					</div>
					<div class="reviews-home-slider owl-carousel">
						@foreach ($reviewList as $keyReview => $valReview)
							<div class="reviews-home-item">
								<div class="reviews-home-video">
									<div style="background-image: url({{ $valReview["preview_video"] }})" class="fake-preview">
										@if (stristr($valReview["video"], 'youtube') === FALSE)
											<a href="{{ $valReview["video"] }}" data-mfp-type="image" data-mfp-bcg="rgba(0, 158, 204, 0.9)" data-mfp-closeinside="false" data-mfp-closeonbcg="true" class="link fake-preview-link mfp-modal"></a>
											<span class="fake-preview-icon fake-preview-icon--image">
												<?php include("svg/loupe.svg"); ?>
											</span>
										@else
											<a href="{{ $valReview["video"] }}" data-mfp-type="iframe" data-mfp-bcg="rgba(0, 158, 204, 0.9)" data-mfp-closeinside="false" data-mfp-closeonbcg="true" class="link fake-preview-link mfp-modal"></a>
											<span class="fake-preview-icon">
												<?php include("svg/play_youtube.svg"); ?>
											</span>
										@endif
									</div>
									<!--iframe(frameborder="0", height="100%", width="100%", src="https://www.youtube.com/embed/WiJGohGIs14?rel=0&amp;controls=0&amp;showinfo=0", allow="autoplay; encrypted-media", allowfullscreen)-->
								</div>
								<div class="reviews-home-container">
									<div class="reviews-home-icon">
										<?php include("svg/quotes.svg"); ?>
									</div>
									<div class="reviews-home-name">
										<span class="reviews-home-name-lastname">{{ $valReview["autor"] }}</span>
									</div>
									<div class="reviews-home-text">{!!html_entity_decode($valReview["text"])!!}
										<span data-toggle="moreinfo" class="toggle-container">{!!html_entity_decode($valReview["textOther"])!!}</span>
									</div>
									<a href="reviews.html" data-toggle-link="moreinfo" data-toggle-text="Свернуть" class="link link-orange link-orange--bottom-reverse reviews-more toggle">Далее</a>
								</div>
							</div>
						@endforeach
					</div>
					<a href="/reviews/" class="link link-black link-black--bottom reviews-home-all">Все отзывы</a>
				</div>
			</div>
		</div>
	@endif
	<div style="background:#f7f8fb" class="page-inner page-inner--max">
		<div class="causes">
			<div class="page-inner page-inner--w2">
				<div class="page-text">
					<h2>Купить недвижимость в сочи легко и безопасно!</h2>
					<div class="causes-text">
						<p>Сочи – это уникальный, красивый и роскошный город, для многих российских и иностранных туристов является курортной Меккой. Это приводит к тому, что недвижимость в Сочи становится всё более привлекательным средством инвестирования и многие мечтают о собственном жилье для постоянного проживания или сдачи внаём.</p>
						<p>В городе развит и успешно функционирует круглогодичный курорт, который по своему функционалу, возможностям и видам предлагаемого отдыха подходит для разных по уровню достатка, взглядам на жизнь и культурным традициям туристов.</p>
						<p>В летнее время года туристов со всего мира зовут роскошные сочинские пляжи, позволяющие комфортно греться на солнышке, а зимой российский курортный город готов предложить европейский уровень сервиса и трассы для ценителей горнолыжного отдыха.</p>
						<p>После проведения Олимпийских игр, Сочи вывел собственную инфраструктуру на уровень, соответствующий мировым стандартам. Благодаря этому, в появились современные торгово-развлекательные комплексы, началась возводиться жилая элитная недвижимость, появились дорожные развязки, созданные по современным строительным технологиям.</p>
					</div><a href="#" class="link link-black link-black--bottom causes-more">Подробнее</a>
				</div>
			</div>
		</div>
	</div>
	@component("components.form-specialorder")@endcomponent
@endsection
