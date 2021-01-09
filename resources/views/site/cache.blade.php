<ul class="d-inline mb-0 text-white font-monospace">
    @foreach($cache as $key)
        <div class="mb-2 bg-dark px-3 py-2">
            {{ $key }}
        </div>
    @endforeach
</ul>
