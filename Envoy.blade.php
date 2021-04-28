@servers(['web' => '127.0.0.1'])

@story('deploy', ['on' => 'web'])
    pull-from-gitlab
    install-laravel-dependencies
    install-yarn-dependencies
    build-assets
    clean-application
@endstory

@task('pull-from-gitlab')
    git pull origin main
@endtask

@task('install-laravel-dependencies')
    composer install --no-progress
    composer dump-autoload
@endtask

@task('install-yarn-dependencies')
    yarn install
@endtask

@task('build-assets')
    yarn production
@endtask

@task('clean-application')
    php artisan app:clean
@endtask

@success
    echo "Taskord has been successfully deployed!";
@endsuccess

@error
    echo "Something went wrong while deploying Taskord!";
@enderror
