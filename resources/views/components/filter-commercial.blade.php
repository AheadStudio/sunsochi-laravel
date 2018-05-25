<form action="/catalog/kommercheskaya_nedvizhimost/get/" method="get" class="form form-filter">
    <input type="hidden" name="section-name" value="kommercheskaya_nedvizhimost">
    @if ($homePage == "Y")
        <input type="hidden" name="home-page" value="Y">
    @endif
    <div class="form-row">
        <div class="form-row-50">
            <div class="form-holder">
                <div id="regions-container--18" class="regions-container white-popup mfp-hide">
                    <div class="regions-container-list">
                        <div class="regions-title">Назначение объекта</div>
                        <ul>
                            @foreach ($predestination as $valPredestination)
                                <li name="predestination__{{ $valPredestination->code }}">
                                    <span class="regions-text">{{ $valPredestination->name }}</span>
                                    <div class="regions-close"></div>
                                </li>
                            @endforeach
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
                    <input type="checkbox" name="see_sea" class="form-item form-item--checkbox"><span class="form-item-checkbox-title">Вид на море</span>
                </label>
                <label class="form-label">
                    <input type="checkbox" name="relief__AzLewKbt" class="form-item form-item--checkbox"><span class="form-item-checkbox-title">Ровный</span>
                </label>
            </div>
        </div>
    </div>
    <div class="form-row">
        <div class="form-row-50">
            <div class="form-item-title">Площадь участка</div>
            <div class="form-holder">
                <input type="range" multiple="" name="area" data-name-input="area" value="32,650" min="32" max="650" step="2" data-valfrom="" data-valto="" data-valtext="&amp;thinsp; м&lt;sup&gt;2&lt;/sup&gt;" class="form-item form-item--range">
            </div>
        </div>
        <div class="form-row-50">
            <div class="form-item-title">Цена</div>
            <div class="form-holder">
                <input type="range" multiple="" name="price" data-name-input="price" value="5980160,180000000" min="5980160" max="180000000" step="10" data-valfrom="" data-valto="" data-valtext="<span class='rub'>i</span>" class="form-item form-item--range">
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
                            @foreach ($district as $keyDistrict => $valDistrict)
                                <li name="district__{{ $valDistrict->code }}">
                                    <span class="regions-text">{{ $valDistrict->name }}</span>
                                    <div class="regions-close"></div>
                                </li>
                            @endforeach
                        </ul>
                        <button type="button" class="button button--blue regions-show">Выбрать</button>
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
    <button type="submit" class="button button--orange-flood filter-submit">Показать</button>
</form>
