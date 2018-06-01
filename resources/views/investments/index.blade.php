@extends("layouts.app")

@section("content")
    <div class="page-inner page-inner--max">
        <div class="intro"><img src="{{ $pageImage }}" class="intro-img">
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
        <div class="options">
            <div class="page-text">
                <h2>Выберите наиболее подходящий вариант</h2>
            </div>
            <div class="options-list options-list--3">
                <div class="options-item options-item--hover">
                    <div class="options-container">
                        <img src="../dummy/options/options_1.png" alt="" class="options-img"></div>
                    <div class="options-title">Перепродажа</div>
                    <div class="options-text">Вкладывайте деньги в недвижимость на этапе строительства и продавайте по выгодной цене на более поздних этапах готовности объекта или когда объект уже сдан.</div>
                    <a href="resale/" class="link button button--orange options-more">Подробнее</a>
                </div>
                <div class="options-item options-item--hover">
                    <div class="options-container">
                        <img src="../dummy/options/options_2.png" alt="" class="options-img"></div>
                    <div class="options-title">Аренда</div>
                    <div class="options-text">Получайте стабильный доход на сдаче недвижимости в аренду. Возможны варианты с краткосрочной и долгосрочной арендой. Отличный вариант пассивного дохода.</div>
                    <a href="lease/" class="link button button--orange options-more">Подробнее</a>
                </div>
                <div class="options-item options-item--hover">
                    <div class="options-container">
                        <img src="../dummy/options/options_3.png" alt="" class="options-img"></div>
                    <div class="options-title">Строительство</div>
                    <div class="options-text">Для тех, кто готов подождать ради максимальной отдачи инвестиций. Ваши деньги обернутся при строительстве коттеджного поселка и принесут от 200% чистой прибыли.</div>
                    <a href="building/" class="link button button--orange options-more">Подробнее</a>
                </div>
            </div>
        </div>
    </div>

    <div style="background:#f7f8fb" class="page-inner page-inner--max">
        <div class="page-inner page-inner--w1">
            <div class="investments-info">
                <div class="page-text">
                    <h2>Инвестиции в недвижимость Сочи - альтернативный вариант обычным вложениям</h2><img src="../dummy/sochi_3.jpg" class="img img-w50 img--right">
                    <p>Сейчас все больше людей выбирают вклады в недвижимость, как выгодный и безопасный вид инвестирования. Доходность таких инвестиций зависит от многих факторов, в том числе от этапа строительства объекта недвижимости, его стоимости и, конечно, расположения. Есть много хороших вариантов для покупки недвижимости, но среди всех особняком стоит недвижимость в Сочи. За последние годы город-курорт Сочи стал настоящим хитом по продажам недвижимости и по праву может считаться    наиболее востребованным в плане инвестиций городом.</p>
                    <div class="options-list options-list--3">
                        <div class="options-item">
                            <div class="options-container">
                                <div class="options-icon">
                                    <?php include("svg/check.svg"); ?>
                                </div>
                            </div>
                            <div class="options-title">Постоянно развивающаяся инфраструктура города</div>
                            <div class="options-text">За последние 5 лет город сильно изменился. Были построены современные объекты инфраструктуры, дорожные развязки, социально-значимые объекты. Город привлекает все больше туристов и развивается стремительными темпами.</div>
                        </div>
                        <div class="options-item">
                            <div class="options-container">
                                <div class="options-icon">
                                    <?php include("svg/check.svg"); ?>
                                </div>
                            </div>
                            <div class="options-title">Высокие темпы роста цен на недвижимость в Сочи</div>
                            <div class="options-text">Для некоторых объектов наблюдается рост стоимости до 50% в год. Если грамотно подойти к вопросу и получить проверенную информацию по объектам у специалистов, то инвестиция может быть не только надежной, но и сверхприбыльной.</div>
                        </div>
                        <div class="options-item">
                            <div class="options-container">
                                <div class="options-icon">
                                    <?php include("svg/check.svg"); ?>
                                </div>
                            </div>
                            <div class="options-title">Недвижимость в городе у моря всегда будет в цене</div>
                            <div class="options-text">Знал бы прикуп - жил бы в Сочи. Желание жить на черноморском побережье было, есть и будет. Количество желающих купить недвижимость в Сочи с каждым годом только растет.</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @component("components.form-specialorder")@endcomponent

@endsection
