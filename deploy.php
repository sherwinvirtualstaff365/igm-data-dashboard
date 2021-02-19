<?php
namespace Deployer;

require 'recipe/laravel.php';

// Project name
set('application', 'img-data');

// Project repository
set('repository', 'git@github.com:sherwinvirtualstaff365/igm-data-dashboard.git');

// [Optional] Allocate tty for git clone. Default value is false.
set('git_tty', true);

// Shared files/dirs between deploys
add('shared_files', []);
add('shared_dirs', []);

// Writable dirs by web server
add('writable_dirs', []);


// Hosts

host('52.64.106.13')
    ->user('sherwin1')
    ->port(8616)
    ->set('deploy_path', '/var/www/vhosts/dashboard.snsserver.com.au/httpdocs');

// Tasks

task('build', function () {
    run('cd {{release_path}} && build');
});

// [Optional] if deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');

// Migrate database before symlink new release.

// before('deploy:symlink', 'artisan:migrate');

after('deploy:update_code', 'artisan:migrate');
