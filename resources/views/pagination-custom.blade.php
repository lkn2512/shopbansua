<style>
    .custom-pagination {
        display: flex;
        justify-content: center;
        list-style: none;
    }

    .custom-pagination a,
    .custom-pagination span {
        padding: 8px 14px;
        margin: 0 5px;
        text-decoration: none;
        border: 1px solid rgb(200, 200, 200);
        border-radius: 0px;
        color: black;
        text-align: center;
    }

    .custom-pagination a:hover {
        background-color: rgb(223, 223, 223);
    }

    .custom-pagination .active {
        background-color: #103667;
        color: white;
        border: 1px solid #103667;
    }
</style>
@if ($paginator->hasPages())
    <div class="custom-pagination">
        {{-- First Page Link --}}
        {{-- @if ($paginator->onFirstPage())
            <span class="disabled"><i class="fa-solid fa-angle-double-left"></i> Đầu</span>
        @else
            <a href="{{ $paginator->url(1) }}" rel="first"><i class="fa-solid fa-angle-double-left"></i> Đầu</a>
        @endif --}}
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span class="disabled"><i class="fa-solid fa-chevron-left"></i></span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev"><i class="fa-solid fa-chevron-left"></i>
            </a>
        @endif
        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <span class="disabled">{{ $element }}</span>
            @endif
            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="active">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next"><i class="fa-solid fa-chevron-right"></i></a>
        @else
            <span class="disabled"><i class="fa-solid fa-chevron-right"></i></span>
        @endif
        {{-- Last Page Link --}}
        {{-- @if ($paginator->hasMorePages())
            <a href="{{ $paginator->url($paginator->lastPage()) }}" rel="last">Cuối <i
                    class="fa-solid fa-angle-double-right"></i></a>
        @else
            <span class="disabled">Cuối <i class="fa-solid fa-angle-double-right"></i></span>
        @endif --}}
    </div>
@endif
