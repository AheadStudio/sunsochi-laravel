@if (isset($showFind) && $showFind == true)
    <div class="find-result">
        <div class="find-result-text">По вашим параметрам найдено объектов: <span>{{ $countOffers }}</span></div>
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
@endif
@if (isset($offersList) && !empty((array)$offersList))
    <div id="offers-list-load" class="offers-list">
        @foreach ($offersList as $keyOffers => $valOffers)
            <div class="offers-item">
                @if (!isset($notShowAdd))
                    @php
                        $favorite = "";
                        $text = "Добавить в избранное";
                        if (!empty(json_decode(Cookie::get('sunsochi-favorite')))) {
                            if (array_search($valOffers->id, json_decode(Cookie::get('sunsochi-favorite'))) != false) {
                                $favorite = "added";
                                $text = "Добавленно";
                            }
                        }
                    @endphp
                    <button type="button" class="offers-container-favorites {{ $favorite }}"  data-favorite='{{ $valOffers->id }}'>
                        <div type="button" class="link offers-container-favorites-icon">
                            @php include("svg/star_orage.svg"); @endphp
                        </div>
                        <div class="link link-orange link-orange--bottom offers-container-favorites-text">{{ $text }}</div>
                    </button>
                @endif
                <div class="offers-container">
                    @if ($valOffers->text_action)
                        <div class="offers-container-mark">
                            {{ $valOffers->text_action }}
                        </div>
                    @endif
                    <img src="{{ $valOffers->photo }}" alt class="offers-container-img">
                    @if (!empty($valOffers->price_ap_min))
                        <div class="offers-container-price">{{ number_format($valOffers->price_ap_min, 0, " ", " ") }} <span class="rub">i</span></div>
                    @endif
                    @if (!empty($valOffers->price) && empty($valOffers->price_ap_min))
                        <div class="offers-container-price">{{ number_format($valOffers->price, 0, " ", " ") }} <span class="rub">i</span></div>
                    @endif
                </div>
                <div class="offers-information">
                    <div class="page-text">
                        <div class="offers-name">{{ $valOffers->name }}</div>
                        <div class="offers-district">{{ $valOffers->district }}</div>
                        <span class="offers-time">{{ $valOffers->deadline }}</span>
                        @if (isset($valOffers->apartments))
                            <dl>
                                @foreach ($valOffers->apartments as $keyApartment => $valApartment)
                                    <dt>
                                        <span>{{ $keyApartment }}</span>
                                    </dt>
                                    <dd>
                                        <span>от {{ number_format($valApartment->price, 0, " ", " ") }}<span class="rub">i</span></span>
                                    </dd>
                                @endforeach
                            </dl>
                        @endif
                    </div>
                </div>
                <a href="{{ url($valOffers->path) }}" class="link button button--orange offers-container-more">Подробнее</a>
            </div>
        @endforeach
    </div>

    @include("pagination.default", [
        "paginator" => $offersList,
        "class" 	=> "offers-more",
        "container" => "#offers-list-load",
        "item" 		=> ".offers-item",
    ])
@endif
