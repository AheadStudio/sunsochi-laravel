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
                                <?php include("svg/vk.svg"); ?>
                            </a>
                            <a href="https://www.facebook.com/sharer/sharer.php?u=http://wemakesites.ru/projects/sunsochi/" target="_blank" class="link blog-share-item">
                                <?php include("svg/fb.svg"); ?>
                            </a>
                        </div>
                    </div>
                    <div class="blog-estimate">
                        <div class="blog-estimate-title">Поставить оценку:</div>
                        <div data-rating data-rating-value="{{$blogItem->rating}}" data-rating-read="false" data-rating-params='{"voted" : "{{ $blogItem->voted }}", "summ" : "{{ $blogItem->summ_rating }}", "code": "{{ $blogItem->code }}"}' class="blog-rating"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if ($blogItemSimilar->isNotEmpty())
        <div style="background:#f7f8fb" class="page-inner page-inner--max">
            <div class="page-inner page-inner--w1">
                <div class="blog blog-offers">
                    <div class="page-text">
                        <h2>Почитать еще на эту тему</h2>
                    </div>
                    <div class="blog-list">
                        @foreach ($blogItemSimilar as $valBlogSimilar)
                            <div class="blog-item">
                                <a href="{{ route("BlogShow", $valBlogSimilar->code) }}" class="link link-black blog-link">
                                    <div class="link blog-holder"><img src="{{ $valBlogSimilar->preview_picture }}" class="blog-img"></div>
                                    <div class="link link-black link--orange blog-title">{{ $valBlogSimilar->name }}</div>
                                </a>
                                <div class="blog-group">
                                    <div class="blog-data">{{ $valBlogSimilar->date }}</div>
                                    <div class="blog-views {{ $valBlogSimilar->views > 0 ? 'active' :'' }}">
                                        <span class="blog-views-icon">
                                            <?php include("svg/views.svg"); ?>
                                        </span>
                                        <span class="blog-views-count">{{ $valBlogSimilar->views }}</span>
                                    </div>
                                    <div data-rating data-rating-value="{{$valBlogSimilar->rating}}" data-rating-read="true" data-rating-params='{"voted" : "{{ $valBlogSimilar->voted }}", "summ" : "{{ $valBlogSimilar->summ_rating }}", "code": "{{ $valBlogSimilar->code }}"}' class="blog-rating"></div>
                                </div>
                                <div class="blog-text">{{ $valBlogSimilar->preview_text }}</div>
                                <div class="blog-tags">
                                    <a href="#" class="link link--opacity blog-tag">Кредит</a>
                                    <a href="#" class="link link--opacity blog-tag">Индивидуальный предприниматель</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endif
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
