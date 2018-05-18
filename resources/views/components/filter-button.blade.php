@php
    switch (substr((string)$countElements, -1)) {
        case "1":
            $strElementsCount = $countElements." объект недвижимости";
            break;
        case "2":
            $strElementsCount = $countElements." объекта недвижимости";
            break;
        case "3":
            $strElementsCount = $countElements." объекта недвижимости";
            break;
        case "4":
            $strElementsCount = $countElements." объекта недвижимости";
            break;
        default:
            $strElementsCount = $countElements." объектов недвижимости";
            break;
    }

@endphp
<button type="submit"  class="button button--orange-flood filter-submit">Показать {{ $strElementsCount }}</button>
