<?php

$catalog_product = <<<sqlite
CREATE TABLE IF NOT EXISTS `catalog_product`(
    `product_id`      INTEGER PRIMARY KEY AUTOINCREMENT,
    'name'            VARCHAR(255),
    'description'     VARCHAR(255),
    'manufacturer_id' INTEGER(11),
    'item_number'     VARCHAR(255),
    'product_type_id' INTEGER(1)
);
sqlite;

$catalog_category_product = <<<sqlite
CREATE TABLE IF NOT EXISTS `catalog_category_product`(
    `product_id`      INTEGER PRIMARY KEY AUTOINCREMENT,
    `category_id`     INTEGER(11),
    `website_id`      INTEGER(11)
);
sqlite;

$catalog_option = <<<sqlite
CREATE TABLE IF NOT EXISTS `catalog_option`(
    `option_id`       INTEGER PRIMARY KEY AUTOINCREMENT,
    `name`            VARCHAR(255),
    `instruction`     VARCHAR(255),
    `required`        INTEGER(1),
    `variation`       INTEGER(1),
    `option_type_id`  INTEGER(1)
);
sqlite;

$catalog_product_option = <<<sqlite
CREATE TABLE IF NOT EXISTS `catalog_product_option`(
    `product_id`      INTEGER(11),
    `option_id`       INTEGER(11),
    `sort_weight`     INTEGER(11)
);
sqlite;

return array(
    'catalog_product'          => $catalog_product,
    'catalog_category_product' => $catalog_category_product,
    'catalog_option'           => $catalog_option,
    'catalog_product_option'   => $catalog_product_option,
);
