@if ($paginator->hasPages())
    <div class="text-center">
        <ul class='page-numbers'>
            @if ($paginator->onFirstPage())
            @else
                <li><a class="page-numbers" href="{{ $paginator->previousPageUrl() }}">
                        <i class="fa fa-arrow-left"></i></a>
                </li>
            @endif

            @foreach ($elements as $element)
                @if (is_string($element))
                    <li><span aria-current="page" class="page-numbers disabled">{{ $element }}</span></li>
                @endif
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li><span aria-current="page" class="page-numbers current">{{ $page }}</span></li>
                        @else
                            <li><a class="page-numbers" href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            @if ($paginator->hasMorePages())
                <li><a class="next page-numbers" href="{{ $paginator->nextPageUrl() }}"><i
                            class="fa fa-arrow-right"></i></a></li>
            @else
            @endif
            @if ($paginator->currentPage() < $paginator->lastPage() - 3 && $page === $paginator->lastPage() - 1)
                <li><span class="page-numbers dots">&hellip;</span></li>
            @endif
        </ul>
    </div>
@endif
