@extends("layouts.app")

@section("content")
    <div class="page-inner page-inner--w4">
        <div class="blog blog-detail">
            <div class="page-text">
                <h1>{{ $pageTitle }}</h1>
                <div class="blog-group">
                    <div class="blog-data">{{ $blogItem->date }}</div>
                    <div class="blog-views {{ $blogItem->views > 0 ? 'active' :'' }}">
                        <span class="blog-views-icon">
                            <?php include("svg/views.svg"); ?>
                        </span>
                        <span class="blog-views-count">{{ $blogItem->views }}</span>
                        </div>
                    <div data-rating data-rating-value="{{ $blogItem->rating }}" data-rating-read="true" class="blog-rating"></div>
                </div>
                <div class="blog-holder">
                    @if (isset($blogItem->preview_picture))
                        <img src="{{ $blogItem->preview_picture }}" class="blog-img">
                    @endif
                </div>
                <div class="blog-text">
                    {!! $blogItem->detail_text !!}
                </div>
                <div class="blog-tags">
                    <a href="#" class="link link--opacity blog-tag">Налоги</a>
                    <a href="#" class="link link--opacity blog-tag">Пенсионеры</a>
                    <a href="#" class="link link--opacity blog-tag">Законодательство</a>
                </div>
                <div class="blog-actions">
                    <div class="blog-share">
                    <div class="blog-share-title">Поделиться:</div>
                    <div class="blog-share-items">
                        <a href="https://vk.com/share.php?url=http://wemakesites.ru/projects/sunsochi/" target="_blank" class="link blog-share-item">
                            <svg data-name="Слой 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 99.33 100"><defs><clipPath><path fill="none" d="M1.67 2h96v96h-96z"/></clipPath></defs><g clip-path="url(#a)"><path d="M11.08 2h77.17a9.45 9.45 0 0 1 9.42 9.41v77.18A9.45 9.45 0 0 1 88.25 98H11.08a9.44 9.44 0 0 1-9.41-9.41V11.41A9.44 9.44 0 0 1 11.08 2zm61.11 67.1h7c2 0 3-1 2.43-3s-2.91-4.85-5.93-8.25c-1.64-1.93-4.1-4-4.85-5.06-1-1.35-.74-1.94 0-3.14 0 0 8.58-12.07 9.47-16.17.45-1.49 0-2.59-2.13-2.59h-7a3.06 3.06 0 0 0-3.07 2s-3.57 8.72-8.64 14.39c-1.64 1.64-2.39 2.16-3.28 2.16-.45 0-1.1-.52-1.1-2V33.49c0-1.79-.52-2.59-2-2.59H42a1.7 1.7 0 0 0-1.79 1.62c0 1.69 2.54 2.09 2.8 6.86v10.36c0 2.27-.41 2.68-1.31 2.68-2.38 0-8.18-8.76-11.62-18.78-.68-1.95-1.36-2.74-3.15-2.74h-7c-2 0-2.41 1-2.41 2 0 1.86 2.38 11.11 11.1 23.33 5.82 8.35 14 12.88 21.47 12.88 4.47 0 5-1 5-2.74v-6.32c0-2 .43-2.41 1.84-2.41 1.05 0 2.84.52 7 4.55 4.79 4.81 5.58 6.91 8.26 6.91z" fill="#fff"/></g></svg>
                        </a>
                        <a href="https://www.facebook.com/sharer/sharer.php?u=http://wemakesites.ru/projects/sunsochi/" target="_blank" class="link blog-share-item"><svg data-name="Слой 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 102.5 98.5"><path d="M99.25 17.25c0-8.41-7.59-16-16-16h-64c-8.41 0-16 7.59-16 16v64c0 8.41 7.59 16 16 16h32V61H39.52V45h11.73v-6.25c0-10.75 8.07-20.43 18-20.43h12.93v16H69.25c-1.42 0-3.07 1.72-3.07 4.29V45h16v16h-16v36.25h17.07c8.41 0 16-7.59 16-16z" fill="#fff" fill-opacity=".54"/></svg></a></div>
                    </div>
                    <div class="blog-estimate">
                        <div class="blog-estimate-title">Поставить оценку:</div>
                        <div data-rating data-rating-value="3" class="blog-rating"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div style="background:#f7f8fb" class="page-inner page-inner--max">
        <div class="page-inner page-inner--w1">
            <div class="blog blog-offers">
                <div class="page-text">
                    <h2>Почитать еще на эту тему</h2>
                </div>
                <div class="blog-list">
                    <div class="blog-item">
                        <a href="#" class="link link-black blog-link">
                            <div class="link blog-holder"><img src="../dummy/blog/2.png" class="blog-img"></div>
                            <div class="link link-black link--orange blog-title">Как взять ипотеку ИП</div></a>
                            <div class="blog-group">
                                <div class="blog-data">14 марта 2018</div>
                                <div class="blog-views active">
                                    <span class="blog-views-icon">
                                        <svg data-name="Слой 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 132 76.05"><defs><clipPath><path fill="none" d="M-720.06-4284.1h4367V9400.49h-4367z"/></clipPath></defs><g clip-path="url(#a)"><path d="M6.45 37.53C17 17.42 39.7 3.5 66 3.5s49 13.92 59.55 34C115 57.65 92.31 71.55 66 71.55S17 57.65 6.45 37.53zm39.7 0A19.85 19.85 0 1 0 66 17.68a19.85 19.85 0 0 0-19.85 19.85z" fill="#eceded"/></g></svg>
                                    </span>
                                    <span class="blog-views-count">203</span>
                                </div>
                                <div data-rating data-rating-value="3" data-rating-read="true" class="blog-rating"></div>
                            </div>
                            <div class="blog-text">Для многих индивидуальных предпринимателей ипотечное кредитование – единственная возможность выгодно для себя приобрести жилую или коммерческую недвижимость. </div>
                            <div class="blog-tags">
                                <a href="#" class="link link--opacity blog-tag">Кредит</a>
                                <a href="#" class="link link--opacity blog-tag">Индивидуальный предприниматель</a>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div style="background:#009ecc" class="page-inner page-inner--max">
        <div class="page-inner page-inner--w1">
            <div class="order-sub">
                <div class="page-text">
                    <h2>Быть в курсе – просто. <br>Подпишитесь!</h2>
                </div>
                <form class="form form-order-sub">
                    <div class="form-row form-row--100">
                        <input type="email" id="name" name="name" required data-error="Укажите Ваш e-mail" aria-required="true" placeholder="Укажите e-mail" class="form-item form-item--text">
                    </div>
                    <div class="form-row form-row--100">
                        <div class="order-call-privacy">Нажимая на кнопку "Отправить заявку", вы даете&nbsp;<a href="#" class="link link-white link--opacity">&ensp;согласие на обработку своих персональных данных</a></div>
                    </div>
                    <div class="form-row form-row--100">
                        <button type="submit" class="button button--orange-flood send-order">Подписаться на блог</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
