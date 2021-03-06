@extends("layouts.app")

@section("content")
    <div class="page-inner page-inner--w1">
        <div class="developers">
            <div class="page-text">
                <h1>{{ $pageTitle }}</h1>
                <div class="developer-info">
                    @if (isset($builderItem->logo) && $builderItem->logo != "")
                        <img src="{{ $builderItem->logo }}" class="img img--left">
                    @endif
                    <div class="developer-info-text">
                        @php
                            echo html_entity_decode($builderItem->text);
                        @endphp
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if (!$builderOffers->isEmpty())
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
    @endif
@endsection
