{{--
    Pagination Bootstrap 5 berbahasa Indonesia untuk panel admin.
    Dipakai lewat $paginator->links('admin.partials.pagination'); parameter
    filter tetap terbawa karena kueri memanggil withQueryString().
--}}
<nav class="d-flex flex-wrap align-items-center justify-content-between gap-2" aria-label="Navigasi halaman">
    <small class="text-body-secondary">
        @if ($paginator->total() > 0)
            Menampilkan {{ $paginator->firstItem() }}&ndash;{{ $paginator->lastItem() }}
            dari {{ $paginator->total() }} data
        @else
            Tidak ada data
        @endif
    </small>

    @if ($paginator->hasPages())
        <ul class="pagination pagination-sm mb-0">
            @if ($paginator->onFirstPage())
                <li class="page-item disabled" aria-disabled="true"><span class="page-link">&lsaquo; Sebelumnya</span></li>
            @else
                <li class="page-item"><a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">&lsaquo; Sebelumnya</a></li>
            @endif

            @foreach ($elements as $element)
                @if (is_string($element))
                    <li class="page-item disabled" aria-disabled="true"><span class="page-link">{{ $element }}</span></li>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active" aria-current="page"><span class="page-link">{{ $page }}</span></li>
                        @else
                            <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            @if ($paginator->hasMorePages())
                <li class="page-item"><a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">Berikutnya &rsaquo;</a></li>
            @else
                <li class="page-item disabled" aria-disabled="true"><span class="page-link">Berikutnya &rsaquo;</span></li>
            @endif
        </ul>
    @endif
</nav>
