-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 02. Dez 2024 um 16:09
-- Server-Version: 10.4.22-MariaDB
-- PHP-Version: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `scooterverleih`
--
CREATE DATABASE IF NOT EXISTS `scooterverleih` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `scooterverleih`;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `person`
--

CREATE TABLE `person` (
  `Person_Id` int(11) NOT NULL,
  `Person_Nachname` varchar(50) NOT NULL,
  `Person_Vorname` varchar(50) DEFAULT NULL,
  `Person_Strasse` varchar(50) DEFAULT NULL,
  `Person_PLZ` varchar(20) DEFAULT NULL,
  `Person_Ort` varchar(50) DEFAULT NULL,
  `Person_SVNr` varchar(10) NOT NULL,
  `Person_Email` varchar(50) DEFAULT NULL,
  `Person_Stammkunde` tinyint(1) NOT NULL DEFAULT 0,
  `Person_Geschlecht` varchar(1) DEFAULT NULL,
  `Person_Abonnement` varchar(10) NOT NULL DEFAULT 'klein',
  `Person_Passwort` varchar(255) NOT NULL COMMENT 'muss so lang sein wegen Verschlüsselung'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `person`
--

INSERT INTO `person` (`Person_Id`, `Person_Nachname`, `Person_Vorname`, `Person_Strasse`, `Person_PLZ`, `Person_Ort`, `Person_SVNr`, `Person_Email`, `Person_Stammkunde`, `Person_Geschlecht`, `Person_Abonnement`, `Person_Passwort`) VALUES
(66, 'Mueller', 'Nathalie', 'Buxdehude 1', '1010', 'Wien', '4367300104', 'nathalie.mueller@gmail.com', 0, 'w', 'klein', '$2y$10$D9/dOuv8IseLVXBDVRdbc.60ujs/An8lo/h5zqbETTF43sfgndQv.'),
(67, 'Bauer', 'Reinhard', 'Axelweg 1', '1010', 'Wien', '4612091060', 'reinhard.bauer@gmail.com', 0, 'm', 'klein', '$2y$10$6mZXjDiPIV/alvMGtC.hiuDpkgDNALSjef3w1lTFaXcp15MlDyhF2'),
(70, 'Mueller', 'Hans', 'Buxdehude 1', '1010', 'Wien', '4612022106', 'hans.mueller@gmail.com', 0, 'm', 'klein', '$2y$10$6mZXjDiPIV/alvMGtC.hiuDpkgDNALSjef3w1lTFaXcp15MlDyhF2');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `scooter`
--

CREATE TABLE `scooter` (
  `Scooter_Id` int(11) NOT NULL,
  `Scooter_Seriennummer` varchar(20) NOT NULL,
  `Scooter_Baujahr` year(4) NOT NULL,
  `Scooter_Farbe` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `scooter`
--

INSERT INTO `scooter` (`Scooter_Id`, `Scooter_Seriennummer`, `Scooter_Baujahr`, `Scooter_Farbe`) VALUES
(1, 'A2020-231', 2021, 'gelb'),
(2, 'A2020-232', 2021, 'blau'),
(3, 'A2020-233', 2021, 'rot'),
(5, 'A2020-234', 2021, 'grün'),
(6, 'A2021-100', 2024, 'rosa'),
(7, 'A2021-101', 2024, 'violett'),
(8, 'A2021-102', 2024, 'türkis');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `verleih`
--

CREATE TABLE `verleih` (
  `Verleih_Id` int(11) NOT NULL,
  `Person_Id` int(11) NOT NULL,
  `VerleihAmUm` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `verleih`
--

INSERT INTO `verleih` (`Verleih_Id`, `Person_Id`, `VerleihAmUm`) VALUES
(9, 66, '2022-04-17 16:24:50');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `verleihposition`
--

CREATE TABLE `verleihposition` (
  `Verleihposition_id` int(11) NOT NULL,
  `Scooter_id` int(11) NOT NULL,
  `Verleih_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `verleihposition`
--

INSERT INTO `verleihposition` (`Verleihposition_id`, `Scooter_id`, `Verleih_id`) VALUES
(19, 5, 9),
(20, 6, 9),
(21, 7, 9);

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `person`
--
ALTER TABLE `person`
  ADD PRIMARY KEY (`Person_Id`),
  ADD UNIQUE KEY `eindeutig` (`Person_SVNr`);

--
-- Indizes für die Tabelle `scooter`
--
ALTER TABLE `scooter`
  ADD PRIMARY KEY (`Scooter_Id`),
  ADD UNIQUE KEY `eindeutig` (`Scooter_Seriennummer`);

--
-- Indizes für die Tabelle `verleih`
--
ALTER TABLE `verleih`
  ADD PRIMARY KEY (`Verleih_Id`),
  ADD UNIQUE KEY `eindeutig` (`Person_Id`,`VerleihAmUm`);

--
-- Indizes für die Tabelle `verleihposition`
--
ALTER TABLE `verleihposition`
  ADD PRIMARY KEY (`Verleihposition_id`),
  ADD UNIQUE KEY `eindeutig` (`Scooter_id`,`Verleih_id`),
  ADD KEY `Verleih_id` (`Verleih_id`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `person`
--
ALTER TABLE `person`
  MODIFY `Person_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT für Tabelle `scooter`
--
ALTER TABLE `scooter`
  MODIFY `Scooter_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT für Tabelle `verleih`
--
ALTER TABLE `verleih`
  MODIFY `Verleih_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT für Tabelle `verleihposition`
--
ALTER TABLE `verleihposition`
  MODIFY `Verleihposition_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `verleih`
--
ALTER TABLE `verleih`
  ADD CONSTRAINT `verleih_ibfk_1` FOREIGN KEY (`Person_Id`) REFERENCES `person` (`Person_Id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints der Tabelle `verleihposition`
--
ALTER TABLE `verleihposition`
  ADD CONSTRAINT `verleihposition_ibfk_1` FOREIGN KEY (`Verleih_id`) REFERENCES `verleih` (`Verleih_Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `verleihposition_ibfk_2` FOREIGN KEY (`Scooter_id`) REFERENCES `scooter` (`Scooter_Id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
