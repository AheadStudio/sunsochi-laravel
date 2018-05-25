<form action="/catalog/kvartiry/get/" method="get" class="form form-filter">
    <input type="hidden" name="section-name" value="kvartiry">
    @if ($homePage == "Y")
        <input type="hidden" name="home-page" value="Y">
    @endif
    <div class="form-row">
        <div class="form-row-100">
            <div class="form-holder">
                <div class="checkbox-list-container">
                    <div class="checkbox-list-container-title">Планировка</div>
                    <label class="form-label">
                        <input type="checkbox" name="number_rooms__K3Jv9mqH" class="form-item form-item--checkbox"><span class="form-item-checkbox-title">1</span>
                    </label>
                    <label class="form-label">
                        <input type="checkbox" name="number_rooms__Yd7KYN6z" class="form-item form-item--checkbox"><span class="form-item-checkbox-title">2</span>
                    </label>
                    <label class="form-label">
                        <input type="checkbox" name="number_rooms__voIib7mE" class="form-item form-item--checkbox"><span class="form-item-checkbox-title">3</span>
                    </label>
                    <label class="form-label">
                        <input type="checkbox" name="number_rooms__UFLXijyc" class="form-item form-item--checkbox"><span class="form-item-checkbox-title">4+</span>
                    </label>
                    <label class="form-label">
                        <input type="checkbox" name="number_rooms__NPoaYeHE" class="form-item form-item--checkbox"><span class="form-item-checkbox-title">Студия</span>
                    </label>
                </div>
                <label class="form-label">
                    <input type="checkbox" name="decoration__T6ZqlhAt" class="form-item form-item--checkbox"><span class="form-item-checkbox-title">С ремонтом</span>
                </label>
            </div>
        </div>
    </div>
    <div class="form-row">
        <div class="form-row-50">
            <div class="form-item-title">Площадь</div>
            <div class="form-holder">
                <input type="range" multiple="" name="area" data-name-input="area" value="18,415" min="18" max="415" step="2" data-valfrom="" data-valto="" data-valtext="&amp;thinsp; м&lt;sup&gt;2&lt;/sup&gt;" class="form-item form-item--range">
            </div>
        </div>
        <div class="form-row-50">
            <div class="form-item-title">Цена</div>
            <div class="form-holder">
                <input type="range" multiple="" name="price" data-name-input="price" value="1910000,150000000" min="1910000" max="150000000" step="1000" data-valfrom="" data-valto="" data-valtext="<span class='rub'>i</span>" class="form-item form-item--range">
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
                <a href="#regions-container--2" data-mfp-closeinside="true" data-mfp-closeonbcg="true" class="link link-black jcf-select-form-item--select mfp-modal"><span class="jcf-select-text"><span>Район</span></span><span class="jcf-select-opener"></span></a>
            </div>
        </div>
        <div class="form-row-50">
            <div class="form-holder">
                <input type="text" name="search" placeholder="Поиск по названию или улице" data-autocomplete-url="/api/catalog/list/" data-autocomplete="true" data-autocomplete-type="link" class="form-item form-item--text">
                <button type="button" class="form-filter-search">
                    <span class="form-filter-search-icon">
                        <?php include("svg/loupe.svg");?>
                    </span>
                </button>
            </div>
        </div>
    </div>
    <div class="filter-selected-regions-list"></div>
    <button type="submit" class="button button--orange-flood filter-submit">Показать</button>
</form>
