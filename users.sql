-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Dic 01, 2023 alle 20:40
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
  `cookie_expiration` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `users`
--

INSERT INTO `users` (`id`, `nome`, `cognome`, `email`, `password`, `registration_date`, `admin`, `rememberMeToken`, `cookie_expiration`) VALUES
(1, 'admin', 'admin', 'admin@gmail.com', '$2y$10$ebeGDLhweRQiPZV.HLR4FOlHcl/r1kpUHgQtV3SGgnkzsROBN/2wu', '2023-11-30 23:00:00', 1, NULL, NULL),
(5, 'Andrea', 'Parisi', 'andreaparisi917@gmail.com', '$2y$10$cGCL0LqYE9KouC5Np7cxzOQIJIeHvlLWlIGaAcHnrL101Z.gNQsRC', '2023-12-01 13:57:32', 0, NULL, NULL),
(6, 'Andrea', 'Parisi', 'andreaparisi917@gmail.co', '$2y$10$ijwlLP.WZRJ1ADRv2OY5G.9JJleu1t9aSSLl3awA6rHcNbnwHhFqq', '2023-12-01 14:02:20', 0, NULL, NULL),
(7, 'aad', 'ad', 'andreaparisi917@gm.hh', '$2y$10$NLvsE7lJtPXwCNICx.86suaxVuIuqMZEV7VssogHIWBb0PY15.7aG', '2023-12-01 14:24:11', 0, NULL, NULL),
(8, 'Andrea', 'Parisi', 'andreaparisi917@gmail.coma', '$2y$10$ZnRRh0ykIjVxPyBOzudm6.eVjk566WVVcsPsbqUx/RzQX5q6K97y6', '2023-12-01 14:37:39', 0, NULL, NULL),
(9, 'Andrea', 'Parisi', 'andreaparisi917@gmail.comaa', '$2y$10$X7Mmp/IVrOV3evy2I0H..uwSSPZUSWNgsFZAzLGJ59ZaMgh1AAO/i', '2023-12-01 14:49:54', 0, NULL, NULL),
(11, 'Andrea', 'Parisi', 'andreaparisi917@gmail.col', '$2y$10$3JSzAx1eKcFCUs21vdhUv.5PFZmcG51AyC/PaxxJdsGcvYGCphlO.', '2023-12-01 18:03:27', 0, NULL, NULL),
(19, 'Andrea', 'Parisi', 'andreaparisi917@gmail.comaaa', '$2y$10$uySfaO37.GnBu3dreBLL0.Iq2lshi3oitGp6.WUpPDDh8mpt88oNy', '2023-12-01 18:59:44', 0, NULL, NULL);

--
-- Indici per le tabelle scaricate
--

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
-- AUTO_INCREMENT per la tabella `users`
--
ALTER TABLE `users`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
