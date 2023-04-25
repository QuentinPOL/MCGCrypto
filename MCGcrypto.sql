-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 26, 2023 at 01:25 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.0.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mcgcrypto`
--

-- --------------------------------------------------------

--
-- Table structure for table `account`
--

CREATE TABLE `account` (
  `idUser` int(11) NOT NULL,
  `nom` varchar(30) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`idUser`, `nom`, `email`, `password`) VALUES
(4, 'Test', '5454', 'eecaf27b183b049cc9e2b549b8521ab09369e9616b43a6be604bb9ad9fccb757'),
(5, 'Tes', 'Quentinpol140@gmail.com', '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4');

-- --------------------------------------------------------

--
-- Table structure for table `crypto`
--

CREATE TABLE `crypto` (
  `idCrypto` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `crypto`
--

INSERT INTO `crypto` (`idCrypto`, `name`, `price`) VALUES
(1, 'MCGCoin', 15),
(2, 'Euro', 1);

-- --------------------------------------------------------

--
-- Table structure for table `market`
--

CREATE TABLE `market` (
  `idMarket` int(11) NOT NULL,
  `idCrypto1` int(11) NOT NULL,
  `idCrypto2` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `market`
--

INSERT INTO `market` (`idMarket`, `idCrypto1`, `idCrypto2`) VALUES
(1, 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

CREATE TABLE `transaction` (
  `idTransaction` int(11) NOT NULL,
  `idMarket` int(11) NOT NULL,
  `idUser` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `amountCrypto` float NOT NULL,
  `amountEuro` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaction`
--

INSERT INTO `transaction` (`idTransaction`, `idMarket`, `idUser`, `type`, `amountCrypto`, `amountEuro`) VALUES
(4, 1, 5, 1, 15, 225),
(5, 1, 5, 1, 15, 225),
(6, 1, 5, 1, 15, 225),
(7, 1, 5, 1, 15, 225),
(8, 1, 5, 1, 1, 15),
(9, 1, 5, 1, 1, 15),
(10, 1, 5, 1, 1, 15),
(11, 1, 5, 1, 1, 15),
(12, 1, 5, 1, 1, 15),
(13, 1, 5, 1, 1, 15),
(14, 1, 5, 1, 1, 15),
(15, 1, 5, 1, 15, 225),
(16, 1, 5, 1, 1, 15),
(17, 1, 5, 1, 0.666667, 10),
(18, 1, 5, 1, 1, 15),
(19, 1, 5, 1, 1, 15),
(20, 1, 5, 1, 1, 15),
(21, 1, 5, 1, 1, 15),
(22, 1, 5, 1, 1, 15),
(23, 1, 5, 2, 1, 15),
(24, 1, 5, 2, 1, 15),
(25, 1, 5, 1, 1, 15),
(26, 1, 5, 2, 1, 15),
(27, 1, 5, 2, 1, 15),
(28, 1, 5, 1, 1, 15),
(29, 1, 5, 2, 1, 15),
(30, 1, 5, 1, 1, 15),
(31, 1, 5, 1, 15, 225),
(32, 1, 5, 1, 12, 180),
(33, 1, 5, 1, 12, 180),
(34, 1, 5, 1, 11, 165),
(35, 1, 5, 1, 1, 15),
(36, 1, 5, 1, 1, 15),
(37, 1, 5, 1, 7.66667, 115),
(38, 1, 5, 1, 1, 15),
(39, 1, 5, 1, 1, 15),
(40, 1, 5, 1, 2, 30),
(41, 1, 5, 1, 1, 15),
(42, 1, 5, 1, 1, 15),
(43, 1, 5, 1, 15, 225),
(44, 1, 5, 2, 1, 15),
(45, 1, 5, 1, 1, 15),
(46, 1, 5, 2, 1, 15);

-- --------------------------------------------------------

--
-- Table structure for table `wallet`
--

CREATE TABLE `wallet` (
  `idWallet` int(11) NOT NULL,
  `IdUser` int(11) NOT NULL,
  `idCrypto` int(11) NOT NULL,
  `amount` float NOT NULL,
  `balanceEUR` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `wallet`
--

INSERT INTO `wallet` (`idWallet`, `IdUser`, `idCrypto`, `amount`, `balanceEUR`) VALUES
(1, 4, 2, 10, 10),
(2, 5, 2, 20, 35),
(3, 5, 1, 2, 30);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`idUser`);

--
-- Indexes for table `crypto`
--
ALTER TABLE `crypto`
  ADD PRIMARY KEY (`idCrypto`);

--
-- Indexes for table `market`
--
ALTER TABLE `market`
  ADD PRIMARY KEY (`idMarket`),
  ADD KEY `idCrypto1` (`idCrypto1`),
  ADD KEY `idCrypto2` (`idCrypto2`);

--
-- Indexes for table `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`idTransaction`),
  ADD KEY `idUser` (`idUser`),
  ADD KEY `idMarket` (`idMarket`);

--
-- Indexes for table `wallet`
--
ALTER TABLE `wallet`
  ADD PRIMARY KEY (`idWallet`),
  ADD KEY `IdUser` (`IdUser`),
  ADD KEY `idCrypto` (`idCrypto`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account`
--
ALTER TABLE `account`
  MODIFY `idUser` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `crypto`
--
ALTER TABLE `crypto`
  MODIFY `idCrypto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `market`
--
ALTER TABLE `market`
  MODIFY `idMarket` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `transaction`
--
ALTER TABLE `transaction`
  MODIFY `idTransaction` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `wallet`
--
ALTER TABLE `wallet`
  MODIFY `idWallet` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `market`
--
ALTER TABLE `market`
  ADD CONSTRAINT `market_ibfk_1` FOREIGN KEY (`idCrypto1`) REFERENCES `crypto` (`idCrypto`),
  ADD CONSTRAINT `market_ibfk_2` FOREIGN KEY (`idCrypto2`) REFERENCES `crypto` (`idCrypto`);

--
-- Constraints for table `transaction`
--
ALTER TABLE `transaction`
  ADD CONSTRAINT `transaction_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `account` (`idUser`),
  ADD CONSTRAINT `transaction_ibfk_2` FOREIGN KEY (`idMarket`) REFERENCES `market` (`idMarket`);

--
-- Constraints for table `wallet`
--
ALTER TABLE `wallet`
  ADD CONSTRAINT `wallet_ibfk_1` FOREIGN KEY (`IdUser`) REFERENCES `account` (`idUser`),
  ADD CONSTRAINT `wallet_ibfk_2` FOREIGN KEY (`idCrypto`) REFERENCES `crypto` (`idCrypto`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
