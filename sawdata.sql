-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Dic 17, 2023 alle 17:44
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
  `articleNum` int(4) NOT NULL,
  `title` varchar(300) NOT NULL,
  `article` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `articoli`
--

INSERT INTO `articoli` (`articleNum`, `title`, `article`) VALUES
(21, '<h1>Sai andare a cedimento?</h1>', '\n<p>Le discussioni su “cedimento si/cedimento no” infiammano sempre gli appassionati, così come quelle sull’esercizio migliore, il carico giusto, la tecnica di intensificazione più efficace e via dicendo.<br><strong>C’è un punto fondamentale che viene sempre dato per scontato: che si riesca davvero ad impegnarsi al massimo</strong>, che ci si sappia spremere a dovere e che, alla fine, se a cedimento si deve andare… che cedimento sia.</p>\n<p><strong>“Andare a cedimento” significa arrivare all’incapacità nel continuare nelle ripetizioni di un esercizio,</strong>&nbsp;è quello che si definisce “cedimento concentrico”. Stabilisco un carico, faccio più ripetizioni possibili con quel carico, dovrebbe essere facile ma in realtà lo è molto molto meno.</p>\n<h2 id=\"2-il-carico-auto-selezionato\"><strong>Il carico auto-selezionato</strong></h2>\n<p>Un aspetto molto sottovalutato è che la persona seleziona sempre un carico per fare un certo numero di ripetizioni. Se deve, cioè, fare un 3×8 che poi diventa 8-6-4 deve identificare quel carico tale per cui può fare 8 ripetizioni ma non 8 e un quarto. Se toppa quel carico e si ferma a 8 (in questo caso)… poco male, tanto ci sono le serie successive dove tirare al massimo!</p>\n<p>Il problema è questo: ok toppare ma… di quanto? 1-2 ripetizioni ci sta, ma 5, 6 o addirittura 10? “Eh ma chi può sbagliare così tanto?”</p>\n<p>Sebbene gli studi scientifici nel campo dell’allenamento in palestra abbiano solitamente una serie di problematiche è però necessario rivolgersi a questi per capire qualcosa, poi starà a noi ragionare sui dati, sui numeri, ma solo gli studi hanno numeri affidabili che non sono sensazioni o “per me” o “io mi trovo bene così” che sono tutte posizioni apprezzabili se però non si estende questo giudizio ad altri, cosa che non succede mai perché vige il “va bene per me, è fantastico per tuti”.</p>\n<p>“Self-Selected Resistance Exercise Load: Implications for Research and Prescription” di Barbosa-Netto per il Journal of Strength And Conditioning Research del 2017 mette in evidenza le estreme difficoltà nella scelta dei carichi allenanti in un dato esercizio che hanno i soggetti che frequentano normalmente le palestre commerciale.</p>\n<p>Questo studio, molto carino, ha visto coinvolti 160 soggetti senza alcuna patologia alle spalle con un minimo di 6 mesi di anzianità di palestra e di allenamento nella panca piana. Diciamo un campione rappresentativo della fauna tipica del fitness.&nbsp;<strong>A queste persone è stato chiesto: “che carico useresti per una serie tirata di panca da 10 ripetizioni?”</strong>, poi ognuno ha fatto, appunto, una serie tirata con quel carico. La tecnica utilizzata era anch’essa rappresentativa del mondo delle palestre, a meno di certe cose ignobili che si continuano a vedere tutt’ora: testa e glutei sulla panca, piedi a terra, il bilanciere parte e arriva a braccia serrate, toccando nel punto intermedio il petto senza rimbalzo).</p>\n<p>Durante la serie ogni soggetto è stato esortato, stile navy seals, a macinare una ripetizione in più, poi una in più, ancora una in più e così via.&nbsp;<strong>Alla fine sono state contate le ripetizioni fatte e confrontate con quelle da fare, cioè 10: più la differenza era elevata e più la persona aveva toppato.</strong></p>'),
(22, '<h1>3’ di recupero per l’ipertrofia</h1>', '\n<p>n palestra<strong>&nbsp;il parametro “recupero” è il meno compreso</strong>&nbsp;e il più sottovalutato quando, appunto, è il mezzo grazie al quale è possibile modulare la tensione meccanica nel suo complesso. Sono pochi, infatti, quelli che tengono conto del tempo che passa con un cronometro o semplicemente guardando l’orologio presente in tutte le palestre.</p>\n<h2 id=\"2-recuperi-brevi-per-aumentare-gli-ormoni-no-grazie\"><strong>Recuperi brevi per aumentare gli ormoni? No grazie</strong></h2>\n<p>In passato<strong>&nbsp;l’“hormone hypotesis</strong>” aveva definito una modalità di allenamento per l’ipertrofia dove i recuperi fra le serie dovevano essere brevi perché questo garantiva un innalzamento degli ormoni anabolici maggiore che con recupero lunghi. L’ipotesi&nbsp;<strong>è stata smentita</strong>&nbsp;poiché l’aumento in acuto delle concentrazioni ormonali anaboliche non si correlava poi con un incremento dell’ipertrofia, ma ancora oggi la tendenza ad avere recuperi brevi è sempre presente nelle classiche schede da palestra: il recupero è sempre di circa 1’, valore che al tempo veniva ritenuto corretto per lo sviluppo ipertrofico.</p>\n<p>In più i soliti refrain “sento bruciare”, “mi sento pompato”, “sono arrivato morto” dati da un recupero breve hanno sempre il loro fascino: la fatica come valore, la fatica come metro di giudizio della bontà di quello che si sta facendo. Il punto è che… sì, la fatica è un valore e come tutte le cose di valore va spesa con parsimonia, solo se serve.</p>\n<p><strong>La letteratura scientifica non ha però indicato un valore ideale del recupero per massimizzare la risposta ipertrofica muscolare</strong>, è comunque possibile trarre alcune indicazioni partendo da una considerazione ovvia per chiunque si sia allenato: in uno schema “x Max”, ad esempio un 4 x Max @ 8RM, più il recupero è breve e meno ripetizioni complessive si possono fare, c’è però da capire come varia il lavoro totale in funzione del recupero e se da questi dati è possibile trarre delle linee guida.</p>\n<h2 id=\"3-dati-sul-recupero\"><strong>Dati sul recupero</strong></h2>\n<p>In questo articolo esamineremo uno studio molto carino, “The Effect of Rest Interval Length on Multi and Single-Joint Exercise Performance and Perceived Exertion” di Senna e colleghi per il Journal Of Strength And Conditioning Research del 2011 che descrive cosa succede in&nbsp;<strong>uno schema di allenamento 5 x 10 @ 10 RM per panca piana,</strong>&nbsp;croci, pressa e leg extension somministrato ad un certo numero di soggetti allenati con&nbsp;<strong>tre differenti recuperi, 1”, 3’ e 5’.</strong></p>\n<p><strong>Lo schema scelto è di sicuro un protocollo molto duro</strong>, anche sovrabbondante rispetto a quelli che si vedono in palestra ma che può rappresentare un ottimo crash test, con i partecipanti spronati a dare il massimo. Il campione di riferimento era composto da clienti di un fitness center, con tutti i pregi e difetti di questa “fauna” e pertanto lo studio è sicuramente rappresentativo di quella che è la “nostra” realtà.</p>\n<p>Si prende come riferimento solo la panca, dato che è l’esercizio più praticato nelle palestre dell’intera Via Lattea: la tecnica utilizzata prevedeva testa e glutei appoggiati alla panca, piedi fermamente a terra, bilanciere al petto senza rimbalzo e gomiti serrati nel punto superiore, una ottima panca classica da palestra.</p>');

