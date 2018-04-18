@extends("layouts.app")

@section("content")
    <div class="page-inner page-inner--w1">
        <div class="developers">
            <div class="page-text">
                <h1>{{ $pageTitle }}</h1>
                <div class="developer-info">
                    <img src="{{ $builderItem->logo }}" class="img img--left">
                    <div class="developer-info-text">
                        {!!html_entity_decode($builderItem->text)!!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div style="background:#f7f8fb" class="page-inner page-inner--max">
        <div class="developers-offers">
            <div class="page-inner page-inner--w1">
                <div class="page-text">
                    <h2>Объекты застройщика</h2>
                </div>
                @component("components.offers", ["offersList" => $builderOffers])@endcomponent
            </div>
        </div>
    </div>
@endsection
