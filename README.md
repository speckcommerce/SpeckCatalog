SpeckCatalog
============
[![Build Status](https://travis-ci.org/speckcommerce/SpeckCatalog.svg?branch=develop)](https://travis-ci.org/speckcommerce/SpeckCatalog)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/speckcommerce/SpeckCatalog/badges/quality-score.png?b=develop)](https://scrutinizer-ci.com/g/speckcommerce/SpeckCatalog/?branch=develop)
[![Code Coverage](https://scrutinizer-ci.com/g/speckcommerce/SpeckCatalog/badges/coverage.png?b=develop)](https://scrutinizer-ci.com/g/speckcommerce/SpeckCatalog/?branch=develop)

Catalog and manager module for the ecommerce platform SpeckCommerce

Introduction
------------

Steps to get this module running:
- in /config/autoload, be sure you have a copy of database.local.php.dist, configured for your database, and saved as database.local.php 
- create the tables necessary for this module, using /vendor/speckcommerce/SpeckCatalog/data/schema.sql
- copy all files from /vendor/speckcommerce/SpeckCatalog/public, into /public

Parts that work right now:
- create + edit a new product - catalogmanger/new/product/item
- view all products - catalogmanager/products

Parts that dont work:
- searching for reusable products/options, from the manager/editor.

Coming soon: 
- zfcuser + zfcuseracl integration.

Come visit us via irc.freenode.net #SpeckCommerce

Dev env
-------

- `vagrant up` Uses libvirt or virtualbox. use `--provider` to force specific
  provider. Shares folder via nfs, make sure it is configured on the host.
- `vagrant ssh`
- `cd /vagrant`
- `d-composer update` runs composer in docker container, current folder is
  shared with container. Execute from /vagrant folder
- `d-php <command>` Shares current folder and runs specified command
  in docker container.
- `d-php vendor/bin/phpunit` Runs phpunit in docker container. Execute from
  /vagrant folder
- `d-php vendor/bin/phpcs` Runs php_codesniffer in docker container. Execute from
  /vagrant folder
