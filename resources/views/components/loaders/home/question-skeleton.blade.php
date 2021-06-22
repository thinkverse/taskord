<div class="ssc">
    @for ($i = 0; $i < $count; $i++)
        <div class="d-flex align-items-center {{ ($i === 0 or $i === $count - 1) ? '' : 'my-4' }}">
            <div class="ssc-circle avatar-30"></div>
            <div class="w-70 ms-2">
                <div class="ssc-line"></div>
                <div class="ssc-line w-30"></div>
            </div>
        </div>
    @endfor
</div>
