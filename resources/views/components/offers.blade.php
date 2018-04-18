@if (isset($offersList))
    <div id="offers-list-load" class="offers-list">
        @foreach ($offersList as $keyOffers => $valOffers)
            <div class="offers-item">
                <div class="offers-container-favorites">
                    <button type="button" class="link offers-container-favorites-icon">
                        @php include("svg/star_orage.svg"); @endphp
                    </button>
                    <button type="button" class="link link-orange link-orange--bottom offers-container-favorites-text">Добавить в избранное</button>
                </div>
                <div class="offers-container">
                    @if ($valOffers["text_action"])
                        <div class="offers-container-mark">
                            @php echo $valOffers["text_action"]; die;@endphp
                        </div>
                    @endif
                    <img src="../dummy/home_1.jpg" alt class="offers-container-img">
                    <div class="offers-container-price">{{ number_format($valOffers["price_from"], 0, " ", " ") }}<span class="rub">i</span></div>
                </div>
                <div class="offers-information">
                    <div class="page-text">
                        <div class="offers-name">{{ $valOffers["name"] }}</div>
                        <div class="offers-district">{{ $valOffers["property"]["district"] }}</div>
                        <span class="offers-time"></span>
                        <dl>
                            <dt>
                                <span>Студия</span>
                            </dt>
                            <dd>
                                <span>от 1 167 920<span class="rub">i</span></span>
                            </dd>
                            <dt>
                                <span>1 комн.</span>
                            </dt>
                            <dd>
                                <span>от 1 910 920<span class="rub">i</span></span>
                            </dd>
                            <dt>
                                <span>2 комн.</span>
                            </dt>
                            <dd>
                                <span>от 1 910 920<span class="rub">i</span></span>
                            </dd>
                        </dl>
                    </div>
                </div>
                <a href="#" class="link button button--orange offers-container-more">Подробнее</a>
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
