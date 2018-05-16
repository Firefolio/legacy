-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 16, 2018 at 07:45 PM
-- Server version: 10.1.24-MariaDB
-- PHP Version: 7.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

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
  `installed` tinyint(1) NOT NULL,
  `username` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `default_password` varchar(256) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `application`
--

INSERT INTO `application` (`name`, `major_version`, `minor_version`, `patch`, `website`, `installed`, `username`, `password`, `default_password`) VALUES
('Firefolio', 0, 9, 0, 'http://firefolio.org/', 1, 'root', '$2y$10$enuAFYVxC6pAeRptkT.AheARTjZzLF35R1s/49fcuF6s4Epu0/mTa', '$2y$10$ranonBYKC2Rd/KNsPQNy1uDokpNGAw80gEPHZu4qyvvqhFJ1WQEmO');

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
('John', '\'Rasmuselerdorf\'', 'Doe', '**Lorem Ipsum** is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 'example@example.com');

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
(1, 'sol', 'https://via.placeholder.com/640x360', 'https://youtu.be/sgHz35ikAkY', 'Sol', '', 'The Sun is the star at the center of the Solar System. It is a nearly perfect sphere of hot plasma, with internal convective motion that generates a magnetic field via a dynamo process.\r\n\r\nIt is by far the most important source of energy for life on Earth. Its diameter is about 1.39 million kilometers, i.e. 109 times that of Earth, and its mass is about 330,000 times that of Earth, accounting for about 99.86% of the total mass of the Solar System.\r\n\r\nAbout three quarters of the Sun\'s mass consists of hydrogen (~73%); the rest is mostly helium (~25%), with much smaller quantities of heavier elements, including oxygen, carbon, neon, and iron.', 'Unspecified', '2018-02-22', 'Public', '', ''),
(2, 'mercury', 'https://via.placeholder.com/640x360', 'https://youtu.be/sgHz35ikAkY', 'Mercury', '', 'Mercury is the smallest and innermost planet in the Solar System. Its orbital period around the Sun of 88 days is the shortest of all the planets in the Solar System. It is named after the Roman deity Mercury, the messenger to the gods.', 'C', '2018-02-16', 'Public', '', ''),
(3, 'venus', 'https://via.placeholder.com/640x360', 'https://youtu.be/sgHz35ikAkY', 'Venus', '', 'Venus is the second planet from the Sun, orbiting it every 224.7 Earth days. It has the longest rotation period of any planet in the Solar System and rotates in the opposite direction to most other planets. It does not have any natural satellites. It is named after the Roman goddess of love and beauty.', 'C#', '2018-02-25', 'Public', '', ''),
(4, 'earth', 'https://via.placeholder.com/640x360', 'https://youtu.be/sgHz35ikAkY', 'Earth', '', 'Earth is the third planet from the Sun and the only object in the Universe known to harbor life. According to radiometric dating and other sources of evidence, Earth formed over 4 billion years ago. Earth\'s gravity interacts with other objects in space, especially the Sun and the Moon, Earth\'s only natural satellite. Earth revolves around the Sun in 365.26 days, a period known as an Earth year. During this time, Earth rotates about its axis about 366.26 times.', 'D', '2018-02-14', 'Public', '', ''),
(5, 'mars', 'https://via.placeholder.com/640x360', 'https://youtu.be/sgHz35ikAkY', 'Mars', '', 'Mars is the fourth planet from the Sun and the second-smallest planet in the Solar System after Mercury. In English, Mars carries a name of the Roman god of war, and is often referred to as the \"Red Planet\" because the reddish iron oxide prevalent on its surface gives it a reddish appearance that is distinctive among the astronomical bodies visible to the naked eye.', 'Dart', '2018-02-03', 'Public', '', ''),
(6, 'jupiter', 'https://via.placeholder.com/640x360', 'https://youtu.be/sgHz35ikAkY', 'Jupiter', '', 'Jupiter is the fifth planet from the Sun and the largest in the Solar System. It is a giant planet with a mass one-thousandth that of the Sun, but two-and-a-half times that of all the other planets in the Solar System combined. Jupiter and Saturn are gas giants; the other two giant planets, Uranus and Neptune are ice giants.', 'Erlang', '2018-02-16', 'Public', '', ''),
(7, 'saturn', 'https://via.placeholder.com/640x360', 'https://youtu.be/sgHz35ikAkY', 'Saturn', '', 'Saturn is the sixth planet from the Sun and the second-largest in the Solar System, after Jupiter. It is a gas giant with an average radius about nine times that of Earth. It has only one-eighth the average density of Earth, but with its larger volume Saturn is over 95 times more massive. Saturn is named after the Roman god of agriculture; its astronomical symbol represents the god\'s sickle.', 'Lua', '2018-02-04', 'Public', '', ''),
(8, 'uranus', 'https://via.placeholder.com/640x360', 'https://youtu.be/sgHz35ikAkY', 'Uranus', '', 'Uranus is the seventh planet from the Sun. It has the third-largest planetary radius and fourth-largest planetary mass in the Solar System. Uranus is similar in composition to Neptune, and both have different bulk chemical composition from that of the larger gas giants Jupiter and Saturn.', 'GLSL', '2018-02-24', 'Public', '', ''),
(9, 'neptune', 'https://via.placeholder.com/640x360', 'https://youtu.be/sgHz35ikAkY', 'Neptune', '', 'Neptune is the eighth and farthest known planet from the Sun in the Solar System. In the Solar System, it is the fourth-largest planet by diameter, the third-most-massive planet, and the densest giant planet.', 'HLSL', '2018-02-24', 'Public', '', '');

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
-- Indexes for table `profile`
--
ALTER TABLE `profile`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
