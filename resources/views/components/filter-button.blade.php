@php
    switch ($countElements) {
        case 1:
            $strElementsCount = $countElements." элемент";
            break;
        case 2:
            $strElementsCount = $countElements." элемента";
            break;
        case 3:
            $strElementsCount = $countElements." элемента";
            break;
        case 4:
            $strElementsCount = $countElements." элемента";
            break;
        default:
            $strElementsCount = $countElements." элементов";
            break;
    }

@endphp
<button type="submit"  class="button button--orange-flood filter-submit">Показать {{ $strElementsCount }}</button>
