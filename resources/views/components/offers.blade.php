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
            <div class="offers-item <?=$hide = isset($notShowAdd) ? "hide-add": ""?>">
                @php
                    $favorite = "";
                    $text = "Добавить в избранное";
                    $newCookie = App\GoodCode\Helper::handlerCookie($valOffers->id, "get");
                    if ($newCookie == true) {
                        $favorite = "added";
                        $text = "Добавленно";
                    }
                @endphp
                <button type="button" class="offers-container-favorites {{ $favorite }}"  data-favorite='{{ $valOffers->id }}'>
                    <div class="link offers-container-favorites-icon">
                        @php include("svg/star_orage.svg"); @endphp
                    </div>
                    <div class="link link-orange link-orange--bottom offers-container-favorites-text">{{ $text }}</div>
                </button>
                <div class="offers-container">
                    @if ($valOffers->text_action)
                        <div class="offers-container-mark">
                            {{ $valOffers->text_action }}
                        </div>
                    @endif
                    @if (!empty($valOffers->photo))
                        <img src="{{ $valOffers->photo }}" alt class="offers-container-img">
                    @else
                        <div class="offers-container-img empty">
                            @php include("svg/logo-mini_preload.svg"); @endphp
                        </div>
                    @endif
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
                                @if (isset($valOffers->id))
                                    <dt>
                                        <span>ID</span>
                                    </dt>
                                    <dd>
                                        <span>{{ $valOffers->id }}</span>
                                    </dd>
                                @endif
                                @foreach ($valOffers->apartments as $keyApartment => $valApartment)
                                    <dt>
                                        <span>{{ $keyApartment }}</span>
                                    </dt>
                                    <dd>
                                        <span>от {{ number_format($valApartment, 0, " ", " ") }}<span class="rub">i</span></span>
                                    </dd>
                                @endforeach
                            </dl>
                        @else
                            <dl>
                                @if (isset($valOffers->id))
                                    <dt>
                                        <span>ID</span>
                                    </dt>
                                    <dd>
                                        <span>{{ $valOffers->id }}</span>
                                    </dd>
                                @endif
                                @if (isset($valOffers->price_m))
                                    <dt>
                                        <span>Цена м<span class="page-text"><sup>2</sup></span></span>
                                    </dt>
                                    <dd>
                                        <span>{{ $valOffers->price_m }}<span class="rub">i</span></span>
                                    </dd>
                                @endif
                                @if (isset($valOffers->floors))
                                    <dt>
                                        <span>Этажей</span>
                                    </dt>
                                    <dd>
                                        <span>{{ $valOffers->floors }}</span>
                                    </dd>
                                @endif
                                @if (isset($valOffers->floor) && isset($valOffers->floors))
                                    <dt>
                                        <span>Этаж</span>
                                    </dt>
                                    <dd>
                                        <span><b>{{ $valOffers->floor }}</b> — <b>{{ $valOffers->floors }}</b></span>
                                    </dd>
                                @endif
                            </dl>
                        @endif
                    </div>
                </div>
                <a href="{{ url($valOffers->path) }}" class="link button button--orange offers-container-more">Подробнее</a>
            </div>
        @endforeach
    </div>
    @if ($offersList instanceof \Illuminate\Pagination\LengthAwarePaginator)
        @include("pagination.default", [
            "paginator" => $offersList,
            "class" 	=> "offers-more",
            "container" => "#offers-list-load",
            "item" 		=> ".offers-item",
        ])
    @endif
@endif
