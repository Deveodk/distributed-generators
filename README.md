# deveodk/distributed-generators

<img src="https://user-images.githubusercontent.com/7561792/27095616-a944a0f6-506e-11e7-88dc-0d2aeaa7bddf.png" width="100%" />

[![Laravel 5.1](https://img.shields.io/badge/Laravel-5.4-orange.svg?style=flat-square)](http://laravel.com)

> Smart generators for distrubuted laravel (https://github.com/esbenp/distributed-laravel). Spin up new bundles in the matter of seconds

## Example
Example of a generated bundle with files

![skaermbillede 2017-06-15 kl 18 43 58](https://user-images.githubusercontent.com/7561792/27192173-a11d1222-51fa-11e7-8294-c644d982fd9c.png)

The package will generate all of the files it can be configured in the config file

![skaermbillede 2017-06-15 kl 18 45 12](https://user-images.githubusercontent.com/7561792/27192223-cb993724-51fa-11e7-9a99-dd5d7e4edc7f.png)

## Installation

```bash
composer require deveodk/distributed-generators
```

Add the service provider to the App config.
```PHP
DeveoDK\DistributedGenerators\DistributedGeneratorsServiceProvider::class
```

Publish the vendor folder content
```PHP
php artisan vendor:publish --provider="DeveoDK\DistributedGenerators\DistributedGeneratorsServiceProvider"
```

## Important disclaimer
This package is made to work with the distributed laravel architecture. If you try to use it in regular laravel it will not work. 

## Usage

The package has multiple commands for generating models, listeners and so on.

```bash
# Generate a new User bundle. Ideal for bootstraping a new bundle
php artsian make:bundle User --all
```

```bash
# Generate a new User controller. It will automaticly be placed under /Controllers
php artsian make:bundle:controller User --namespace="integrations/User"
```

```bash
# Generate a new User model. It will automaticly be placed under /Models
php artsian make:bundle:model User --namespace="integrations/User"
```

```bash
# Generate a new User listerner. It will automaticly be placed under /Listeners
php artsian make:bundle:listener User --namespace="integrations/User"
```

```bash
# Generate a new User exception. It will automaticly be placed under /Exceptions
php artsian make:bundle:exception User --namespace="integrations/User"
```

```bash
# Generate a new User event. It will automaticly be placed under /Events
php artsian make:bundle:event User --namespace="integrations/User"
```

```bash
# Generate a new User transformer. It will automaticly be placed under /Transformers
php artsian make:bundle:transformer User --namespace="integrations/User"
```

```bash
# Generate a new User route file. It will automaticly be placed under /
php artsian make:bundle:route User --namespace="integrations/User"
```

## Special thanks
A special thanks to [esbenp](https://github.com/esbenp) for creating the distributed laravel structure that this package is build on

## License
[MIT](http://opensource.org/licenses/MIT)

<img src="https://cloud.githubusercontent.com/assets/7561792/26640815/14beb45c-4629-11e7-89db-fbca538a6be5.png" width="100%" />