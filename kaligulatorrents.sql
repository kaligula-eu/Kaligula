-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 21. Jun 2022 um 19:07
-- Server-Version: 10.4.22-MariaDB
-- PHP-Version: 7.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `kaligulatorrents`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `image` varchar(100) NOT NULL DEFAULT 'default.png',
  `added` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `config`
--

CREATE TABLE `config` (
  `title` varchar(20) NOT NULL,
  `slogan` varchar(100) NOT NULL,
  `registration` tinyint(1) NOT NULL DEFAULT 1,
  `fontawesome` varchar(20) NOT NULL,
  `cookie` varchar(20) NOT NULL,
  `url` varchar(100) NOT NULL,
  `announce` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `invites`
--

CREATE TABLE `invites` (
  `id` int(11) NOT NULL,
  `creator` int(11) NOT NULL,
  `token` text NOT NULL,
  `user` int(11) DEFAULT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  `used` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `peers`
--

CREATE TABLE `peers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ipAddress` varchar(80) NOT NULL,
  `port` int(11) NOT NULL,
  `peerId` varchar(40) NOT NULL,
  `infoHash` varchar(40) NOT NULL,
  `key` varchar(40) NOT NULL,
  `userAgent` varchar(80) NOT NULL,
  `expire` int(11) NOT NULL,
  `isSeed` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `sessions`
--

CREATE TABLE `sessions` (
  `user-id` int(11) NOT NULL,
  `token` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `torrents`
--

CREATE TABLE `torrents` (
  `id` int(11) NOT NULL,
  `slug` text NOT NULL,
  `name` varchar(250) NOT NULL,
  `link` text NOT NULL,
  `infohash` text NOT NULL,
  `file` text NOT NULL,
  `description` text DEFAULT NULL,
  `user` int(11) NOT NULL,
  `type` varchar(20) NOT NULL DEFAULT 'Original',
  `deleted` tinyint(1) NOT NULL DEFAULT 0,
  `deleted_reason` text DEFAULT NULL,
  `added` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` text NOT NULL,
  `image` text NOT NULL DEFAULT 'https://cdn.henai.eu/assets/images/avatar.png',
  `country` int(11) DEFAULT NULL,
  `default_uplang` varchar(2) NOT NULL DEFAULT 'en',
  `website` varchar(200) DEFAULT NULL,
  `about` text DEFAULT NULL,
  `level` int(11) NOT NULL DEFAULT 4,
  `theme` int(11) NOT NULL DEFAULT 3,
  `banned` tinyint(1) NOT NULL DEFAULT 0,
  `banned_reason` varchar(200) DEFAULT NULL,
  `joined` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `config`
--
ALTER TABLE `config`
  ADD UNIQUE KEY `title` (`title`);

--
-- Indizes für die Tabelle `invites`
--
ALTER TABLE `invites`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `peers`
--
ALTER TABLE `peers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `infoHash` (`infoHash`),
  ADD KEY `peerId` (`peerId`);

--
-- Indizes für die Tabelle `torrents`
--
ALTER TABLE `torrents`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `invites`
--
ALTER TABLE `invites`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `peers`
--
ALTER TABLE `peers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `torrents`
--
ALTER TABLE `torrents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