-- --------------------------------------------------------

--
-- Struttura della tabella `commenti`
--

CREATE TABLE `commenti` (
  `id_commento` int(4) NOT NULL,
  `articolo` int(4) NOT NULL,
  `utente` varchar(100) NOT NULL,
  `testo` varchar(1000) NOT NULL,
  `data_inserimento` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `commenti`
--

INSERT INTO `commenti` (`id_commento`, `articolo`, `utente`, `testo`, `data_inserimento`) VALUES
(4, 21, 'andreaparisi917@gmail.com', 'a', '2023-12-17');

-- --------------------------------------------------------

--
-- Struttura della tabella `users`
--

CREATE TABLE `users` (
  `id` int(4) NOT NULL,
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
(1, 'adminftyftu', 'admin', 'admin@gmail.com', '$2y$10$ebeGDLhweRQiPZV.HLR4FOlHcl/r1kpUHgQtV3SGgnkzsROBN/2wu', '2023-11-30 23:00:00', 1, NULL, NULL, NULL, NULL, NULL),
(38, 'Andrea', 'Parisi', 'andreapariaasi917@gmail.comaaaa', '$2y$10$GlKrEpY052IW.N77lC6B8ureAO2Qqtta52u92NVQpfnZ.gO54VyJ.', '2023-12-07 14:48:21', 0, NULL, NULL, '', '', 0),
(39, 'Andrea', 'Pa', 'ndreaaaaparisi917@gmail.coma', '$2y$10$/poQjOCagXJYg8B77jFzpuqsDYvg4oc/ipx0B3pB8Anvl4sGldT.i', '2023-12-08 15:23:03', 0, NULL, NULL, NULL, NULL, NULL),
(40, 'Andreaaa', 'Parisi', 'andreaparisi917@gmail.com', '$2y$10$aJlfy96DySXk7v2SA/xykenhcU.iK7GLe7KtgRbkWV/srtflof0mK', '2023-12-11 23:23:15', 0, NULL, NULL, NULL, NULL, NULL),
(41, 'Andrea', 'Parisi', 'andreaparisi917@gmail.coma', '$2y$10$gQpAHL3FwX9mRwfN8EUHi.KImqcpgYxtN843UglYUTiRFJxHJP7Qa', '2023-12-13 16:45:15', 0, NULL, NULL, NULL, NULL, NULL),
(42, 'Andrea', 'Parisi', 'andreaparisi917@gmail.comaaa', '$2y$10$PevCdzYyuUgh89gMTJuhBOtgMmwmQF02GHmfiV5edBf7kijX1Wk4.', '2023-12-14 20:55:06', 0, NULL, NULL, NULL, NULL, NULL);

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `articoli`
--
ALTER TABLE `articoli`
  ADD PRIMARY KEY (`articleNum`);

--
-- Indici per le tabelle `commenti`
--
ALTER TABLE `commenti`
  ADD PRIMARY KEY (`id_commento`),
  ADD KEY `Commento relativo ad articolo` (`articolo`),
  ADD KEY `Utente relativo a commento` (`utente`);

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
  MODIFY `articleNum` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT per la tabella `commenti`
--
ALTER TABLE `commenti`
  MODIFY `id_commento` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT per la tabella `users`
--
ALTER TABLE `users`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `commenti`
--
ALTER TABLE `commenti`
  ADD CONSTRAINT `Commento relativo ad articolo` FOREIGN KEY (`articolo`) REFERENCES `articoli` (`articleNum`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Utente relativo a commento` FOREIGN KEY (`utente`) REFERENCES `users` (`email`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
