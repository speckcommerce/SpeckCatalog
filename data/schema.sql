-- phpMyAdmin SQL Dump
-- version 3.4.8
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 23, 2012 at 12:02 PM
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
  `record_id` varchar(2) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `rev_active` tinyint(1) NOT NULL DEFAULT '1',
  `rev_user_id` int(11) DEFAULT NULL,
  `rev_datetime` datetime NOT NULL,
  `rev_eol_datetime` datetime DEFAULT NULL,
  `rev_id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`rev_id`),
  KEY `record_id` (`record_id`,`rev_active`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `catalog_availability`
--

CREATE TABLE IF NOT EXISTS `catalog_availability` (
  `rev_id` int(11) NOT NULL AUTO_INCREMENT,
  `record_id` int(11) DEFAULT NULL,
  `rev_active` int(1) NOT NULL DEFAULT '1',
  `rev_datetime` datetime NOT NULL,
  `rev_eol_datetime` datetime DEFAULT NULL,
  `rev_user_id` int(11) DEFAULT NULL,
  `search_data` text,
  `parent_product_uom_id` int(11) NOT NULL,
  `distributor_company_id` int(11) DEFAULT NULL,
  `cost` float NOT NULL,
  PRIMARY KEY (`rev_id`),
  KEY `record_id` (`record_id`,`rev_active`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `catalog_category`
--

CREATE TABLE IF NOT EXISTS `catalog_category` (
  `record_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `search_data` text NOT NULL,
  PRIMARY KEY (`record_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `catalog_category_category_linker`
--

CREATE TABLE IF NOT EXISTS `catalog_category_category_linker` (
  `rev_id` int(11) NOT NULL AUTO_INCREMENT,
  `record_id` int(11) DEFAULT NULL,
  `rev_active` int(1) NOT NULL DEFAULT '1',
  `rev_datetime` datetime NOT NULL,
  `rev_eol_datetime` datetime DEFAULT NULL,
  `rev_user_id` int(11) DEFAULT NULL,
  `parent_category_id` int(11) NOT NULL,
  `child_category_id` int(11) NOT NULL,
  PRIMARY KEY (`rev_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `catalog_category_product_linker`
--

CREATE TABLE IF NOT EXISTS `catalog_category_product_linker` (
  `rev_id` int(11) NOT NULL AUTO_INCREMENT,
  `record_id` int(11) DEFAULT NULL,
  `rev_active` int(1) NOT NULL DEFAULT '1',
  `rev_timestamp` bigint(20) NOT NULL,
  `rev_user_id` int(11) DEFAULT NULL,
  `category_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  PRIMARY KEY (`rev_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `catalog_choice`
--

CREATE TABLE IF NOT EXISTS `catalog_choice` (
  `record_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) DEFAULT NULL,
  `price_override_fixed` float(9,2) NOT NULL,
  `price_discount_fixed` float(9,2) NOT NULL,
  `price_discount_percent` float(2,2) NOT NULL,
  `price_no_charge` tinyint(4) NOT NULL,
  `search_data` text,
  `override_name` varchar(255) DEFAULT NULL,
  `default_choice_id` int(11) DEFAULT NULL,
  `type` enum('choice','product') NOT NULL,
  KEY `record_id` (`record_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=283 ;

-- --------------------------------------------------------

--
-- Table structure for table `catalog_choice_option_linker`
--

CREATE TABLE IF NOT EXISTS `catalog_choice_option_linker` (
  `linker_id` int(11) DEFAULT NULL,
  `choice_id` int(11) NOT NULL,
  `option_id` int(11) NOT NULL,
  `sort_weight` int(11) NOT NULL DEFAULT '0',
  UNIQUE KEY `link` (`choice_id`,`option_id`),
  KEY `linker_id` (`linker_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `catalog_company`
--

CREATE TABLE IF NOT EXISTS `catalog_company` (
  `record_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `search_data` text NOT NULL,
  KEY `record_id` (`record_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `catalog_media`
--

CREATE TABLE IF NOT EXISTS `catalog_media` (
  `record_id` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(255) DEFAULT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `search_data` text,
  KEY `record_id` (`record_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=41 ;

-- --------------------------------------------------------

--
-- Table structure for table `catalog_option`
--

CREATE TABLE IF NOT EXISTS `catalog_option` (
  `record_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `instruction` varchar(255) DEFAULT NULL,
  `search_data` text,
  `required` tinyint(1) NOT NULL DEFAULT '0',
  `list_type` enum('radio','checkbox','dropdown') DEFAULT 'radio',
  KEY `record_id` (`record_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20475 ;

-- --------------------------------------------------------

--
-- Table structure for table `catalog_option_choice_linker`
--

CREATE TABLE IF NOT EXISTS `catalog_option_choice_linker` (
  `linker_id` int(11) NOT NULL AUTO_INCREMENT,
  `option_id` int(11) NOT NULL,
  `choice_id` int(11) NOT NULL,
  `sort_weight` int(11) NOT NULL DEFAULT '0',
  KEY `linker_id` (`linker_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=283 ;

-- --------------------------------------------------------

--
-- Table structure for table `catalog_option_image_linker`
--

CREATE TABLE IF NOT EXISTS `catalog_option_image_linker` (
  `rev_id` int(11) NOT NULL AUTO_INCREMENT,
  `linker_id` int(11) DEFAULT NULL,
  `rev_active` int(1) NOT NULL DEFAULT '1',
  `rev_datetime` datetime NOT NULL,
  `rev_eol_datetime` datetime DEFAULT NULL,
  `rev_user_id` int(11) DEFAULT NULL,
  `option_id` int(11) NOT NULL,
  `media_id` int(11) NOT NULL,
  `sort_weight` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`rev_id`),
  KEY `linker_id` (`linker_id`,`rev_active`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=208 ;

-- --------------------------------------------------------

--
-- Table structure for table `catalog_product`
--

CREATE TABLE IF NOT EXISTS `catalog_product` (
  `record_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `description` text,
  `type` enum('item','shell','builder') NOT NULL DEFAULT 'shell',
  `item_number` varchar(255) DEFAULT NULL,
  `manufacturer_company_id` int(11) DEFAULT NULL,
  `search_data` text,
  PRIMARY KEY (`record_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=27895 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=44 ;

-- --------------------------------------------------------

--
-- Table structure for table `catalog_product_spec`
--

CREATE TABLE IF NOT EXISTS `catalog_product_spec` (
  `rev_id` int(11) NOT NULL AUTO_INCREMENT,
  `record_id` int(11) DEFAULT NULL,
  `rev_active` int(1) NOT NULL DEFAULT '1',
  `rev_datetime` datetime NOT NULL,
  `rev_eol_datetime` datetime DEFAULT NULL,
  `rev_user_id` int(11) DEFAULT NULL,
  `product_id` int(11) NOT NULL,
  `label` varchar(255) DEFAULT NULL,
  `value` text,
  `tab_delimited` text,
  `search_data` text,
  PRIMARY KEY (`rev_id`),
  KEY `record_id` (`record_id`,`rev_active`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

-- --------------------------------------------------------

--
-- Table structure for table `catalog_product_uom`
--

CREATE TABLE IF NOT EXISTS `catalog_product_uom` (
  `record_id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_product_id` int(11) NOT NULL,
  `search_data` text,
  `price` float NOT NULL,
  `retail` float NOT NULL,
  `quantity` int(11) NOT NULL,
  `uom_code` varchar(2) NOT NULL DEFAULT 'EA',
  `sort_weight` int(11) NOT NULL DEFAULT '0',
  KEY `record_id` (`record_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;
