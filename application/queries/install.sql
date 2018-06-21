-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 11, 2018 at 11:05 AM
-- Server version: 10.1.24-MariaDB
-- PHP Version: 7.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Database: `firefolio`
--

-- --------------------------------------------------------

--
-- Table structure for table `application`
--

CREATE TABLE `application` (
  `name` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `major_version` int(11) NOT NULL,
  `minor_version` int(11) NOT NULL,
  `patch` int(11) NOT NULL,
  `website` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `default_username` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `default_password` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `mode` enum('Debug','Release','Demo') COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `application`
--

INSERT INTO `application` (`name`, `major_version`, `minor_version`, `patch`, `website`, `username`, `default_username`, `password`, `default_password`, `mode`) VALUES
('Firefolio', 1, 0, 1, 'http://firefolio.org/', 'root', 'root', '$2y$10$xnEuArz9F2S0gt311YBNxu6YNuPxZHNgBozxQl8kn0IlACCg5gDjm', 'changeitnow', 'Release');

-- --------------------------------------------------------

--
-- Table structure for table `hyperlinks`
--

CREATE TABLE `hyperlinks` (
  `id` int(128) NOT NULL,
  `type` enum('profile','project') COLLATE utf8_unicode_ci NOT NULL,
  `header` varchar(1024) COLLATE utf8_unicode_ci NOT NULL,
  `url` varchar(2048) COLLATE utf8_unicode_ci NOT NULL,
  `project` int(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `profile`
--

CREATE TABLE `profile` (
  `first_name` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `middle_name` varchar(512) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(1024) COLLATE utf8_unicode_ci NOT NULL,
  `biography` text COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(128) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `profile`
--

INSERT INTO `profile` (`first_name`, `middle_name`, `last_name`, `biography`, `email`) VALUES
('John', '\'Rasmuselerdorf\'', 'Doe', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 'example@example.com');

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` int(8) NOT NULL,
  `uri` varchar(512) COLLATE utf8_unicode_ci NOT NULL,
  `thumbnail` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `trailer` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(512) COLLATE utf8_unicode_ci NOT NULL,
  `subtitle` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `language` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `visibility` enum('Public','Private') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Private',
  `status` enum('In Development','Postponed','Released','Cancelled','Prototype') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'In Development',
  `purpose` varchar(64) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `uri`, `thumbnail`, `trailer`, `title`, `subtitle`, `description`, `language`, `date`, `visibility`, `status`, `purpose`) VALUES
(1, 'hello_world', 'https://via.placeholder.com/640x480', '', 'Hello, World!', '', 'This is your first project. Keep it, edit it or throw it away. Be sure to [read the documentation](https://firefolio.readthedocs.io/) if you\'re stuck!', '', '2018-06-21', 'Public', 'Prototype', 'Demo');

-- --------------------------------------------------------

--
-- Table structure for table `screenshots`
--

CREATE TABLE `screenshots` (
  `id` int(32) NOT NULL,
  `path` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `caption` text COLLATE utf8_unicode_ci NOT NULL,
  `project` int(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `application`
--
ALTER TABLE `application`
  ADD PRIMARY KEY (`name`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `hyperlinks`
--
ALTER TABLE `hyperlinks`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `profile`
--
ALTER TABLE `profile`
  ADD PRIMARY KEY (`email`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `screenshots`
--
ALTER TABLE `screenshots`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `hyperlinks`
--
ALTER TABLE `hyperlinks`
  MODIFY `id` int(128) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `screenshots`
--
ALTER TABLE `screenshots`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
