@if ($projects->lastPage() > 1)
    <ul class="pagination">
    @for ($i = 1; $i <= $projects->lastPage(); $i++)

            <li class="page-item">
                <a href="{{ $projects->url($i) }}"
                   class="p-3 page-dir @if($i == 1) active @endif">
                    {{ $i }}
                </a>
            </li>
        @endfor
    </ul>
@endif
