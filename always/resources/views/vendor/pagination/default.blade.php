
<div class="pagelist">
    <span>共{{ $paginator->total() }}条</span>
    @if ($paginator->onFirstPage())
        <a href="#">&lt;</a>
    @else
        <a href="{{ $paginator->previousPageUrl() }}">&lt;</a>
    @endif
    @foreach ($elements as $element)
        {{-- "Three Dots" Separator --}}
        @if (is_string($element))
            <a disabled href="javascript:void(0)">{{ $element }}</a>
        @endif
        {{-- Array Of Links --}}
        @if (is_array($element))
            @foreach ($element as $page => $url)
                @if ($page == $paginator->currentPage())
                    <a class="active" href="javascript:void(0)">{{ $page }}</a>
                @else
                    <a href="{{ $url }}">{{ $page }}</a>
                @endif
            @endforeach
        @endif
    @endforeach
    @if ($paginator->hasMorePages())
        <a href="{{ $paginator->nextPageUrl() }}">&gt;</a>
    @else
        <a href="#">&gt;</a>
    @endif
</div>

