-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Dic 13, 2023 alle 19:47
-- Versione del server: 10.4.32-MariaDB
-- Versione PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sawdata`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `articoli`
--

CREATE TABLE `articoli` (
  `articleNum` int(3) NOT NULL,
  `title` varchar(300) NOT NULL,
  `article` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `articoli`
--

INSERT INTO `articoli` (`articleNum`, `title`, `article`) VALUES
(3, '<h1>&lt;script&gt;asdadada&lt;/script&gt;</h1>', '\n<p>yfhyrhrsht</p>\n<p>srdgeasgrf</p>\n<p>gsrgdstrg</p>\n<p>sdfggr</p>'),
(4, '<h1>a</h1>', '\n<p>sddccdbfc</p>\n<p>dafjkasdbfhk</p>\n<p>dashkbdfas</p>');

-- --------------------------------------------------------

--
-- Struttura della tabella `users`
--

CREATE TABLE `users` (
  `id` int(50) NOT NULL,
  `nome` varchar(30) NOT NULL,
  `cognome` varchar(30) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(150) NOT NULL,
  `registration_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `admin` tinyint(1) NOT NULL,
  `rememberMeToken` varchar(150) DEFAULT NULL,
  `cookie_expiration` date DEFAULT NULL,
  `telefono` varchar(10) DEFAULT NULL,
  `indirizzo` varchar(150) DEFAULT NULL,
  `eta` int(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `users`
--

INSERT INTO `users` (`id`, `nome`, `cognome`, `email`, `password`, `registration_date`, `admin`, `rememberMeToken`, `cookie_expiration`, `telefono`, `indirizzo`, `eta`) VALUES
(1, 'admin', 'admin', 'admin@gmail.com', '$2y$10$ebeGDLhweRQiPZV.HLR4FOlHcl/r1kpUHgQtV3SGgnkzsROBN/2wu', '2023-11-30 23:00:00', 1, NULL, NULL, NULL, NULL, NULL),
(38, 'Andrea', 'Parisi', 'andreapariaasi917@gmail.comaaaa', '$2y$10$GlKrEpY052IW.N77lC6B8ureAO2Qqtta52u92NVQpfnZ.gO54VyJ.', '2023-12-07 14:48:21', 0, NULL, NULL, '', '', 0),
(39, 'Andrea', 'Pa', 'ndreaaaaparisi917@gmail.coma', '$2y$10$/poQjOCagXJYg8B77jFzpuqsDYvg4oc/ipx0B3pB8Anvl4sGldT.i', '2023-12-08 15:23:03', 0, NULL, NULL, NULL, NULL, NULL),
(40, 'Andreaaa', 'Parisi', 'andreaparisi917@gmail.com', '$2y$10$aJlfy96DySXk7v2SA/xykenhcU.iK7GLe7KtgRbkWV/srtflof0mK', '2023-12-11 23:23:15', 0, NULL, NULL, NULL, NULL, NULL),
(41, 'Andrea', 'Parisi', 'andreaparisi917@gmail.coma', '$2y$10$gQpAHL3FwX9mRwfN8EUHi.KImqcpgYxtN843UglYUTiRFJxHJP7Qa', '2023-12-13 16:45:15', 0, NULL, NULL, NULL, NULL, NULL);

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `articoli`
--
ALTER TABLE `articoli`
  ADD PRIMARY KEY (`articleNum`);

--
-- Indici per le tabelle `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `articoli`
--
ALTER TABLE `articoli`
  MODIFY `articleNum` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT per la tabella `users`
--
ALTER TABLE `users`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
