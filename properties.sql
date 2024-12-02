-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 02, 2024 at 04:44 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `php_project`
--

-- --------------------------------------------------------

--
-- Table structure for table `properties`
--

CREATE TABLE `properties` (
  `id` int(11) NOT NULL,
  `property_type` varchar(100) NOT NULL,
  `price_range` varchar(100) NOT NULL,
  `location` varchar(255) NOT NULL,
  `area` int(11) NOT NULL,
  `capacity` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `photos` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `properties`
--

INSERT INTO `properties` (`id`, `property_type`, `price_range`, `location`, `area`, `capacity`, `description`, `photos`) VALUES
(1, 'Apartment', '200,000 - 400,000', 'Metro Manila, Quezon City', 32, '1-2 persons', 'Located near major universities, shopping malls, and MRT stations for easy commuting.', 'house1.jpg'),
(2, 'Residential Lot', '300,000 - 600,000', 'Cavite, Dasmari?as City', 50, 'N/A (Lot only)', 'Situated in a gated community, close to schools, hospitals, and public markets.', 'house2.jpg'),
(3, 'Condo', '600,000 - 1,000,000', 'Metro Manila, Makati City', 35, '1-2 persons', 'Walking distance to business districts, parks, and upscale restaurants.', 'house3.jpg'),
(4, 'House and Lot', '800,000 - 1,000,000', 'Laguna, Sta. Rosa City', 60, '3-4 persons', 'Located in a suburban area near industrial zones, schools, and commercial establishments.', 'house4.jpg'),
(5, 'Apartment', '250,000 - 500,000', 'Pampanga, Angeles City', 40, '2-3 persons', 'Close to Clark Freeport Zone, SM City Clark, and Angeles University Foundation.', 'house5.jpg'),
(6, 'Commercial', '500,000 - 1,000,000', 'Bulacan, Malolos City', 70, 'N/A (Commercial)', 'Strategically located near public markets, transportation hubs, and schools.', 'house6.jpg'),
(7, 'Residential Lot', '400,000 - 700,000', 'Rizal, Antipolo City', 80, 'N/A (Lot only)', 'Overlooks the Metro Manila skyline; near churches, resorts, and eco-tourism sites.', 'house7.jpg'),
(8, 'House and Lot', '600,000 - 900,000', 'Batangas, Lipa City', 65, '3-4 persons', 'Located in a peaceful community near Lipa Cathedral and SM City Lipa.', 'house8.jpg'),
(9, 'Condo', '700,000 - 1,000,000', 'Metro Manila, Taguig City', 30, '1 person', 'Situated in Bonifacio Global City, near high-end malls and multinational offices.', 'house9.jpg'),
(10, 'Residential Lot', '200,000 - 300,000', 'Ilocos Norte, Laoag City', 100, 'N/A (Lot only)', 'Located in a quiet area near government offices and cultural landmarks.', 'house10.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `properties`
--
ALTER TABLE `properties`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `properties`
--
ALTER TABLE `properties`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
