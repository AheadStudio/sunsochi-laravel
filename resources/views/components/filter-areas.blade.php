<form action="/catalog/uchastki/get/" method="get" class="form form-filter">
    <input type="hidden" name="section-name" value="uchastki">
    @if ($homePage == "Y")
        <input type="hidden" name="home-page" value="Y">
    @endif
    <div class="form-row">
        <div class="form-row-100">
            <div class="form-holder">
                <label class="form-label">
                    <input type="checkbox" name="see_sea" class="form-item form-item--checkbox"><span class="form-item-checkbox-title">Вид на море</span>
                </label>
                <label class="form-label">
                    <input type="checkbox" name="relief__AzLewKbt"class="form-item form-item--checkbox"><span class="form-item-checkbox-title">Ровный</span>
                </label>
            </div>
        </div>
    </div>
    <div class="form-row">
        <div class="form-row-50">
            <div class="form-item-title">Площадь участка</div>
            <div class="form-holder">
                <input type="range" multiple="" name="area" data-name-input="area" value="3,62" min="3" max="62" step="1" data-valfrom="" data-valto="" data-valtext="&amp;thinsp;сотки" class="form-item form-item--range">
            </div>
        </div>
        <div class="form-row-50">
            <div class="form-item-title">Цена</div>
            <div class="form-holder">
                <input type="range" multiple="" name="price" data-name-input="price" value="600000,70000000" min="600000" max="70000000" step="1000" data-valfrom="" data-valto="" data-valtext="&thinsp;<span class='rub'>i<span>" class="form-item form-item--range">
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
                <a href="#regions-container--1118" data-mfp-closeinside="true" data-mfp-closeonbcg="true" class="link link-black jcf-select-form-item--select mfp-modal"><span class="jcf-select-text"><span>Район</span></span><span class="jcf-select-opener"></span></a>
            </div>
        </div>
        <div class="form-row-50">
            <div class="form-holder">
                <input type="text" name="search" placeholder="Поиск по названию или улице" data-autocomplete-url="/api/catalog/list/" data-autocomplete="true" data-autocomplete-type="link" class="form-item form-item--text">
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
