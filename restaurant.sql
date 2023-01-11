-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Gegenereerd op: 11 mei 2022 om 16:39
-- Serverversie: 10.4.24-MariaDB
-- PHP-versie: 8.1.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Database: `exmane_restaurant`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `bestellingen`
--

CREATE TABLE `bestellingen` (
  `ID` int(11) NOT NULL,
  `Reservering_ID` int(11) NOT NULL,
  `Menuitems_ID` int(11) NOT NULL,
  `Aantal` varchar(255) DEFAULT NULL,
  `Geserverd` tinyint(4) DEFAULT 0,
  `Gerechtsoort_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `gerechtcategorien`
--

CREATE TABLE `gerechtcategorien` (
  `ID` int(11) NOT NULL,
  `Code` varchar(255) DEFAULT NULL,
  `Naam` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Gegevens worden geëxporteerd voor tabel `gerechtcategorien`
--

INSERT INTO `gerechtcategorien` (`ID`, `Code`, `Naam`) VALUES
(1, 'drk', 'Dranken'),
(2, 'hap', 'Hapjes'),
(3, 'hog', 'Hoofdgerechten'),
(4, 'nag', 'Nagerechten'),
(5, 'vog', 'voorgerechten'),
(9, 'TestGroep', 'Groep');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `gerechtsoorten`
--

CREATE TABLE `gerechtsoorten` (
  `ID` int(11) NOT NULL,
  `Code` varchar(255) DEFAULT NULL,
  `Naam` varchar(255) DEFAULT NULL,
  `Gerechtcategorie_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Gegevens worden geëxporteerd voor tabel `gerechtsoorten`
--

INSERT INTO `gerechtsoorten` (`ID`, `Code`, `Naam`, `Gerechtcategorie_ID`) VALUES
(1, 'koh', 'Koude Hapjes', 2),
(3, 'fik', 'Frisdrank', 1),
(4, 'bir', 'Bieren', 1),
(5, 'ijn', 'Ijs', 4),
(6, 'kov', 'Koude voorgerechten', 5),
(7, 'mon', 'Mousse', 4),
(8, 'veh', 'Vegetarisch hoofdgerechten', 3),
(9, 'vih', 'Visgerechten', 3),
(11, 'TestSub', 'Test2', 5);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `klanten`
--

CREATE TABLE `klanten` (
  `ID` int(11) NOT NULL,
  `Naam` varchar(255) NOT NULL,
  `Telefoon` int(11) NOT NULL,
  `Email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Gegevens worden geëxporteerd voor tabel `klanten`
--

INSERT INTO `klanten` (`ID`, `Naam`, `Telefoon`, `Email`) VALUES
(1, 'Testtets', 61234567, '');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `menuitems`
--

CREATE TABLE `menuitems` (
  `ID` int(11) NOT NULL,
  `Code` varchar(255) DEFAULT NULL,
  `Naam` varchar(255) DEFAULT NULL,
  `Gerechtsoort_ID` int(11) NOT NULL,
  `Prijs` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Gegevens worden geëxporteerd voor tabel `menuitems`
--

INSERT INTO `menuitems` (`ID`, `Code`, `Naam`, `Gerechtsoort_ID`, `Prijs`) VALUES
(1, 'bi1', 'Pilsner', 4, '2.95'),
(2, 'Test', 'Test frisdrank invoren', 3, '22.00'),
(4, 'test eten', 'Test eten 1', 5, '23.00'),
(5, 'test2eten', 'test', 9, '2.21'),
(6, 'Etenhap', 'Test etem koude hapjes', 1, '222.00');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `reserveringen`
--

CREATE TABLE `reserveringen` (
  `ID` int(11) NOT NULL,
  `Tafel` int(11) NOT NULL,
  `Klant_ID` int(11) NOT NULL,
  `Datum` date NOT NULL,
  `Tijd` time NOT NULL,
  `Aantal` int(11) NOT NULL,
  `Status` tinyint(4) NOT NULL DEFAULT 1,
  `Datum_toegevoegd` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `Aantal_k` int(11) NOT NULL DEFAULT 0,
  `Allergieen` text DEFAULT NULL,
  `Opmerkingen` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Gegevens worden geëxporteerd voor tabel `reserveringen`
--

INSERT INTO `reserveringen` (`ID`, `Tafel`, `Klant_ID`, `Datum`, `Tijd`, `Aantal`, `Status`, `Datum_toegevoegd`, `Aantal_k`, `Allergieen`, `Opmerkingen`) VALUES
(1, 2, 1, '2022-05-11', '15:33:00', 2, 1, '2022-05-11 13:36:23', 0, '', '');

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `bestellingen`
--
ALTER TABLE `bestellingen`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `Reservering_ID` (`Reservering_ID`),
  ADD KEY `Menuitems_ID` (`Menuitems_ID`);

--
-- Indexen voor tabel `gerechtcategorien`
--
ALTER TABLE `gerechtcategorien`
  ADD PRIMARY KEY (`ID`);

--
-- Indexen voor tabel `gerechtsoorten`
--
ALTER TABLE `gerechtsoorten`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `Gerechtcategorie_ID` (`Gerechtcategorie_ID`);

--
-- Indexen voor tabel `klanten`
--
ALTER TABLE `klanten`
  ADD PRIMARY KEY (`ID`);

--
-- Indexen voor tabel `menuitems`
--
ALTER TABLE `menuitems`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `Gerechtsoort_ID` (`Gerechtsoort_ID`);

--
-- Indexen voor tabel `reserveringen`
--
ALTER TABLE `reserveringen`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `Klant_ID` (`Klant_ID`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `bestellingen`
--
ALTER TABLE `bestellingen`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `gerechtcategorien`
--
ALTER TABLE `gerechtcategorien`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT voor een tabel `gerechtsoorten`
--
ALTER TABLE `gerechtsoorten`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT voor een tabel `klanten`
--
ALTER TABLE `klanten`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT voor een tabel `menuitems`
--
ALTER TABLE `menuitems`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT voor een tabel `reserveringen`
--
ALTER TABLE `reserveringen`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Beperkingen voor geëxporteerde tabellen
--

--
-- Beperkingen voor tabel `bestellingen`
--
ALTER TABLE `bestellingen`
  ADD CONSTRAINT `bestellingen_ibfk_1` FOREIGN KEY (`Reservering_ID`) REFERENCES `reserveringen` (`ID`),
  ADD CONSTRAINT `bestellingen_ibfk_2` FOREIGN KEY (`Menuitems_ID`) REFERENCES `menuitems` (`ID`);

--
-- Beperkingen voor tabel `gerechtsoorten`
--
ALTER TABLE `gerechtsoorten`
  ADD CONSTRAINT `gerechtsoorten_ibfk_1` FOREIGN KEY (`Gerechtcategorie_ID`) REFERENCES `gerechtcategorien` (`ID`);

--
-- Beperkingen voor tabel `menuitems`
--
ALTER TABLE `menuitems`
  ADD CONSTRAINT `menuitems_ibfk_1` FOREIGN KEY (`Gerechtsoort_ID`) REFERENCES `gerechtsoorten` (`ID`);

--
-- Beperkingen voor tabel `reserveringen`
--
ALTER TABLE `reserveringen`
  ADD CONSTRAINT `reserveringen_ibfk_1` FOREIGN KEY (`Klant_ID`) REFERENCES `klanten` (`ID`);
COMMIT;
