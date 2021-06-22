<div class="ssc">
    @for ($i = 0; $i < $count; $i++)
        <div class="d-flex align-items-center {{ ($i === 0 or $i === $count - 1) ? '' : 'my-3' }}">
            <div class="ssc-line w-30 m-0 me-2 w-5"></div>
            <div class="ssc-circle avatar-30 me-3"></div>
            <div class="ssc-line w-30 m-0 me-3"></div>
            <div class="ssc-head-line w-10"></div>
        </div>
    @endfor
</div>
