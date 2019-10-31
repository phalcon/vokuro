# Vökuró

[![Discord](https://img.shields.io/discord/310910488152375297?label=Discord)](http://phalcon.link/discord)
[![Build Status](https://travis-ci.org/phalcon/vokuro.svg?branch=master)](https://travis-ci.org/phalcon/vokuro)
[![Phalcon Backers](https://img.shields.io/badge/phalcon-backers-99ddc0.svg)](https://github.com/phalcon/cphalcon/blob/master/BACKERS.md)
[![OpenCollective](https://opencollective.com/phalcon/backers/badge.svg)](#backers)
[![OpenCollective](https://opencollective.com/phalcon/sponsors/badge.svg)](#sponsors)

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

### Install Vökuró via composer create-project

TODO: change version after next release is launched.

```bash
composer create-project phalcon/vokuro /path/to/vokuro-folder "4.0.x-dev" --prefer-dist
```

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
- `var/cache/acl`
- `var/cache/metaData`
- `var/cache/session`
- `var/cache/volt`

## NOTE

The master branch will always contain the latest stable version.
If you wish to check older versions or newer ones currently under development, please switch to the relevant branch.

## Improving this Sample

Phalcon is an open source project and a volunteer effort.
Vökuró does not have human resources fully dedicated to the maintenance of this software.
If you want something to be improved or you want a new feature please submit a Pull Request.

## Sponsors

Become a sponsor and get your logo on our README on Github with a link to your site. [[Become a sponsor](https://opencollective.com/phalcon#sponsor)]

<a href="https://opencollective.com/phalcon/#contributors">
<img src="https://opencollective.com/phalcon/tiers/sponsors.svg?avatarHeight=48&width=800" alt="sponsors">
</a>

## Backers

Support us with a monthly donation and help us continue our activities. [[Become a backer](https://opencollective.com/phalcon#backer)]

<a href="https://opencollective.com/phalcon/#contributors">
<img src="https://opencollective.com/phalcon/tiers/backers.svg?avatarHeight=48&width=800&height=200" alt="backers">
</a>

## License

Vökuró is open-sourced software licensed under the New BSD License.
