SpeckCatalog
============

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
