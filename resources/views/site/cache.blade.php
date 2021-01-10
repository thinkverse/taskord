<div class="mb-0 text-white font-monospace">
    @foreach($cache as $key)
        <div class="mb-2 bg-dark px-3 py-2">
            {{ preg_replace("/taskord_cache:.*?:/", "", $key) }}
        </div>
    @endforeach
</div>
