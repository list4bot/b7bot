-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- المزود: 127.0.0.1
-- أنشئ في: 09 أكتوبر 2018 الساعة 16:53
-- إصدارة المزود: 5.5.57-0ubuntu0.14.04.1
-- PHP إصدارة: 5.5.9-1ubuntu4.22

USE b7bot;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- قاعدة البيانات: `b7bot`
--

-- --------------------------------------------------------

--
-- بنية الجدول `messages`
--

CREATE TABLE IF NOT EXISTS `messages` (
  `from_id_one` int(100) NOT NULL,
  `message_id_one` int(100) NOT NULL,
  `from_id_two` int(100) NOT NULL,
  `message_id_two` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- بنية الجدول `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `from_id` int(100) NOT NULL,
  `username` text NOT NULL,
  `is_username` int(1) NOT NULL,
  `foreignkey` varchar(6) NOT NULL,
  `banlist` text NOT NULL,
  `step` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
