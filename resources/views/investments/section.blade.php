@extends("layouts.app")

@section("content")
    <div class="page-inner page-inner--max">
        <div class="intro"><img src="{{ $pageImage }}" class="intro-img">
            <div class="intro-text">{{ $pageTitle }}</div>
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
        <div class="investments-info">
            <div class="page-text">
                <img src="/dummy/investments_house.jpg" class="img img-w50 img--left">
                <p>Реализация проектов “под ключ” любой сложности (жилого дома, коттеджного поселка или коммерческого объекта) на земельных участках. Мы осуществляем подбор земельного участка, подготовку проекта под строительство (разработка индивидуальной концепции) и курируем каждый этап работ. Гарантируем выполнение согласованного плана продаж в строящемся или уже реализованном объекте недвижимости. При сдаче в аренду (сезонную или долгосрочную) гарантируем загруженность объекта  недвижимости.</p>
            </div>
        </div>
    </div>

    <div style="background:#f7f8fb" class="page-inner page-inner--max">
        <div class="page-inner page-inner--w1">
            <div class="investments-offers">
                <div class="page-text">
                    <h2>Что мы предлагаем</h2>
                    <div class="check-list check-list--2">
                        <div class="check-item">3 направления инвестиций в строительство: жилой дом, коттеджный поселок, коммерческий объект.</div>
                        <div class="check-item">Гарантия загруженности объекта при сдаче в аренду.</div>
                        <div class="check-item">Согласование всей документации на всех этапах реализации проекта.</div>
                        <div class="check-item">Работаем только с проверенными временем партнерами.</div>
                        <div class="check-item">Экспертный подбор земельного участка, отвечающего всем требованиям выбранного направления инвестиций</div>
                        <div class="check-item">Реальная вовлеченность во все процессы.</div>
                        <div class="check-item">Только креативные решения</div>
                        <div class="check-item">Гарантия продаж, согласно утвержденного плана.</div>
                    </div>
                </div>
                <div class="offers-more">
                    <a href="apartments.html" class="link button button--blue" data-trigger="#investments">Смотреть объекты</a>
                </div>
            </div>
        </div>
    </div>

    <div id="investments" class="investments-offers-block hide">
        <div class="page-inner page-inner--w1">
            <div class="page-text">
                <h2>Поиск по объектам</h2>
            </div>
            <div class="filter">
                <a href="#" class="link filter-clear">Очистить все</a>
                <div class="filter-list">
                    <div class="filter-item">
                        @component("components.filer-investments", ["pageCode" => $pageCode, "district" => $district])@endcomponent
                    </div>
                </div>
            </div>
        </div>

        <div class="page-inner page-inner--w1">
            <div class="page-text">
                <div class="offers-block">
                    @if (isset($offers))
                        @component("components.offers", ["offersList" => $offers, "showFind" => $showFind, "countOffers" => $countOffers])@endcomponent
                    @endif
                </div>
            </div>
        </div>
    </div>

    @component("components.form-specialorder")@endcomponent

@endsection
