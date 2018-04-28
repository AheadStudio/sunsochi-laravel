@extends("layouts.app")

@section("content")
    <div class="page-inner page-inner--w4">
        <div class="news-detail">
            <div class="page-text">
                <div id="news-detail-load" class="new-detail-info">
                    <a href="{{ url()->previous() }}" class="link link-black link-black--bottom back">Назад</a>
                    <h1>{{ $pageTitle }}</h1>
                    <div class="news-detail-date">{{ $newsItem->date }}</div>
                    {!!html_entity_decode($newsItem->detail_text)!!}
                </div>
            </div>
        </div>
    </div>
@endsection
