# Vökuró

This is a sample application for the [Phalcon Framework](https://github.com/phalcon/cphalcon).
We expect to implement as many features as possible to showcase the framework and its potential.

Please write us if you have any feedback.

Thanks.

## Get Started

### Requirements

To run this application on your machine, you need at least:

* PHP >= 7.2
* Phalcon >= 4.0
* MySQL >= 5.5
* Apache Web Server with `mod_rewrite enabled`, and `AllowOverride Options` (or `All`) in your `httpd.conf` or Nginx Web Server
* Latest [Phalcon Framework](https://github.com/phalcon/cphalcon) extension installed/enabled

### Installing Dependencies via Composer

Vökuró's dependencies must be installed using Composer. Install composer in a common location or in your project:

```bash
curl -s http://getcomposer.org/installer | php
```

Run the composer installer:

```bash
cd vokuro
composer install
cp .env.example .env
vendor/bin/phinx migrate
vendor/bin/phinx seed:run
```

**NOTE** After the installation, please ensure that the following folders have write permissions set:
- `cache`

## NOTE

The master branch will always contain the latest stable version.
If you wish to check older versions or newer ones currently under development, please switch to the relevant branch.

## Improving this Sample

Phalcon is an open source project and a volunteer effort.
Vökuró does not have human resources fully dedicated to the maintenance of this software.
If you want something to be improved or you want a new feature please submit a Pull Request.

## License

Vökuró is open-sourced software licensed under the New BSD License.
