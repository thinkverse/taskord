@servers(['prod' => '127.0.0.1'])

@story('deploy', ['on' => 'prod'])
    pull-from-gitlab-and-migrate
    install-laravel-dependencies
    install-yarn-dependencies
    clean-application
    build-assets
@endstory

@task('pull-from-gitlab-and-migrate')
    echo "Pulling latest changes from GitLab";
    php artisan down
    git pull origin main
    echo "Database Migration Started ✅";
    php artisan migrate --force
    echo "Database Migration Ended ✅";
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

@task('clean-application')
    echo "Cleaning the Taskord application";
    php artisan app:clean
@endtask

@task('build-assets')
    echo "Building CSS and JS assets";
    yarn production
@endtask

@success
    echo "Taskord has been successfully deployed!\n";
@endsuccess

@error
    echo "Something went wrong while deploying Taskord!\n";
@enderror
