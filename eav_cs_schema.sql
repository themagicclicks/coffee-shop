-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 25, 2026 at 07:23 AM
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
-- Database: `eav_cs`
--

-- --------------------------------------------------------

--
-- Table structure for table `entities`
--

CREATE TABLE `entities` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `entity_type_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `entity_attributes`
--

CREATE TABLE `entity_attributes` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `entity_attribute_data`
--

CREATE TABLE `entity_attribute_data` (
  `id` int(11) NOT NULL,
  `entity_id` int(11) NOT NULL,
  `attribute_id` int(11) NOT NULL,
  `value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `entity_attribute_input_map`
--

CREATE TABLE `entity_attribute_input_map` (
  `id` int(11) NOT NULL,
  `attribute_id` int(11) NOT NULL,
  `input_type_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `entity_attribute_map`
--

CREATE TABLE `entity_attribute_map` (
  `id` int(11) NOT NULL,
  `entity_type_id` int(11) NOT NULL,
  `attribute_id` int(11) NOT NULL,
  `attribute_order` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `entity_relations`
--

CREATE TABLE `entity_relations` (
  `id` int(11) NOT NULL,
  `parent_entity_id` int(11) NOT NULL,
  `child_entity_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `entity_states`
--

CREATE TABLE `entity_states` (
  `id` int(11) NOT NULL,
  `state_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `entity_state_map`
--

CREATE TABLE `entity_state_map` (
  `id` int(11) NOT NULL,
  `entity_id` int(11) NOT NULL,
  `state_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `entity_templates`
--

CREATE TABLE `entity_templates` (
  `id` int(11) NOT NULL,
  `template_name` varchar(255) NOT NULL,
  `template_html` text NOT NULL,
  `preview_template_html` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `entity_types`
--

CREATE TABLE `entity_types` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `title` varchar(500) NOT NULL,
  `template_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `entity_updates`
--

CREATE TABLE `entity_updates` (
  `entity_id` int(11) NOT NULL,
  `last_updated` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `input_field_types`
--

CREATE TABLE `input_field_types` (
  `id` int(11) NOT NULL,
  `type_name` varchar(255) NOT NULL,
  `type_type` enum('string','integer','float','boolean','null') NOT NULL,
  `type_input` varchar(5000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `entities`
--
ALTER TABLE `entities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `entity_type_id` (`entity_type_id`);

--
-- Indexes for table `entity_attributes`
--
ALTER TABLE `entity_attributes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `entity_attribute_data`
--
ALTER TABLE `entity_attribute_data`
  ADD PRIMARY KEY (`id`),
  ADD KEY `entity_id` (`entity_id`),
  ADD KEY `attribute_id` (`attribute_id`);

--
-- Indexes for table `entity_attribute_input_map`
--
ALTER TABLE `entity_attribute_input_map`
  ADD PRIMARY KEY (`id`),
  ADD KEY `attribute_id` (`attribute_id`),
  ADD KEY `input_type_id` (`input_type_id`);

--
-- Indexes for table `entity_attribute_map`
--
ALTER TABLE `entity_attribute_map`
  ADD PRIMARY KEY (`id`),
  ADD KEY `entity_type_id` (`entity_type_id`),
  ADD KEY `attribute_id` (`attribute_id`);

--
-- Indexes for table `entity_relations`
--
ALTER TABLE `entity_relations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parent_entity_id` (`parent_entity_id`),
  ADD KEY `child_entity_id` (`child_entity_id`);

--
-- Indexes for table `entity_states`
--
ALTER TABLE `entity_states`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `state_name` (`state_name`);

--
-- Indexes for table `entity_state_map`
--
ALTER TABLE `entity_state_map`
  ADD PRIMARY KEY (`id`),
  ADD KEY `entity_id` (`entity_id`),
  ADD KEY `state_id` (`state_id`);

--
-- Indexes for table `entity_templates`
--
ALTER TABLE `entity_templates`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `template_name` (`template_name`);

--
-- Indexes for table `entity_types`
--
ALTER TABLE `entity_types`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `entity_updates`
--
ALTER TABLE `entity_updates`
  ADD PRIMARY KEY (`entity_id`);

--
-- Indexes for table `input_field_types`
--
ALTER TABLE `input_field_types`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `type_name` (`type_name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `entities`
--
ALTER TABLE `entities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `entity_attributes`
--
ALTER TABLE `entity_attributes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `entity_attribute_data`
--
ALTER TABLE `entity_attribute_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `entity_attribute_input_map`
--
ALTER TABLE `entity_attribute_input_map`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `entity_attribute_map`
--
ALTER TABLE `entity_attribute_map`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `entity_relations`
--
ALTER TABLE `entity_relations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `entity_states`
--
ALTER TABLE `entity_states`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `entity_state_map`
--
ALTER TABLE `entity_state_map`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `entity_templates`
--
ALTER TABLE `entity_templates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `entity_types`
--
ALTER TABLE `entity_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `input_field_types`
--
ALTER TABLE `input_field_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `entities`
--
ALTER TABLE `entities`
  ADD CONSTRAINT `entities_ibfk_1` FOREIGN KEY (`entity_type_id`) REFERENCES `entity_types` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `entity_attribute_data`
--
ALTER TABLE `entity_attribute_data`
  ADD CONSTRAINT `entity_attribute_data_ibfk_1` FOREIGN KEY (`entity_id`) REFERENCES `entities` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `entity_attribute_data_ibfk_2` FOREIGN KEY (`attribute_id`) REFERENCES `entity_attributes` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `entity_attribute_input_map`
--
ALTER TABLE `entity_attribute_input_map`
  ADD CONSTRAINT `entity_attribute_input_map_ibfk_1` FOREIGN KEY (`attribute_id`) REFERENCES `entity_attributes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `entity_attribute_input_map_ibfk_2` FOREIGN KEY (`input_type_id`) REFERENCES `input_field_types` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `entity_attribute_map`
--
ALTER TABLE `entity_attribute_map`
  ADD CONSTRAINT `entity_attribute_map_ibfk_1` FOREIGN KEY (`entity_type_id`) REFERENCES `entity_types` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `entity_attribute_map_ibfk_2` FOREIGN KEY (`attribute_id`) REFERENCES `entity_attributes` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `entity_relations`
--
ALTER TABLE `entity_relations`
  ADD CONSTRAINT `entity_relations_ibfk_1` FOREIGN KEY (`parent_entity_id`) REFERENCES `entities` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `entity_relations_ibfk_2` FOREIGN KEY (`child_entity_id`) REFERENCES `entities` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `entity_state_map`
--
ALTER TABLE `entity_state_map`
  ADD CONSTRAINT `entity_state_map_ibfk_1` FOREIGN KEY (`entity_id`) REFERENCES `entities` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `entity_state_map_ibfk_2` FOREIGN KEY (`state_id`) REFERENCES `entity_states` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `entity_updates`
--
ALTER TABLE `entity_updates`
  ADD CONSTRAINT `entity_updates_ibfk_1` FOREIGN KEY (`entity_id`) REFERENCES `entities` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
