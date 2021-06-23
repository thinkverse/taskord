<div class="ssc">
    @for ($i = 0; $i < $count; $i++)
        <div class="d-flex align-items-center {{ ($i === 0 or $i === $count - 1) ? 'my-2' : 'my-4' }}">
            <div class="ssc-circle avatar-20"></div>
            <div class="w-70 ms-3">
                <div class="ssc-line"></div>
                <div class="d-flex align-items-center">
                    <div class="ssc-line w-20 m-0"></div>
                    <div class="ssc-line w-5 m-0 ms-1"></div>
                    <div class="ssc-line w-5 m-0 ms-1"></div>
                </div>
            </div>
        </div>
    @endfor
</div>
