@extends("layouts.app")

@section("content")
    <div class="apartment apartment-card">

        <div class="page-inner page-inner--w1">
            <div class="apartment-header">
                <div class="apartment-header-col">
                    <div class="apartment-title">{{ $element["name"] }}</div>
                    <div class="apartment-location">
                        @if (isset($element["code_fields"]["District"]))
                            <a href="/catalog/{{ $section }}/filter/district__{{ $element["code_fields"]["District"][0]["property"]["code"] }}" class="link link-black link-black--bottom">Район {{ $element["code_fields"]["District"][0]["property"]["name"] }},</a>
                        @endif
                        @if (isset($cottage) && !empty($cottage))
                            <a href="{{ $cottage["url"] }}" class="link link-black link-black--bottom">{{ $cottage["name"] }}</a>
                        @endif
                        @if (!empty($element["yandex_coord"]))
                            <a href="#" data-goto="#mapYandex" class="link link-orange link-orange--bottom apartment-location-map">На карте</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="page-inner page-inner--max">
            <div class="apartment-preview">
                <div class="page-inner page-inner--w1">
                    <div class="apartment-preview-container">

                        <div class="apartment-slider apartment-slider--w75 for-preloader">
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

                        <div class="apartment-preview-text-container fixed-block-container">
                            <div data-fixed-block="apartment-preview-text" class="apartment-preview-text fixed-block">
                                <button type="button" class="link apartment-preview-text-icon <? echo (isset($element["check_cookie"])) ? "added" : '' ?>" data-favorite="{{ $element["id"] }}">
                                    @php include("svg/star_orage.svg"); @endphp
                                </button>
                                @if (!empty($element["price"]))
                                    <div class="apartment-preview-text-price">{{ number_format($element["price"], 0, '', ' ') }}<span class="rub">i</span></div>
                                @endif
                                @if (!empty($element["price_m"]))
                                    <div class="apartment-preview-text-credit">{{ number_format($element["price_m"], 0, '', ' ') }}<span class="rub">i</span> м<sup>2</sup></div>
                                @endif
                                @if (!empty($element["id"]))
                                    <div class="apartment-preview-text-id">ID {{ $element["id"] }}</div>
                                @endif
                                <a href="/form/order-object" data-mfp-type="ajax" data-mfp-ajaxcontent="#form-call" data-mfp-bcg="#009ecc" data-mfp-closeinside="false" class="link button button--orange-reverse apartment-preview-order mfp-modal">Заявка</a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="apartment-information">
            <div class="page-text">
                @if (isset($element["code_fields"]["AddOptions"]))
                    <div class="apartment-description-item">
                        <div class="apartment-features">
                            @foreach ($element["code_fields"]["AddOptions"] as $valOptions)
                                <div class="apartment-features-item">
                                    <div class="apartment-features-item-icon">
                                        {!! $valOptions["property"]["icon"] !!}
                                    </div>
                                    <div class="apartment-features-item-text">{{ $valOptions["property"]["name"] }}</div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
                @if ($element["detail_text"])
                    <div class="apartment-description-item">
                        <div class="border-text border-text--full">
                            <p>{!! $element["detail_text"] !!}</p>
                        </div>
                    </div>
                @endif
                <div class="apartment-description-item">
                    <div class="apartment-detail-info">
                        <dl>
                            <dt>Площадь</dt>
                                <dd>{{ $element["area"] }} м<sup>2</sup></dd>
                            <dt>Этаж</dt>
                                <dd>{{ $element["floor"] }}</dd>
                            @if (!empty($element["code_fields"]["NumberRoom"]))
                                <dt>Количество комнат </dt>
                                    <dd>{{ $element["code_fields"]["NumberRoom"][0]["property"]["name"] }}</dd>
                            @endif
                            @if (!empty($element["number_bathrooms"]))
                                <dt>Количество сан узлов</dt>
                                    <dd>{{ $element["number_bathrooms"] }}</dd>
                            @endif
                            @if (!empty($element["height_ceiling"]))
                                <dt>Высота потолков</dt>
                                    <dd>{{ $element["height_ceiling"] }} м</dd>
                            @endif
                            @if (!empty($element["code_fields"]["Decoration"]))
                                <dt>Отделка</dt>
                                    <dd>{{ $element["code_fields"]["Decoration"][0]["property"]["name"] }} </dd>
                            @endif
                            @if (!empty($element["code_fields"]["ParkingPlaces"]))
                                <dt>Место парковки</dt>
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
                            @if (!empty($element["see_sea"]) && $element["see_sea"] == 1 )
                                <dt>Вид на море</dt>
                                    <dd>Да</dd>
                            @endif
                            @if (!empty($element["code_fields"]["Communication"]))
                                <dt>Коммуникации</dt>
                                    <dd>{{ $element["code_fields"]["Communication"][0]["property"]["name"] }}</dd>
                            @endif
                            @if (!empty($element["code_fields"]["Heating"]))
                                <dt>Отопление</dt>
                                    <dd>{{ $element["code_fields"]["Heating"][0]["property"]["name"] }}</dd>
                            @endif
                            @if (!empty($element["code_fields"]["Sewerage"]))
                                <dt>Канализация</dt>
                                    <dd>{{ $element["code_fields"]["Sewerage"][0]["property"]["name"] }}</dd>
                            @endif
                        </dl>
                    </div>
                </div>
                @if (!empty($element["yandex_coord"]))
                    <div class="apartment-description-item">
                        <div class="apartment-map">
                            <div id="mapYandex" data-center="[{{ $element["yandex_coord"] }}]" data-zoom="12" data-points="[{name:&quot;1&quot;, position: &quot;{{ $element["yandex_coord"] }}&quot;, description:&quot;Сочи, район Светлана, 3-комп. квартира, 170 м&quot;}]" class="map"></div>
                            <!--div(class="map", id="mapGoogle", data-lat="43.60405218", data-lng="39.73541935", data-zoom="16", data-icon="../svg/point_map.svg")-->
                        </div>
                    </div>
                @endif
            </div>
        </div>

        @if (isset($similarElements) && $similarElements->isNotEmpty())
            <div style="background:#f7f8fb" data-fixed-limit="apartment-preview-text" class="page-inner page-inner--max">
                <div class="page-inner page-inner--w1">
                    <div class="page-text">
                        <h2>Похожие объекты</h2>
                        @component("components.offers", ["offersList" => $similarElements, "showFind" => false, "countOffers" => $similarElements->count()])@endcomponent

                    </div>
                </div>
            </div>
        @endif

        @component("components.form-specialorder")@endcomponent

    </div>
@endsection
