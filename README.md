# Rollback Missing Migrations for Laravel

###### Laravel package for rolling back migrations between different releases

[![Github Status](https://github.com/umbrellio/rollback-missing-migrations/workflows/CI/badge.svg)](https://github.com/umbrellio/rollback-missing-migrations/actions)
[![Coverage Status](https://coveralls.io/repos/github/umbrellio/rollback-missing-migrations/badge.svg?branch=master)](https://coveralls.io/github/umbrellio/rollback-missing-migrations?branch=master)
[![Latest Stable Version](https://poser.pugx.org/umbrellio/rollback-missing-migrations/v/stable.png)](https://packagist.org/packages/umbrellio/rollback-missing-migrations)
[![Total Downloads](https://poser.pugx.org/umbrellio/rollback-missing-migrations/downloads.png)](https://packagist.org/packages/umbrellio/rollback-missing-migrations)
[![Code Intelligence Status](https://scrutinizer-ci.com/g/umbrellio/rollback-missing-migrations/badges/code-intelligence.svg?b=master)](https://scrutinizer-ci.com/code-intelligence)
[![Build Status](https://scrutinizer-ci.com/g/umbrellio/rollback-missing-migrations/badges/build.png?b=master)](https://scrutinizer-ci.com/g/umbrellio/rollback-missing-migrations/build-status/master)
[![Code Coverage](https://scrutinizer-ci.com/g/umbrellio/rollback-missing-migrations/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/umbrellio/rollback-missing-migrations/?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/umbrellio/rollback-missing-migrations/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/umbrellio/rollback-missing-migrations/?branch=master)


## Installation

__composer__  

`composer require umbrellio/rollback-missing-migrations`

## Usage

In your **new** release directory:   

`php artisan rollback_missing_migrations:rollback <path_to_artisan>`

- `<path_to_artisan>` - absolute path to artisan command in previous release 

Example:

`php artisan rollback_missing_migrations:rollback /projects/old_release/your_app/artisan`

If your migrations files locate in the custom directory you can use optional parameters:

- `--path` - path where your migration files locate in **current** release
- `--old-path` - path where your migration files locate in **old** release
- `--realpath` - this flag indicates, how `--path` and `--old-path` formats (absolute or relative) will be recognized
 
Example with a relative path:
 
```
php artisan rollback_missing_migrations:rollback /projects/old_release_app/artisan \
    --old-path=database/old_custom_folder \ 
    --path=database/custom_migration_folder 
```

Example with an absolute path:
 
```
php artisan rollback_missing_migrations:rollback /projects/old_release/your_app/artisan \
    --old-path=/projects/old_release/your_app/database/old_custom_folder \ 
    --path=/new_release/your_app/database/custom_migration_folder \ 
    --realpath
```

In case if you need rollback new migrations different from origin/master, you can use `rollback_new_migrations:rollback`

## Authors

Created by Art4es & Korben Dallas.

<a href="https://github.com/umbrellio/">
<img style="float: left;" src="https://umbrellio.github.io/Umbrellio/supported_by_umbrellio.svg" alt="Supported by Umbrellio" width="439" height="72">
</a>
