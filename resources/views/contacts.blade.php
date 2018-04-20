@extends("layouts.app")

@section("content")
    <div class="page-inner page-inner--w1">
        <div class="contacts">
            <div class="page-text">
                <h1>Контакты</h1>
            </div>
            <div class="contacts-holder"><img src="../dummy/contacts.jpg" class="contacts-img"></div>
            <div itemscope itemtype="http://schema.org/Organization" class="contacts-container">
                <div class="contacts-item">
                    <div class="contacts-title">Офис</div>
                    <p><a href="yandexnavi://build_route_on_map?lat_to=43.60405218&amp;lon_to=39.73541935" itemprop="addressLocality" class="link link-black contacts-location">г. Сочи, ул. Пластунская, 81, 3 этаж, офис 17 </a></p>
                    <p><a href="tel:+78007075523" itemprop="telephone" class="link link-black link--orange contacts-mobile">8-800-707-55-23</a></p>
                    <p><a href="mailto:info@sunsochi.com" itemprop="email" class="link link-black link-black--bottom-inverse contacts-mail">info@sunsochi.com </a></p>
                </div>
                <div itemprop="address" itemscope itemtype="http://schema.org/PostalAddress" class="contacts-item">
                    <div class="contacts-title">Реквизиты</div>
                    <p>Общество с Ограниченной Ответсвенностью </p>
                    <p itemprop="name">«СОЛНЕЧНЫЙ СОЧИ» </p>
                    <p>ИНН: 2320240206 КПП: 232001001 </p>
                    <p>Адрес: <span itemprop="postalCode">354000, </span><span itemprop="addressLocality">г. Сочи, </span><span itemprop="streetAddress">ул. Пластунская, 81, офис 17</span></p>
                    <p>Р/сч: 40702810730060002826, </p>
                    <p>ЮГО-ЗАПАДНЫЙ БАНК ПАО СБЕРБАНК</p>
                </div>
            </div>
        </div>
    </div>
    <div class="page-inner page-inner--max">
        <div class="contacts">
            <div class="map-container">
                <div id="mapYandex" data-center="[{{ $mapPoint }}]" data-zoom="18" data-points='[{name:"1", position: "{{ $mapPoint }}", icon: "../svg/point_map.svg", iconW: 55, iconH: 85, description:"Сочи, ул. Пластунская, 81, 3 этаж, офис 17"}]' class="map"></div>
            </div>
        </div>
    </div>
@endsection
