<div class="card p-1 rounded-0 d-flex border-bottom border-primary bg-primary text-white">
    <div class="ps-2 pe-2">
        <span class="float-start">
            <span class="fw-bold">
                <x-heroicon-o-terminal class="heroicon" />
                <a class="text-white" href="https://gitlab.com/yo/taskord/-/tree/{{ $branchname }}" target="_blank" rel="noreferrer">{{ $branchname }}</a>
                <span class="px-1">➜</span>
                <a class="text-white" href="https://gitlab.com/yo/taskord/-/commit/{{ $headHASH }}" target="_blank" rel="noreferrer">{{ Str::limit($headHASH, 8, '') }}</a>
            </span>
            <a class="text-white fw-bold ms-3"
                href="https://gitlab.com/yo/taskord/-/releases/v{{ config('app.version') }}" target="_blank" rel="noreferrer">
                <x-heroicon-o-archive class="heroicon" />
                v{{ config('app.version') }}
            </a>
            <a class="text-white fw-bold ms-3"
                href="https://github.com/laravel/framework/releases/tag/v{{ App::VERSION() }}" target="_blank" rel="noreferrer">
                <x-heroicon-o-chip class="heroicon" />
                Laravel v{{ laravel_version() }}
            </a>
            <a class="text-white fw-bold ms-3"
                href="http://git.php.net/?p=php-src.git;a=shortlog;h=refs/heads/PHP-{{ phpversion() }}" target="_blank" rel="noreferrer">
                <x-heroicon-o-code class="heroicon" />
                PHP v{{ phpversion() }}
            </a>
        </span>
        <span class="float-end">
            <a class="fw-bold me-3 text-white" href="/admin/horizon" target="_blank" rel="noreferrer">
                <x-heroicon-o-collection class="heroicon" />
                {{ $jobs }}
                <span class="fw-normal">
                    {{ str_plural('job', $jobs) }}
                </span>
            </a>
            <a class="fw-bold me-3 text-white cursor-pointer" data-bs-toggle="modal" data-bs-target="#cacheModal" title="Cache Hits">
                <x-heroicon-o-folder-open class="heroicon" />
                {{ $cache }}
                <span class="fw-normal">
                    cached
                </span>
            </a>
            <span class="fw-bold me-3">
                <x-heroicon-o-cog class="heroicon" />
                {{ memory_usage() }}
            </span>
            <span class="fw-bold me-3">
                <x-heroicon-o-clock class="heroicon" />
                {{ bcmul((microtime(true) - LARAVEL_START), '1000', 0) }}ms
                <span class="fw-normal">response total</span>
            </span>
            <span class="fw-bold me-3">
                <a class="cursor-pointer" data-bs-toggle="modal" data-bs-target="#cleanModal" title="Clear Cache">
                    <x-heroicon-o-trash class="heroicon text-white" />
                </a>
            </span>
            <span class="fw-bold me-3">
                <a href="/graphiql" target="_blank" title="GraphiQL" rel="noreferrer">
                    <x-heroicon-o-cube-transparent class="heroicon text-white" />
                </a>
            </span>
            <span class="fw-bold me-3">
                <a href="{{ route('admin.stats') }}" title="Admin">
                    <x-heroicon-o-shield-check class="heroicon text-white" />
                </a>
            </span>
            <span class="fw-bold">
                <a class="cursor-pointer" data-bs-toggle="modal" data-bs-target="#deployModal" title="Deploy">
                    <x-heroicon-o-cloud class="heroicon text-white" />
                </a>
            </span>
        </span>
    </div>
    @include('livewire.admin.modals.clean')
    @include('livewire.admin.modals.cache')
    @include('livewire.admin.modals.deploy')
</div>
