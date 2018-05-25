@extends("layouts.app")

@section("content")
    <div class="page-inner page-inner--w1">
        <div class="about">
            <div class="page-text">
                <h1>{{ $pageTitle }}</h1>
                <div class="page-inner page-inner--w4">
                    <p>Компания “Солнечный Сочи” занимается экспертным подбором недвижимости любых типов в городе-курорте Сочи, организовывая не только полное сопровождение сделки, но и предлагая инвестиционные проекты “под ключ”.</p>
                    <p>Компания постоянно развивается, следуя современным тенденциям и технологиям. Каждый клиент представляет для компании большую ценность, что проявляется в качественной индивидуальной работе под каждого желающего приобрести недвижимость в лучшем курорте России - Сочи. Компания “Солнечный Сочи” отличается выстраиванием прозрачных отношений с клиентами и партнерами. Основной упор делается не на увеличение числа сотрудников, а на рост экспертности и знания рынка недвижимости у каждого работающего в компании. Экспертами компании “Солнечный Сочи” организовывается индивидуальная дистанционная работа под каждого клиента, высококомфортабельный сервис и полное юридической сопровождение сделки.</p>
                </div>
            </div>
        </div>
    </div>

    <div style="background:#f7f8fb" class="page-inner page-inner--max">
        <div class="about-info">
            <div class="page-inner page-inner--w1">
                <div class="page-text">
                    <h2>Компания &#171;Солнечный Сочи&#187; - это</h2>
                    <div data-movesetting="{&quot;speed&quot;:&quot;1000&quot;, &quot;margin&quot;: &quot;50&quot;}" data-moveitems=".about-info-item" class="about-info-container">
                        <div class="about-info-item">
                            <div data-animate-number-step="1" data-animate-number="1" class="about-info-title">1</div>
                            <div class="about-info-text">первый многофункциональный сайт <br>по недвижимости в России</div>
                        </div>
                        <div class="about-info-item">
                            <div data-animate-number-step="1" data-animate-number="30" class="about-info-title">30</div>
                            <div class="about-info-text">квалифицированных <br>экспертов <br>по недвижимости</div>
                        </div>
                        <div class="about-info-item">
                            <div data-animate-number-step="1" data-animate-number="5" class="about-info-title">5</div>
                            <div class="about-info-text">лет на рынке <br>недвижимости Сочи</div>
                        </div>
                        <div class="about-info-item">
                            <div data-animate-number-step="3" data-animate-number="99" data-percent="%" class="about-info-title">99%</div>
                            <div class="about-info-text">застройщиков - наши <br>партнеры</div>
                        </div>
                        <div class="about-info-item">
                            <div data-animate-number-step="1" data-animate-number="47" class="about-info-title">47</div>
                            <div class="about-info-text">среднее число показов <br>объектов в день</div>
                        </div>
                        <div class="about-info-item">
                            <div data-animate-number-step="6" data-animate-number="106" class="about-info-title">106</div>
                            <div class="about-info-text">среднее число <br>консультаций в сутки</div>
                        </div>
                        <div class="about-info-item">
                            <div data-animate-number-step="100" data-animate-number="2500" class="about-info-title">2500</div>
                            <div class="about-info-text">объектов недвижимости <br>в базе</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="page-inner page-inner--max">
        <div class="about-home">
            <div class="page-inner page-inner--w1">
                <div class="page-text">
                    <h2>О нас за 100 секунд</h2>
                </div>
                <div class="about-video">
                    <div style="background-image: url(/dummy/youtube/preview_youtube.png)" class="fake-preview">
                        <a href="https://www.youtube.com/watch?v=4zGIoURvzsQ" data-mfp-type="iframe" data-mfp-bcg="rgba(0, 158, 204, 0.9)" data-mfp-closeinside="false" data-mfp-closeonbcg="true" class="link fake-preview-link mfp-modal"></a>
                        <span class="fake-preview-icon">
                            <svg data-name="Слой 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 358 350"><path d="M179 345A170 170 0 1 0 9 175a170 170 0 0 0 170 170z" fill="none" stroke="#fff" stroke-width="2"/><path d="M141.5 259.4a12.49 12.49 0 0 1-12.4-12.5V109.5a12.47 12.47 0 0 1 6.2-10.8 12.66 12.66 0 0 1 12.5 0l119.1 68.7a12.27 12.27 0 0 1 6.2 10.8 12.47 12.47 0 0 1-6.2 10.8l-119.1 68.7a12.2 12.2 0 0 1-6.3 1.7" fill="#fff"/></svg>
                        </span>
                    </div>
                <!--iframe(frameborder="0", height="100%", width="100%", src="https://www.youtube.com/embed/4zGIoURvzsQ?rel=0&controls=0&showinfo=0", allow="autoplay; encrypted-media", allowfullscreen)-->
                </div>
            </div>
        </div>
    </div>
@endsection
