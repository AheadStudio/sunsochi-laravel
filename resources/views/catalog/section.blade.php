@extends("layouts.app")

@section("content")
    <div class="page-inner page-inner--max">
        <div class="intro">
            <img src="{{ $pageImage }}" class="intro-img">
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
        <div class="page-text">
            <h2>Поиск по объектам</h2>
        </div>
        <div class="filter">
            <a href="#" data-filter-tab="filter_reset" data-filter-tie="mainfilter" class="link filter-clear">Очистить все</a>
            <div class="filter-tabs">
                <div data-filter-tab="filter_1" class="filter-tab active">Новостройки</div>
                <div data-filter-tab="filter_2" class="filter-tab">Квартиры</div>
                <div data-filter-tab="filter_3" class="filter-tab">Дома</div>
                <div data-filter-tab="filter_4" class="filter-tab">Участки</div>
                <div data-filter-tab="filter_5" class="filter-tab">Коммерческие</div>
            </div>
            <div class="filter-list">
                <div data-filter-item="filter_reset" class="filter-item">
                    <form action="#" class="form form-filter">
                      <div class="filter-selected-regions-list"></div>
                      <button type="submit" data-filter-button-tpl="Показать {0} обектов" class="button button--orange-flood filter-submit">Показать объекты</button>
                    </form>
                </div>
                <div data-filter-item="filter_1" class="filter-item">
                    <form action="/api/catalog/" method="get" class="form form-filter">
                        <div class="form-row">
                            <div class="form-row-100">
                                <div class="form-holder">
                                    <label class="form-label">
                                        <input type="checkbox" name="section__novostroyki_v_sochi_po_fz_214" class="form-item form-item--checkbox"><span class="form-item-checkbox-title">ФЗ-214</span>
                                    </label>
                                    <label class="form-label">
                                        <input type="checkbox" name="section__sdannye_novostroyki_v_sochi" class="form-item form-item--checkbox"><span class="form-item-checkbox-title">Сданные</span>
                                    </label>
                                    <label class="form-label">
                                        <input type="checkbox" name="section__novostroyki_pod_ipoteku" class="form-item form-item--checkbox"><span class="form-item-checkbox-title">Ипотека</span>
                                    </label>
                                    <label class="form-label">
                                        <input type="checkbox" name="military_mortgage" class="form-item form-item--checkbox"><span class="form-item-checkbox-title">Военная ипотека</span>
                                    </label>
                                    <label class="form-label">
                                        <input type="checkbox" name="section__novostroyki_u_morya" class="form-item form-item--checkbox"><span class="form-item-checkbox-title">Близость к морю</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-50">
                                <div class="form-item-title">Площадь</div>
                                <div class="form-holder">
                                    <input type="range" multiple="" name="area" data-name-input="area_ap" value="20,650" min="20" max="650" step="10" data-valfrom="" data-valto="" data-valtext="&amp;thinsp;м&lt;sup&gt;2&lt;/sup&gt;" class="form-item form-item--range">
                                </div>
                            </div>
                            <div class="form-row-50">
                                <div class="form-item-title">Цена</div>
                                <div class="form-holder">
                                    <input type="range" multiple="" name="price" data-name-input="price" value="800000,180000000" min="800000" max="180000000" step="1000" data-valfrom="" data-valto="" data-valtext="&amp;thinsp; м&lt;sup&gt;2&lt;/sup&gt;" class="form-item form-item--range">
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-50">
                                <div class="form-holder">
                                    <div id="regions-container--1" class="regions-container white-popup mfp-hide">
                                        <div class="regions-container-list">
                                            <div class="regions-title">Выберите район</div>
                                            <ul>
                                                @foreach ($district as $keyDistrict => $valDistrict)
                                                    <li name="district__{{ $valDistrict->code }}">
                                                        <span class="regions-text">{{ $valDistrict->name }}</span>
                                                        <div class="regions-close"></div>
                                                    </li>
                                                @endforeach
                                            </ul>
                                            <button type="button" class="button button--blue regions-show">Показать объекты</button>
                                        </div>
                                    </div>
                                    <a href="#regions-container--1" data-mfp-closeinside="true" data-mfp-closeonbcg="true" class="link link-black jcf-select-form-item--select mfp-modal"><span class="jcf-select-text"><span>Район</span></span><span class="jcf-select-opener"></span></a>
                                </div>
                            </div>
                            <div class="form-row-50">
                                <div class="form-holder">
                                    <input type="text" name="search" placeholder="Поиск по названию или улице" data-autocomplete-url="/api/catalog/district/" data-autocomplete="true" class="form-item form-item--text">
                                    <button type="button" class="form-filter-search">
                                        <span class="form-filter-search-icon">
                                            <?php include("svg/loupe.svg") ?>
                                        </span>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="filter-selected-regions-list"></div>
                        <button type="submit" data-filter-button-tpl="Показать {number} обектов" class="button button--orange-flood filter-submit">Показать</button>
                    </form>
                </div>
                <div data-filter-item="filter_2" class="filter-item">
                    <form action="/api/catalog/" method="get" class="form form-filter">
                        <input type="hidden" name="token" value="{{ Session::token() }}" />
                        <div class="form-row">
                            <div class="form-row-100">
                                <div class="form-holder">
                                    <div class="checkbox-list-container">
                                        <div class="checkbox-list-container-title">Планировка</div>
                                        <label class="form-label">
                                            <input type="checkbox" name="number_rooms|one"  class="form-item form-item--checkbox"><span class="form-item-checkbox-title">1</span>
                                        </label>
                                        <label class="form-label">
                                            <input type="checkbox" class="form-item form-item--checkbox"><span class="form-item-checkbox-title">2</span>
                                        </label>
                                        <label class="form-label">
                                            <input type="checkbox" class="form-item form-item--checkbox"><span class="form-item-checkbox-title">3</span>
                                        </label>
                                        <label class="form-label">
                                            <input type="checkbox" class="form-item form-item--checkbox"><span class="form-item-checkbox-title">4+</span>
                                        </label>
                                        <label class="form-label">
                                            <input type="checkbox" class="form-item form-item--checkbox"><span class="form-item-checkbox-title">Студия</span>
                                        </label>
                                    </div>
                                    <label class="form-label">
                                        <input type="checkbox" class="form-item form-item--checkbox"><span class="form-item-checkbox-title">С ремонтом</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-50">
                                <div class="form-item-title">Площадь</div>
                                <div class="form-holder">
                                    <input type="range" multiple="" value="20,100" min="10" max="150" step="10" data-valfrom="" data-valto="" data-valtext="&amp;thinsp; м&lt;sup&gt;2&lt;/sup&gt;" class="form-item form-item--range">
                                </div>
                            </div>
                            <div class="form-row-50">
                                <div class="form-item-title">Цена</div>
                                <div class="form-holder">
                                    <input type="range" multiple="" value="708000,50000000" min="700000" max="100000000" step="1000" data-valfrom="" data-valto="" data-valtext="&amp;thinsp; м&lt;sup&gt;2&lt;/sup&gt;" class="form-item form-item--range">
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-50">
                                <div class="form-holder">
                                    <div id="regions-container--2" class="regions-container white-popup mfp-hide">
                                        <div class="regions-container-list">
                                            <div class="regions-title">Выберите район</div>
                                            <ul>
                                                <li name="adler"><span class="regions-text">Адлер</span>
                                                    <div class="regions-close"></div>
                                                </li>
                                                <li name="bihta"><span class="regions-text">Быхта</span>
                                                    <div class="regions-close"></div>
                                                </li>
                                                <li name="dogomis"><span class="regions-text">Догомыс</span>
                                                    <div class="regions-close"></div>
                                                </li>
                                                <li name="dons"><span class="regions-text">Донская</span>
                                                    <div class="regions-close"></div>
                                                </li>
                                                <li name="q"><span class="regions-text">Завокзальный</span>
                                                    <div class="regions-close"></div>
                                                </li>
                                                <li name="w"><span class="regions-text">Заречный</span>
                                                    <div class="regions-close"></div>
                                                </li>
                                                <li name="e"><span class="regions-text">Касная Пляна</span>
                                                    <div class="regions-close"></div>
                                                </li>
                                                <li name="r"><span class="regions-text">КСМ</span>
                                                    <div class="regions-close"></div>
                                                </li>
                                                <li name="t"><span class="regions-text">Кудепста</span>
                                                    <div class="regions-close"></div>
                                                </li>
                                                <li name="y"><span class="regions-text">Курортный городок</span>
                                                    <div class="regions-close"></div>
                                                </li>
                                                <li name="u"><span class="regions-text">Лазаревский</span>
                                                    <div class="regions-close"></div>
                                                </li>
                                                <li name="i"><span class="regions-text">Макаренко</span>
                                                    <div class="regions-close"></div>
                                                </li>
                                                <li name="o"><span class="regions-text">Мамайка</span>
                                                    <div class="regions-close"></div>
                                                </li>
                                                <li name="a"><span class="regions-text">Мацеста</span>
                                                    <div class="regions-close"></div>
                                                </li>
                                                <li name="f"><span class="regions-text">Новый сочи</span>
                                                    <div class="regions-close"></div>
                                                </li>
                                                <li name="g"><span class="regions-text">Олимпийский парк</span>
                                                    <div class="regions-close"></div>
                                                </li>
                                                <li name="h"><span class="regions-text">Приморье</span>
                                                    <div class="regions-close"></div>
                                                </li>
                                                <li name="j"><span class="regions-text">Раздольное</span>
                                                    <div class="regions-close"></div>
                                                </li>
                                                <li name="k"><span class="regions-text">Светлана</span>
                                                    <div class="regions-close"></div>
                                                </li>
                                                <li name="l"><span class="regions-text">Соболевка</span>
                                                    <div class="regions-close"></div>
                                                </li>
                                                <li name="z"><span class="regions-text">Хоста</span>
                                                    <div class="regions-close"></div>
                                                </li>
                                                <li name="x"><span class="regions-text">Центр</span>
                                                    <div class="regions-close"></div>
                                                </li>
                                                <li name="c"><span class="regions-text">Яна Фабрициуса     </span>
                                                    <div class="regions-close"></div>
                                                </li>
                                            </ul>
                                            <button type="button" class="button button--blue regions-show">Показать объекты</button>
                                        </div>
                                    </div>
                                    <a href="#regions-container--2" data-mfp-closeinside="true" data-mfp-closeonbcg="true" class="link link-black jcf-select-form-item--select mfp-modal"><span class="jcf-select-text"><span>Район</span></span><span class="jcf-select-opener"></span></a>
                                </div>
                            </div>
                            <div class="form-row-50">
                                <div class="form-holder">
                                    <input type="text" placeholder="Поиск по названию или улице" data-autocomplete="true" class="form-item form-item--text">
                                    <button type="button" class="form-filter-search">
                                        <span class="form-filter-search-icon">
                                            <?php include("svg/loupe.svg");?>
                                        </span>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="filter-selected-regions-list"></div>
                        <button type="submit" data-filter-button-tpl="Показать {0} обектов" class="button button--orange-flood filter-submit">Показать 11 356 объектов</button>
                    </form>
                </div>
                <div data-filter-item="filter_3" class="filter-item">
                    <form action="#" class="form form-filter">
                        <div class="form-row">
                            <div class="form-row-50">
                                <div class="form-item-title">Площадь</div>
                                <div class="form-holder">
                                    <input type="range" multiple="" value="20,100" min="10" max="150" step="10" data-valfrom="" data-valto="" data-valtext="&amp;thinsp; м&lt;sup&gt;2&lt;/sup&gt;" class="form-item form-item--range">
                                </div>
                            </div>
                            <div class="form-row-50">
                                <div class="form-item-title">Цена</div>
                                <div class="form-holder">
                                    <input type="range" multiple="" value="708000,50000000" min="700000" max="100000000" step="1000" data-valfrom="" data-valto="" data-valtext="&amp;thinsp; м&lt;sup&gt;2&lt;/sup&gt;" class="form-item form-item--range">
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-50">
                                <div class="form-holder">
                                    <div id="regions-container--3" class="regions-container white-popup mfp-hide">
                                        <div class="regions-container-list">
                                            <div class="regions-title">Выберите район</div>
                                                <ul>
                                                    <li name="adler"><span class="regions-text">Адлер</span>
                                                        <div class="regions-close"></div>
                                                    </li>
                                                    <li name="bihta"><span class="regions-text">Быхта</span>
                                                        <div class="regions-close"></div>
                                                    </li>
                                                    <li name="dogomis"><span class="regions-text">Догомыс</span>
                                                        <div class="regions-close"></div>
                                                    </li>
                                                    <li name="dons"><span class="regions-text">Донская</span>
                                                        <div class="regions-close"></div>
                                                    </li>
                                                    <li name="q"><span class="regions-text">Завокзальный</span>
                                                        <div class="regions-close"></div>
                                                    </li>
                                                    <li name="w"><span class="regions-text">Заречный</span>
                                                        <div class="regions-close"></div>
                                                    </li>
                                                    <li name="e"><span class="regions-text">Касная Пляна</span>
                                                        <div class="regions-close"></div>
                                                    </li>
                                                    <li name="r"><span class="regions-text">КСМ</span>
                                                        <div class="regions-close"></div>
                                                    </li>
                                                    <li name="t"><span class="regions-text">Кудепста</span>
                                                        <div class="regions-close"></div>
                                                    </li>
                                                    <li name="y"><span class="regions-text">Курортный городок</span>
                                                        <div class="regions-close"></div>
                                                    </li>
                                                    <li name="u"><span class="regions-text">Лазаревский</span>
                                                        <div class="regions-close"></div>
                                                    </li>
                                                    <li name="i"><span class="regions-text">Макаренко</span>
                                                        <div class="regions-close"></div>
                                                    </li>
                                                    <li name="o"><span class="regions-text">Мамайка</span>
                                                        <div class="regions-close"></div>
                                                    </li>
                                                    <li name="a"><span class="regions-text">Мацеста</span>
                                                        <div class="regions-close"></div>
                                                    </li>
                                                    <li name="f"><span class="regions-text">Новый сочи</span>
                                                        <div class="regions-close"></div>
                                                    </li>
                                                    <li name="g"><span class="regions-text">Олимпийский парк</span>
                                                        <div class="regions-close"></div>
                                                    </li>
                                                    <li name="h"><span class="regions-text">Приморье</span>
                                                        <div class="regions-close"></div>
                                                    </li>
                                                    <li name="j"><span class="regions-text">Раздольное</span>
                                                        <div class="regions-close"></div>
                                                    </li>
                                                    <li name="k"><span class="regions-text">Светлана</span>
                                                        <div class="regions-close"></div>
                                                    </li>
                                                    <li name="l"><span class="regions-text">Соболевка</span>
                                                        <div class="regions-close"></div>
                                                    </li>
                                                    <li name="z"><span class="regions-text">Хоста</span>
                                                        <div class="regions-close"></div>
                                                    </li>
                                                    <li name="x"><span class="regions-text">Центр</span>
                                                        <div class="regions-close"></div>
                                                    </li>
                                                    <li name="c"><span class="regions-text">Яна Фабрициуса</span>
                                                        <div class="regions-close"></div>
                                                    </li>
                                                </ul>
                                                <button type="button" class="button button--blue regions-show">Показать объекты</button>
                                        </div>
                                    </div>
                                    <a href="#regions-container--3" data-mfp-closeinside="true" data-mfp-closeonbcg="true" class="link link-black jcf-select-form-item--select mfp-modal"><span class="jcf-select-text"><span>Район</span></span><span class="jcf-select-opener"></span></a>
                                </div>
                            </div>
                            <div class="form-row-50">
                                <div class="form-holder">
                                    <input type="text" placeholder="Поиск по названию или улице" data-autocomplete="true" class="form-item form-item--text">
                                    <button type="button" class="form-filter-search">
                                        <span class="form-filter-search-icon">
                                            <?php include("svg/loupe.svg")?>
                                        </span>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="filter-selected-regions-list"></div>
                        <button type="submit" data-filter-button-tpl="Показать {0} обектов" class="button button--orange-flood filter-submit">Показать 11 356 объектов</button>
                    </form>
                </div>
                <div data-filter-item="filter_4" class="filter-item">
                    <form action="#" class="form form-filter">
                        <div class="form-row">
                            <div class="form-row-100">
                                <div class="form-holder">
                                    <label class="form-label">
                                        <input type="checkbox" class="form-item form-item--checkbox"><span class="form-item-checkbox-title">Вид на море</span>
                                    </label>
                                    <label class="form-label">
                                        <input type="checkbox" class="form-item form-item--checkbox"><span class="form-item-checkbox-title">Ровный</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-50">
                                <div class="form-item-title">Площадь участка</div>
                                <div class="form-holder">
                                    <input type="range" multiple="" value="20,100" min="10" max="150" step="10" data-valfrom="" data-valto="" data-valtext="&amp;thinsp;сотки" class="form-item form-item--range">
                                </div>
                            </div>
                            <div class="form-row-50">
                                <div class="form-item-title">Цена</div>
                                <div class="form-holder">
                                    <input type="range" multiple="" value="10000000,50000000" min="700000" max="100000000" step="1000" data-valfrom="" data-valto="" data-valtext="&thinsp;<span class='rub'>i<span>" class="form-item form-item--range">
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-50">
                                <div class="form-holder">
                                    <div id="regions-container--1118" class="regions-container white-popup mfp-hide">
                                        <div class="regions-container-list">
                                            <div class="regions-title">Выберите район</div>
                                            <ul>
                                                <li name="adler"><span class="regions-text">Адлер</span>
                                                    <div class="regions-close"></div>
                                                </li>
                                                <li name="bihta"><span class="regions-text">Быхта</span>
                                                    <div class="regions-close"></div>
                                                </li>
                                                <li name="dogomis"><span class="regions-text">Догомыс</span>
                                                    <div class="regions-close"></div>
                                                </li>
                                                <li name="dons"><span class="regions-text">Донская</span>
                                                    <div class="regions-close"></div>
                                                </li>
                                                <li name="q"><span class="regions-text">Завокзальный</span>
                                                    <div class="regions-close"></div>
                                                </li>
                                                <li name="w"><span class="regions-text">Заречный</span>
                                                    <div class="regions-close"></div>
                                                </li>
                                                <li name="e"><span class="regions-text">Касная Пляна</span>
                                                    <div class="regions-close"></div>
                                                </li>
                                                <li name="r"><span class="regions-text">КСМ</span>
                                                    <div class="regions-close"></div>
                                                </li>
                                                <li name="t"><span class="regions-text">Кудепста</span>
                                                    <div class="regions-close"></div>
                                                </li>
                                                <li name="y"><span class="regions-text">Курортный городок</span>
                                                    <div class="regions-close"></div>
                                                </li>
                                                <li name="u"><span class="regions-text">Лазаревский</span>
                                                    <div class="regions-close"></div>
                                                </li>
                                                <li name="i"><span class="regions-text">Макаренко</span>
                                                    <div class="regions-close"></div>
                                                </li>
                                                <li name="o"><span class="regions-text">Мамайка</span>
                                                    <div class="regions-close"></div>
                                                </li>
                                                <li name="a"><span class="regions-text">Мацеста</span>
                                                    <div class="regions-close"></div>
                                                </li>
                                                <li name="f"><span class="regions-text">Новый сочи</span>
                                                    <div class="regions-close"></div>
                                                </li>
                                                <li name="g"><span class="regions-text">Олимпийский парк</span>
                                                    <div class="regions-close"></div>
                                                </li>
                                                <li name="h"><span class="regions-text">Приморье</span>
                                                    <div class="regions-close"></div>
                                                </li>
                                                <li name="j"><span class="regions-text">Раздольное</span>
                                                    <div class="regions-close"></div>
                                                </li>
                                                <li name="k"><span class="regions-text">Светлана</span>
                                                    <div class="regions-close"></div>
                                                </li>
                                                <li name="l"><span class="regions-text">Соболевка</span>
                                                    <div class="regions-close"></div>
                                                </li>
                                                <li name="z"><span class="regions-text">Хоста</span>
                                                    <div class="regions-close"></div>
                                                </li>
                                                <li name="x"><span class="regions-text">Центр</span>
                                                    <div class="regions-close"></div>
                                                </li>
                                                <li name="c"><span class="regions-text">Яна Фабрициуса</span>
                                                    <div class="regions-close"></div>
                                                </li>
                                            </ul>
                                            <button type="button" class="button button--blue regions-show">Показать объекты</button>
                                        </div>
                                    </div>
                                    <a href="#regions-container--1118" data-mfp-closeinside="true" data-mfp-closeonbcg="true" class="link link-black jcf-select-form-item--select mfp-modal"><span class="jcf-select-text"><span>Район</span></span><span class="jcf-select-opener"></span></a>
                                </div>
                            </div>
                            <div class="form-row-50">
                                <div class="form-holder">
                                    <input type="text" placeholder="Поиск по названию или улице" data-autocomplete="true" class="form-item form-item--text">
                                    <button type="button" class="form-filter-search">
                                        <span class="form-filter-search-icon">
                                            <?php include("svg/loupe.svg")?>
                                        </span>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="filter-selected-regions-list"></div>
                        <button type="submit" data-filter-button-tpl="Показать {0} обектов" class="button button--orange-flood filter-submit">Показать 11 356 объектов</button>
                    </form>
                </div>
                <div data-filter-item="filter_5" class="filter-item">
                    <form action="#" class="form form-filter">
                        <div class="form-row">
                            <div class="form-row-50">
                                <div class="form-holder">
                                    <div id="regions-container--18" class="regions-container white-popup mfp-hide">
                                        <div class="regions-container-list">
                                            <div class="regions-title">Выберите район</div>
                                                <ul>
                                                    <li name="adler"><span class="regions-text">Адлер</span>
                                                        <div class="regions-close"></div>
                                                    </li>
                                                    <li name="bihta"><span class="regions-text">Быхта</span>
                                                        <div class="regions-close"></div>
                                                    </li>
                                                    <li name="dogomis"><span class="regions-text">Догомыс</span>
                                                        <div class="regions-close"></div>
                                                    </li>
                                                    <li name="dons"><span class="regions-text">Донская</span>
                                                        <div class="regions-close"></div>
                                                    </li>
                                                    <li name="q"><span class="regions-text">Завокзальный</span>
                                                        <div class="regions-close"></div>
                                                    </li>
                                                    <li name="w"><span class="regions-text">Заречный</span>
                                                        <div class="regions-close"></div>
                                                    </li>
                                                    <li name="e"><span class="regions-text">Касная Пляна</span>
                                                        <div class="regions-close"></div>
                                                    </li>
                                                    <li name="r"><span class="regions-text">КСМ</span>
                                                        <div class="regions-close"></div>
                                                    </li>
                                                    <li name="t"><span class="regions-text">Кудепста</span>
                                                        <div class="regions-close"></div>
                                                    </li>
                                                    <li name="y"><span class="regions-text">Курортный городок</span>
                                                        <div class="regions-close"></div>
                                                    </li>
                                                    <li name="u"><span class="regions-text">Лазаревский</span>
                                                        <div class="regions-close"></div>
                                                    </li>
                                                    <li name="i"><span class="regions-text">Макаренко</span>
                                                        <div class="regions-close"></div>
                                                    </li>
                                                    <li name="o"><span class="regions-text">Мамайка</span>
                                                        <div class="regions-close"></div>
                                                    </li>
                                                    <li name="a"><span class="regions-text">Мацеста</span>
                                                        <div class="regions-close"></div>
                                                    </li>
                                                    <li name="f"><span class="regions-text">Новый сочи</span>
                                                        <div class="regions-close"></div>
                                                    </li>
                                                    <li name="g"><span class="regions-text">Олимпийский парк</span>
                                                        <div class="regions-close"></div>
                                                    </li>
                                                    <li name="h"><span class="regions-text">Приморье</span>
                                                        <div class="regions-close"></div>
                                                    </li>
                                                    <li name="j"><span class="regions-text">Раздольное</span>
                                                        <div class="regions-close"></div>
                                                    </li>
                                                    <li name="k"><span class="regions-text">Светлана</span>
                                                        <div class="regions-close"></div>
                                                    </li>
                                                    <li name="l"><span class="regions-text">Соболевка</span>
                                                        <div class="regions-close"></div>
                                                    </li>
                                                    <li name="z"><span class="regions-text">Хоста</span>
                                                        <div class="regions-close"></div>
                                                    </li>
                                                    <li name="x"><span class="regions-text">Центр</span>
                                                        <div class="regions-close"></div>
                                                    </li>
                                                    <li name="c"><span class="regions-text">Яна Фабрициуса</span>
                                                        <div class="regions-close"></div>
                                                    </li>
                                                </ul>
                                            <button type="button" class="button button--blue regions-show">Показать объекты</button>
                                        </div>
                                    </div>
                                    <a href="#regions-container--18" data-mfp-closeinside="true" data-mfp-closeonbcg="true" class="link link-black jcf-select-form-item--select mfp-modal">
                                        <span class="jcf-select-text"><span>Гостиницы</span></span><span class="jcf-select-opener"></span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-100">
                                <div class="form-holder">
                                    <label class="form-label">
                                        <input type="checkbox" class="form-item form-item--checkbox"><span class="form-item-checkbox-title">Вид на море</span>
                                    </label>
                                    <label class="form-label">
                                        <input type="checkbox" class="form-item form-item--checkbox"><span class="form-item-checkbox-title">Ровный</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-50">
                                <div class="form-item-title">Площадь участка</div>
                                <div class="form-holder">
                                    <input type="range" multiple="" value="20,100" min="10" max="150" step="10" data-valfrom="" data-valto="" data-valtext="&amp;thinsp;м&lt;sup&gt;2&lt;/sup&gt;" class="form-item form-item--range">
                                </div>
                            </div>
                            <div class="form-row-50">
                                <div class="form-item-title">Цена</div>
                                <div class="form-holder">
                                    <input type="range" multiple="" value="10000000,50000000" min="700000" max="100000000" step="1000" data-valfrom="" data-valto="" data-valtext="&thinsp;<span class='rub'>i</span>" class="form-item form-item--range">
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-row-50">
                                <div class="form-holder">
                                    <div id="regions-container--99" class="regions-container white-popup mfp-hide">
                                        <div class="regions-container-list">
                                            <div class="regions-title">Выберите район</div>
                                            <ul>
                                                <li name="adler"><span class="regions-text">Адлер</span>
                                                    <div class="regions-close"></div>
                                                </li>
                                                <li name="bihta"><span class="regions-text">Быхта</span>
                                                    <div class="regions-close"></div>
                                                </li>
                                                <li name="dogomis"><span class="regions-text">Догомыс</span>
                                                    <div class="regions-close"></div>
                                                </li>
                                                <li name="dons"><span class="regions-text">Донская</span>
                                                    <div class="regions-close"></div>
                                                </li>
                                                <li name="q"><span class="regions-text">Завокзальный</span>
                                                    <div class="regions-close"></div>
                                                </li>
                                                <li name="w"><span class="regions-text">Заречный</span>
                                                    <div class="regions-close"></div>
                                                </li>
                                                <li name="e"><span class="regions-text">Касная Пляна</span>
                                                    <div class="regions-close"></div>
                                                </li>
                                                <li name="r"><span class="regions-text">КСМ</span>
                                                    <div class="regions-close"></div>
                                                </li>
                                                <li name="t"><span class="regions-text">Кудепста</span>
                                                    <div class="regions-close"></div>
                                                </li>
                                                <li name="y"><span class="regions-text">Курортный городок</span>
                                                    <div class="regions-close"></div>
                                                </li>
                                                <li name="u"><span class="regions-text">Лазаревский</span>
                                                    <div class="regions-close"></div>
                                                </li>
                                                <li name="i"><span class="regions-text">Макаренко</span>
                                                    <div class="regions-close"></div>
                                                </li>
                                                <li name="o"><span class="regions-text">Мамайка</span>
                                                    <div class="regions-close"></div>
                                                </li>
                                                <li name="a"><span class="regions-text">Мацеста</span>
                                                    <div class="regions-close"></div>
                                                </li>
                                                <li name="f"><span class="regions-text">Новый сочи</span>
                                                    <div class="regions-close"></div>
                                                </li>
                                                <li name="g"><span class="regions-text">Олимпийский парк</span>
                                                    <div class="regions-close"></div>
                                                </li>
                                                <li name="h"><span class="regions-text">Приморье</span>
                                                    <div class="regions-close"></div>
                                                </li>
                                                <li name="j"><span class="regions-text">Раздольное</span>
                                                    <div class="regions-close"></div>
                                                </li>
                                                <li name="k"><span class="regions-text">Светлана</span>
                                                    <div class="regions-close"></div>
                                                </li>
                                                <li name="l"><span class="regions-text">Соболевка</span>
                                                    <div class="regions-close"></div>
                                                </li>
                                                <li name="z"><span class="regions-text">Хоста</span>
                                                    <div class="regions-close"></div>
                                                </li>
                                                <li name="x"><span class="regions-text">Центр</span>
                                                    <div class="regions-close"></div>
                                                </li>
                                                <li name="c"><span class="regions-text">Яна Фабрициуса     </span>
                                                    <div class="regions-close"></div>
                                                </li>
                                            </ul>
                                            <button type="button" class="button button--blue regions-show">Показать объекты</button>
                                        </div>
                                    </div>
                                    <a href="#regions-container--99" data-mfp-closeinside="true" data-mfp-closeonbcg="true" class="link link-black jcf-select-form-item--select mfp-modal"><span class="jcf-select-text"><span>Район</span></span><span class="jcf-select-opener"></span></a>
                                </div>
                            </div>
                        <div class="form-row-50">
                            <div class="form-holder">
                                <input type="text" placeholder="Поиск по названию или улице" data-autocomplete="true" class="form-item form-item--text">
                                <button type="button" class="form-filter-search">
                                    <span class="form-filter-search-icon">
                                        <?php include("svg/loupe.svg")?>
                                    </span>
                                </button>
                            </div>
                            </div>
                        </div>
                        <div class="filter-selected-regions-list"></div>
                        <button type="submit" data-filter-button-tpl="Показать {0} обектов" class="button button--orange-flood filter-submit">Показать 11 356 объектов</button>
                    </form>
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
                                <div class="popular-item"><a href="#" class="link link-blue link-blue--bottom link-blue--bottom popular-item-link">Недорогие новостройки в Сочи</a><span class="popular-item-count">16</span></div>
                                <div class="popular-item"><a href="#" class="link link-blue link-blue--bottom popular-item-link">Новостройки бизнес класса</a><span class="popular-item-count">34</span></div>
                                <div class="popular-item"><a href="#" class="link link-blue link-blue--bottom popular-item-link">Новостройки в Сочи по ФЗ 214</a><span class="popular-item-count">23</span></div>
                                <div class="popular-item"><a href="#" class="link link-blue link-blue--bottom popular-item-link">Новостройки от застройщика</a><span class="popular-item-count">18</span></div>
                                <div class="popular-item"><a href="#" class="link link-blue link-blue--bottom popular-item-link">Новостройки под ипотеку</a><span class="popular-item-count">44</span></div>
                                <div class="popular-item"><a href="#" class="link link-blue link-blue--bottom popular-item-link">Новостройки эконом класса</a><span class="popular-item-count">145</span></div>
                                <div class="popular-item"><a href="#" class="link link-blue link-blue--bottom popular-item-link">Сданные новостройки в Сочи</a><span class="popular-item-count">45</span></div>
                                <div class="popular-item"><a href="#" class="link link-blue link-blue--bottom popular-item-link">Элитные новостройки в Сочи </a><span class="popular-item-count">11</span></div>
                            </div>
                        </div>
                        <div class="popular-col popular-col--30">
                            <h3>Популярные районы</h3>
                            <div class="popular-list">
                                <a href="#" class="link link-blue link-blue--bottom popular-item-link">Адлер</a>
                                <a href="#" class="link link-blue link-blue--bottom popular-item-link">Дагомы</a>
                                <a href="#" class="link link-blue link-blue--bottom popular-item-link">Мацеста</a>
                                <a href="#" class="link link-blue link-blue--bottom popular-item-link">Ценр Сочи</a>
                                <a href="#" class="link link-blue link-blue--bottom popular-item-link">Красная поляна</a>
                                <a href="#" class="link link-blue link-blue--bottom popular-item-link">Мамайка</a>
                                <a href="#" class="link link-blue link-blue--bottom popular-item-link">Хоста</a>
                            </div>
                        </div>
                    </div>
                    <div class="find-result">
                        <div class="find-result-text">По вашим параметрам найдено обектов: {{$countOffers}}</div>
                        <form action="#" class="find-result-form">
                            <select placeholder="Сортировка" class="find-result-select">
                                <option value="" selected class="disabled">Сортировка</option>
                                <option>По домам</option>
                                <option>По квартирам</option>
                                <option>По площади</option>
                            </select>
                        </form>
                        <a href="#" class="link link-blue button find-result-button find-result-button--map">
                            <span class="find-result-button-icon">
                                <?php include("svg/point-map-mini.svg");?>
                            </span>
                            <span class="find-result-button-text">на карте</span>
                        </a>
                        <button type="button" class="button find-result-button find-result-button--list">
                            <span class="find-result-button-icon">
                                <?php include("svg/list-grid.svg");?>
                            </span>
                            <span class="find-result-button-text">списком</span>
                        </button>
                    </div>
                    @if (isset($offers))
                        @component("components.offers", ["offersList" => $offers])@endcomponent
                    @endif
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
    <div style="background:#009ecc" class="page-inner page-inner--max">
        <div class="page-inner page-inner--w1">
            <div class="order-call">
                <div class="page-text">
                    <h2>Закажите профессиональный подбор сейчас</h2>
                </div>
                <form class="form form-order-call">
                    <div class="form-row form-row--100">
                        <input type="text" id="name" name="name" required data-error="Ваше имя" aria-required="true" placeholder="Ваше имя" class="form-item form-item--text">
                    </div>
                    <div class="form-row form-row--100">
                        <input type="text" id="mobile" name="mobile" required data-error="Укажите телефон" aria-required="true" data-pattern="mobileRU" data-number="+7 (000) 000-00-00" placeholder="Контактный телефон" class="form-item form-item--text">
                    </div>
                    <div class="form-row form-row--100">
                        <div class="order-call-privacy">Нажимая на кнопку "Отправить заявку", вы даете<a href="#" class="link link-white link--opacity">&ensp;согласие на обработку своих персональных данных</a></div>
                    </div>
                    <div class="form-row form-row--100">
                        <button type="submit" class="button button--orange-flood send-order">Отправить заявку</button>
                </div>
                </form>
                <div class="order-call-hotline">
                    <span class="order-call-hotline-text">Бесплатная горячая линия</span>
                    <a href="tel:+78007075523" class="link link-white link--opacity order-call-hotline-mobile">8-800-707-55-23</a>
                    <span class="order-call-hotline-text">операторы доступны</span>
                    <span class="order-call-hotline-text">с 8:00 до 22:00 МСК</span></div>
                    <div class="order-call-icon">
                        <?php include("svg/call.svg")?>
                    </div>
                </div>
            </div>
        </div>
@endsection
