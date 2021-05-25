@servers(['prod' => '127.0.0.1'])

@story('deploy', ['on' => 'prod'])
    pull-from-gitlab-and-migrate
    install-laravel-dependencies
    install-yarn-dependencies
    clean-application
    build-assets
@endstory

@setup
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    try {
        $dotenv->load();
        $dotenv->required(['DISCORD_WEBHOOK_URL'])->notEmpty();
    } catch (Exception $e)  {
        echo $e->getMessage();
    }
@endsetup

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
    php artisan horizon:publish
@endtask

@success
    echo "Taskord has been successfully deployed!\n";
    @discord(env('DISCORD_WEBHOOK_URL'), '✅ Taskord has been successfully deployed!')
@endsuccess

@error
    echo "Something went wrong while deploying Taskord!\n";
    @discord(env('DISCORD_WEBHOOK_URL'), '❌ Something went wrong while deploying Taskord!')
@enderror
