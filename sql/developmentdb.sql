-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: mysql
-- Generation Time: Jun 30, 2024 at 03:48 PM
-- Server version: 11.1.2-MariaDB-1:11.1.2+maria~ubu2204
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `developmentdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `blog`
--

CREATE TABLE `blog` (
  `contentId` int(11) NOT NULL,
  `subHeader` varchar(255) NOT NULL,
  `text` text NOT NULL,
  `imageName` varchar(255) DEFAULT NULL,
  `header` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `blog`
--

INSERT INTO `blog` (`contentId`, `subHeader`, `text`, `imageName`, `header`) VALUES
(18, 'Embrace the Change, Transform Your Lifes', 'Starting a fitness journey can be both exciting and daunting. The key is to set realistic goals and stay consistent. Remember, it\'s not about perfection but progress. Every step you take towards a healthier lifestyle is a victory. Begin with small changes, like incorporating more whole foods into your diet and finding a form of exercise you enjoy. Celebrate your successes, no matter how small, and stay motivated by tracking your progress', 'image1.jpg', 'Kickstart Your Fitness Journey'),
(20, 'Small Steps Lead to Big Changes', 'Consistency is the cornerstone of any successful fitness regimen. It\'s the daily commitment to your health and wellness that leads to lasting results. Create a routine that fits into your lifestyle and stick to it. Whether it\'s a 30-minute morning run, a yoga session in the evening, or a strength training workout, make it a non-negotiable part of your day. Remember, it\'s not about the intensity of your workouts but the regularity', 'image2.jpg', 'The Power of Consistency'),
(24, 'Nutrition Tips for Optimal Performance', 'What you eat plays a crucial role in your fitness journey. Proper nutrition fuels your body, aids in recovery, and enhances your performance. Focus on a balanced diet rich in lean proteins, whole grains, healthy fats, and plenty of fruits and vegetables. Stay hydrated and avoid processed foods that can derail your progress.', 'image3.jpg', 'Fuel Your Body Right\r\n\r\n'),
(34, 'Stay Inspired and Keep Moving Forward', 'Staying motivated can be challenging, especially when results seem slow. Find what inspires you and use it to fuel your workouts. It could be a fitness role model, a motivational quote, or the desire to improve your health. Set short-term goals to keep yourself engaged and reward yourself for achieving them. Surround yourself with supportive people who encourage your progress.', 'image4.jpg', 'Finding Your Motivations');

-- --------------------------------------------------------

--
-- Table structure for table `nutrition_facts`
--

CREATE TABLE `nutrition_facts` (
  `food_id` int(11) NOT NULL,
  `food_name` varchar(255) NOT NULL,
  `carbs` decimal(10,2) DEFAULT NULL,
  `proteins` decimal(10,2) DEFAULT NULL,
  `fats` decimal(10,2) DEFAULT NULL,
  `fibers` decimal(10,2) DEFAULT NULL,
  `goal_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `nutrition_facts`
--

INSERT INTO `nutrition_facts` (`food_id`, `food_name`, `carbs`, `proteins`, `fats`, `fibers`, `goal_id`) VALUES
(1, 'Spinach', 1.20, 0.50, 0.20, 0.70, 0),
(2, 'Broccoli', 6.60, 2.80, 0.60, 2.60, 0),
(5, 'Cucumber', 3.60, 0.50, 0.20, 0.50, 0),
(7, 'Lettuce', 1.00, 0.50, 0.10, 1.00, 0),
(8, 'Zucchini', 3.10, 1.20, 0.20, 1.00, 0),
(12, 'Sweet Potato', 20.10, 1.60, 0.10, 3.00, 1),
(14, 'Oats', 66.30, 16.90, 7.00, 10.60, 1),
(15, 'Greek Yogurt', 3.60, 10.00, 5.00, 0.00, 1),
(18, 'Almonds', 21.70, 21.20, 49.40, 11.80, 1),
(19, 'Chicken Breast', 0.00, 31.00, 3.60, 0.00, 1),
(22, 'Eggs', 0.60, 12.60, 9.50, 0.00, 2),
(23, 'Beef', 0.00, 26.10, 21.20, 0.00, 2),
(24, 'Greek Yogurt', 3.60, 10.00, 5.00, 0.00, 2),
(25, 'Cottage Cheese', 3.40, 11.10, 4.30, 0.00, 2),
(29, 'Peanut Butter', 20.00, 25.00, 50.00, 8.00, 2),
(30, 'Pasta', 71.20, 12.50, 1.10, 2.50, 2);

-- --------------------------------------------------------

--
-- Table structure for table `userfood`
--

CREATE TABLE `userfood` (
  `id` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `foodname` varchar(255) NOT NULL,
  `carbs` decimal(10,2) NOT NULL,
  `proteins` decimal(10,2) NOT NULL,
  `fats` decimal(10,2) NOT NULL,
  `fibers` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `userName` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `age` int(11) DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `weight` decimal(10,2) DEFAULT NULL,
  `height` decimal(10,2) DEFAULT NULL,
  `bmrInfo` decimal(10,2) DEFAULT NULL,
  `goal` enum('Lose Weight','Maintain Weight','Build Muscle') DEFAULT NULL,
  `caloriesIntake` decimal(10,2) DEFAULT NULL,
  `role` enum('ADMIN','USER') DEFAULT 'USER'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `userName`, `password`, `age`, `gender`, `weight`, `height`, `bmrInfo`, `goal`, `caloriesIntake`, `role`) VALUES
(186, 'User', '$2y$10$.D4jKfex6UN951KY1/idOeiDDYv2PuI8sofT2jp/YlgU2ujaMVP7u', 23, 'Male', 80.00, 198.00, 1979.75, 'Build Muscle', 2279.75, 'USER'),
(223, 'Admin', '$2y$10$q2MvfXVlvoli4TrlDIBB2uVFt3kui1VHRkYFB2Ngxez9tsGaIX1K6', 21, 'Male', 80.00, 190.00, 1952.72, 'Maintain Weight', 1952.72, 'ADMIN');

-- --------------------------------------------------------

--
-- Table structure for table `workout`
--

CREATE TABLE `workout` (
  `id` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `workoutName` varchar(255) NOT NULL,
  `duration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `blog`
--
ALTER TABLE `blog`
  ADD PRIMARY KEY (`contentId`);

--
-- Indexes for table `nutrition_facts`
--
ALTER TABLE `nutrition_facts`
  ADD PRIMARY KEY (`food_id`);

--
-- Indexes for table `userfood`
--
ALTER TABLE `userfood`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userId` (`userId`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `workout`
--
ALTER TABLE `workout`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userId` (`userId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `blog`
--
ALTER TABLE `blog`
  MODIFY `contentId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `nutrition_facts`
--
ALTER TABLE `nutrition_facts`
  MODIFY `food_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `userfood`
--
ALTER TABLE `userfood`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=138;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=259;

--
-- AUTO_INCREMENT for table `workout`
--
ALTER TABLE `workout`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=174;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `userfood`
--
ALTER TABLE `userfood`
  ADD CONSTRAINT `userfood_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `users` (`id`);

--
-- Constraints for table `workout`
--
ALTER TABLE `workout`
  ADD CONSTRAINT `workout_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
