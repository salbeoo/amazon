-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Apr 20, 2022 alle 12:18
-- Versione del server: 10.4.6-MariaDB
-- Versione PHP: 7.3.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `5aisalbe_amazon`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `articolo`
--

CREATE TABLE `articolo` (
  `id` int(11) NOT NULL,
  `codice` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `descrizione` text NOT NULL,
  `quantita` int(11) NOT NULL,
  `prezzo` int(11) NOT NULL,
  `idCategoria` int(11) NOT NULL,
  `immagine` varchar(256) DEFAULT NULL,
  `peso` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `articolo`
--

INSERT INTO `articolo` (`id`, `codice`, `nome`, `descrizione`, `quantita`, `prezzo`, `idCategoria`, `immagine`, `peso`) VALUES
(1, 1, 'ps5', 'CPU: 8x Zen 2 Cores at 3.5GHz. GPU: 10.28 TFLOPs, 36 CUs at 2.23GHz (frequenza variabile) Architettura GPU: RDNA 2 personalizzata. Memoria: 16GB GDDR6/256-bit.', 10, 451, 1, 'uploads/ps5.png', 2),
(2, 6, 'cavallo', 'un bel cavallo', 100, 809, 1, 'uploads/cavalloRuotato.png', 500);

-- --------------------------------------------------------

--
-- Struttura della tabella `carrello`
--

CREATE TABLE `carrello` (
  `idCarrelloCodice` int(11) NOT NULL,
  `data` date NOT NULL,
  `idUtente` int(11) DEFAULT NULL,
  `pagato` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `carrello`
--

INSERT INTO `carrello` (`idCarrelloCodice`, `data`, `idUtente`, `pagato`) VALUES
(1, '2022-04-19', NULL, 0),
(2, '2022-04-19', 13, 0),
(3, '2022-04-19', NULL, 0),
(4, '2022-04-19', NULL, 0),
(5, '2022-04-19', 13, 0),
(6, '2022-04-19', NULL, 0),
(7, '2022-04-20', 13, 0),
(8, '2022-04-20', NULL, 0),
(9, '2022-04-20', 1, 0),
(10, '2022-04-20', 1, 0),
(11, '2022-04-20', NULL, 0),
(12, '2022-04-20', NULL, 0);

-- --------------------------------------------------------

--
-- Struttura della tabella `categoria`
--

CREATE TABLE `categoria` (
  `codice` int(11) NOT NULL,
  `tipo` varchar(100) NOT NULL,
  `descrizione` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `categoria`
--

INSERT INTO `categoria` (`codice`, `tipo`, `descrizione`) VALUES
(1, 'Elettronica - Informatica', 'cose elettroniche');

-- --------------------------------------------------------

--
-- Struttura della tabella `commento`
--

CREATE TABLE `commento` (
  `id` int(11) NOT NULL,
  `commento` int(11) DEFAULT NULL,
  `stelle` int(11) DEFAULT NULL,
  `idArticolo` int(11) NOT NULL,
  `idUtente` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struttura della tabella `contiene_acquisto`
--

CREATE TABLE `contiene_acquisto` (
  `id` int(11) NOT NULL,
  `idArticolo` int(11) NOT NULL,
  `idCarrello` int(11) NOT NULL,
  `quantita` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `contiene_acquisto`
--

INSERT INTO `contiene_acquisto` (`id`, `idArticolo`, `idCarrello`, `quantita`) VALUES
(8, 2, 11, 1),
(10, 2, 11, 1),
(11, 2, 2, 1);

-- --------------------------------------------------------

--
-- Struttura della tabella `indirizzo`
--

CREATE TABLE `indirizzo` (
  `id` int(11) NOT NULL,
  `nazione` int(11) NOT NULL,
  `via` int(11) NOT NULL,
  `civico` int(11) NOT NULL,
  `paese` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struttura della tabella `ordine`
--

CREATE TABLE `ordine` (
  `id` int(11) NOT NULL,
  `data` date NOT NULL,
  `ora` time NOT NULL,
  `idCarrello` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struttura della tabella `utente`
--

CREATE TABLE `utente` (
  `id` int(11) NOT NULL,
  `nome` varchar(32) NOT NULL,
  `cognome` varchar(32) NOT NULL,
  `dataNascita` date NOT NULL,
  `sesso` varchar(32) NOT NULL,
  `username` varchar(32) DEFAULT NULL,
  `password` varchar(32) NOT NULL,
  `telefono` varchar(12) DEFAULT NULL,
  `email` varchar(32) NOT NULL,
  `fotoProfilo` varchar(255) DEFAULT NULL,
  `ruolo` int(11) NOT NULL DEFAULT 0,
  `idIndirizzo` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `utente`
--

INSERT INTO `utente` (`id`, `nome`, `cognome`, `dataNascita`, `sesso`, `username`, `password`, `telefono`, `email`, `fotoProfilo`, `ruolo`, `idIndirizzo`) VALUES
(1, 'Alberto', 'Stagno', '2003-01-01', 'Uomo', NULL, '6e6bc4e49dd477ebc98ef4046c067b5f', NULL, 'abc@aaa.it', NULL, 0, NULL),
(2, 'Simo', 'Sessa', '2003-01-01', 'Uomo', NULL, '6e6bc4e49dd477ebc98ef4046c067b5f', NULL, 'simo@gmail.com', NULL, 0, NULL),
(13, 'admin', 'admin', '2003-01-01', 'Uomo', 'admin', '21232f297a57a5a743894a0e4a801fc3', NULL, 'admin', NULL, 1, NULL);

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `articolo`
--
ALTER TABLE `articolo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK3` (`idCategoria`);

--
-- Indici per le tabelle `carrello`
--
ALTER TABLE `carrello`
  ADD PRIMARY KEY (`idCarrelloCodice`),
  ADD KEY `FK6` (`idUtente`);

--
-- Indici per le tabelle `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`codice`);

--
-- Indici per le tabelle `commento`
--
ALTER TABLE `commento`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK4` (`idArticolo`),
  ADD KEY `FK5` (`idUtente`);

--
-- Indici per le tabelle `contiene_acquisto`
--
ALTER TABLE `contiene_acquisto`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK7` (`idArticolo`),
  ADD KEY `FK8` (`idCarrello`);

--
-- Indici per le tabelle `indirizzo`
--
ALTER TABLE `indirizzo`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `ordine`
--
ALTER TABLE `ordine`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK9` (`idCarrello`);

--
-- Indici per le tabelle `utente`
--
ALTER TABLE `utente`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `FK1` (`idIndirizzo`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `articolo`
--
ALTER TABLE `articolo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT per la tabella `carrello`
--
ALTER TABLE `carrello`
  MODIFY `idCarrelloCodice` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT per la tabella `categoria`
--
ALTER TABLE `categoria`
  MODIFY `codice` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT per la tabella `contiene_acquisto`
--
ALTER TABLE `contiene_acquisto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT per la tabella `indirizzo`
--
ALTER TABLE `indirizzo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `ordine`
--
ALTER TABLE `ordine`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `utente`
--
ALTER TABLE `utente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `articolo`
--
ALTER TABLE `articolo`
  ADD CONSTRAINT `FK3` FOREIGN KEY (`idCategoria`) REFERENCES `categoria` (`codice`);

--
-- Limiti per la tabella `carrello`
--
ALTER TABLE `carrello`
  ADD CONSTRAINT `FK6` FOREIGN KEY (`idUtente`) REFERENCES `utente` (`id`);

--
-- Limiti per la tabella `commento`
--
ALTER TABLE `commento`
  ADD CONSTRAINT `FK4` FOREIGN KEY (`idArticolo`) REFERENCES `articolo` (`id`),
  ADD CONSTRAINT `FK5` FOREIGN KEY (`idUtente`) REFERENCES `utente` (`id`);

--
-- Limiti per la tabella `contiene_acquisto`
--
ALTER TABLE `contiene_acquisto`
  ADD CONSTRAINT `FK7` FOREIGN KEY (`idArticolo`) REFERENCES `articolo` (`id`),
  ADD CONSTRAINT `FK8` FOREIGN KEY (`idCarrello`) REFERENCES `carrello` (`idCarrelloCodice`);

--
-- Limiti per la tabella `ordine`
--
ALTER TABLE `ordine`
  ADD CONSTRAINT `FK9` FOREIGN KEY (`idCarrello`) REFERENCES `carrello` (`idCarrelloCodice`);

--
-- Limiti per la tabella `utente`
--
ALTER TABLE `utente`
  ADD CONSTRAINT `FK1` FOREIGN KEY (`idIndirizzo`) REFERENCES `indirizzo` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
