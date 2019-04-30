@if ($paginator->lastPage() > 1)
    <ul class="pagination">
        @for ($i = 1; $i <= $paginator->lastPage(); $i++)
            <li class="{{ ($paginator->currentPage() == $i) ? ' active' : '' }}">
                <a href="{{ $paginator->url($i) }}"
                   class="p-3">
                    {{ $i }}
                </a>
            </li>
        @endfor
    </ul>
@endif
