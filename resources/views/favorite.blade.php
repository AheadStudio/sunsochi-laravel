@extends("layouts.app")

@section("content")
    <div class="page-inner page-inner--w1">
        <div class="offers-favorite">
            @if (!empty((array) $offers))
                @component("components.offers", ["offersList" => $offers, "showFind" => $showFind, "countOffers" => $countOffers, "notShowAdd" => $notShowAdd])@endcomponent
            @else
                <div class="page-text">
                    <h1>Вы еще не добавили к себе в избранное</h1>
                </div>
            @endif
        </div>
    </div>
@endsection
