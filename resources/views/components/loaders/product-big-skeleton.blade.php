<div class="ssc">
    <div class="card">
        <ul class="list-group list-group-flush">
            @for ($i = 0; $i < $count; $i++)
                <li class="list-group-item py-3">
                    <div class="d-flex align-items-center">
                        <div class="ssc-circle rounded avatar-50"></div>
                        <div class="w-70 ms-2">
                            <div class="ssc-line w-30 mb-3"></div>
                            <div class="ssc-line w-20"></div>
                        </div>
                        <div class="ssc-circle avatar-30 ms-auto"></div>
                    </div>
                </li>
            @endfor
        </ul>
    </div>
</div>
