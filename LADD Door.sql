-- phpMyAdmin SQL Dump
-- version 2.8.0.3-Debian-1
-- http://www.phpmyadmin.net
-- 
-- Host: localhost
-- Generation Time: Mar 01, 2009 at 12:02 AM
-- Server version: 5.0.22
-- PHP Version: 5.1.2
-- 
-- Database: `LADD_Door`
-- 
CREATE DATABASE `LADD_Door` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `LADD_Door`;

-- --------------------------------------------------------

-- 
-- Table structure for table `Door_Tickets`
-- 

CREATE TABLE `Door_Tickets` (
  `tick_ID` mediumint(9) NOT NULL auto_increment,
  `tick_NUM` mediumint(9) NOT NULL,
  `tick_ORDERDATE` datetime NOT NULL,
  `tick_EVENTDATE` date NOT NULL,
  `tick_ATTENDLAST` tinytext NOT NULL,
  `tick_ATTENDFIRST` tinytext NOT NULL,
  `tick_SHIPLAST` tinytext NOT NULL,
  `tick_SHIPFIRST` tinytext NOT NULL,
  `tick_SHIPADDR` tinytext NOT NULL,
  `tick_SHIPCITY` tinytext NOT NULL,
  `tick_SHIPSTATE` char(2) NOT NULL,
  `tick_SHIPZIP` tinytext NOT NULL,
  `tick_SHIPPHONE` tinytext NOT NULL,
  `tick_EMAIL` tinytext NOT NULL,
  `tick_CARDNUM` tinytext NOT NULL,
  `tick_LEVEL` enum('GEN','VIP') NOT NULL,
  `tick_SPLITHOSTLAST` tinytext NOT NULL,
  `tick_SPLITHOSTFIRST` tinytext NOT NULL,
  `tick_CLAIMED` tinyint(1) NOT NULL,
  `tick_CLAIMDATE` datetime default NULL,
  PRIMARY KEY  (`tick_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1230 ;
