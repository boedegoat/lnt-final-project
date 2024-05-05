<div class="d-flex align-items-center gap-2">
    @if ($backHref)
        <a href="{{ $backHref }}"><i class="bi bi-arrow-left"></i></a>
    @endif
    <h1 class="py-3" style="font-size: 1.8rem; margin: 0">{{ $slot }}</h1>
</div>
