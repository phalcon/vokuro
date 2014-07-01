-- phpMyAdmin SQL Dump
-- version 4.1.0-rc3
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 07, 2014 at 02:05 PM
-- Server version: 5.5.32
-- PHP Version: 5.5.7

--
-- Database: `vokuro`
--

-- --------------------------------------------------------

--
-- Table structure for table `email_confirmations`
--

DROP TABLE IF EXISTS `email_confirmations`;
CREATE TABLE IF NOT EXISTS `email_confirmations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `code` char(32) NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  `modified_at` int(10) unsigned DEFAULT NULL,
  `confirmed` tinyint(1) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `failed_logins`
--

DROP TABLE IF EXISTS `failed_logins`;
CREATE TABLE IF NOT EXISTS `failed_logins` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned DEFAULT NULL,
  `ip_address` char(15) NOT NULL,
  `attempted` smallint(5) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `password_changes`
--

DROP TABLE IF EXISTS `password_changes`;
CREATE TABLE IF NOT EXISTS `password_changes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `ip_address` char(15) NOT NULL,
  `user_agent` varchar(48) NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
CREATE TABLE IF NOT EXISTS `permissions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `profiles_id` int(10) unsigned NOT NULL,
  `resource` varchar(16) NOT NULL,
  `action` varchar(16) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `profiles_id` (`profiles_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `profiles_id`, `resource`, `action`) VALUES
(1, 3, 'users', 'index'),
(2, 3, 'users', 'search'),
(3, 3, 'profiles', 'index'),
(4, 3, 'profiles', 'search'),
(5, 1, 'users', 'index'),
(6, 1, 'users', 'search'),
(7, 1, 'users', 'edit'),
(8, 1, 'users', 'create'),
(9, 1, 'users', 'delete'),
(10, 1, 'users', 'changePassword'),
(11, 1, 'profiles', 'index'),
(12, 1, 'profiles', 'search'),
(13, 1, 'profiles', 'edit'),
(14, 1, 'profiles', 'create'),
(15, 1, 'profiles', 'delete'),
(16, 1, 'permissions', 'index'),
(17, 2, 'users', 'index'),
(18, 2, 'users', 'search'),
(19, 2, 'users', 'edit'),
(20, 2, 'users', 'create'),
(21, 2, 'profiles', 'index'),
(22, 2, 'profiles', 'search');

-- --------------------------------------------------------

--
-- Table structure for table `profiles`
--

DROP TABLE IF EXISTS `profiles`;
CREATE TABLE IF NOT EXISTS `profiles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL,
  `active` tinyint(1) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `active` (`active`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

--
-- Dumping data for table `profiles`
--

INSERT INTO `profiles` (`id`, `name`, `active`) VALUES
(1, 'Administrators', 1),
(2, 'Users', 1),
(3, 'Read-Only', 1);

-- --------------------------------------------------------

--
-- Table structure for table `remember_tokens`
--

DROP TABLE IF EXISTS `remember_tokens`;
CREATE TABLE IF NOT EXISTS `remember_tokens` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `token` char(32) NOT NULL,
  `user_agent` varchar(120) NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `token` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `reset_passwords`
--

DROP TABLE IF EXISTS `reset_passwords`;
CREATE TABLE IF NOT EXISTS `reset_passwords` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `code` varchar(48) NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  `modified_at` int(10) unsigned DEFAULT NULL,
  `reset` tinyint(1) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `success_logins`
--

DROP TABLE IF EXISTS `success_logins`;
CREATE TABLE IF NOT EXISTS `success_logins` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `ip_address` char(15) NOT NULL,
  `user_agent` varchar(120) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` char(60) NOT NULL,
  `must_change_password` tinyint(1) unsigned DEFAULT 0,
  `profiles_id` int(10) unsigned NOT NULL,
  `banned` tinyint(1) unsigned NOT NULL DEFAULT 0,
  `suspended` tinyint(1) unsigned NOT NULL DEFAULT 0,
  `active` tinyint(1) unsigned DEFAULT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `profiles_id` (`profiles_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `must_change_password`, `profiles_id`, `banned`, `suspended`, `active`) VALUES
(1, 'Bob Burnquist', 'bob@phalconphp.com', '$2a$08$Lx1577KNhPa9lzFYKssadetmbhaveRtCoVaOnoXXxUIhrqlCJYWCW', 0, 1, 0, 0, 1),
(2, 'Erik', 'erik@phalconphp.com', '$2a$08$f4llgFQQnhPKzpGmY1sOuuu23nYfXYM/EVOpnjjvAmbxxDxG3pbX.', 0, 1, 1, 1, 1),
(3, 'Veronica', 'veronica@phalconphp.com', '$2a$08$NQjrh9fKdMHSdpzhMj0xcOSwJQwMfpuDMzgtRyA89ADKUbsFZ94C2', 0, 1, 0, 0, 1),
(4, 'Yukimi Nagano', 'yukimi@phalconphp.com', '$2a$08$cxxpy4Jvt6Q3xGKgMWIILuf75RQDSroenvoB7L..GlXoGkVEMoSr.', 0, 2, 0, 0, 1);
