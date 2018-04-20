@extends("layouts.app")

@section("content")
    <div class="page-inner page-inner--w1">
        <div class="vacancies">
            <div class="page-text">
                <h1>{{ $pageTitle }}</h1>
                <div class="page-subtitle">{{ $pageSubtitle }}</div>
            </div>
            <div class="vacancies-container">
                <div class="vacancies-list">
                    <div class="vacancies-item">
                            <div class="vacancies-item-title">Эксперт по недвижимости</div>
                            <div class="vacancies-item-subtitle">Должностные обязанности:</div>
                            <div class="page-text">
                                <ul>
                                    <li>Работа с впервые обратившимся клиентами.</li>
                                    <li>Презентация риторский услуги.</li>
                                    <li>Деловые переговоры с собственнками, покупателями недвижимости и контрагентами.</li>
                                    <li>Заключение договоров на оказание риелторских услуг</li>
                                    <li>Подбор и презентация объектов недвижимости.</li>
                                    <li>Сопровождение сделок покупки-продажи.</li>
                                    <li>Поддержание и расширение клиентской базы.</li>
                                    <li>Активный поиск объектов и клиентов.</li>
                                    <li>Сбор и оформление документов, связанных со сделкой.</li>
                                    <li>Активный посик объектов иклиентов.</li>
                                    <li>Сбор и оформление документов, связанных со сделкой.</li>
                                    <li>Выезды на объекты, консультации по недвижимости, по ипотечному кредитованию, покупки, продажи, альтернативы, срочного выкупа.</li>
                                </ul>
                            </div>
                            <div class="vacancies-item-subtitle">Требования:</div>
                            <div class="page-text">
                                <ul>
                                    <li>Коммуникабельность</li>
                                    <li>Настойчивость, ответсвенность, целеустремленность</li>
                                    <li>Нацеленность на результат</li>
                                </ul>
                            </div>
                            <div class="vacancies-item-subtitle">Услования:</div>
                            <div class="page-text">
                                <ul>
                                    <li>До 60% от каждой сделки</li>
                                    <li>Безлимитную мобильную связь</li>
                                    <li>Система поощрений</li>
                                    <li>Комфортный офис в центре Москвы</li>
                                    <li>Полный рабочий день</li>
                                    <li>На территории работтодателя</li>
                                </ul>
                            </div>
                            <div class="vacancies-item-subtitle">Зарплата:</div>
                            <div class="page-text">
                                <ul>
                                    <li>От 60 000 до 150 000 руб</li>
                                </ul>
                            </div>
                            <a href="form-bid.html" data-mfp-type="ajax" data-mfp-ajaxcontent="#form-call" data-mfp-bcg="#009ecc" data-mfp-closeinside="false" class="link button button--orange-flood vacancies-link mfp-modal">Откликнуться на вакансию</a>
                        </div>
                    </div>
                <div class="vacancies-contacts">
                    <div data-sticky data-sticky-offset-top="100">
                        <div class="vacancies-subtitle">Контакты</div>
                        <a href="tel:+78007075523" class="link link--orange vacancies-link">8-800-707-55-23</a>
                        <a href="mailto:info@sunsochi.com" class="link link-black--bottom vacancies-link">info@sunsochi.com</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
