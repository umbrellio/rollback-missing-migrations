# PHP Deploy

###### Laravel package for rolling back migrations between different releases

[![Github Status](https://github.com/umbrellio/php-deploy/workflows/CI/badge.svg)](https://github.com/umbrellio/php-deploy/actions)
[![Coverage Status](https://coveralls.io/repos/github/umbrellio/php-deploy/badge.svg?branch=master)](https://coveralls.io/github/umbrellio/php-deploy?branch=master)
[![Latest Stable Version](https://poser.pugx.org/umbrellio/php-deploy/v/stable.png)](https://packagist.org/packages/umbrellio/php-deploy)
[![Total Downloads](https://poser.pugx.org/umbrellio/php-deploy/downloads.png)](https://packagist.org/packages/umbrellio/php-deploy)
[![Code Intelligence Status](https://scrutinizer-ci.com/g/umbrellio/php-deploy/badges/code-intelligence.svg?b=master)](https://scrutinizer-ci.com/code-intelligence)
[![Build Status](https://scrutinizer-ci.com/g/umbrellio/php-deploy/badges/build.png?b=master)](https://scrutinizer-ci.com/g/umbrellio/php-deploy/build-status/master)
[![Code Coverage](https://scrutinizer-ci.com/g/umbrellio/php-deploy/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/umbrellio/php-deploy/?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/umbrellio/php-deploy/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/umbrellio/php-deploy/?branch=master)


## Installation

__composer__  

`composer require umbrellio/php-deploy`

## Usage

In your **new** release directory:   

`php artisan rollback_missing_migrations:rollback <path_to_artisan>`

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

## Authors

Created by Art4es & Korben Dallas.

<a href="https://github.com/umbrellio/">
<img style="float: left;" src="https://umbrellio.github.io/Umbrellio/supported_by_umbrellio.svg" alt="Supported by Umbrellio" width="439" height="72">
</a>
