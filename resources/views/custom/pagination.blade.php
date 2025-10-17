@if ($paginator->hasPages())
<nav style="display: flex; justify-content: center; align-items: center; gap: 8px; margin-top: 24px;">
    @if ($paginator->onFirstPage())
        <span style="padding: 8px 12px; color: var(--gemini-text-secondary); cursor: not-allowed;">
            <i class="fas fa-chevron-left"></i> Oldingi
        </span>
    @else
        <a href="{{ $paginator->previousPageUrl() }}" style="padding: 8px 12px; background: var(--gemini-surface); border: 1px solid var(--gemini-border); border-radius: 6px; color: var(--gemini-text); text-decoration: none;">
            <i class="fas fa-chevron-left"></i> Oldingi
        </a>
    @endif

    @foreach ($elements as $element)
        @if (is_string($element))
            <span style="padding: 8px 12px; color: var(--gemini-text-secondary);">{{ $element }}</span>
        @endif

        @if (is_array($element))
            @foreach ($element as $page => $url)
                @if ($page == $paginator->currentPage())
                    <span style="padding: 8px 12px; background: var(--gemini-blue); color: white; border-radius: 6px;">{{ $page }}</span>
                @else
                    <a href="{{ $url }}" style="padding: 8px 12px; background: var(--gemini-surface); border: 1px solid var(--gemini-border); border-radius: 6px; color: var(--gemini-text); text-decoration: none;">{{ $page }}</a>
                @endif
            @endforeach
        @endif
    @endforeach

    @if ($paginator->hasMorePages())
        <a href="{{ $paginator->nextPageUrl() }}" style="padding: 8px 12px; background: var(--gemini-surface); border: 1px solid var(--gemini-border); border-radius: 6px; color: var(--gemini-text); text-decoration: none;">
            Keyingi <i class="fas fa-chevron-right"></i>
        </a>
    @else
        <span style="padding: 8px 12px; color: var(--gemini-text-secondary); cursor: not-allowed;">
            Keyingi <i class="fas fa-chevron-right"></i>
        </span>
    @endif
</nav>
@endif