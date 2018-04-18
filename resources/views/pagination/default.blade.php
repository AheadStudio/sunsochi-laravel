@if ($paginator->lastPage() > 1 && $paginator->currentPage() != $paginator->lastPage())
    <div class="{{ $class }}">
        <a href="{{ $paginator->url($paginator->currentPage()+1) }}" data-container="{{ $container }}" data-itemsselector="{{ $item }}" class="link button button--blue load-more">Показать еще</a>
    </div>
@endif
