@servers(['web' => '127.0.0.1'])

@story('deploy', ['on' => 'web'])
    pull-from-gitlab
    install-laravel-dependencies
    install-yarn-dependencies
    build-assets
    clean-application
@endstory

@task('pull-from-gitlab')
    echo "Pulling latest changes from GitLab";
    php artisan down
    git pull origin main
    php artisan up
@endtask

@task('install-laravel-dependencies')
    echo "Installing PHP dependencies";
    composer install --no-progress
    composer dump-autoload
@endtask

@task('install-yarn-dependencies')
    echo "Install Yarn dependencies";
    yarn install
@endtask

@task('build-assets')
    echo "Building CSS and JS assets";
    yarn production
@endtask

@task('clean-application')
    echo "Cleaning the Taskord application";
    php artisan app:clean
@endtask

@success
    echo "Taskord has been successfully deployed!\n";
@endsuccess

@error
    echo "Something went wrong while deploying Taskord!\n";
@enderror
