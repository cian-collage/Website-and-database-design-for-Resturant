-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 22, 2024 at 02:03 AM
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
-- Database: `project`
--

-- --------------------------------------------------------

--
-- Table structure for table `edits`
--

CREATE TABLE `edits` (
  `Edit_id` bigint(20) UNSIGNED NOT NULL,
  `EditType` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `edits`
--

INSERT INTO `edits` (`Edit_id`, `EditType`) VALUES
(36, 'Add'),
(37, 'Delete'),
(38, 'Add'),
(39, 'Edit'),
(40, 'Delete'),
(41, 'Add'),
(42, 'Edit'),
(43, 'Delete'),
(44, 'Add'),
(45, 'Edit'),
(46, 'Delete'),
(47, 'Add'),
(48, 'Edit'),
(49, 'Delete');

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `Name` varchar(50) NOT NULL,
  `Description` varchar(100) NOT NULL,
  `Price` float NOT NULL,
  `Alergen` varchar(20) NOT NULL,
  `category` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`Name`, `Description`, `Price`, `Alergen`, `category`) VALUES
('Flaming Shrimp Cocktail', 'Jumbo shrimp flambeed tableside in brandy sauce', 14.99, 'Shellfish, Alcohol', 'Starters'),
('Fire-Roasted Red Pepper Soup', 'Creamy soup with roasted red peppers, served with a drizzle of chili oil', 9.99, 'Dairy', 'Starters'),
('Scorched Scallop Salad', 'Seared scallops served over mixed greens with a charred lemon vinaigrette', 16.49, 'Shellfish', 'Starters'),
('Sizzling Saganaki', 'Pan-fried Greek cheese flamed with brandy and served with lemon wedges', 12.99, 'Dairy, Alcohol', 'Starters'),
('Ember-Grilled Ribeye Steak', 'Prime ribeye steak cooked over open flames and served with roasted potatoes', 32.99, 'None', 'Mains'),
('Inferno-Infused Lamb Chops', 'Juicy lamb chops marinated in spicy harissa and grilled to perfection', 28.99, 'None', 'Mains'),
('Flame-Charred Salmon Fillet', 'Fresh salmon fillet flame-grilled and served with fire-roasted vegetables', 26.99, 'Fish', 'Mains'),
('Blazing Beef Tenderloin', 'Tender beef tenderloin seared to a perfect char and served with a smoky bourbon glaze', 35.99, 'Alcohol', 'Mains'),
('Smoked Paprika Chicken', 'Chicken breast marinated in smoked paprika, grilled over hot coals, and served with wild rice', 22.99, 'None', 'Mains'),
('Fire-Kissed Vegetable Skewers', 'Assorted vegetables skewered and grilled over an open flame, served with chimichurri sauce', 18.99, 'None', 'Mains'),
('Flambeed Crème Brûlée', 'Classic vanilla custard topped with caramelized sugar, flambeed for a rich flavor', 9.99, 'Dairy', 'Desserts'),
('Molten Lava Cake', 'Decadent chocolate cake with a gooey molten center, served with vanilla ice cream', 11.49, 'Dairy, Gluten', 'Desserts');

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `reservation_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `reservation_date` date NOT NULL,
  `reservation_time` time NOT NULL,
  `party_size` int(11) NOT NULL,
  `special_requests` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reservations`
--

INSERT INTO `reservations` (`reservation_id`, `user_id`, `reservation_date`, `reservation_time`, `party_size`, `special_requests`) VALUES
(15, 4, '2024-04-12', '15:00:00', 5, 'Test1'),
(16, 5, '2024-04-11', '15:00:00', 5, 'Test2'),
(17, 4, '2024-04-12', '02:40:00', 44, 'LICWE'),
(18, 4, '2024-04-13', '03:44:00', 9, 'test'),
(19, 4, '2024-04-13', '03:44:00', 9, 'test'),
(20, 4, '2024-04-13', '03:44:00', 9, 'test'),
(21, 4, '2024-04-13', '03:44:00', 9, 'test');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `User_id` int(11) NOT NULL,
  `Username` varchar(50) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `UserType` enum('admin','staff','user') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`User_id`, `Username`, `Password`, `UserType`) VALUES
(1, 'admin', 'password123', 'admin'),
(2, 'staff1', 'password123', 'staff'),
(3, 'staff2', 'password123', 'staff'),
(4, 'user1', 'password123', 'user'),
(5, 'user2', 'password123', 'user'),
(6, 'user3', 'password123', 'user'),
(7, 'user4', 'password123', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `edits`
--
ALTER TABLE `edits`
  ADD UNIQUE KEY `Edit_id` (`Edit_id`);

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`reservation_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`User_id`),
  ADD UNIQUE KEY `Username` (`Username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `edits`
--
ALTER TABLE `edits`
  MODIFY `Edit_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `reservation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `User_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `reservations_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`User_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
