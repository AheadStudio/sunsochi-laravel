@extends("layouts.app404")

@section("content")
    <div class="page-inner page-inner--w4">
        <div class="page-text">
            <div class="page-404">
                <a href="/" class="link page-404-logo">
                    @php include("svg/logo.svg"); @endphp
                </a>
            <div class="page-404-desc">Вся жилая и коммерческая недвижимость в Сочи <br>с помощью выбора и оформления</div>
            <div class="page-404-icon">
                @php include("svg/404.svg"); @endphp
            </div>
            <h1 class="page-404-title">404-ошибка</h1>
            <div class="page-404-back">Страница не найдена или удалена.<br>
                <a href="/" class="link link-black link-black--bottom">Вернуться на главную</a>
            </div>
            <div class="page-404-copyrights">&#169; SunSochi.com - Недвижимость в Сочи.</div>
            </div>
        </div>
    </div>
@endsection
