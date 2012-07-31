-- phpMyAdmin SQL Dump
-- version 3.4.8
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 31, 2012 at 11:31 AM
-- Server version: 5.5.24
-- PHP Version: 5.3.14

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `speck`
--

-- --------------------------------------------------------

--
-- Table structure for table `ansi_uom`
--

CREATE TABLE IF NOT EXISTS `ansi_uom` (
  `uom_code` varchar(2) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`uom_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `catalog_availability`
--

CREATE TABLE IF NOT EXISTS `catalog_availability` (
  `availability_id` int(11) NOT NULL AUTO_INCREMENT,
  `search_data` text,
  `parent_product_uom_id` int(11) NOT NULL,
  `distributor_company_id` int(11) DEFAULT NULL,
  `cost` float NOT NULL,
  PRIMARY KEY (`availability_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 

-- --------------------------------------------------------

--
-- Table structure for table `catalog_category`
--

CREATE TABLE IF NOT EXISTS `catalog_category` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `search_data` text NOT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 

-- --------------------------------------------------------

--
-- Table structure for table `catalog_category_category_linker`
--

CREATE TABLE IF NOT EXISTS `catalog_category_category_linker` (
  `linker_id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_category_id` int(11) NOT NULL,
  `child_category_id` int(11) NOT NULL,
  PRIMARY KEY (`linker_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 

-- --------------------------------------------------------

--
-- Table structure for table `catalog_category_product_linker`
--

CREATE TABLE IF NOT EXISTS `catalog_category_product_linker` (
  `linker_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  PRIMARY KEY (`linker_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 

-- --------------------------------------------------------

--
-- Table structure for table `catalog_choice`
--

CREATE TABLE IF NOT EXISTS `catalog_choice` (
  `choice_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) DEFAULT NULL,
  `price_override_fixed` float(9,2) NOT NULL,
  `price_discount_fixed` float(9,2) NOT NULL,
  `price_discount_percent` float(2,2) NOT NULL,
  `price_no_charge` tinyint(4) NOT NULL,
  `search_data` text,
  `override_name` varchar(255) DEFAULT NULL,
  `default_choice_id` int(11) DEFAULT NULL,
  `type` enum('choice','product') NOT NULL,
  PRIMARY KEY (`choice_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 

-- --------------------------------------------------------

--
-- Table structure for table `catalog_choice_option_linker`
--

CREATE TABLE IF NOT EXISTS `catalog_choice_option_linker` (
  `linker_id` int(11) NOT NULL AUTO_INCREMENT,
  `choice_id` int(11) NOT NULL,
  `option_id` int(11) NOT NULL,
  `sort_weight` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`linker_id`),
  UNIQUE KEY `link` (`choice_id`,`option_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 

-- --------------------------------------------------------

--
-- Table structure for table `catalog_company`
--

CREATE TABLE IF NOT EXISTS `catalog_company` (
  `company_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `search_data` text NOT NULL,
  PRIMARY KEY (`company_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 

-- --------------------------------------------------------

--
-- Table structure for table `catalog_media`
--

CREATE TABLE IF NOT EXISTS `catalog_media` (
  `media_id` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(255) DEFAULT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `search_data` text,
  PRIMARY KEY (`media_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 

-- --------------------------------------------------------

--
-- Table structure for table `catalog_option`
--

CREATE TABLE IF NOT EXISTS `catalog_option` (
  `option_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `instruction` varchar(255) DEFAULT NULL,
  `search_data` text,
  `required` tinyint(1) NOT NULL DEFAULT '0',
  `list_type` enum('radio','checkbox','dropdown') DEFAULT 'radio',
  PRIMARY KEY (`option_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 

-- --------------------------------------------------------

--
-- Table structure for table `catalog_option_choice_linker`
--

CREATE TABLE IF NOT EXISTS `catalog_option_choice_linker` (
  `linker_id` int(11) NOT NULL AUTO_INCREMENT,
  `option_id` int(11) NOT NULL,
  `choice_id` int(11) NOT NULL,
  `sort_weight` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`linker_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 

-- --------------------------------------------------------

--
-- Table structure for table `catalog_option_image_linker`
--

CREATE TABLE IF NOT EXISTS `catalog_option_image_linker` (
  `linker_id` int(11) NOT NULL AUTO_INCREMENT,
  `option_id` int(11) NOT NULL,
  `media_id` int(11) NOT NULL,
  `sort_weight` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`linker_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 

-- --------------------------------------------------------

--
-- Table structure for table `catalog_product`
--

CREATE TABLE IF NOT EXISTS `catalog_product` (
  `product_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `description` text,
  `type` enum('item','shell','builder') NOT NULL DEFAULT 'shell',
  `item_number` varchar(255) DEFAULT NULL,
  `manufacturer_company_id` int(11) DEFAULT NULL,
  `search_data` text,
  PRIMARY KEY (`product_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 

-- --------------------------------------------------------

--
-- Table structure for table `catalog_product_document_linker`
--

CREATE TABLE IF NOT EXISTS `catalog_product_document_linker` (
  `linker_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `media_id` int(11) NOT NULL,
  `sort_weight` int(11) NOT NULL DEFAULT '0',
  KEY `linker_id` (`linker_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 

-- --------------------------------------------------------

--
-- Table structure for table `catalog_product_image_linker`
--

CREATE TABLE IF NOT EXISTS `catalog_product_image_linker` (
  `linker_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `media_id` int(11) NOT NULL,
  `sort_weight` int(11) NOT NULL DEFAULT '0',
  KEY `linker_id` (`linker_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 

-- --------------------------------------------------------

--
-- Table structure for table `catalog_product_option_linker`
--

CREATE TABLE IF NOT EXISTS `catalog_product_option_linker` (
  `linker_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `option_id` int(11) NOT NULL,
  `sort_weight` int(11) NOT NULL DEFAULT '0',
  UNIQUE KEY `link` (`option_id`,`product_id`),
  KEY `linker_id` (`linker_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 

-- --------------------------------------------------------

--
-- Table structure for table `catalog_product_spec`
--

CREATE TABLE IF NOT EXISTS `catalog_product_spec` (
  `spec_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `label` varchar(255) DEFAULT NULL,
  `value` text,
  `tab_delimited` text,
  `search_data` text,
  PRIMARY KEY (`spec_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 

-- --------------------------------------------------------

--
-- Table structure for table `catalog_product_uom`
--

CREATE TABLE IF NOT EXISTS `catalog_product_uom` (
  `product_uom_id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_product_id` int(11) NOT NULL,
  `search_data` text,
  `price` float NOT NULL,
  `retail` float NOT NULL,
  `quantity` int(11) NOT NULL,
  `uom_code` varchar(2) NOT NULL DEFAULT 'EA',
  `sort_weight` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`product_uom_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 
