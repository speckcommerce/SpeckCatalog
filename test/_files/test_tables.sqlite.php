<?php

$return['catalog_product'] = <<<sqlite
CREATE TABLE IF NOT EXISTS `catalog_product`(
    `product_id`      INTEGER PRIMARY KEY AUTOINCREMENT,
    'name'            VARCHAR(255),
    'description'     VARCHAR(255),
    'manufacturer_id' INTEGER(11),
    'item_number'     VARCHAR(255),
    'product_type_id' INTEGER(1)
);
sqlite;

$return['catalog_category_product'] = <<<sqlite
CREATE TABLE IF NOT EXISTS `catalog_category_product`(
    `product_id`      INTEGER PRIMARY KEY AUTOINCREMENT,
    `category_id`     INTEGER(11),
    `website_id`      INTEGER(11)
);
sqlite;

$return['catalog_option'] = <<<sqlite
CREATE TABLE IF NOT EXISTS `catalog_option`(
    `option_id`       INTEGER PRIMARY KEY AUTOINCREMENT,
    `name`            VARCHAR(255),
    `instruction`     VARCHAR(255),
    `required`        INTEGER(1),
    `variation`       INTEGER(1),
    `option_type_id`  INTEGER(1)
);
sqlite;

$return['catalog_product_option'] = <<<sqlite
CREATE TABLE IF NOT EXISTS `catalog_product_option`(
    `product_id`      INTEGER(11),
    `option_id`       INTEGER(11),
    `sort_weight`     INTEGER(11)
);
sqlite;


$return['catalog_choice_option'] = <<<sqlite
CREATE TABLE IF NOT EXISTS `catalog_choice_option`(
    `option_id`       INTEGER(11),
    `choice_id`       INTEGER(11),
    `sort_weight`     INTEGER(11)
);
sqlite;

$return['catalog_choice'] = <<<sqlite
 CREATE TABLE IF NOT EXISTS `catalog_choice` (
  `choice_id`              INTEGER PRIMARY KEY AUTOINCREMENT,
  `product_id`             INTEGER(11),
  `option_id`              INTEGER(11),
  `price_override_fixed`   DECIMAL(15,5) NOT NULL DEFAULT '0.00000',
  `price_discount_fixed`   DECIMAL(15,5) NOT NULL DEFAULT '0.00000',
  `price_discount_percent` DECIMAL(5,2)  NOT NULL DEFAULT '0.00',
  `price_no_charge`        INTEGER(1)    NOT NULL DEFAULT '0',
  `override_name`          VARCHAR(255)  DEFAULT NULL,
  `sort_weight`            INTEGER(11)   NOT NULL DEFAULT '0'
);
sqlite;

$return['catalog_product_uom'] = <<<sqlite
CREATE TABLE IF NOT EXISTS `catalog_product_uom` (
  `uom_code`    VARCHAR(2)    NOT NULL DEFAULT 'EA',
  `product_id`  INTEGER(11)   NOT NULL,
  `price`       DECIMAL(15,5) NOT NULL,
  `retail`      DECIMAL(15,5) NOT NULL,
  `quantity`    INTEGER(11)   NOT NULL,
  `sort_weight` INTEGER(11)   NOT NULL DEFAULT '0',
  `enabled`     INTEGER(4)    NOT NULL DEFAULT '1'
)
sqlite;

return $return;
