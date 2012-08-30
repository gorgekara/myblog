-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 07, 2012 at 02:42 PM
-- Server version: 5.5.24
-- PHP Version: 5.3.10-1ubuntu3.2

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `cmsbase`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `CategoryID` int(25) NOT NULL AUTO_INCREMENT,
  `Categories` varchar(20) NOT NULL,
  PRIMARY KEY (`CategoryID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`CategoryID`, `Categories`) VALUES
(13, 'Web'),
(14, 'Software');

-- --------------------------------------------------------

--
-- Table structure for table `commenting`
--

CREATE TABLE IF NOT EXISTS `commenting` (
  `PostID` int(11) NOT NULL,
  `CommentID` int(11) NOT NULL,
  `TimeDate` varchar(15) NOT NULL,
  `CommentingID` int(11) NOT NULL AUTO_INCREMENT,
  `UserID` int(11) NOT NULL,
  PRIMARY KEY (`CommentingID`),
  KEY `CommentID` (`CommentID`),
  KEY `PostID` (`PostID`),
  KEY `UserID` (`UserID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `CommentID` int(11) NOT NULL AUTO_INCREMENT,
  `Comment` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`CommentID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=56 ;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`CommentID`, `Comment`) VALUES
(40, 'test comment'),
(41, 'adsdsa'),
(42, '<br>'),
(43, 'awasdsadassad'),
(44, 'Looks amazing!<br>'),
(52, 'The moment of truth!'),
(55, 'Nice Yoda you have done!');

-- --------------------------------------------------------

--
-- Table structure for table `options`
--

CREATE TABLE IF NOT EXISTS `options` (
  `OptionID` int(11) NOT NULL AUTO_INCREMENT,
  `OptionName` varchar(200) NOT NULL,
  `Value` varchar(200) NOT NULL,
  PRIMARY KEY (`OptionID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `options`
--

INSERT INTO `options` (`OptionID`, `OptionName`, `Value`) VALUES
(6, 'Site Title', 'Bgy'),
(7, 'Footer text', 'Bgy &copy; 2012'),
(8, 'Blog tagline', 'Modern blog for modern people'),
(9, 'Blog image', 'http://localhost/d/Images/site_logo.png');

-- --------------------------------------------------------

--
-- Table structure for table `password`
--

CREATE TABLE IF NOT EXISTS `password` (
  `PasswordID` int(11) NOT NULL AUTO_INCREMENT,
  `Passwords` varchar(200) NOT NULL,
  `UserID` int(11) NOT NULL,
  PRIMARY KEY (`PasswordID`),
  KEY `UserID` (`UserID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `password`
--

INSERT INTO `password` (`PasswordID`, `Passwords`, `UserID`) VALUES
(1, '202cb962ac59075b964b07152d234b70', 27),
(6, '8b4cf0258846b23e0a8272bee22c38dd', 32),
(7, '8b4cf0258846b23e0a8272bee22c38dd', 33),
(8, '202cb962ac59075b964b07152d234b70', 34);

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE IF NOT EXISTS `post` (
  `PostID` int(11) NOT NULL AUTO_INCREMENT,
  `PostTitle` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `PostContent` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `PostImage` text NOT NULL,
  `Tags` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `CategoryID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `Time` varchar(20) NOT NULL,
  `Date` varchar(20) NOT NULL,
  PRIMARY KEY (`PostID`),
  KEY `CategoryID` (`CategoryID`),
  KEY `UserID` (`UserID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=95 ;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`PostID`, `PostTitle`, `PostContent`, `PostImage`, `Tags`, `CategoryID`, `UserID`, `Time`, `Date`) VALUES
(94, 'das', 'dsadas', 'http://2.bp.blogspot.com/-nmQRB3iW8io/Tjv3rMXg2lI/AAAAAAAASgE/GQFSWMffWAg/s1600/movie_preview_screen13bacdefg_copy.jpg', 'system76 test', 14, 33, '00:17', '06-07-2012');

-- --------------------------------------------------------

--
-- Table structure for table `usernames`
--

CREATE TABLE IF NOT EXISTS `usernames` (
  `UserID` int(11) NOT NULL AUTO_INCREMENT,
  `Username` varchar(50) NOT NULL,
  `Email` varchar(150) NOT NULL,
  `RName` varchar(50) NOT NULL,
  `RSurname` varchar(50) NOT NULL,
  `About` text NOT NULL,
  `Admin` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`UserID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=35 ;

--
-- Dumping data for table `usernames`
--

INSERT INTO `usernames` (`UserID`, `Username`, `Email`, `RName`, `RSurname`, `About`, `Admin`) VALUES
(27, 'karagorge', 'gorgekara@gmail.com', 'Gjorge', 'Karakabakov', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 1),
(32, 'dark4p', 'gorgekara@gmail.com', 'Anon', 'Anonymous', 'Here should stand description of the user', 0),
(33, 'david', 'dpetkov21@hotmail.com', 'Anon', 'Anonymous', 'Here should stand description of the user', 0),
(34, 'newuser', 'newuser@gmail.com', 'Anon', 'Anonymous', 'Here should stand description of the user', 0);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `commenting`
--
ALTER TABLE `commenting`
  ADD CONSTRAINT `commenting_ibfk_1` FOREIGN KEY (`CommentID`) REFERENCES `comments` (`CommentID`) ON DELETE CASCADE,
  ADD CONSTRAINT `commenting_ibfk_2` FOREIGN KEY (`PostID`) REFERENCES `post` (`PostID`) ON DELETE CASCADE,
  ADD CONSTRAINT `commenting_ibfk_3` FOREIGN KEY (`UserID`) REFERENCES `usernames` (`UserID`);

--
-- Constraints for table `password`
--
ALTER TABLE `password`
  ADD CONSTRAINT `password_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `usernames` (`UserID`);

--
-- Constraints for table `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `post_ibfk_1` FOREIGN KEY (`CategoryID`) REFERENCES `category` (`CategoryID`),
  ADD CONSTRAINT `post_ibfk_2` FOREIGN KEY (`UserID`) REFERENCES `usernames` (`UserID`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
