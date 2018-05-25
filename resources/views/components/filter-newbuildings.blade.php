<form action="/catalog/novostrojki/get/" method="get" class="form form-filter">
    <input type="hidden" name="section-name" value="novostrojki">
    @if ($homePage == "Y")
        <input type="hidden" name="home-page" value="Y">
    @endif
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
                <input type="range" multiple="" name="area_ap" data-name-input="area" value="20,650" min="20" max="650" step="10" data-valfrom="" data-valto="" data-valtext="&amp;thinsp;м&lt;sup&gt;2&lt;/sup&gt;" class="form-item form-item--range">
            </div>
        </div>
        <div class="form-row-50">
            <div class="form-item-title">Цена</div>
            <div class="form-holder">
                <input type="range" multiple="" name="price_ap" data-name-input="price" value="800000,180000000" min="800000" max="180000000" step="1000" data-valfrom="" data-valto="" data-valtext="<span class='rub'>i</span>" class="form-item form-item--range">
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
                        <button type="button" class="button button--blue regions-show">Выбрать</button>
                    </div>
                </div>
                <a href="#regions-container--1" data-mfp-closeinside="true" data-mfp-closeonbcg="true" class="link link-black jcf-select-form-item--select mfp-modal"><span class="jcf-select-text"><span>Район</span></span><span class="jcf-select-opener"></span></a>
            </div>
        </div>
        <div class="form-row-50">
            <div class="form-holder">
                <input type="text" name="search" placeholder="Поиск по названию или улице" data-autocomplete-url="/api/catalog/list/" data-autocomplete="true" data-autocomplete-type="link" class="form-item form-item--text">
                <button type="button" class="form-filter-search">
                    <span class="form-filter-search-icon">
                        <?php include("svg/loupe.svg") ?>
                    </span>
                </button>
            </div>
        </div>
    </div>
    <div class="filter-selected-regions-list"></div>
    <button type="submit" class="button button--orange-flood filter-submit">Показать</button>
</form>
