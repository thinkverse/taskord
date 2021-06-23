<div class="ssc">
    <div class="card">
        <ul class="list-group list-group-flush">
            @for ($i = 0; $i < $count; $i++)
                <li class="list-group-item py-3">
                    <div class="d-flex align-items-center">
                        <div class="ssc-circle avatar-40"></div>
                        <div class="w-70 ms-2">
                            <div class="ssc-line w-20"></div>
                            <div class="ssc-line w-10"></div>
                        </div>
                        <div class="ssc-line w-10 m-0 ms-auto"></div>
                    </div>
                    <div class="mt-3">
                        <div class="ssc-head-line w-50"></div>
                        <div class="ssc-line w-70 mt-3"></div>
                        <div class="ssc-line w-80"></div>
                    </div>
                    <div class="d-flex align-items-center mt-4">
                        <div class="ssc-line w-5 m-0"></div>
                        <div class="ssc-line w-5 m-0 ms-2"></div>
                    </div>
                </li>
            @endfor
        </ul>
    </div>
</div>
