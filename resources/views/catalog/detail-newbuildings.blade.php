@extends("layouts.app")

@section("content")
    <div class="apartment">
        <div class="page-inner page-inner--w1 apartment-stub">
            <div data-fixed-apartment class="apartment-header-fixed">
                <div class="apartment-header">
                    <div class="apartment-header-col">
                        <div class="apartment-title">{{ $element["name"] }}</div>
                        <div class="apartment-location">
                            @if (isset($element["code_fields"]["District"]))
                                <a href="/catalog/{{ $section }}/filter/district__{{ $element["code_fields"]["District"][0]["property"]["code"] }}" class="link link-black link-black--bottom">Район {{ $element["code_fields"]["District"][0]["property"]["name"] }}</a>
                            @endif
                            @if (!empty($element["yandex_coord"]))
                                <a href="#" data-goto="#mapYandex" class="link link-orange link-orange--bottom apartment-location-map">На карте</a>
                            @endif
                        </div>
                        <div class="apartment-deadline">
                            @if (isset($element["code_fields"]["Deadline"]))
                                <div class="apartment-deadline-term">Срок сдачи: {{ $element["code_fields"]["Deadline"][0]["property"]["name"] }}</div>
                            @endif
                            @if (!empty($element["home_readiness"]))
                                <div class="apartment-deadline-finish">Готовность: {{ $element["home_readiness"] }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="apartment-header-col">
                    <div class="apartment-preview-text-container apartment-preview-text">
                        <button type="button" class="link apartment-preview-text-icon <? echo (isset($element["check_cookie"])) ? "added" : '' ?>" data-favorite="{{ $element["id"] }}">
                            @php include("svg/star_orage.svg"); @endphp
                        </button>
                        <div class="apartment-preview-text-info">
                            @if (!empty($element["price"]))
                                <div class="apartment-preview-text-price">{{ number_format($element["price"], 0, '', ' ') }}<span class="rub">i</span> / м<sup>2</sup></div>
                            @endif
                            @if (!empty($element["area"]))
                                <div class="apartment-preview-text-credit">{{ number_format($element["area"], 0, '', ' ') }} м<sup>2</sup></div>
                            @endif
                            <a href="/form/order-object" data-mfp-type="ajax" data-mfp-ajaxcontent="#form-call" data-mfp-bcg="#009ecc" data-mfp-closeinside="false" data-mfp-info='{"id": {{ $element["id"] }} }' class="link button button--orange-reverse apartment-preview-order mfp-modal">Оставить заявку</a>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="page-inner page-inner--max">
            <div class="apartment-preview">
                <div class="page-inner page-inner--w1">
                    <div class="apartment-preview-container">
                        <div class="apartment-slider apartment-slider--w100 for-preloader">
                            @if (!empty($element["picture"]))
                                <div class="light-slider">
                                    @foreach ($element["picture"] as $valPicture)
                                        <div data-thumb="{{ $valPicture["path"] }}" class="apartment-slider-item">
                                            <img src="{{ $valPicture["path"] }}" alt="{{ $valPicture["name"] }}">
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="light-slider" data-lightslider-loop="false" data-lightslider-thumbItem="false">
                                    <div class="apartment-slider-item empty">
                                        @php include("svg/logo-mini_preload.svg"); @endphp
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="apartment-information">
            <div class="page-text">
                <div class="apartment-tabs border-text--bottom">
                    <div class="page-inner page-inner--w1">
                        <div class="filter-tabs">
                            <div data-filter-tab="prop_1" class="filter-tab active">Описание</div>
                            <div data-filter-tab="prop_2" class="filter-tab">Квартиры</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="filter-list">
                <div data-filter-item="prop_1" class="page-inner page-inner--w2 filter-item">
                    @if (!empty($element["home_readiness"]))
                        <div class="apartment-item">
                            <div data-progress="{{ str_replace("%", "", $element["home_readiness"]) }}" class="apartment-progress">
                                <div data-progress-text="Готовность дома - $count%" class="apartment-progress-text"></div>
                                <div class="apartment-progress-bar">
                                    <div data-progress-fill class="apartment-progress-bar-fill"></div>
                                </div>
                                <div class="apartment-progress-list">
                                    <div class="apartment-progress-item">Проект</div>
                                    <div class="apartment-progress-item">Котлован</div>
                                    <div class="apartment-progress-item">Фундамент</div>
                                    <div class="apartment-progress-item">Строительство</div>
                                    <div class="apartment-progress-item">Коммуникации</div>
                                    <div class="apartment-progress-item">Остекленение</div>
                                    <div class="apartment-progress-item">Фасад</div>
                                    <div class="apartment-progress-item">Ландшафт</div>
                                    <div class="apartment-progress-item">Заселен</div>
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="apartment-item">
                        <div class="page-text">
                            @if (!empty($element["detail_text"]))
                                <div class="apartment-description-item">
                                    <div class="border-text border-text--bottom"><p>{!! $element["detail_text"] !!}</p></div>
                                </div>
                            @endif
                            @if (isset($element["code_fields"]["AddOptions"]))
                                <div class="apartment-description-item">
                                    <div class="apartment-features border-text border-text--bottom">
                                        @foreach ($element["code_fields"]["AddOptions"] as $valOptions)
                                            <div class="apartment-features-item">
                                                <div class="apartment-features-item-icon">{!! $valOptions["property"]["icon"] !!}</div>
                                                <div class="apartment-features-item-text">{{ $valOptions["property"]["name"] }}</div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                            <div class="apartment-description-item">
                                <div class="apartment-detail-info border-text border-text--bottom">
                                    <dl>
                                        @if (isset($element["code_fields"]["Deadline"]))
                                            <dt>Срок сдачи</dt>
                                            <dd>{{ $element["code_fields"]["Deadline"][0]["property"]["name"] }}</dd>
                                        @endif
                                        @if (isset($element["builder"]))
                                            <dt>Застройщик</dt>
                                            <dd><a href="{{ $element["builder"]["url"] }}" class="link link-black link-black--bottom">{{ $element["builder"]["name"] }}</a></dd>
                                        @endif
                                        @if (!empty($element["number_apartments"]))
                                            <dt>Всего квартир </dt>
                                            <dd>{{ $element["number_apartments"] }}</dd>
                                        @endif
                                        @if (!empty($element["floors"]))
                                            <dt>Этажей</dt>
                                            <dd> {{ $element["floors"] }}</dd>
                                        @endif
                                        @if (!empty($element["area_ap_max"]) && !empty($element["area_ap_min"]))
                                            <dt>Площадь квартир</dt>
                                            <dd>от {{ $element["area_ap_min"] }} до {{ $element["area_ap_max"] }} м<sup>2</sup></dd>
                                        @endif
                                        @if (isset($element["code_fields"]["ClassBuildings"]))
                                            <dt>Класс здания</dt>
                                            <dd>{{ $element["code_fields"]["ClassBuildings"][0]["property"]["name"] }}</dd>
                                        @endif
                                        @if (!empty($element["height_ceiling"]))
                                            <dt>Высота потолков </dt>
                                            <dd>{{ $element["height_ceiling"] }}м</dd>
                                        @endif
                                        @if (!empty($element["code_fields"]["Decoration"]))
                                            <dt>Отделка</dt>
                                            <dd>{{ $element["code_fields"]["Decoration"][0]["property"]["name"] }} </dd>
                                        @endif
                                        @if (!empty($element["code_fields"]["ParkingPlaces"]))
                                            <dt>Парковка</dt>
                                            <dd>{{ $element["code_fields"]["ParkingPlaces"][0]["property"]["name"] }}</dd>
                                        @endif
                                        @if (!empty($element["type_building"]))
                                            <dt>Тип постройки</dt>
                                            <dd>{{ $element["type_building"] }}</dd>
                                        @endif
                                        @if (!empty($element["to_sea"]))
                                            <dt>Расстояние до моря</dt>
                                            <dd>{{ $element["to_sea"] }} м</dd>
                                        @endif
                                        @if (!empty("mortgage"))
                                            <dt>Ипотека</dt>
                                            <dd>да</dd>
                                        @endif
                                        @if (!empty("federal_law_214"))
                                            <dt>Федеральный закон 214</dt>
                                            <dd>да</dd>
                                        @endif
                                        @if (!empty($element["code_fields"]["Sewerage"]))
                                            <dt>Канализация</dt>
                                            <dd>{{ $element["code_fields"]["Sewerage"][0]["property"]["name"] }}</dd>
                                        @endif

                                    </dl>
                                </div>
                                @if (!empty($element["infrastructure"]))
                                    <div class="apartment-detail-info">
                                        <div class="infrastructure">
                                            @if (!empty($element["infrastructure"]))
                                                <div class="infrastructure-column">
                                                    <div class="title">Инфраструктура рядом</div>
                                                    @if (!empty($element["infrastructure"]))
                                                        @foreach ($element["infrastructure"] as $value)
                                                            <div class="text">{{ $value }}</div>
                                                        @endforeach
                                                    @endif
                                                </div>
                                                <div class="infrastructure-column">
                                                    <div class="title">На территории ЖК</div>
                                                    @if (!empty($element["include"]))
                                                        @foreach ($element["include"] as $value)
                                                            <div class="text">{{ $value }}</div>
                                                        @endforeach
                                                    @endif
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    @if ($element["yandex_coord"])
                        <div class="apartment-description-item">
                            <div class="apartment-map">
                                <div id="mapYandex" data-center="[{{ $element["yandex_coord"] }}]" data-zoom="12" data-points="[{name:&quot;1&quot;, position: &quot;{{ $element["yandex_coord"] }}&quot;, description:&quot;Сочи, район Светлана, 3-комп. квартира, 170 м&quot;}]" class="map"></div>
                            </div>
                        </div>
                    @endif

                </div>
                <div data-filter-item="prop_2" class="page-inner page-inner--max filter-item">
                    <div class="apartment-result">
                        <div class="page-inner page-inner--w1">
                            <div class="apartment-result-container">
                                @if (!empty($element["number_apartments"]))
                                    <div class="apartment-result-text">Всего квартир: {{ $element["number_apartments"] }}</div>
                                @endif
                                <div class="apartment-result-controls">
                                    <button type="button" data-filter-tab="view_1" class="button apartment-result-button apartment-result-button--list active">
                                        <span class="apartment-result-button-icon">
                                            @php include("svg/list.svg"); @endphp
                                        </span>
                                        <span class="apartment-result-button-text">списком</span>
                                    </button>
                                    <button type="button" data-filter-tab="view_2" class="button apartment-result-button apartment-result-button--grid">
                                        <span class="apartment-result-button-icon">
                                            @php include("svg/list-grid.svg"); @endphp
                                        </span>
                                        <span class="apartment-result-button-text">шахматка</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="page-inner page-inner--w1">
                        <div data-filter-item="view_1" class="apartment-list filter-item">
                            @if (!empty($element["free_apartments"]))
                                <div class="apartment-types-list">
                                    <!--div(class="apartment-type")-->
                                    <!--    div(class="apartment-type-badge", data-badge="1", style="background:#9b9b9b")-->
                                    <!--    div(class="apartment-type-text") Продано:-->
                                    <!--    div(class="apartment-type-count") 136-->
                                    <div class="apartment-type">
                                        <div class="apartment-type-text">В продаже:</div>
                                        <div class="apartment-type-count">{{ count($element["free_apartments"]) }}</div>
                                    </div>
                                    <div class="apartment-type">
                                        <div data-badge="2" style="background:#498FE1" class="apartment-type-badge"></div>
                                        <div class="apartment-type-text">Без отделки:</div>
                                        <div class="apartment-type-count">{{ $element["decoration_count"]["8hJkbSPc"] }}</div>
                                    </div>
                                    <div class="apartment-type">
                                        <div data-badge="3" style="background:#0036cb" class="apartment-type-badge"></div>
                                        <div class="apartment-type-text">С ремонтом:</div>
                                        <div class="apartment-type-count">{{ $element["decoration_count"]["T6ZqlhAt"] }}</div>
                                    </div>
                                    <div class="apartment-type">
                                        <div data-badge="4" style="background:#b43894" class="apartment-type-badge"></div>
                                        <div class="apartment-type-text">Предчистовая:</div>
                                        <div class="apartment-type-count">{{ $element["decoration_count"]["1lKIq2Yc"] }}</div>
                                    </div>
                                </div>

                                <div class="page-text">
                                    <div class="apartment-table">
                                        <table class="sort-table">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>Площадь</th>
                                                    <th>Этаж</th>
                                                    <th>Цена</th>
                                                    <th>Цена м<sup>2</sup></th>
                                                    <th>Отделка</th>
                                                    <th>Статус</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($element["free_apartments"] as $keyFreeAp => $valFreeAp)
                                                    <tr data-apartment-info='{"apartment": "{{ $valFreeAp[0]["name"] }}", "price": "{{ number_format($valFreeAp[0]["price"], 0, '', ' ') }}", "checkCookie": "{{ $valFreeAp[0]["check_cookie"] }}", "linkObject": "{{ $valFreeAp[0]["link"] }}", "id": {{ $valFreeAp[0]["id"] }}, "image": "{{ $valFreeAp[0]["image_path"] }}", "imagesheme": ""}' class="tooltip-item">
                                                        <td>{{ $valFreeAp[0]["name"] }}</td>
                                                        <td>{{ $valFreeAp[0]["area"] }} м<sup>2</sup></td>
                                                        <td>{{ $valFreeAp[0]["floor"] }}</td>
                                                        <td>{{ number_format($valFreeAp[0]["price"], 0, '', ' ') }}<span class="rub">i</span></td>
                                                        <td>{{ number_format($valFreeAp[0]["price_m"], 0, '', ' ')  }}<span class="rub">i/м</span><sup>2</sup></td>
                                                        <td>{{ $valFreeAp[0]["decorations_name"] }}</td>
                                                        <td>{{ $valFreeAp[0]["decorations_code"] }}
                                                            <div class="apartment-type-badge apartment-type-badge--orange" style="background: {{ $valFreeAp[0]['color'] }}"></div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @else
                                <div class="page-text">
                                    <br>
                                    <h1>Нет объектов в продаже</h1>
                                    <br>
                                    <br>
                                </div>
                            @endif
                        </div>
                        <div data-filter-item="view_2" class="apartment-list filter-item">
                            <div class="apartment-types-list">
                                <div class="apartment-type">
                                    <div data-badge="1" style="background:#ffe200" class="apartment-type-badge"></div>
                                    <div class="apartment-type-text">Продано:</div>
                                    <div class="apartment-type-count">136</div>
                                </div>
                                <div class="apartment-type">
                                    <div data-badge="2" style="background:#848783" class="apartment-type-badge"></div>
                                    <div class="apartment-type-text">Забронировано:</div>
                                    <div class="apartment-type-count">30</div>
                                </div>
                            </div>
                            <div class="apartment-types-list">
                                <div class="apartment-type">
                                    <div class="apartment-type-text">В продаже:</div>
                                    <div class="apartment-type-count">78</div>
                                </div>
                                <div class="apartment-type">
                                    <div data-badge="3" style="background:#41aa33" class="apartment-type-badge"></div>
                                    <div class="apartment-type-text">Без отделки</div>
                                </div>
                                <div class="apartment-type">
                                    <div data-badge="4" style="background:#498FE1" class="apartment-type-badge"></div>
                                    <div class="apartment-type-text">Предчистовая отделка</div>
                                </div>
                                <div class="apartment-type">
                                    <div data-badge="3" style="background:#E147D9" class="apartment-type-badge"></div>
                                    <div class="apartment-type-text">С ремонтом</div>
                                </div>
                                <div class="apartment-type">
                                    <div data-badge="4" style="background:#f99d22" class="apartment-type-badge"></div>
                                    <div class="apartment-type-text">Акция</div>
                                </div>
                            </div>
                            <div class="page-text">
                                <div class="apartment-structure">
                                    @if (isset($element["chess_apartments"]))
                                        @for ($section = 1; $section <= $element["chess"]["section_list"]; $section++)
                                            <div class="apartment-structure-item">
                                                <div class="apartment-structure-name">{{ $element["chess"]["section_names"][$section-1] }}</div>
                                                    <div data-structure = '{"size": {"row": <?=$element["floors"]?>, "col": <?=$element["chess"]["section_lenght"]?> }, "floorslink": [123, 111, 222], "objects": [ <? foreach ($element["chess_apartments"]["section"][$section] as $key => $value) : ?>{"position": <?=$value["chess"]; ?>, "text": "<? echo($text = isset($value["decorations_name"]) ? $value["decorations_name"] : ""); ?>", "color": "<?=$value["color"]; ?>", "info": {"id": "<?=$value["id"]; ?>", "apartment": "<?=$value["name"]; ?>", "price": "<?=number_format($value["price"], 0, '', ' ') ?>", "oldprice": "<? echo(!is_null($value["old_price"]) ? number_format($value["old_price"], 0, '', ' ') : ""); ?>", "image": "<? echo(isset($value["image_path"]) ? $value["image_path"] : ""); ?>", "imagesheme": "/dummy/apartment-icon/2.png"}} <? echo(key(array_slice( $element["chess_apartments"]["section"][$section], -1, 1, TRUE )) == $key ? "" : ",");?> <? endforeach; ?> ]}' class="apartment-structure-grid">
                                                    <div class="apartment-structure-floor">Этажи</div>
                                                    <div class="apartment-structure-grid-container">
                                                        <div class="apartment-structure-grid-container-floors"></div>
                                                        <div class="apartment-structure-grid-container-list"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endfor
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if (isset($similarElements) && $similarElements->isNotEmpty())
        <div style="background:#f7f8fb" data-fixed-limit="apartment-preview-text" class="page-inner page-inner--max">
            <div class="page-inner page-inner--w1">
                <div class="page-text">
                    <h2>Похожие объекты</h2>
                    @component("components.offers", ["offersList" => $similarElements, "showFind" => false, "countOffers" => $similarElements->count()]) @endcomponent
                </div>
            </div>
        </div>
        @endif
        @component("components.form-specialorder")@endcomponent
    </div>
@endsection
