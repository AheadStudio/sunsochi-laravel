@extends("layouts.app")

@section("content")
    <div class="page-inner page-inner--max">
        <div class="intro">
            <img src="{{ $pageImage }}" class="intro-img">
            <div class="intro-text">{!! $pageTitle !!}</div>
            <div class="intro-advantages">
                @foreach ($pageTabs as $value)
                    <div class="intro-advantages-item">
                        <div class="intro-advantages-icon">
                            <?php include("svg/check.svg"); ?>
                        </div>
                        <div class="intro-advantages-text">{!! $value !!}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="page-inner page-inner--w1">
        <div class="page-text">
            <h2>Поиск по объектам</h2>
        </div>
        <div class="filter">
            <a href="#" class="link filter-clear">Очистить все</a>
            <div class="filter-list">
                <div class="filter-item">
                    @if ($pageSection == "novostrojki")
                        @component("components.filter-newbuildings", ["homePage" => "N", "district" => $district, "predestination" => ""])@endcomponent
                    @endif
                    @if ($pageSection == "kvartiry")
                        @component("components.filter-apartments", ["homePage" => "N", "district" => $district, "predestination" => ""])@endcomponent
                    @endif
                    @if ($pageSection == "elitnye")
                        @component("components.filter-elite", ["homePage" => "N", "district" => $district, "predestination" => ""])@endcomponent
                    @endif
                    @if ($pageSection == "doma")
                        @component("components.filter-houses", ["homePage" => "N", "district" => $district, "predestination" => ""])@endcomponent
                    @endif
                    @if ($pageSection == "uchastki")
                        @component("components.filter-areas", ["homePage" => "N", "district" => $district, "predestination" => ""])@endcomponent
                    @endif
                    @if ($pageSection == "kommercheskaya_nedvizhimost")
                        @component("components.filter-commercial", ["homePage" => "N", "district" => $district, "predestination" => $predestination])@endcomponent
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="page-inner page-inner--max">
        <div class="section-shadow">
            <div class="page-inner page-inner--w1">
                <div class="page-text">
                    <div class="popular">
                        <div class="popular-col popular-col--60">
                            <h3>Популярные запросы</h3>
                            <div class="popular-list popular-list--column">
                                @foreach ($popularQuery as $valPopularQuery)
                                    <div class="popular-item">
                                        <a href="{{ $valPopularQuery->url }}" class="link link-blue link-blue--bottom link-blue--bottom popular-item-link">{{ $valPopularQuery->name }}</a>
                                        <span class="popular-item-count">{{ $valPopularQuery->count_elements }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="popular-col popular-col--30">
                            <h3>Популярные районы</h3>
                            <div class="popular-list">
                                @foreach ($popularDistrict as $valPopularDistrict)
                                    @if (!empty($valPopularDistrict->popular))
                                        <a href="district__{{ $valPopularDistrict->code }}/" class="link link-blue link-blue--bottom popular-item-link">{{ $valPopularDistrict->name }}</a>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="offers-block">
                        @if (isset($offers))
                            @component("components.offers", ["offersList" => $offers, "showFind" => $showFind, "countOffers" => $countOffers])@endcomponent
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div style="background:#fff" class="page-inner page-inner--max">
        <div class="causes">
            <div class="page-inner page-inner--w1">
                <div class="page-text">
                    <h2>Купить недвижимость в сочи легко и безопасно!</h2>
                    <div class="causes-text">
                        <p>Агентство недвижимости «Солнечный Сочи» занимается продажей различной недвижимости по цене застройщика. В каталоге представлены лучшие новостройки Сочи – ЖК Лазурный Берег, Верещагин, Малибу, Панорама Сочи и пр. Купить квартиру в Новостройке выгодно, поскольку стоимость такого жилья постоянно увеличивается.</p>
                        <p>Покупателей привлекает в новостройках еще и то, что они располагаются в самых красивых и живописных районах города. Каждый ЖК имеет удобное расположение, рядом вся необходимая инфраструктура. На выбор покупателям представляются квартиры различной площади, начиная от компактных студий, заканчивая большими 4-х комнатными вариантами. В квартирах проведены современные коммуникации и инженерные системы.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @component("components.form-specialorder")@endcomponent
@endsection
