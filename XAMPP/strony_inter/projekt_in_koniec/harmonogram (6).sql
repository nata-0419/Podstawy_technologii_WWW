-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Cze 05, 2025 at 11:37 AM
-- Wersja serwera: 10.4.32-MariaDB
-- Wersja PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `harmonogram`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `aktywnosci_grupowe`
--

CREATE TABLE `aktywnosci_grupowe` (
  `id` int(10) NOT NULL,
  `nazwa` varchar(50) NOT NULL,
  `opis` text NOT NULL,
  `termin` date NOT NULL,
  `typ` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_polish_ci;

--
-- Dumping data for table `aktywnosci_grupowe`
--

INSERT INTO `aktywnosci_grupowe` (`id`, `nazwa`, `opis`, `termin`, `typ`) VALUES
(1, 'Komunia', 'przygotować komunię Kajetana na 25.05.2025', '2025-05-25', 'impreza rodzinna'),
(2, 'Wyjazd czerwcowy', 'przyszykować sie i zakupić sprzęt na wyjazd pod namioty', '2025-06-12', 'wyjazd'),
(4, 'Imieniny babci Zosi', 'kupić prezent', '2025-06-30', 'rodzina'),
(14, 'dzień dziecka', 'zorganizować dzień dziecka', '2025-06-01', 'rodzina');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `aktywnosci_uzytkownik`
--

CREATE TABLE `aktywnosci_uzytkownik` (
  `id_AktUzy` int(10) UNSIGNED NOT NULL,
  `id_uzytkownika` int(10) UNSIGNED NOT NULL,
  `id_aktywnosci` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_polish_ci;

--
-- Dumping data for table `aktywnosci_uzytkownik`
--

INSERT INTO `aktywnosci_uzytkownik` (`id_AktUzy`, `id_uzytkownika`, `id_aktywnosci`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 2, 1),
(5, 1, 4),
(15, 1, 14),
(16, 4, 14),
(17, 2, 2);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `cele`
--

CREATE TABLE `cele` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_uzytkownika` int(10) UNSIGNED NOT NULL,
  `nazwa` varchar(50) NOT NULL,
  `kategoria` varchar(50) NOT NULL,
  `opis` text NOT NULL,
  `zdjecie` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_polish_ci;

--
-- Dumping data for table `cele`
--

INSERT INTO `cele` (`id`, `id_uzytkownika`, `nazwa`, `kategoria`, `opis`, `zdjecie`) VALUES
(1, 1, 'Wakacje na Malediwach', 'wakacje', 'zorganizowanie oraz wykupienie wakacji', 'malediwy.webp'),
(4, 1, 'Zakup samochodu', 'Samochód', 'kupić samochód z roku 2020', 'mercedes.webp'),
(6, 1, 'Komunia brata', 'okazja rodzinna', 'kupić prezent oraz zaplanować obiad rodzinny', '');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `galeria`
--

CREATE TABLE `galeria` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_aktywnosci` int(10) NOT NULL,
  `sciezka` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_polish_ci;

--
-- Dumping data for table `galeria`
--

INSERT INTO `galeria` (`id`, `id_aktywnosci`, `sciezka`) VALUES
(1, 1, 'g11.jpg'),
(2, 1, 'g12.jpg'),
(3, 2, 'g21.jpg'),
(4, 2, 'g22.jpg'),
(5, 2, 'g23.jpg');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `komentarze`
--

CREATE TABLE `komentarze` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_wsp` int(10) UNSIGNED NOT NULL,
  `komentarz` text NOT NULL,
  `data_dodania` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_polish_ci;

--
-- Dumping data for table `komentarze`
--

INSERT INTO `komentarze` (`id`, `id_wsp`, `komentarz`, `data_dodania`) VALUES
(1, 1, 'napisałam kartkę z życzeniami', '2025-05-23'),
(2, 1, 'wydrukowałam kartki i kupiłam czekoladki', '2025-05-24'),
(3, 1, 'trzeba kupić jeszcze skarpetki', '2025-05-27'),
(4, 3, 'oki jutro kupię', '2025-05-27'),
(5, 3, 'a możesz mi podać rozmiar', '2025-05-27'),
(8, 3, 'hejooo', '2025-05-28'),
(9, 15, 'hejka robię testy', '2025-05-28'),
(10, 15, 'marta widzisz mnie/', '2025-05-28'),
(11, 16, 'tak pomogę ci', '2025-05-28'),
(15, 2, 'Robert wolisz domek czy hotel?', '2025-06-05'),
(16, 17, 'Hej, wiesz co wydaje mi się że domek będzie lepszy', '2025-06-05'),
(17, 17, 'a jedziemy swoim samochodem czy jednak  chcemy pociag?', '2025-06-05'),
(18, 2, 'ja wolała bym jechać swoim samochodem', '2025-06-05');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `podzial_zad`
--

CREATE TABLE `podzial_zad` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_wsp` int(10) UNSIGNED NOT NULL,
  `trescZadania` text NOT NULL,
  `status` enum('nie rozpoczeto realizacji','w trakcie realizacji','zakonczono swoja czesc','') NOT NULL,
  `dataUkonczenia` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_polish_ci;

--
-- Dumping data for table `podzial_zad`
--

INSERT INTO `podzial_zad` (`id`, `id_wsp`, `trescZadania`, `status`, `dataUkonczenia`) VALUES
(1, 1, 'kupić czekoladke', 'zakonczono swoja czesc', '2025-05-24'),
(2, 1, 'zapakować ubrania', 'w trakcie realizacji', '2025-05-24'),
(3, 3, 'hhhhhhhh', 'zakonczono swoja czesc', '2025-05-28'),
(5, 15, 'zrobię lody', 'w trakcie realizacji', '2025-05-31'),
(6, 16, 'wezmę balony', '', '2025-05-30'),
(8, 2, 'zarezerwować nocleg', '', '2025-06-13'),
(9, 17, 'zorganizować transpotr', 'w trakcie realizacji', '2025-06-18');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `status`
--

CREATE TABLE `status` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_aktywnosci` int(10) NOT NULL,
  `statusZam` enum('nie rozpoczęto realizacji','w trakcie realizacji','ukoczono','') NOT NULL,
  `ikona` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_polish_ci;

--
-- Dumping data for table `status`
--

INSERT INTO `status` (`id`, `id_aktywnosci`, `statusZam`, `ikona`) VALUES
(1, 1, 'ukoczono', ''),
(2, 2, 'w trakcie realizacji', ';)'),
(3, 4, 'nie rozpoczęto realizacji', ':()'),
(11, 14, 'w trakcie realizacji', '🔄');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `szczegoly_celu`
--

CREATE TABLE `szczegoly_celu` (
  `id_celu` int(10) UNSIGNED NOT NULL,
  `koszty` int(11) NOT NULL,
  `uzbierana_kwota` int(11) NOT NULL,
  `data_rozpoczecia` date NOT NULL,
  `data_zakonczenia` date NOT NULL,
  `status` enum('nie rozpoczęto planowania','w trakcie planowania','w trakcie wykonywania','ukończony cel') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_polish_ci;

--
-- Dumping data for table `szczegoly_celu`
--

INSERT INTO `szczegoly_celu` (`id_celu`, `koszty`, `uzbierana_kwota`, `data_rozpoczecia`, `data_zakonczenia`, `status`) VALUES
(1, 5500, 3000, '2025-07-08', '2025-09-06', 'w trakcie planowania'),
(4, 70000, 10000, '2025-05-31', '2026-01-22', 'nie rozpoczęto planowania'),
(6, 7000, 2000, '2025-04-09', '2025-05-26', 'w trakcie wykonywania');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `szczegoly_zad`
--

CREATE TABLE `szczegoly_zad` (
  `id_zadania` int(10) UNSIGNED NOT NULL,
  `data` date NOT NULL,
  `godzina` time NOT NULL,
  `stan_realizacji` enum('nie rozpoczęto zadania','w trakcie realizacji','zakończenie zadania','') NOT NULL,
  `szczegoly` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_polish_ci;

--
-- Dumping data for table `szczegoly_zad`
--

INSERT INTO `szczegoly_zad` (`id_zadania`, `data`, `godzina`, `stan_realizacji`, `szczegoly`) VALUES
(1, '2025-05-20', '14:45:00', 'zakończenie zadania', 'kontynuacja pracy z strony www'),
(3, '2025-05-21', '14:50:00', 'w trakcie realizacji', 'aa'),
(4, '2025-05-21', '16:36:00', 'nie rozpoczęto zadania', 'pojechać z babcią na pole'),
(5, '2025-05-21', '19:28:00', 'w trakcie realizacji', 'sss'),
(6, '2025-05-22', '08:15:00', 'nie rozpoczęto zadania', 'kolokwium z matematyki3'),
(7, '2025-05-22', '16:27:00', 'nie rozpoczęto zadania', 'aaa'),
(8, '2025-05-23', '18:10:00', 'nie rozpoczęto zadania', 'pojechać do wiktori na paznokcie'),
(9, '2025-05-27', '17:12:00', 'w trakcie realizacji', 'brak'),
(10, '2025-05-28', '12:00:00', 'zakończenie zadania', 'gggg'),
(11, '2025-06-04', '15:57:00', 'zakończenie zadania', 'pokazać pracę oraz sprawozdanie'),
(12, '2025-06-05', '10:58:00', 'w trakcie realizacji', 'jechać na wieś oraz zrobić zakupy'),
(13, '2025-06-05', '13:58:00', 'nie rozpoczęto zadania', 'jechać do kwiaiarni');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `uzytkownik`
--

CREATE TABLE `uzytkownik` (
  `id` int(10) UNSIGNED NOT NULL,
  `imie` varchar(50) NOT NULL,
  `nazwisko` varchar(50) NOT NULL,
  `nick` varchar(50) NOT NULL,
  `haslo` varchar(255) NOT NULL,
  `zdjecie` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_polish_ci;

--
-- Dumping data for table `uzytkownik`
--

INSERT INTO `uzytkownik` (`id`, `imie`, `nazwisko`, `nick`, `haslo`, `zdjecie`) VALUES
(1, 'Natalia', 'Góras', 'nati', '$2y$10$uqS5zKt8aE7avTMM3nMqCexjD8UyrkIgxdkUSavZOynFTE.vjzcne', 'arbuz.jpg'),
(2, 'Robert', 'Perzanowski', 'roki', '$2y$10$gpNDDBZCofIESXs4aq.fceB46J0fecAplLKocP9D7wv5nV1gwlZ92', 'ananas.jpg'),
(3, 'Julia', 'Gąska', 'gąska', '$2y$10$LFnPZNi.yAjDZnOwBQcBxe8yczlQW6U8fqf6Iu9wGffKwYS2TPEWu', 'jagoda.jpg'),
(4, 'Marta', 'Grudzień', 'soltys', '$2y$10$Mn3l1N8jWM8vDwv1MOm3eelCdbiIvjRZvfdAgxoNIbJaObVbHbRb.', 'malina.jpg');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `zadania`
--

CREATE TABLE `zadania` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_uzytkownika` int(10) UNSIGNED NOT NULL,
  `nazwa` varchar(50) NOT NULL,
  `piorytet` int(11) NOT NULL,
  `kategoria` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_polish_ci;

--
-- Dumping data for table `zadania`
--

INSERT INTO `zadania` (`id`, `id_uzytkownika`, `nazwa`, `piorytet`, `kategoria`) VALUES
(1, 1, 'zadanie WWW', 7, 'studia'),
(3, 1, 'praca indywidualna z www', 9, 'Studia'),
(4, 1, 'pomoc babci', 6, 'Rodzina'),
(5, 1, 'wyjazd', 3, 'Spotkanie'),
(6, 1, 'Egzamin Matematyka', 7, 'Studia'),
(7, 1, 'Praca indywidualna z www', 9, 'Studia'),
(8, 1, 'paznokcie', 8, 'uroda'),
(9, 1, 'praca indywidualna z www', 9, 'Studia'),
(10, 4, 'badania', 8, 'lekarz'),
(11, 1, 'Oddać pracę WWW', 1, 'studia'),
(12, 1, 'Pomoc babci', 6, 'rodzina'),
(13, 1, 'praca wiacainia', 7, 'praca');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `aktywnosci_grupowe`
--
ALTER TABLE `aktywnosci_grupowe`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `aktywnosci_uzytkownik`
--
ALTER TABLE `aktywnosci_uzytkownik`
  ADD PRIMARY KEY (`id_AktUzy`),
  ADD KEY `id_aktywnosci` (`id_aktywnosci`),
  ADD KEY `id_uzytkownika` (`id_uzytkownika`);

--
-- Indeksy dla tabeli `cele`
--
ALTER TABLE `cele`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `galeria`
--
ALTER TABLE `galeria`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_aktywnosci` (`id_aktywnosci`);

--
-- Indeksy dla tabeli `komentarze`
--
ALTER TABLE `komentarze`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_wsp` (`id_wsp`);

--
-- Indeksy dla tabeli `podzial_zad`
--
ALTER TABLE `podzial_zad`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_wsp` (`id_wsp`);

--
-- Indeksy dla tabeli `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_aktywnosci` (`id_aktywnosci`);

--
-- Indeksy dla tabeli `szczegoly_celu`
--
ALTER TABLE `szczegoly_celu`
  ADD UNIQUE KEY `id_celu` (`id_celu`);

--
-- Indeksy dla tabeli `szczegoly_zad`
--
ALTER TABLE `szczegoly_zad`
  ADD UNIQUE KEY `id_zadania` (`id_zadania`);

--
-- Indeksy dla tabeli `uzytkownik`
--
ALTER TABLE `uzytkownik`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `zadania`
--
ALTER TABLE `zadania`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `aktywnosci_grupowe`
--
ALTER TABLE `aktywnosci_grupowe`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `aktywnosci_uzytkownik`
--
ALTER TABLE `aktywnosci_uzytkownik`
  MODIFY `id_AktUzy` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `cele`
--
ALTER TABLE `cele`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `galeria`
--
ALTER TABLE `galeria`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `komentarze`
--
ALTER TABLE `komentarze`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `podzial_zad`
--
ALTER TABLE `podzial_zad`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `status`
--
ALTER TABLE `status`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `uzytkownik`
--
ALTER TABLE `uzytkownik`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `zadania`
--
ALTER TABLE `zadania`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `aktywnosci_uzytkownik`
--
ALTER TABLE `aktywnosci_uzytkownik`
  ADD CONSTRAINT `aktywnosci_uzytkownik_ibfk_1` FOREIGN KEY (`id_aktywnosci`) REFERENCES `aktywnosci_grupowe` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `aktywnosci_uzytkownik_ibfk_2` FOREIGN KEY (`id_uzytkownika`) REFERENCES `uzytkownik` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `cele`
--
ALTER TABLE `cele`
  ADD CONSTRAINT `cele_ibfk_1` FOREIGN KEY (`id_uzytkownika`) REFERENCES `uzytkownik` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `galeria`
--
ALTER TABLE `galeria`
  ADD CONSTRAINT `galeria_ibfk_1` FOREIGN KEY (`id_aktywnosci`) REFERENCES `aktywnosci_grupowe` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `komentarze`
--
ALTER TABLE `komentarze`
  ADD CONSTRAINT `komentarze_ibfk_1` FOREIGN KEY (`id_wsp`) REFERENCES `aktywnosci_uzytkownik` (`id_AktUzy`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `podzial_zad`
--
ALTER TABLE `podzial_zad`
  ADD CONSTRAINT `podzial_zad_ibfk_1` FOREIGN KEY (`id_wsp`) REFERENCES `aktywnosci_uzytkownik` (`id_AktUzy`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `status`
--
ALTER TABLE `status`
  ADD CONSTRAINT `status_ibfk_1` FOREIGN KEY (`id_aktywnosci`) REFERENCES `aktywnosci_grupowe` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `szczegoly_celu`
--
ALTER TABLE `szczegoly_celu`
  ADD CONSTRAINT `szczegoly_celu_ibfk_1` FOREIGN KEY (`id_celu`) REFERENCES `cele` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `szczegoly_zad`
--
ALTER TABLE `szczegoly_zad`
  ADD CONSTRAINT `szczegoly_zad_ibfk_1` FOREIGN KEY (`id_zadania`) REFERENCES `zadania` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `zadania`
--
ALTER TABLE `zadania`
  ADD CONSTRAINT `zadania_ibfk_1` FOREIGN KEY (`id_uzytkownika`) REFERENCES `uzytkownik` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
