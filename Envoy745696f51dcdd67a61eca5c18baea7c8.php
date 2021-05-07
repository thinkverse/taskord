<?php $__container->servers(['prod' => '127.0.0.1']); ?>

<?php $__container->startMacro('deploy', ['on' => 'prod']); ?>
    pull-from-gitlab-and-migrate
    install-laravel-dependencies
    install-yarn-dependencies
    clean-application
    build-assets
<?php $__container->endMacro(); ?>

<?php
    require __DIR__.'/vendor/autoload.php';
    (new \Dotenv())->load(__DIR__, '.env');
?>

<?php $__container->startTask('pull-from-gitlab-and-migrate'); ?>
    echo "Pulling latest changes from GitLab";
    php artisan down
    git pull origin main
    echo "Database Migration Started ✅";
    php artisan migrate --force
    echo "Database Migration Ended ✅";
    php artisan up
<?php $__container->endTask(); ?>

<?php $__container->startTask('install-laravel-dependencies'); ?>
    echo "Installing PHP dependencies";
    composer install --no-progress
    composer dump-autoload
<?php $__container->endTask(); ?>

<?php $__container->startTask('install-yarn-dependencies'); ?>
    echo "Install Yarn dependencies";
    yarn install
<?php $__container->endTask(); ?>

<?php $__container->startTask('clean-application'); ?>
    echo "Cleaning the Taskord application";
    php artisan app:clean
<?php $__container->endTask(); ?>

<?php $__container->startTask('build-assets'); ?>
    echo "Building CSS and JS assets";
    yarn production
<?php $__container->endTask(); ?>

<?php $_vars = get_defined_vars(); $__container->success(function() use ($_vars) { extract($_vars); 
    echo "Taskord has been successfully deployed!\n";
     if (! isset($task)) $task = null; Laravel\Envoy\Discord::make(env('DISCORD_WEBHOOK_URL'), 'Hello')->task($task)->send();
}); ?>

<?php $_vars = get_defined_vars(); $__container->error(function($task) use ($_vars) { extract($_vars, EXTR_SKIP); 
    echo "Something went wrong while deploying Taskord!\n";
}); ?>
