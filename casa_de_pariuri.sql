-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Gazdă: 127.0.0.1
-- Timp de generare: mai 16, 2023 la 09:50 PM
-- Versiune server: 10.4.28-MariaDB
-- Versiune PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Bază de date: `casa_de_pariuri`
--

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `angajat`
--

CREATE TABLE `angajat` (
  `CODA` int(11) NOT NULL,
  `Nume` varchar(45) NOT NULL,
  `Prenume` varchar(45) NOT NULL,
  `Varsta` int(11) NOT NULL,
  `CODP` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Eliminarea datelor din tabel `angajat`
--

INSERT INTO `angajat` (`CODA`, `Nume`, `Prenume`, `Varsta`, `CODP`) VALUES
(1, 'Popescu', 'Vasile', 30, 1),
(2, 'Popescu', 'Marian', 30, 1),
(3, 'Astefanesei', 'Iulian', 35, 1);

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `aparat`
--

CREATE TABLE `aparat` (
  `CODAP` int(11) NOT NULL,
  `Nume` varchar(45) NOT NULL,
  `Producator` varchar(45) NOT NULL,
  `Vechime` int(11) NOT NULL,
  `Cost` int(11) NOT NULL,
  `CODP` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Eliminarea datelor din tabel `aparat`
--

INSERT INTO `aparat` (`CODAP`, `Nume`, `Producator`, `Vechime`, `Cost`, `CODP`) VALUES
(1, 'A', 'A', 10, 500, 1),
(2, 'B', 'B', 5, 1000, 2),
(3, 'C', 'B', 8, 700, 2);

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `casa_de_pariuri`
--

CREATE TABLE `casa_de_pariuri` (
  `CODP` int(11) NOT NULL,
  `Nume` varchar(45) NOT NULL,
  `Locatie` varchar(45) NOT NULL,
  `Contact` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Eliminarea datelor din tabel `casa_de_pariuri`
--

INSERT INTO `casa_de_pariuri` (`CODP`, `Nume`, `Locatie`, `Contact`) VALUES
(1, 'MAGIC JACKPOT', 'Galati', ' 202-918-2132'),
(2, 'MR BIT', 'Galati', '505-415-0147'),
(3, 'MR BIT', 'Braila', '505-576-1721');

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `client`
--

CREATE TABLE `client` (
  `CNP` int(11) NOT NULL,
  `Nume` varchar(45) NOT NULL,
  `Prenume` varchar(45) NOT NULL,
  `Adresa` varchar(45) NOT NULL,
  `Varsta` int(11) NOT NULL,
  `CODPA` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Eliminarea datelor din tabel `client`
--

INSERT INTO `client` (`CNP`, `Nume`, `Prenume`, `Adresa`, `Varsta`, `CODPA`) VALUES
(12345, 'Popescu', 'Andrei', 'Galati', 20, 1),
(12346, 'Popescu', 'Mihai', 'Galati', 21, 1),
(12347, 'Boeuru', 'GeorgeBraila', 'Braila', 22, 1);

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `cota`
--

CREATE TABLE `cota` (
  `CODC` int(11) NOT NULL,
  `Miza` float NOT NULL,
  `Castiguri` float NOT NULL,
  `Profit` float NOT NULL,
  `Sansa` float NOT NULL,
  `CODPA` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Eliminarea datelor din tabel `cota`
--

INSERT INTO `cota` (`CODC`, `Miza`, `Castiguri`, `Profit`, `Sansa`, `CODPA`) VALUES
(1, 100, 200, 100, 2, 1),
(2, 200, 400, 200, 2, 1),
(3, 400, 800, 400, 2, 1);

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `pariu`
--

CREATE TABLE `pariu` (
  `CODPA` int(11) NOT NULL,
  `Tip` varchar(45) NOT NULL,
  `Sport` varchar(45) NOT NULL,
  `Data_Incheieri` date NOT NULL,
  `Data_Realizari` date NOT NULL,
  `CODAP` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Eliminarea datelor din tabel `pariu`
--

INSERT INTO `pariu` (`CODPA`, `Tip`, `Sport`, `Data_Incheieri`, `Data_Realizari`, `CODAP`) VALUES
(1, 'Simplu', 'Fotbal', '2023-05-17', '2023-05-27', 1),
(2, 'Handicap Asiatic', 'Fotbal', '2023-05-17', '2023-06-22', 1),
(3, 'Simplu', 'Handball', '2023-06-17', '2023-07-30', 2);

--
-- Indexuri pentru tabele eliminate
--

--
-- Indexuri pentru tabele `angajat`
--
ALTER TABLE `angajat`
  ADD PRIMARY KEY (`CODA`),
  ADD KEY `CODP` (`CODP`);

--
-- Indexuri pentru tabele `aparat`
--
ALTER TABLE `aparat`
  ADD PRIMARY KEY (`CODAP`),
  ADD KEY `CODP` (`CODP`);

--
-- Indexuri pentru tabele `casa_de_pariuri`
--
ALTER TABLE `casa_de_pariuri`
  ADD PRIMARY KEY (`CODP`);

--
-- Indexuri pentru tabele `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`CNP`),
  ADD KEY `CODPA` (`CODPA`);

--
-- Indexuri pentru tabele `cota`
--
ALTER TABLE `cota`
  ADD PRIMARY KEY (`CODC`),
  ADD KEY `CODPA` (`CODPA`);

--
-- Indexuri pentru tabele `pariu`
--
ALTER TABLE `pariu`
  ADD PRIMARY KEY (`CODPA`),
  ADD KEY `CODAP` (`CODAP`);

--
-- Constrângeri pentru tabele eliminate
--

--
-- Constrângeri pentru tabele `angajat`
--
ALTER TABLE `angajat`
  ADD CONSTRAINT `angajat_ibfk_1` FOREIGN KEY (`CODP`) REFERENCES `casa_de_pariuri` (`CODP`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constrângeri pentru tabele `aparat`
--
ALTER TABLE `aparat`
  ADD CONSTRAINT `aparat_ibfk_1` FOREIGN KEY (`CODP`) REFERENCES `casa_de_pariuri` (`CODP`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constrângeri pentru tabele `client`
--
ALTER TABLE `client`
  ADD CONSTRAINT `client_ibfk_1` FOREIGN KEY (`CODPA`) REFERENCES `pariu` (`CODPA`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constrângeri pentru tabele `cota`
--
ALTER TABLE `cota`
  ADD CONSTRAINT `cota_ibfk_1` FOREIGN KEY (`CODPA`) REFERENCES `pariu` (`CODPA`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constrângeri pentru tabele `pariu`
--
ALTER TABLE `pariu`
  ADD CONSTRAINT `pariu_ibfk_1` FOREIGN KEY (`CODAP`) REFERENCES `aparat` (`CODAP`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
